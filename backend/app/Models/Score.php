<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Score
 *
 * @property int $id
 * @property int $leaderboard_id
 * @property int $player_id
 * @property int $score_value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Leaderboard $leaderboard
 * @property Player $player
 *
 * @package App\Models
 */
class Score extends Model
{
    use HasFactory;
	protected $table = 'scores';

	protected $casts = [
		'leaderboard_id' => 'int',
		'player_id' => 'int',
		'score_value' => 'int',
        'tries' => 'int',
	];

	protected $fillable = [
		'leaderboard_id',
		'player_id',
		'score_value',
        'tries'
	];

	public function leaderboard()
	{
		return $this->belongsTo(Leaderboard::class);
	}

	public function player()
	{
		return $this->belongsTo(Player::class);
	}
}
