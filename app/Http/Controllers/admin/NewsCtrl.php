<?php

namespace App\Http\Controllers\admin;

use App\Awards;
use App\Http\Controllers\ParamCtrl;
use App\News;
use App\Players;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function fbPost(Request $req)
    {
        $data = array(
            'type' => 'fb',
            'link' => $req->post
        );
        News::create($data);

        return redirect()->back()->with('status','saved');
    }

    public function awardPost(Request $req)
    {
        $award = $req->awardee;
        if($award=='week'){
            $player = Awards::where('type','week')
                ->orderBy('id','desc')
                ->first();
            if(!isset($player))
            {
                return redirect()->back()->with('status','nothing');
            }
            $player_id = $player->player_id;
            $stats = ParamCtrl::getWeekPlayerByWeek($player->award_date,$player_id);
            $stats = $stats['stats'];
            $award = 'Player of the Week';
            $week = date('W',strtotime($player->award_date));
            $title = 'Player of the Week : Week #' . ($week-11);
        }else if($award=='month'){
            $player = Awards::where('type','month')
                ->orderBy('id','desc')
                ->first();
            if(!isset($player))
            {
                return redirect()->back()->with('status','nothing');
            }
            $player_id = $player->player_id;
            $stats = ParamCtrl::getMonthPlayerByMonth($player->award_date,$player_id);
            $stats = $stats['stats'];
            $month = date('F',strtotime($player->award_date));
            $award = 'Player of the Month';
            $title = 'Player of the Month :'. $month;
        }else if($award=='overall'){
            $player = ParamCtrl::getTopPlayer();
            if(!isset($player))
            {
                return redirect()->back()->with('status','nothing');
            }
            $player_id = $player['player_id'];
            $stats = $player['stats'];
            $award = 'Overall Player';
            $title = 'Rank 1 Overall Statistics';
        }
        $data = array(
            'type' => 'award',
            'title' => $title,
            'contents' => self::contents($player_id,$award,$stats),
            'player_id' => $player_id
        );
        News::create($data);
        return redirect()->back()->with('status','saved');
    }

    public function contents($id,$award, $stats)
    {
        $player = Players::find($id);

        $contents = "<span class='text-bold text-aqua'>$player->fname $player->lname</span> has been named our <span class='text-bold text-warning'>$award</span> with an average of<span class='text-bold text-info'>";
        foreach($stats as $row):
            $contents .= ' '.number_format($row['count'],1).' '.$row['value'];
        endforeach;
        $contents .= '</span>. Congratulations!';
        return $contents;
    }

    public function deletePost(Request $req)
    {
        $id = $req->postID;
        News::where('id',$id)
            ->delete();

        return redirect()->back()->with('status','deleted');
    }

    public function getPost($id)
    {
        $news = News::find($id);
        return $news->contents;
    }

    public function updatePost(Request $req)
    {
        $id = $req->postUpdateID;
        $contents = $req->contents;
        News::where('id',$id)
            ->update([
                'contents' => $contents
            ]);

        return redirect()->back()->with('status','updated');
    }
}
