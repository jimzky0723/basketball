<?php

namespace App\Http\Controllers;

use App\Boxscore;
use App\Games;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParamCtrl extends Controller
{
    static function getAge($date){
        //date in mm/dd/yyyy format; or it can be in other formats as well
        $birthDate = date('m/d/Y',strtotime($date));
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        return $age;
    }

    static function getTopPlayer()
    {
        $stats = Boxscore::select(
                'player_id',
                DB::raw('SUM(pts)/count(team) as pts'),
                DB::raw('SUM(ast)/count(team) as ast'),
                DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb'),
                DB::raw('(SUM(pts) + (SUM(oreb)+SUM(dreb)) + SUM(ast) + SUM(stl) + SUM(blk))-(((SUM(fg2a)+SUM(fg3a)) - (SUM(fg3m)+SUM(fg2m))) + (SUM(fta) - SUM(ftm)) + (SUM(turnover))) as eff')
            )
            ->orderBy('eff','desc')
            ->groupBy('player_id')
            ->first();
        return $stats;
    }

}
