<?php

namespace App\Http\Controllers\admin;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $news = News::orderBy('id','desc')->paginate(5);
        return view('admin.home',[
            'title' => 'Admin Panel',
            'news' => $news
        ]);
    }
}
