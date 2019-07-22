<?php

namespace App\Api\Booking;

use Validator;
use App\Api\Classes\Classes;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;

class BookingService implements BookingServiceInterface
{
    public function listBookings($page = 1, $limit = 10)
    {
        $skip = ($page - 1) * $limit;
        $bookings = Booking::offset($skip)->limit($limit)->get();

        return $bookings;
    }

    public function getBooking($id)
    {
        $booking = Booking::find($id);

        if (! $booking) {
            throw new NotFoundException('Resource not found');
        }

        return $booking;
    }

    public function insertBooking($name, $date)
    {
        $this->validateBooking($name, $date);
        $class = $this->validateClass($date);

        $booking = new Booking([
      'name' => $name,
      'date' => $date,
    ]);

        $booking->classes()->associate($class);
        $booking->save();

        return $booking;
    }

    public function updateBooking($id, $name, $date)
    {
        $this->validateBooking($name, $date);
        $booking = Booking::find($id);

        if (! $booking) {
            throw new NotFoundException('Resource not found');
        }

        $class = $this->findClasses($date);

        $booking->update([
      'name' => $name,
      'date' => $date,
    ]);

        return $booking;
    }

    public function deleteBooking($id)
    {
        $booking = Booking::destroy($id);

        return $booking;
    }

    public function bookingClasses($id)
    {
        $booking = Booking::with('classes')->find($id);

        if (! $booking) {
            throw new NotFoundException('Resource not found', 404);
        }

        return $booking;
    }

    private function validateBooking($name, $date)
    {
        $request = [
      'name' => $name,
      'date' => $date,
    ];

        $validator = Validator::make($request, [
      'name' => 'required|string|min:2',
      'date' => 'required|date_format:Y-m-d|after:yesterday',
    ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }
    }

    private function validateClass($date)
    {
        $class = $this->findClasses($date);

        $numberOfClassesBookings = Booking::where('classes_id', $class->id)
            ->whereDate('date', $date)
            ->count();

        if ($numberOfClassesBookings >= $class->capacity) {
            throw new \Exception('Class is already full', 409);
        }

        return $class;
    }

    private function findClasses($date)
    {
        $class = Classes::whereDate('start_date', '<=', $date)
      ->whereDate('end_date', '>=', $date)
      ->first();

        if (! $class) {
            throw new NotFoundException('Class not found at date'.$date);
        }

        return $class;
    }
}
