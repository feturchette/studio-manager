<?php

namespace Tests\Functional\Api\Classes;

use Tests\TestCase;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UpdateClassTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanUpdateCreatedClass()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $update = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $update);
        $this->assertEquals(200, $response->status());
        $this->seeJson($update);
        $this->seeInDatabase('classes', $update);
    }

    /** @test */
    public function itCanNotUpdateClassWhenThereAreAtLeastOneClassInsertedBetweenTheDates()
    {
        factory(Classes::class, 2)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $update = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/1', $update);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanUpdateWhenClassNotFound()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $update = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/1', $update);
        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenNameIsNotInformed()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenNameNotString()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 1,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenNameIsLessThanFourCharacters()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'abc',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenStartDateIsNotInformed()
    {
        $class = factory(Classes::class)->create();
        $endDate = date('Y-m-d');
        $newClass = [
            'name' => 'Test',
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenStartDateIsBeforeToday()
    {
        $class = factory(Classes::class)->create();
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime($today.' -1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $yesterday,
            'end_date' => $today,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenStartDateIsWithWrongFormat()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('d-m-Y');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenEndDateIsNotInformed()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenEndDateIsBeforeStartDate()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' -1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenEndDateIsWithWrongFormat()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('d-m-Y', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenCapacityIsNotInformed()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenCapacityIsNotInteger()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 'a',
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotUpdateClassWhenCapacityIsZero()
    {
        $class = factory(Classes::class)->create();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 0,
        ];
        $response = $this->call('PUT', '/api/classes/'.$class->id, $newClass);
        $this->assertEquals(422, $response->status());
    }
}
