<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\Player;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    use ApiResponse;

    public function submitNewScoreForPlayer(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'leaderboard_id' => 'required|exists:leaderboards,id',
            'player_name' => 'required|string',
            'score_value' => 'required|integer',
        ]);
        $leaderboard = Leaderboard::findOrFail($data['leaderboard_id']);
        $tenant = $request->attributes->get('tenant');
        if ($leaderboard->game->tenant->id != $tenant->id) {
            return response()->json(['error' => 'Access denied'], 404);
        }
        $player = Player::firstOrCreate(
            ['player_uid' => $data['player_name'], 'game_id' => $leaderboard->game_id],
            ['display_name' => $data['player_name']]
        );

        $score = Score::firstOrNew([
            'leaderboard_id' => $data['leaderboard_id'],
            'player_id' => $player->id
        ]);

        if($data['score_value'] > $score->score_value){
            $score->score_value = $data['score_value'];
        }

        $score->tries ++;
        $score->save();

        return $this->successResponse(['submitted_score' => $score], 200);
    }

    public function deleteScoreForPlayer(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer',
        ]);

        $score = Score::FindOrFail($data['id']);

        $tenant = $request->attributes->get('tenant');

        if ($score->leaderboard->game->tenant->id != $tenant->id) {
            return response()->json(['error' => 'Access denied'], 404);
        }

        $score->delete();
        return $this->successResponse(['deleted_score' => $score], 200);
    }
}
