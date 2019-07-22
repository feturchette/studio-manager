<?php

namespace Tests\Functional\Api\Bookings;

use Tests\TestCase;
use App\Api\Booking\Booking;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class GetClassesBookingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanGetCreatedBookingOfAClass()
    {
        $class = factory(Classes::class)->create([
            'capacity' => 2
        ]);
        factory(Booking::class,2)->create([
            'classes_id' => $class->id,
        ]);
        $class = Classes::find(1)->toArray();

        $response = $this->call('GET', '/api/classes/'.$class['id'].'/bookings/');
        $this->assertEquals(200, $response->status());
        $this->seeJson($class);
    }

    /** @test */
    public function itCanNotGetWhenClassNotFound()
    {
        $response = $this->call('GET', '/api/classes/1/bookings/');
        $this->assertEquals(404, $response->status());
    }
}
