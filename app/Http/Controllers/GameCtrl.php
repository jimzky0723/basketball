<?php

namespace App\Http\Controllers;

use App\Boxscore;
use Illuminate\Http\Request;

class GameCtrl extends Controller
{
    static function getScore($game_id,$team)
    {
        $score = Boxscore::where('game_id',$game_id)
                ->where('team',$team)
                ->sum('pts');

        return $score;
    }
}
