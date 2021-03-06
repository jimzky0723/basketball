<?php

namespace App\Http\Controllers;

use App\Boxscore;
use App\Comm;
use App\Games;
use App\Players;
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
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb'),
            DB::raw('(SUM(pts) + (SUM(oreb)+SUM(dreb)) + SUM(ast) + SUM(stl) + SUM(blk))-(((SUM(fg2a)+SUM(fg3a)) - (SUM(fg3m)+SUM(fg2m))) + (SUM(fta) - SUM(ftm)) + (SUM(turnover))) as eff')
        )
            ->orderBy('eff','desc')
            ->groupBy('player_id')
            ->first();


        $data['pts'] = array(
            'count' => $stats->pts,
            'value' => 'PPG'
        );
        $data['ast'] = array(
            'count' => $stats->ast,
            'value' => 'APG'
        );
        $data['reb'] = array(
            'count' => $stats->reb,
            'value' => 'RPG'
        );
        $data['stl'] = array(
            'count' => $stats->stl,
            'value' => 'SPG'
        );
        $data['blk'] = array(
            'count' => $stats->blk,
            'value' => 'BPG'
        );

        $array = collect($data)->sortBy('count')->reverse()->toArray();
        $data = array_slice($array, 0, 3);
        return array(
            'player_id' => $stats->player_id,
            'stats' => $data
        );
    }

    static function getWeekPlayer($date)
    {
        $week = date('W',strtotime($date));
        $stats = Boxscore::select(
            'player_id',
            DB::raw('WEEK(games.date_match) as week'),
//            DB::raw('SUM(pts)/count(team) as pts'),
//            DB::raw('SUM(ast)/count(team) as ast'),
//            DB::raw('SUM(stl)/count(team) as stl'),
//            DB::raw('SUM(blk)/count(team) as blk'),
//            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb'),
//            DB::raw('(SUM(pts) + (SUM(oreb)+SUM(dreb)) + SUM(ast) + (SUM(stl)*2) + (SUM(blk)*2))-(((SUM(fg2a)+SUM(fg3a)) - (SUM(fg3m)+SUM(fg2m))) + (SUM(fta) - SUM(ftm)) + ((SUM(turnover)*2))) as eff')
            DB::raw('count(team) as gp'),
            DB::raw('SUM(pts)/count(team) as pts'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('SUM(turnover)/count(team) as turnover'),
            DB::raw('(SUM(oreb)+SUM(dreb))/count(team) as reb'),
            DB::raw('
            (
            (SUM(pts)/count(team)) + 
            ((SUM(oreb)+SUM(dreb))/count(team)) + 
            (SUM(ast)/count(team)) + 
            ((SUM(stl)*2)/count(team)) + 
            ((SUM(blk))*2)/count(team))-
            (
            (((SUM(fg2a)/count(team))+(SUM(fg3a)/count(team))) - 
            ((SUM(fg3m)/count(team))+(SUM(fg2m)/count(team)))) + 
            ((SUM(fta)/count(team)) - (SUM(ftm)/count(team))) + 
            ((SUM(turnover)*2)/count(team)) + 
            ((SUM(pf))/count(team))
            ) 
            as eff')
        )
            ->leftJoin('games','games.id','=','boxscore.game_id')
            ->havingRaw("COUNT(team) > 1")
            ->where(DB::raw('WEEK(games.date_match)'),($week-1))
            ->orderBy('eff','desc')
            ->groupBy('player_id')
            ->first();


        $data['pts'] = array(
            'count' => $stats->pts,
            'value' => 'PPG'
        );
        $data['ast'] = array(
            'count' => $stats->ast,
            'value' => 'APG'
        );
        $data['reb'] = array(
            'count' => $stats->reb,
            'value' => 'RPG'
        );
        $data['stl'] = array(
            'count' => $stats->stl,
            'value' => 'SPG'
        );
        $data['blk'] = array(
            'count' => $stats->blk,
            'value' => 'BPG'
        );

        $array = collect($data)->sortBy('count')->reverse()->toArray();
        $data = array_slice($array, 0, 3);
        return array(
            'player_id' => $stats->player_id,
            'stats' => $data
        );
    }

    static function getWeekPlayerByWeek($date,$player_id)
    {
        $week = date('W',strtotime($date));
        $stats = Boxscore::select(
            'player_id',
            DB::raw('WEEK(games.date_match) as week'),
            DB::raw('SUM(pts)/count(team) as pts'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb'),
            DB::raw('(SUM(pts) + (SUM(oreb)+SUM(dreb)) + SUM(ast) + SUM(stl) + SUM(blk))-(((SUM(fg2a)+SUM(fg3a)) - (SUM(fg3m)+SUM(fg2m))) + (SUM(fta) - SUM(ftm)) + (SUM(turnover))) as eff')
        )
            ->leftJoin('games','games.id','=','boxscore.game_id')
            ->where(DB::raw('WEEK(games.date_match)'),($week-1))
            ->where('boxscore.player_id',$player_id)
            ->first();


        $data['pts'] = array(
            'count' => $stats->pts,
            'value' => 'PPG'
        );
        $data['ast'] = array(
            'count' => $stats->ast,
            'value' => 'APG'
        );
        $data['reb'] = array(
            'count' => $stats->reb,
            'value' => 'RPG'
        );
        $data['stl'] = array(
            'count' => $stats->stl,
            'value' => 'SPG'
        );
        $data['blk'] = array(
            'count' => $stats->blk,
            'value' => 'BPG'
        );

        $array = collect($data)->sortBy('count')->reverse()->toArray();
        $data = array_slice($array, 0, 3);
        return array(
            'player_id' => $stats->player_id,
            'stats' => $data
        );
    }

    static function getMonthPlayer($date)
    {
        $month = (int) date('m',strtotime($date));
        $stats = Boxscore::select(
            'player_id',
            DB::raw('SUM(pts)/count(team) as pts'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('SUM(turnover)/count(team) as turnover'),
            DB::raw('(SUM(oreb)+SUM(dreb))/count(team) as reb'),
            DB::raw('
            (
            (SUM(pts)/count(team)) + 
            ((SUM(oreb)+SUM(dreb))/count(team)) + 
            (SUM(ast)/count(team)) + 
            ((SUM(stl)*2)/count(team)) + 
            ((SUM(blk))*2)/count(team))-
            (
            (((SUM(fg2a)/count(team))+(SUM(fg3a)/count(team))) - 
            ((SUM(fg3m)/count(team))+(SUM(fg2m)/count(team)))) + 
            ((SUM(fta)/count(team)) - (SUM(ftm)/count(team))) + 
            ((SUM(turnover)*2)/count(team)) + 
            ((SUM(pf))/count(team))
            ) 
            as eff')
        )
            ->leftJoin('games','games.id','=','boxscore.game_id')
            ->havingRaw("COUNT(team) > 4")
            ->where(DB::raw('MONTH(games.date_match)'),$month)
            ->orderBy('eff','desc')
            ->groupBy('player_id')
            ->first();



        $data['pts'] = array(
            'count' => $stats->pts,
            'value' => 'PPG'
        );
        $data['ast'] = array(
            'count' => $stats->ast,
            'value' => 'APG'
        );
        $data['reb'] = array(
            'count' => $stats->reb,
            'value' => 'RPG'
        );
        $data['stl'] = array(
            'count' => $stats->stl,
            'value' => 'SPG'
        );
        $data['blk'] = array(
            'count' => $stats->blk,
            'value' => 'BPG'
        );

        $array = collect($data)->sortBy('count')->reverse()->toArray();
        $data = array_slice($array, 0, 3);
        return array(
            'player_id' => $stats->player_id,
            'stats' => $data
        );
    }

    static function getPlayerStatsByMonth($month_no,$player_id)
    {
        $stats = Boxscore::select(
            DB::raw('count(team) as gp'),
            DB::raw('SUM(win)/count(team) as win'),
            DB::raw('(SUM(fg2m) + SUM(fg3m))/count(team) as fgm'),
            DB::raw('(SUM(fg2a) + SUM(fg3a))/count(team) as fga'),
            DB::raw('(SUM(fg2m) + SUM(fg3m))/(SUM(fg2a) + SUM(fg3a)) as fg_per'),
            DB::raw('SUM(fg3m)/count(team) as fg3m'),
            DB::raw('SUM(fg3a)/count(team) as fg3a'),
            DB::raw('(SUM(fg3m))/(SUM(fg3a)) as fg3_per'),
            DB::raw('SUM(ftm)/count(team) as ftm'),
            DB::raw('SUM(fta)/count(team) as fta'),
            DB::raw('(SUM(ftm))/(SUM(fta)) as ft_per'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb'),
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('SUM(pf)/count(team) as pf'),
            DB::raw('SUM(turnover)/count(team) as turnover'),
            DB::raw('SUM(pts)/count(team) as pts')
        )
            ->leftJoin('games','games.id','=','boxscore.game_id')
            ->where(DB::raw('MONTH(games.date_match)'),$month_no)
            ->where('boxscore.player_id',$player_id)
            ->first();
        return $stats;
    }

    static function getMonthPlayerByMonth($date,$player_id)
    {
        $month = (int) date('m',strtotime($date));
        $stats = Boxscore::select(
            'player_id',
            DB::raw('SUM(pts)/count(team) as pts'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb'),
            DB::raw('(SUM(pts) + (SUM(oreb)+SUM(dreb)) + SUM(ast) + SUM(stl) + SUM(blk))-(((SUM(fg2a)+SUM(fg3a)) - (SUM(fg3m)+SUM(fg2m))) + (SUM(fta) - SUM(ftm)) + (SUM(turnover))) as eff')
        )
            ->leftJoin('games','games.id','=','boxscore.game_id')
            ->where(DB::raw('MONTH(games.date_match)'),$month)
            ->where('boxscore.player_id',$player_id)
            ->first();


        $data['pts'] = array(
            'count' => $stats->pts,
            'value' => 'PPG'
        );
        $data['ast'] = array(
            'count' => $stats->ast,
            'value' => 'APG'
        );
        $data['reb'] = array(
            'count' => $stats->reb,
            'value' => 'RPG'
        );
        $data['stl'] = array(
            'count' => $stats->stl,
            'value' => 'SPG'
        );
        $data['blk'] = array(
            'count' => $stats->blk,
            'value' => 'BPG'
        );

        $array = collect($data)->sortBy('count')->reverse()->toArray();
        $data = array_slice($array, 0, 3);
        return array(
            'player_id' => $stats->player_id,
            'stats' => $data
        );
    }

    static function getPlayerStats($id)
    {
        $stats = Boxscore::select(
            'player_id',
            DB::raw('SUM(pts)/count(team) as pts'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb'),
            DB::raw('(SUM(pts) + (SUM(oreb)+SUM(dreb)) + SUM(ast) + SUM(stl) + SUM(blk))-(((SUM(fg2a)+SUM(fg3a)) - (SUM(fg3m)+SUM(fg2m))) + (SUM(fta) - SUM(ftm)) + (SUM(turnover))) as eff')
        )
            ->where('player_id',$id)
            ->first();


        $data['pts'] = array(
            'count' => $stats->pts,
            'value' => 'PPG'
        );
        $data['ast'] = array(
            'count' => $stats->ast,
            'value' => 'APG'
        );
        $data['reb'] = array(
            'count' => $stats->reb,
            'value' => 'RPG'
        );
        $data['stl'] = array(
            'count' => $stats->stl,
            'value' => 'SPG'
        );
        $data['blk'] = array(
            'count' => $stats->blk,
            'value' => 'BPG'
        );

        $array = collect($data)->sortBy('count')->reverse()->toArray();
        $data = array_slice($array, 0, 3);
        return array(
            'player' => Players::find($id),
            'stats' => $data
        );
    }

    static function getFeaturedPlayer($id)
    {

        $featured = Boxscore::select(
            'player_id',
            DB::raw('SUM(pts)/count(team) as pts'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb')
        )
            ->where('player_id',$id)
            ->first();
        return $featured;
    }

    static function getCommitteeOfTheWeek()
    {
        $date = date('M d, Y');
        $comm = Comm::limit(6)->get();
        if(isset($comm)){
            $date = Comm::first()->schedule;
        }

        return array(
            'comm' => $comm,
            'date' => $date
        );
    }

    function pictures($folder,$file)
    {
        $url = 'public/upload/'.$folder.'/'.$file;
        return response()->file($url);
    }

}
