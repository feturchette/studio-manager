<?php

namespace Tests\Functional\Api\Classes;

use Tests\TestCase;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ListClassesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanListCreatedClasses()
    {
        factory(Classes::class, 2)->create();

        $class1 = Classes::find(1)->toArray();
        $class2 = Classes::find(2)->toArray();

        $response = $this->call('GET', '/api/classes/');
        $this->assertEquals(200, $response->status());
        $this->seeJson($class1);
        $this->seeJson($class2);
    }

    /** @test */
    public function itCanListPaginatingCreatedClasses()
    {
        factory(Classes::class, 2)->create();

        $class1 = Classes::find(1)->toArray();
        $class2 = Classes::find(2)->toArray();

        $response = $this->call('GET', '/api/classes?page=1&limit=1');
        $this->assertEquals(200, $response->status());
        $this->seeJson($class1);

        $response = $this->call('GET', '/api/classes?page=2&limit=1');
        $this->assertEquals(200, $response->status());
        $this->seeJson($class2);
    }

    /** @test */
    public function itCanListEmpty()
    {
        $response = $this->call('GET', '/api/classes/');
        $this->assertEquals(204, $response->status());
        $this->seeJson(['data' => []]);
    }
}
