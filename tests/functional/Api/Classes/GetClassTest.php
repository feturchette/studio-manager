<?php

namespace Tests\Functional\Api\Classes;

use Tests\TestCase;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class GetClassTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanGetCreatedClass()
    {
        factory(Classes::class)->create();
        $class = Classes::find(1)->toArray();

        $response = $this->call('GET', '/api/classes/'.$class['id']);
        $this->assertEquals(200, $response->status());
        $this->seeJson($class);
    }

    /** @test */
    public function itCanNotGetWhenClassNotFound()
    {
        $response = $this->call('GET', '/api/classes/1');
        $this->assertEquals(404, $response->status());
    }
}
