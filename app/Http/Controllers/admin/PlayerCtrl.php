<?php

namespace App\Http\Controllers\admin;

use App\Boxscore;
use App\Games;
use App\Players;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PlayerCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $data = Players::orderBy('lname','asc');
        $name = Session::get('searchPlayer');
        if(isset($name))
        {
            $data = $data->where(function($q) use($name){
                $q = $q->where('fname','like',"%$name%")
                    ->orwhere('lname','like',"%$name%")
                    ->orwhere('mname','like',"%$name%")
                    ->orwhere(DB::raw('concat(fname," ",mname," ",lname)'),'like',"%$name%")
                    ->orwhere(DB::raw('concat(fname," ",lname)'),'like',"%$name%")
                    ->orwhere(DB::raw('concat(lname," ",fname," ",mname)'),'like',"%$name%");
            });
        }
        $data = $data->paginate(20);
        return view('admin.players',[
            'title' => 'List of Players',
            'data' => $data
        ]);
    }

    public function searchPlayer(Request $req)
    {
        Session::put('searchPlayer',$req->player);
        return self::index();
    }

    public function create()
    {
        return view('admin.addPlayer',[
            'title' => 'Add Player'
        ]);
    }

    public function store(Request $req)
    {
        $tmp = array(
            $req->fname,
            $req->lname,
            date('Ymd',strtotime($req->dob))
        );
        $unique = implode("",$tmp);

        $prof_pic = 'default.jpg';
        $portrait_pic = 'default.jpg';
        if($_FILES['prof_pic']['name']){
            $prof_pic = self::uploadPicture($_FILES['prof_pic'],$unique,'profile');
        }
        if($_FILES['portrait_pic']['name']){
            $portrait_pic = self::uploadPicture($_FILES['portrait_pic'],$unique,'portrait');
        }



        $match = array('unique_id' => $unique);
        $date_expired = '0000-00-00';
        if($req->status==1 && $req->payment){
            $date_expired = date('Y-m-d',strtotime($req->date_registered . "+6 month"));
        }
        Players::updateOrCreate($match,
            [
                'fname'=>$req->fname,
                'mname'=>$req->mname,
                'lname'=>$req->lname,
                'dob'=>$req->dob,
                'position'=>$req->position,
                'jersey'=>$req->jersey,
                'height'=>$req->height,
                'weight'=>$req->weight,
                'section'=>$req->section,
                'prof_pic' => $prof_pic,
                'portrait_pic' => $portrait_pic,
                'status' => $req->status,
                'date_expired' => $date_expired
            ]);

        return redirect()->back()->with('status','saved');
    }

    function uploadPicture($file,$name,$type)
    {
        $path = public_path('upload/'.$type);
        $size = getimagesize($file['tmp_name']);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = $name.'.'.$ext;
        if($size==FALSE){
            $name = 'default.png';
        }else{
            //move uploaded file to a directory
            move_uploaded_file($file['tmp_name'],$path.'/'.$new_name);

            $name = $name.'.'.$ext;
        }
        return $name;
    }

    function edit($id)
    {
        $data = Players::find($id);
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
            ->where('player_id',$id)
            ->first();

        $game_log = Games::select('games.*','boxscore.team as myteam')
            ->leftJoin('boxscore','boxscore.game_id','=','games.id')
            ->where('boxscore.player_id',$id)
            ->where('games.winner','!=','')
            ->orderBy('date_match','desc')
            ->limit(10)
            ->get();

        return view('admin.addPlayer',[
            'title' => 'Update Player',
            'data' => $data,
            'stats' => $stats,
            'game_log' => $game_log
        ]);
    }

    function update(Request $req)
    {
        $unique = $req->unique_id;

        $tmp = array(
            $req->fname,
            $req->lname,
            date('Ymd',strtotime($req->dob))
        );
        $new_unique = implode("",$tmp);

        $match = array('unique_id' => $unique);
        if($_FILES['prof_pic']['name'])
        {
            $prof_pic = self::uploadPicture($_FILES['prof_pic'],$new_unique,'profile');
            Players::updateOrCreate($match,['prof_pic'=>$prof_pic]);
        }
        if($_FILES['portrait_pic']['name'])
        {
            $portrait_pic = self::uploadPicture($_FILES['portrait_pic'],$new_unique,'portrait');
            Players::updateOrCreate($match,['portrait_pic'=>$portrait_pic]);
        }

        $date_expired = '0000-00-00';
        if($req->status==1 && $req->payment){
            $date_expired = date('Y-m-d',strtotime($req->date_registered ."+6 month"));
            Players::updateOrCreate($match,[
                'date_expired' => $date_expired
            ]);
        }
        Players::updateOrCreate($match,
            [
                'unique_id' => $new_unique,
                'fname'=>$req->fname,
                'mname'=>$req->mname,
                'lname'=>$req->lname,
                'dob'=>$req->dob,
                'position'=>$req->position,
                'jersey'=>$req->jersey,
                'height'=>$req->height,
                'weight'=>$req->weight,
                'section'=>$req->section,
                'status'=>$req->status
            ]);

        return redirect()->back()->with('status','updated');

    }

    public function destroy($player_id)
    {
        Boxscore::where('player_id',$player_id)
            ->delete();
        Games::where('winner_id',$player_id)
            ->update([
                'winner_id' => 0,
                'winner_score' => 0
            ]);
        Games::where('losser_id',$player_id)
            ->update([
                'losser_id' => 0,
                'losser_score' => 0
            ]);
        Players::find($player_id)->delete();

        return redirect('admin/players')->with('status','deleted');
    }
}
