<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Player
 *
 * @property int $id
 * @property int $game_id
 * @property string $player_uid
 * @property string|null $display_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Game $game
 * @property Collection|Score[] $scores
 *
 * @package App\Models
 */
class Player extends Model
{
    use HasFactory;
	protected $table = 'players';

	protected $casts = [
		'game_id' => 'int'
	];

	protected $fillable = [
		'game_id',
		'player_uid',
		'display_name'
	];

	public function game()
	{
		return $this->belongsTo(Game::class);
	}

	public function scores()
	{
		return $this->hasMany(Score::class);
	}
}
