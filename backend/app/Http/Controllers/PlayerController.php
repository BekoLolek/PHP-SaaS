<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    use ApiResponse;

    public function showScoresForPlayer(Request $request){

        $data = $request->validate([
            'id' => 'required|integer|exists:players,id',
        ]);
        $tenant = $request->attributes->get('tenant');



        $player = Player::findOrFail($data['id']);
        if($player->game->tenant->id != $tenant->id){
            return response()->json(['error' => 'Access denied'], 404);
        }
        $scores = $player->scores->map(fn($score) => [
            'game_name' => $score->leaderboard->game->slug,
            'leaderboard_name' => $score->leaderboard->name,
            'player_name' => $score->player->display_name,
            'score' => $score->score,
            'tries' => $score->tries,
        ])
        ->sortByDesc('score_value')
        ->values();

        return $this->successResponse(['scores' => $scores], 200);
    }
}
