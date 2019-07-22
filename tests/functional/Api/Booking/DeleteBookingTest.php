<?php

namespace Tests\Functional\Api\Bookings;

use Tests\TestCase;
use App\Api\Booking\Booking;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DeleteBookingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanDeleteCreatedBookings()
    {
        $class = factory(Classes::class)->create();
        $booking = factory(Booking::class)->create([
            'classes_id' => $class->id,
        ]);

        $response = $this->call('DELETE', '/api/bookings/'.$booking->id);
        $this->assertEquals(200, $response->status());
    }
}
