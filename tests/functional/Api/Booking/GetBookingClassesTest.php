<?php

namespace Tests\Functional\Api\Bookings;

use Tests\TestCase;
use App\Api\Booking\Booking;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class GetBookingClassesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanGetCreatedClassOfABooking()
    {
        $class = factory(Classes::class)->create();
        factory(Booking::class)->create([
            'classes_id' => $class->id,
        ]);
        $booking = Booking::find(1)->toArray();

        $response = $this->call('GET', '/api/bookings/'.$booking['id'].'/classes/');
        $this->assertEquals(200, $response->status());
        $this->seeJson($booking);
    }

    /** @test */
    public function itCanNotGetWhenBookingNotFound()
    {
        $response = $this->call('GET', '/api/bookings/1/classes');
        $this->assertEquals(404, $response->status());
    }
}
