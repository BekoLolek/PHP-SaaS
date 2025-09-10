<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use App\Models\Leaderboard;
use App\Models\Player;
use App\Models\Score;

class LeaderboardSeeder extends Seeder
{
    public function run(): void
    {
        // Clear tables first
        DB::table('scores')->truncate();
        DB::table('players')->truncate();
        DB::table('leaderboards')->truncate();
        DB::table('games')->truncate();
        DB::table('tenants')->truncate();

        // Create 2 tenants
        $tenant1 = Tenant::create([
            'name' => 'Tenant One',
            'email' => 'tenant1@example.com',
            'password' => bcrypt('password1'),
            'api_key' => 'apikeytest123',
            'api_secret' => 'apisecrettest123',
            'plan' => 'free',
            'active' => true
        ]);

        $tenant2 = Tenant::create([
            'name' => 'Tenant Two',
            'email' => 'tenant2@example.com',
            'password' => bcrypt('password2'),
            'api_key' => 'apikeytest456',
            'api_secret' => 'apisecrettest456',
            'plan' => 'pro',
            'active' => true
        ]);

        // Create 1 game per tenant
        $game1 = Game::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Game One',
            'slug' => 'game-one'
        ]);

        $game2 = Game::create([
            'tenant_id' => $tenant2->id,
            'name' => 'Game Two',
            'slug' => 'game-two'
        ]);

        // Create 1 leaderboard per game
        $leaderboard1 = Leaderboard::create([
            'game_id' => $game1->id,
            'name' => 'Leaderboard One',
            'mode' => 'BEST'
        ]);

        $leaderboard2 = Leaderboard::create([
            'game_id' => $game2->id,
            'name' => 'Leaderboard Two',
            'mode' => 'BEST'
        ]);

        // Create 1 player per game
        $player1 = Player::create([
            'game_id' => $game1->id,
            'player_uid' => 'player1',
            'display_name' => 'Alice'
        ]);

        $player2 = Player::create([
            'game_id' => $game2->id,
            'player_uid' => 'player2',
            'display_name' => 'Bob'
        ]);

        // Add 1 score per player
        Score::create([
            'leaderboard_id' => $leaderboard1->id,
            'player_id' => $player1->id,
            'score_value' => 1500,
            'tries' => 3,
        ]);

        Score::create([
            'leaderboard_id' => $leaderboard2->id,
            'player_id' => $player2->id,
            'score_value' => 1200
        ]);
    }
}
