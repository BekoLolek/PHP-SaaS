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
 * Class Game
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $name
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Tenant $tenant
 * @property Collection|Player[] $players
 *
 * @package App\Models
 */
class Game extends Model
{
    use HasFactory;
    protected $table = 'games';

	protected $casts = [
		'tenant_id' => 'int'
	];

	protected $fillable = [
		'tenant_id',
		'name',
		'slug'
	];

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

    public function leaderboards()
    {
        return $this->hasMany(Leaderboard::class);
    }

	public function players()
	{
		return $this->hasMany(Player::class);
	}
}
