<?php

namespace Tests\Functional\Api\Bookings;

use Tests\TestCase;
use App\Api\Booking\Booking;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class InsertBookingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanInsertBooking()
    {
        $class = factory(Classes::class)->create();
        $date = date('Y-m-d');

        $newBooking = [
            'name' => 'Test',
            'date' => $date,
        ];
        $response = $this->call('POST', '/api/bookings/', $newBooking);
        $this->assertEquals(201, $response->status());
        $this->seeJson($newBooking);
        $this->seeInDatabase('bookings', $newBooking);
    }

    /** @test */
    public function itCanNotInsertBookingWhenItWouldExceedClassesCapacity()
    {
        $class = factory(Classes::class)->create([
            'capacity' => 1,
        ]);

        factory(Booking::class)->create([
            'classes_id' => $class->id,
        ]);

        $date = date('Y-m-d');
        $newBooking = [
            'name' => 'Test',
            'date' => $date,
        ];

        $response = $this->call('POST', '/api/bookings/', $newBooking);
        $this->assertEquals(409, $response->status());
    }

    /** @test */
    public function itCanNotInsertBookingWhenNameIsNotInformed()
    {
        $date = date('Y-m-d');

        $newBooking = [
            'date' => $date,
        ];
        $response = $this->call('POST', '/api/bookings/', $newBooking);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertBookingWhenNameNotString()
    {
        $date = date('Y-m-d');

        $newBooking = [
            'name' => 1,
            'date' => $date,
        ];
        $response = $this->call('POST', '/api/bookings/', $newBooking);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertBookingWhenNameIsLessThanTwoCharacters()
    {
        $date = date('Y-m-d');

        $newBooking = [
            'name' => 'a',
            'date' => $date,
        ];
        $response = $this->call('POST', '/api/bookings/', $newBooking);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertBookingWhenDateIsNotInformed()
    {
        $newBooking = [
            'name' => 'Test',
        ];
        $response = $this->call('POST', '/api/bookings/', $newBooking);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertBookingWhenDateIsBeforeToday()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime($today.' -1 day'));
        $newBooking = [
            'name' => 'Test',
            'date' => $yesterday,
        ];
        $response = $this->call('POST', '/api/bookings/', $newBooking);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertBookingWhenDateIsWithWrongFormat()
    {
        $date = date('d-m-Y');

        $newBooking = [
            'name' => 'Test',
            'date' => $date,
        ];
        $response = $this->call('POST', '/api/bookings/', $newBooking);
        $this->assertEquals(422, $response->status());
    }
}
