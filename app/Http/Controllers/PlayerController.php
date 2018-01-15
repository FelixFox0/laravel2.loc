<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Player;
use App\Http\Requests\PlayerRequest;
use Illuminate\Http\Request;

class PlayerController extends Controller
{

    public function show(Request $request)
    {

        $start = $request->start ?? 0;
        $n = $request->n ?? 10;

        $players = Player::getPlayers($start, $n, $request->level, $request->search);
        return response()->json([
            'players' => $players['players'],
        ])->header('x-total', $players['total'])->header('access-control-expose-headers', 'x-total');
    }

    public function store(PlayerRequest $request)
    {
        $player = new Player();
        $player->name = mb_strtolower($request->name);
        $player->level = $request->level;
        $player->score = $request->score;
        $player->suspected = $request->suspected;
        if ($player->save()) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

}
