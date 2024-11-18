<?php

namespace Tests\Feature;

use App\Models\Route;
use App\Models\Stop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreRoute()
    {
        $stops = Stop::factory()->count(3)->create();

        $response = $this->postJson('/api/routes', [
            'name' => 'Test Route',
            'stops' => $stops->pluck('id')->toArray(),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'stops' => [
                    '*' => ['id', 'name'],
                ],
            ]);

        $this->assertDatabaseHas('routes', ['name' => 'Test Route']);
    }

    public function testUpdateRoute()
    {
        $route = Route::factory()->create();
        $newStops = Stop::factory()->count(4)->create();

        $response = $this->putJson("/api/routes/{$route->id}", [
            'name' => 'Updated Route',
            'stops' => $newStops->pluck('id')->toArray(),
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'stops' => [
                    '*' => ['id', 'name'],
                ],
            ]);

        $this->assertDatabaseHas('routes', ['id' => $route->id, 'name' => 'Updated Route']);
    }
}
