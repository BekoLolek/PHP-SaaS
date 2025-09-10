<?php

namespace Database\Factories;

use App\Models\Leaderboard;
use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaderboardFactory extends Factory
{
    protected $model = Leaderboard::class;

    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'name' => $this->faker->word.' Leaderboard',
            'mode' => 'BEST',
        ];
    }
}
