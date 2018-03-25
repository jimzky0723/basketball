<?php

namespace App\Http\Controllers\admin;

use App\Awards;
use App\Http\Controllers\ParamCtrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AwardCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $week = Awards::where('type','week')
            ->orderBy('id','desc')
            ->first();
        $month = Awards::where('type','month')
            ->orderBy('id','desc')
            ->first();
        return view('admin.award',[
            'title' => 'Awardee',
            'week' => $week,
            'month' => $month
        ]);
    }

    public function store(Request $request,$type)
    {
        $date = $request->date;
        if($type=='week'){
            $player = ParamCtrl::getWeekPlayer($date);
        }else if($type=='month'){
            $player = ParamCtrl::getMonthPlayer($date);
        }

        $player_id = $player['player_id'];
        $data = array(
            'type' => $type,
            'player_id' => $player_id,
            'award_date' => $date
        );
        Awards::create($data);

        return redirect()->back()->with('status',$type);

    }
}
