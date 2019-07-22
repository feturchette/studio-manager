<?php

namespace App\Http\Controllers;

use App\Api\Booking\Booking;
use Illuminate\Http\Request;
use App\Api\Booking\BookingServiceInterface;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingServiceInterface $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function list(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);
            $bookings = $this->bookingService->listBookings($page, $limit);

            $code = count($bookings) == 0 ? 204 : 200;

            return response()->json([
                'data' => $bookings,
                'page' => $page,
                'limit' => $limit,
            ], $code);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function get($id)
    {
        try {
            $booking = $this->bookingService->getBooking($id);

            return $this->customResponse($booking, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function insert(Request $request)
    {
        try {
            $booking = $this->bookingService->insertBooking($request->input('name'), $request->input('date'));

            return $this->customResponse($booking, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function update($id, Request $request)
    {
        try {
            $booking = $this->bookingService->updateBooking($id, $request->input('name'), $request->input('date'));

            return $this->customResponse($booking, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function delete($id)
    {
        try {
            $this->bookingService->deleteBooking($id);

            return response()->json(['message' => 'Booking Deleted']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getBookingClasses($id)
    {
        try {
            $bookingClasses = $this->bookingService->bookingClasses($id);

            return response()->json(['booking' => $bookingClasses], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function customResponse(Booking $booking, int $code)
    {
        return response()->json([
            'data' => $booking,
            'links' => [
                'href' => '/api/bookings/'.$booking->id,
                'rel' => 'booking',
                'type' => 'GET',
            ],
        ], $code);
    }
}
