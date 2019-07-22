<?php

namespace App\Api\Classes;

use Validator;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;

class ClassesService implements ClassesServiceInterface
{
    public function listClasses($page = 1, $limit = 10)
    {
        $skip = ($page - 1) * $limit;
        $classes = Classes::offset($skip)->limit($limit)->get();

        return $classes;
    }

    public function getClass($id)
    {
        $class = Classes::find($id);

        if (! $class) {
            throw new NotFoundException('Resource not found');
        }

        return $class;
    }

    public function insertClass($name, $start_date, $end_date, $capacity)
    {
        $this->validateClass($name, $start_date, $end_date, $capacity);

        $class = Classes::create([
      'name' => $name,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'capacity' => $capacity,
    ]);

        return $class;
    }

    public function updateClass($id, $name, $start_date, $end_date, $capacity)
    {
        $this->validateClass($name, $start_date, $end_date, $capacity, $id);

        $class = Classes::find($id);

        if (! $class) {
            throw new NotFoundException('Resource not found');
        }

        $class->update([
      'name' => $name,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'capacity' => $capacity,
    ]);

        return $class;
    }

    public function deleteClass($id)
    {
        $class = Classes::destroy($id);

        return $class;
    }

    public function classBookings($id)
    {
        $class = Classes::with('bookings')->find($id);

        if (!$class) {
            throw new NotFoundException('Resource not found', 404);
        }

        return $class;
    }

    private function validateClass($name, $start_date, $end_date, $capacity, $id = 0)
    {
        $request = [
      'name' => $name,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'capacity' => $capacity,

    ];

        $validator = Validator::make($request, [
      'name' => 'required|string|min:4',
      'start_date' => 'required|date_format:Y-m-d|after:yesterday|before:end_date',
      'end_date' => 'required|date_format:Y-m-d|after:start_date',
      'capacity' => 'required|integer|min:1',
    ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        $classes = $this->validateClassesBetween($start_date, $end_date, $id);

        if (count($classes) > 0) {
            throw new ValidationException('Já existem classes entre as datas'.$start_date.' e '.$end_date);
        }
    }

    private function validateClassesBetween($startDate, $endDate, $id = 0)
    {
        return Classes::whereDate('start_date', '>=', $startDate)
      ->whereDate('end_date', '<=', $endDate)
      ->where('id', '<>', $id)
      ->get();
    }
}
