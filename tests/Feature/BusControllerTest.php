<?php

namespace Tests\Feature;

use App\Models\Stop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testFindBus()
    {
        $from = Stop::factory()->create();
        $to = Stop::factory()->create();

        $response = $this->getJson("/api/find-bus?from={$from->id}&to={$to->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'from',
                'to',
                'buses' => [
                    '*' => [
                        'route',
                        'next_arrivals',
                    ],
                ],
            ]);
    }
}
