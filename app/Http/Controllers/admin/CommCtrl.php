<?php

namespace App\Http\Controllers\admin;

use App\Comm;
use App\Players;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $data = Comm::select('players.*','comm.id as comm_id','comm.schedule')
            ->leftJoin('players','players.id','=','comm.player_id')
            ->limit(6)
            ->get();
        return view('admin.comm',[
            'title' => 'Committee of the Week',
            'data' => $data
        ]);
    }

    public function store(Request $req)
    {
        $schedule = $req->schedule;
        $players = Players::where('comm_status',0)
                ->inRandomOrder()
                ->limit(6)
                ->get();
        if(count($players)<6){
            Players::where('comm_status',1)
                    ->update([
                        'comm_status' => 0
                    ]);
            $players = Players::where('comm_status',0)
                ->inRandomOrder()
                ->limit(6)
                ->get();
        }

        Comm::truncate();
        $data = array();
        foreach($players as $row){
            $data = array(
                'player_id' => $row->id,
                'schedule' => $schedule
            );
            Comm::create($data);

            Players::where('id',$row->id)
                ->update([
                    'comm_status' => 1
                ]);
        }
        return redirect()->back();
    }
}
