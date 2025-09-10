<?php

namespace Database\Factories;

use App\Models\Score;
use App\Models\Player;
use App\Models\Leaderboard;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    protected $model = Score::class;

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'leaderboard_id' => Leaderboard::factory(),
            'score_value' => $this->faker->numberBetween(100, 5000),
        ];
    }
}
