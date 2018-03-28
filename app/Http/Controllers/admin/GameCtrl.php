<?php

namespace App\Http\Controllers\admin;

use App\Games;
use App\Boxscore;
use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $data = Games::orderBy('date_match','desc')
                ->groupBy('date_match')
                ->paginate(5);
        return view('admin.games',[
            'title' => 'Game Schedule',
            'data' => $data
        ]);
    }

    public function store(Request $req)
    {
        $data = array(
            'home_team' => $req->home_team,
            'away_team' => $req->away_team,
            'date_match' => $req->date_match
        );
        $id = Games::create($data)->id;

        return redirect('admin/games/assign/'.$id);
    }

    public function assign($game_id)
    {
        $data = Games::find($game_id);
        return view('admin.assign',[
            'title' => 'Team Roster',
            'data' => $data
        ]);
    }

    public function assignPlayer(Request $req)
    {
        foreach($req->players as $row)
        {
            $data = array(
                'game_id' => $req->game_id,
                'team' => $req->team,
                'player_id' => $row
            );
            Boxscore::create($data);
        }
        return redirect()->back()->with('status',$req->side);

    }

    public function boxscore($game_id)
    {
        $data = Games::find($game_id);
        return view('admin.boxscore',[
            'title' => 'Box Score',
            'data' => $data
        ]);
    }

    public function calculate($game_id)
    {
        $game = Games::find($game_id);
        $home = $game->home_team;
        $away = $game->away_team;
        $game_id = $game->id;

        $home_score = Boxscore::where('team',$home)
                ->where('game_id',$game_id)
                ->sum('pts');
        $away_score = Boxscore::where('team',$away)
            ->where('game_id',$game_id)
            ->sum('pts');
        if($home_score==0 && $away_score==0){
            return redirect()->back();
        }

        if($home_score > $away_score)
        {
            $winner = Boxscore::where('team',$home)
                ->where('game_id',$game_id)
                ->orderBy('pts','desc')
                ->limit(1)
                ->first();
            $winner_id = $winner->player_id;
            $winner_score = $winner->pts;

            $losser = Boxscore::where('team',$away)
                ->where('game_id',$game_id)
                ->orderBy('pts','desc')
                ->limit(1)
                ->first();
            $losser_id = $losser->player_id;
            $losser_score = $losser->pts;
        }else{
            $winner = Boxscore::where('team',$away)
                ->where('game_id',$game_id)
                ->orderBy('pts','desc')
                ->limit(1)
                ->first();
            $winner_id = $winner->player_id;
            $winner_score = $winner->pts;

            $losser = Boxscore::where('team',$home)
                ->where('game_id',$game_id)
                ->orderBy('pts','desc')
                ->limit(1)
                ->first();
            $losser_id = $losser->player_id;
            $losser_score = $losser->pts;
        }

        $winner = ($home_score > $away_score) ? $home:$away;
        $losser = ($home_score < $away_score) ? $home:$away;
        $data = array(
            'home_score' => $home_score,
            'away_score' => $away_score,
            'winner' => $winner,
            'winner_id' => $winner_id,
            'winner_score' => $winner_score,
            'losser_id' => $losser_id,
            'losser_score' => $losser_score,
            'status' => 1
        );
        Games::where('id',$game_id)
            ->update($data);

        Boxscore::where('game_id',$game_id)
            ->where('team',$winner)
            ->update([
                'win' => 1
            ]);

        Boxscore::where('game_id',$game_id)
            ->where('team',$losser)
            ->update([
                'win' => 0
            ]);

        return redirect()->back();
    }

    public function endGame(Request $req,$game_id)
    {
        $news = array(
            'type' => 'score',
            'game_id' => $game_id,
            'contents' => $req->contents
        );
        News::create($news);

        return self::calculate($game_id);
    }

    public function removePlayer($game_id,$player_id)
    {
        Boxscore::where('game_id',$game_id)
            ->where('player_id',$player_id)
            ->delete();
        return redirect()->back()->with('status','deleted');
    }

    public function manualStats($game_id,$player_id)
    {
        $stats = Boxscore::where('game_id',$game_id)
            ->where('player_id',$player_id)
            ->first();
        return $stats;
    }

    public function autoStats($game_id,$player_id,$column,$team)
    {
        Boxscore::where('game_id',$game_id)
            ->where('player_id',$player_id)
            ->increment($column,1);

        if($column=='fg2m'){
            Boxscore::where('game_id',$game_id)
                ->where('player_id',$player_id)
                ->increment('fg2a',1);
            Boxscore::where('game_id',$game_id)
                ->where('player_id',$player_id)
                ->increment('pts',2);
        }else if($column=='fg3m'){
            Boxscore::where('game_id',$game_id)
                ->where('player_id',$player_id)
                ->increment('fg3a',1);
            Boxscore::where('game_id',$game_id)
                ->where('player_id',$player_id)
                ->increment('pts',3);
        }else if($column=='ftm'){
            Boxscore::where('game_id',$game_id)
                ->where('player_id',$player_id)
                ->increment('fta',1);
            Boxscore::where('game_id',$game_id)
                ->where('player_id',$player_id)
                ->increment('pts',1);
        }
        $score = self::getScore($game_id,$team);
        return $score;

    }

    public function getScore($game_id,$team)
    {
        $score = Boxscore::where('game_id',$game_id)
            ->where('team',$team)
            ->sum('pts');

        return $score;
    }

    public function saveManualStats(Request $req)
    {

        $match = array(
            'game_id' => $req->game_id,
            'player_id' => $req->player_id
        );
        $pt1 = $req->ftm * 1;
        $pt2 = $req->f2m * 2;
        $pt3 = $req->f3m * 3;
        $pts = $pt1+$pt2+$pt3;
        $data = array(
            'fg2m' => $req->f2m,
            'fg2a' => $req->f2a,
            'fg3m' => $req->f3m,
            'fg3a' => $req->f3a,
            'ftm' => $req->ftm,
            'fta' => $req->fta,
            'oreb' => $req->oreb,
            'dreb' => $req->dreb,
            'ast' => $req->ast,
            'stl' => $req->stl,
            'blk' => $req->blk,
            'turnover' => $req->turnover,
            'pf' => $req->pf,
            'pts' => $pts
        );
        Boxscore::updateOrCreate($match,$data);
        return redirect()->back();
    }

    public function destroy($game_id)
    {
        Boxscore::where('game_id',$game_id)
            ->delete();

        Games::find($game_id)
            ->delete();
        return redirect('admin/games')->with('status','deleted');
    }

    public function startGame($game_id,$team)
    {
        $data = Games::find($game_id);
        return view('admin.start',[
            'data' => $data,
            'team' => $team
        ]);
    }

    public function scoreboard($game_id)
    {
        $game = Games::find($game_id);
        return view('guest.scoreboard',[
            'game' => $game
        ]);
    }
}
