<?php

namespace App\Http\Controllers;

use App\Boxscore;
use App\Games;
use App\News;
use App\Players;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeCtrl extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $news = News::orderBy('id','desc')->paginate(5);
        return view('guest.home',[
            'title' => 'DOH Basketball Club',
            'news' => $news
        ]);
    }

    public function filterPlayers(Request $req)
    {
        $filter = $req->filter;
        Session::put('filterPlayer',$filter);
        return self::players();
    }

    public function players()
    {
        $data = Players::orderBy('lname','asc');
        $filter = Session::get('filterPlayer');
        if(isset($filter)){
            $data = $data->where('position','like',"%$filter%");
        }
        $data = $data->paginate(20);
        return view('guest.players',[
            'title' => 'Players',
            'data' => $data,
            'filter' => $filter
        ]);
    }

    public function profile($player_id)
    {
        $name = Players::find($player_id);
        $data = Players::find($player_id);

        $stats = Boxscore::select(
                    'player_id',
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
                ->where('player_id',$player_id)
                ->first();

        $game_log = Games::select('games.*','boxscore.team as myteam')
                ->leftJoin('boxscore','boxscore.game_id','=','games.id')
                ->where('boxscore.player_id',$player_id)
                ->where('games.winner','!=','')
                ->orderBy('date_match','desc')
                ->limit(10)
                ->get();

        return view('guest.profile',[
            'title' => '#'.$name->jersey.' '.$name->fname.' '.$name->lname.', '.$name->position,
            'data' => $data,
            'game_log' => $game_log,
            'player_id' => $player_id,
            'stats' => $stats
        ]);
    }

    public function score()
    {
        $data = Games::orderBy('date_match','desc')
                ->groupBy('date_match')
                ->paginate(1);
        return view('guest.score',[
            'title' => 'Scoreboard',
            'data' => $data
        ]);
    }

    public function boxscore($game_id)
    {
        $data = Games::find($game_id);
        return view('guest.boxscore',[
            'title' => 'Box Score',
            'data' => $data
        ]);
    }

    public function filterRanking(Request $req)
    {
        $filter = $req->filter;
        Session::put('filterRanking',$filter);
        return self::ranking();
    }

    public function ranking()
    {

        $stats = Boxscore::select(
            'player_id',
            DB::raw('count(team) as gp'),
            DB::raw('SUM(pts) as pts'),
            DB::raw('SUM(ast) as ast'),
            DB::raw('SUM(stl) as stl'),
            DB::raw('SUM(blk) as blk'),
            DB::raw('SUM(turnover) as turnover'),
            DB::raw('(SUM(oreb)+SUM(dreb)) as reb'),
            DB::raw('(SUM(pts) + (SUM(oreb)+SUM(dreb)) + SUM(ast) + SUM(stl) + SUM(blk))-(((SUM(fg2a)+SUM(fg3a)) - (SUM(fg3m)+SUM(fg2m))) + (SUM(fta) - SUM(ftm)) + (SUM(turnover))) as eff')
        );

        $filter = Session::get('filterRanking');
        if(isset($filter)){
            $stats = $stats->leftJoin('players','players.id','=','boxscore.player_id')
                    ->where('players.position','like',"%$filter%");
        }

        $stats = $stats
            ->orderBy('eff','desc')
            ->groupBy('player_id')
            ->limit(30)
            ->get();
        return view('guest.ranking',[
            'title' => 'TOP 30 Players: Overall Stats',
            'data' => $stats,
            'filter' => $filter
        ]);
    }

    public function stats(Request $req)
    {
        $sort = 'scoring';
        if($req->sort){
            $sort = $req->sort;
        }
        $data = Boxscore::select(
            'player_id',
            DB::raw('count(team) as gp'),
            DB::raw('SUM(pts)/count(team) as pts'),
            DB::raw('SUM(ast)/count(team) as ast'),
            DB::raw('SUM(stl)/count(team) as stl'),
            DB::raw('SUM(blk)/count(team) as blk'),
            DB::raw('SUM(fg2m)/count(team) as fg2m'),
            DB::raw('SUM(fg2a)/count(team) as fg2a'),
            DB::raw('SUM(fg3m)/count(team) as fg3m'),
            DB::raw('SUM(fg3a)/count(team) as fg3a'),
            DB::raw('SUM(win)/count(team) as win'),
            DB::raw('(SUM(fg2m) + SUM(fg3m))/(SUM(fg2a) + SUM(fg3a)) as fg_per'),
            DB::raw('(SUM(fg3m))/(SUM(fg3a)) as fg3_per'),
            DB::raw('(SUM(ftm))/(SUM(fta)) as ft_per'),
            DB::raw('SUM(turnover)/count(team) as turnover'),
            DB::raw('((SUM(oreb)+SUM(dreb)))/count(team) as reb')
        );

        $title = 'Points Per Game Statistics';
        $col = 'pts';
        if($sort=='assist'){
            $title = 'Assist Per Game Statistics';
            $col = 'ast';
        }else if($sort=='rebound'){
            $title = 'Rebound Per Game Statistics';
            $col = 'reb';
        }else if($sort=='steal'){
            $title = 'Steal Per Game Statistics';
            $col = 'stl';
        }else if($sort=='turnover'){
            $title = 'Turnover Per Game Statistics';
            $col = 'turnover';
        }else if($sort=='fieldgoal'){
            $title = 'Field Goal %';
            $col = 'fg_per';
        }else if($sort=='block'){
            $title = 'Block Per Game Statistics';
            $col = 'blk';
        }else if($sort=='3-fieldgoal'){
            $title = '3-Point Field Goals %';
            $col = 'fg3_per';
        }else if($sort=='freethrow'){
            $title = 'Free-Throw Shooting Statistics';
            $col = 'ft_per';
        }else if($sort=='winning'){
            $title = 'Winning Percentage';
            $col = 'win';
        }

        $data = $data->orderBy($col,'desc')
            ->groupBy('player_id')
            ->limit(30)
            ->get();

        return view('guest.stats',[
            'title' => $title,
            'data' => $data,
            'sort' => $col
        ]);
    }
}
