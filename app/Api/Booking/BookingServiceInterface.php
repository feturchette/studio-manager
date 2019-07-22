<?php

namespace App\Api\Booking;

interface BookingServiceInterface
{
    public function listBookings($page = 1, $limit = 10);

    public function getBooking($id);

    public function insertBooking($name, $date);

    public function updateBooking($id, $name, $date);

    public function deleteBooking($id);

    public function bookingClasses($id);
}
