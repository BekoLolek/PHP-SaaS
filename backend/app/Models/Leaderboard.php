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
 * Class Leaderboard
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $name
 * @property string $mode
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Tenant $tenant
 * @property Collection|Score[] $scores
 *
 * @package App\Models
 */
class Leaderboard extends Model
{
    use HasFactory;
    protected $table = 'leaderboards';

	protected $casts = [
		'game_id' => 'int'
	];

	protected $fillable = [
		'game_id',
		'name',
		'mode'
	];

	public function scores()
	{
		return $this->hasMany(Score::class);
	}

    public function game(){
        return $this->belongsTo(Game::class);
    }
}
