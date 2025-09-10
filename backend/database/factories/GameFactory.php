<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
        ];
    }
}
