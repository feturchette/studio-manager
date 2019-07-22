<?php

namespace Tests\Functional\Api\Bookings;

use Tests\TestCase;
use App\Api\Booking\Booking;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ListBookingsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanListCreatedBookings()
    {
        $class = factory(Classes::class)->create([
            'capacity' => 3,
        ]);
        factory(Booking::class, 2)->create([
            'classes_id' => $class->id,
        ]);

        $booking1 = Booking::find(1)->toArray();
        $booking2 = Booking::find(2)->toArray();

        $response = $this->call('GET', '/api/bookings/');
        $this->assertEquals(200, $response->status());
        $this->seeJson($booking1);
        $this->seeJson($booking2);
    }

    /** @test */
    public function itCanListPaginatingCreatedBookings()
    {
        $class = factory(Classes::class)->create([
            'capacity' => 1,
        ]);
        factory(Booking::class, 2)->create([
            'classes_id' => $class->id,
        ]);

        $booking1 = Booking::find(1)->toArray();
        $booking2 = Booking::find(2)->toArray();

        $response = $this->call('GET', '/api/bookings?page=1&limit=1');
        $this->assertEquals(200, $response->status());
        $this->seeJson($booking1);

        $response = $this->call('GET', '/api/bookings?page=2&limit=1');
        $this->assertEquals(200, $response->status());
        $this->seeJson($booking2);
    }

    /** @test */
    public function itCanListEmpty()
    {
        $response = $this->call('GET', '/api/bookings/');
        $this->assertEquals(204, $response->status());
        $this->seeJson(['data' => []]);
    }
}
