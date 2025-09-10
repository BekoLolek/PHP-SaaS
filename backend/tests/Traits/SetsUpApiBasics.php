<?php

namespace Tests\Traits;

use App\Models\Game;
use App\Models\Leaderboard;
use App\Models\Player;
use App\Models\Tenant;

trait SetsUpApiBasics{
    protected $tenant1;
    protected $tenant2;
    protected $game1;
    protected $game2;
    protected $leaderboard1;
    protected $leaderboard2;
    protected $player1;
    protected $player2;

    protected function setUpApiBasics(): void{
        $this->tenant1 = Tenant::factory()->create([
            'api_key' => 'test_key123',
            'api_secret' => 'test_secret123',
        ]);
        $this->game1 = Game::factory()->create([
            'tenant_id' => $this->tenant1->id,
            'name' => 'Game 1',
        ]);
        $this->leaderboard1 = Leaderboard::factory()->create([
            'game_id' => $this->game1->id,
        ]);
        $this->player1 = Player::factory()->create(['game_id' => $this->game1->id, 'player_uid' => 'Alice', 'display_name' => 'Alice']);


        $this->tenant2 = Tenant::factory()->create([
            'api_key' => 'test_key456',
            'api_secret' => 'test_secret456',
        ]);
        $this->game2 = Game::factory()->create([
            'tenant_id' => $this->tenant2->id,
            'name' => 'Game 1',
        ]);
        $this->leaderboard2 = Leaderboard::factory()->create([
            'game_id' => $this->game2->id,
        ]);
        $this->player2 = Player::factory()->create(['game_id' => $this->game2->id, 'player_uid' => 'Bob', 'display_name' => 'Bob']);
    }
}
