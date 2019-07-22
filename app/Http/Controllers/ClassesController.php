<?php

namespace App\Http\Controllers;

use App\Api\Classes\Classes;
use Illuminate\Http\Request;
use App\Api\Classes\ClassesServiceInterface;

class ClassesController extends Controller
{
    private $classesService;

    public function __construct(ClassesServiceInterface $classesService)
    {
        $this->classesService = $classesService;
    }

    public function list(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);
            $classes = $this->classesService->listClasses($page, $limit);
            $code = count($classes) == 0 ? 204 : 200;

            return response()->json([
              'data' => $classes,
          ], $code);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function get($id)
    {
        try {
            $class = $this->classesService->getClass($id);

            return $this->customResponse($class, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function insert(Request $request)
    {
        try {
            $class = $this->classesService->insertClass(
              $request->input('name'),
              $request->input('start_date'),
              $request->input('end_date'),
              $request->input('capacity')
          );

            return $this->customResponse($class, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function update($id, Request $request)
    {
        try {
            $class = $this->classesService->updateClass(
              $id,
              $request->input('name'),
              $request->input('start_date'),
              $request->input('end_date'),
              $request->input('capacity')
          );

            return $this->customResponse($class, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function delete($id)
    {
        try {
            if (! $this->classesService->deleteClass($id)) {
                return response()->json(['error' => 'Not found'], 404);
            }

            return response()->json(['message' => 'Class Deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], $e->getCode());
        }
    }

    public function getClassBookings($id)
    {
        try {
            $classBookings = $this->classesService->classBookings($id);

            return response()->json(['class' => $classBookings], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function customResponse(Classes $class, int $code)
    {
        return response()->json([
            'data' => $class,
            'links' => [
                'href' => '/api/classes/'.$class->id,
                'rel' => 'booking',
                'type' => 'GET',
            ],
        ], $code);
    }
}
