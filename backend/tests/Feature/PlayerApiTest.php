<?php

namespace Tests\Feature;

use App\Models\Score;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\SetsUpApiBasics;

class PlayerApiTest extends TestCase
{
    use RefreshDatabase, SetsUpApiBasics;
    protected function setUp(): void{
        parent::setUp();
        $this->setUpApiBasics();
    }
    /** @test */
    public function it_returns_all_scores_for_player(): void
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
        ])->getJson('/api/player/'.$this->player1->id.'/scores');

        $response->assertStatus(200)->assertJsonCount(1)
            ->assertJsonFragment(['player_name' => 'Alice', 'score_value' => 2000]);
    }
}
