<?php

namespace Tests\Functional\Api\Classes;

use Tests\TestCase;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class InsertClassTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanInsertClass()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(201, $response->status());
        $this->seeJson($newClass);
        $this->seeInDatabase('classes', $newClass);
    }

    /** @test */
    public function itCanNotInsertClassWhenThereAreAtLeastOneClassInsertedBetweenTheDates()
    {
        factory(Classes::class)->create();
        $class = Classes::find(1)->toArray();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenNameIsNotInformed()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenNameNotString()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 1,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenNameIsLessThanFourCharacters()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'abc',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenStartDateIsNotInformed()
    {
        $endDate = date('Y-m-d');
        $newClass = [
            'name' => 'Test',
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenStartDateIsBeforeToday()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime($today.' -1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $yesterday,
            'end_date' => $today,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenStartDateIsWithWrongFormat()
    {
        $startDate = date('d-m-Y');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenEndDateIsNotInformed()
    {
        $startDate = date('Y-m-d');
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenEndDateIsBeforeStartDate()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' -1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenEndDateIsWithWrongFormat()
    {
        $startDate = date('Y-m-d');
        $endDate = date('d-m-Y', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 10,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenCapacityIsNotInformed()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenCapacityIsNotInteger()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 'a',
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }

    /** @test */
    public function itCanNotInsertClassWhenCapacityIsZero()
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));
        $newClass = [
            'name' => 'Test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => 0,
        ];
        $response = $this->call('POST', '/api/classes/', $newClass);
        $this->assertEquals(422, $response->status());
    }
}
