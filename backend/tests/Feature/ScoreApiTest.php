<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Leaderboard;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetsUpApiBasics;

class ScoreApiTest extends TestCase
{
    use RefreshDatabase, SetsUpApiBasics;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpApiBasics();
    }

    /** @test */
    public function it_can_submit_a_score()
    {
        $payload = [
            'player_name' => 'Alice',
            'leaderboard_id' => $this->leaderboard1->id,
            'score_value' => 1500
        ];

        $response = $this->withHeaders([
            'X-API-KEY' => $this->tenant1->api_key,
            'X-API-SECRET' => $this->tenant1->api_secret,
        ])->postJson('/api/scores/submit', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'score_id']);

        $this->assertDatabaseHas('scores', [
            'score_value' => 1500,
            'leaderboard_id' => $this->leaderboard1->id
        ]);

        $this->assertDatabaseHas('players', [
            'player_uid' => 'Alice',
            'game_id' => $this->game1->id
        ]);
    }
    /** @test */
    public function it_rejects_requests_without_auth()
    {
        $response = $this->postJson('/api/scores/submit', [
            'leaderboard_id' => 1,
            'player_name' => 'Alice',
            'score_value' => 1000,
        ]);

        $response->assertStatus(401);
    }
}
