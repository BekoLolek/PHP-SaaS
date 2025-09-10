<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'player_uid' => $this->faker->unique()->userName,
            'display_name' => $this->faker->name,
        ];
    }
}
