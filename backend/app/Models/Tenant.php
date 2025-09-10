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
 * Class Tenant
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $plan
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Game[] $games
 * @property Collection|Leaderboard[] $leaderboards
 *
 * @package App\Models
 */
class Tenant extends Model
{
    use HasFactory;
	protected $table = 'tenants';

	protected $casts = [
		'active' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'password',
		'email',
		'plan',
		'active',
        'api_key',
        'api_secret',
	];

	public function games()
	{
		return $this->hasMany(Game::class);
	}

	public function leaderboards()
	{
		return $this->hasMany(Leaderboard::class);
	}
}
