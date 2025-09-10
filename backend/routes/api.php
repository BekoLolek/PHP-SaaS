<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\TenantController;
use App\Http\Middleware\ApiKeyAuth;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiKeyAuth::class)->group(function () {
    //Score routes
    Route::post('/scores/submit', [ScoreController::class, 'submitNewScoreForPlayer']);
    Route::delete('/scores/delete', [ScoreController::class, 'deleteScoreForPlayer']);

    //Leaderboard routes
    Route::get('/leaderboard', [LeaderboardController::class, 'getTopTenLeaderboardScores']);
    Route::post('/leaderboard/submit', [LeaderboardController::class, 'submitNewLeaderboard']);
    Route::delete('/leaderboard/delete', [LeaderboardController::class, 'deleteLeaderboard']);
    Route::get('/leaderboard/scores', [LeaderboardController::class, 'getAllLeaderboardScores']);
    Route::get('/leaderboard/stats', [LeaderboardController::class, 'getLeaderboardStats']);

    //Player routes
    Route::get('/players/scores', [PlayerController::class, 'showScoresForPlayer']);

    //Game routes
    Route::get('/games', [GameController::class, 'showAllGamesForTenant']);
    Route::post('/games/submit', [GameController::class, 'submitNewGameForTenant']);
    Route::delete('/games/delete', [GameController::class, 'deleteGameForTenant']);
    Route::get('/games/leaderboards', [GameController::class, 'showLeaderboardsForGame']);

    //Tenant routes
    Route::get('/tenants/me', [TenantController::class, 'showTenantInfo']);


    //Website routes
    Route::get('/tenants/generate_new_api', [TenantController::class, 'generateNewApiForTenant']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
