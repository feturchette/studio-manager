<?php

namespace Tests\Functional\Api\Classes;

use Tests\TestCase;
use App\Api\Classes\Classes;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DeleteClassTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itCanDeleteCreatedClasses()
    {
        $class = factory(Classes::class)->create();

        $response = $this->call('DELETE', '/api/classes/'.$class->id);
        $this->assertEquals(200, $response->status());
    }
}
