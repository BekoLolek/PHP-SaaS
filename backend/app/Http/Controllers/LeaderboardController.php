<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaderboardController extends Controller
{
    use ApiResponse;

    public function getTopTenLeaderboardScores(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:leaderboards,id',
        ]);

        $leaderboard = Leaderboard::findOrFail($data['id']);

        $tenant = $request->attributes->get('tenant');
        if($leaderboard->game->tenant->id != $tenant->id){
            return response()->json(['error' => 'Access denied'], 404);
        }

        $scores = $leaderboard->scores->sortByDesc('score_value')->map(fn($score) => [
            'player_name' => $score->player->display_name ?? $score->player->player_uid,
            'score_value' => $score->score_value,
            'tries' => $score->tries,
        ])
        ->take(10)
        ->values();

        return $this->successResponse(['top_ten_scores' => $scores], 200);

    }

    public function getAllLeaderboardScores(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:leaderboards,id',
        ]);
        $leaderboard = Leaderboard::findOrFail($data['id']);
        $tenant = $request->attributes->get('tenant');
        if($leaderboard->game->tenant->id != $tenant->id){
            return response()->json(['error' => 'Access denied'], 404);
        }

        $scores = $leaderboard->scores->sortByDesc('score_value')->map(fn($score) => [
            'player_name' => $score->player->display_name ?? $score->player->player_uid,
            'score_value' => $score->score_value,
            'tries' => $score->tries,
        ])
            ->values();

        return $this->successResponse(['all_scores' => $scores], 200);
    }

    public function submitNewLeaderboard(Request $request){


        $data = $request->validate([
           'game_id' => 'required|integer|exists:games,id',
           'name' => 'required|string',
           'mode'  => ['required',
               Rule::in(['BEST', 'CUMULATIVE', 'TIME_ASC'])],
        ]);

        $tenant = $request->attributes->get('tenant');

        $game = Game::where('id', $data['game_id'])
            ->where('tenant_id', $tenant->id)
            ->first();

        if (! $game) {
            return response()->json(['error' => 'Game not found or access denied'], 404);
        }

        $leaderboard = Leaderboard::create([
            'game_id' => $data['game_id'],
            'name' => $data['name'],
            'mode' => $data['mode'],
        ]);

        return $this->successResponse(['created_leaderboard' => $leaderboard], 201);

    }

    public function deleteLeaderboard(Request $request){
        $data = $request->validate([
            'id' => 'required|integer'
        ]);
        $leaderboard = Leaderboard::FindOrFail($data['id']);

        $tenant = $request->attributes->get('tenant');

        if($leaderboard->game->tenant->id != $tenant->id){
            return response()->json(['error' => 'Access denied'], 404);
        }



        $leaderboard->delete();


        return $this->successResponse(['deleted_leaderboard' => $leaderboard], 200);
    }

    public function getLeaderboardStats(Request $request){
        $data = $request->validate([
            'id' => 'required|integer|exists:leaderboards,id',
        ]);

        $leaderboard = Leaderboard::findOrFail($data['id']);

        $tenant = $request->attributes->get('tenant');

        if($leaderboard->game->tenant->id != $tenant->id){
            return response()->json(['error' => 'Access denied'], 404);
        }
        //total players count, top 3 scores, avg scores, avg tries
        $totalPlayersCount = $leaderboard->scores->count();

        $topScores = $leaderboard->scores->sortByDesc('score_value')->take(3);
        $avgScores = $leaderboard->scores->avg('score_value');
        $avgTries = $leaderboard->scores->avg('tries');

        $stats = [
            'totalPlayersCount' => $totalPlayersCount,
            'topScores' => $topScores,
            'avgScores' => $avgScores,
            'avgTries' => $avgTries,
        ];

        return $this->successResponse(['stats' => $stats], 200);
    }
}

