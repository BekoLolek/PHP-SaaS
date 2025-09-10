<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\SetsUpApiBasics;

class GameApiTest extends TestCase
{
    use RefreshDatabase, SetsUpApiBasics;
    protected function setUp(): void{
        parent::setUp();
        $this->setUpApiBasics();
    }
    /** @test */
    public function it_returns_all_games_of_tenant(): void
    {
        $response = $this->withHeaders([
            'X-API-KEY' => $this->tenant1->apiKey,
            'X-API-SECRET' => $this->tenant1->secret,
        ])->getJson('/api/games');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment(['name' => 'Game 1']);
    }
}
