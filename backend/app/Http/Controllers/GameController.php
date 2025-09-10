<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Leaderboard;
use Illuminate\Http\Request;

class GameController extends Controller
{
    use ApiResponse;
    public function showAllGamesForTenant(Request $request){
        $tenant = $request->attributes->get('tenant');
        $games = Game::where('tenant_id', $tenant->id)->get()->map(fn($game) => [
            'id' => $game->id,
            'name' => $game->name,
            'slug' => $game->slug,
            'leaderboard_count' => $game->leaderboards->count(),
        ]);

        return $this->successResponse(['games' => $games], 200);
    }

    public function submitNewGameForTenant(Request $request){
        $tenant = $request->attributes->get('tenant');

        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
        ]);

        $game = Game::create([
            'tenant_id' => $tenant->id,
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        return $this->successResponse(['created_game' => $game], 201);

    }

    public function deleteGameForTenant(Request $request){
        $data = $request->validate([
            'id' => 'required|integer',
        ]);
        $tenant = $request->attributes->get('tenant');
        $game = Game::FindOrFail($data['id']);
        if($game->tenant->id !== $tenant->id){
            return response()->json(['error' => 'Access denied'], 404);
        }
        $game->delete();
        $game->makeHidden(['tenant']);
        return $this->successResponse(['deleted_game' => $game], 200);


    }

    public function showLeaderboardsForGame(Request $request){
        $tenant = $request->attributes->get('tenant');

        $data = $request->validate([
            'id' => 'required|integer|exists:games,id',
        ]);

        $game = Game::findOrFail($data['id']);

        if($game->tenant->id != $tenant->id){
            return response()->json(['error' => 'Access denied'], 404);
        }

        $leaderboards = $game->leaderboards;

        return $this->successResponse(['leaderboards' => $leaderboards], 200);
    }
}
