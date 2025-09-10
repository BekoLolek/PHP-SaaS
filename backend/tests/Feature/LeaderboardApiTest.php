<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Leaderboard;
use App\Models\Player;
use App\Models\Score;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetsUpApiBasics;

class LeaderboardApiTest extends TestCase
{
    use RefreshDatabase, SetsUpApiBasics;

    protected function setUp(): void{
        parent::setUp();
        $this->setUpApiBasics();
    }

    /** @test */
    public function it_returns_top_scores_for_a_leaderboard()
    {
        Score::factory()->create([
            'leaderboard_id' => $this->leaderboard1->id,
            'player_id' => $this->player1->id,
            'score_value' => 2000
        ]);

        Score::factory()->create([
            'leaderboard_id' => $this->leaderboard1->id,
            'player_id' => $this->player2->id,
            'score_value' => 1500
        ]);

        $response = $this->withHeaders([
            'X-API-KEY' => $this->tenant1->api_key,
            'X-API-SECRET' => $this->tenant1->api_secret,
        ])->getJson("/api/leaderboard/{$this->leaderboard1->id}");

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['player_name' => 'Alice', 'score_value' => 2000])
            ->assertJsonFragment(['player_name' => 'Bob', 'score_value' => 1500]);
    }
}
