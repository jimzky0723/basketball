<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeCtrl@index');
Route::get('/players','HomeCtrl@players');
Route::post('/players','HomeCtrl@filterPlayers');
Route::get('/player/{player_id}','HomeCtrl@profile');
Route::get('/score','HomeCtrl@score');
Route::get('/score/boxscore/{game_id}','HomeCtrl@boxscore');
Route::get('stats','HomeCtrl@stats');
Route::post('stats','HomeCtrl@stats');

Route::get('ranking','HomeCtrl@ranking');
Route::post('ranking','HomeCtrl@filterRanking');

Route::get('ranking/week','HomeCtrl@rankingWeek');
Route::post('ranking/week','HomeCtrl@filterRankingWeek');

Route::get('ranking/month','HomeCtrl@rankingMonth');
Route::post('ranking/month','HomeCtrl@filterRankingMonth');

Route::get('admin/scoreboard/{game_id}','admin\GameCtrl@scoreboard');


Route::get('/logout', function (){
    Session::flush();
    return redirect('login');
});
Route::get('/login', 'LoginCtrl@login');
Route::post('/login', 'LoginCtrl@validateLogin');


//admin page
Route::get('admin','admin\HomeCtrl@index');

Route::get('admin/players','admin\PlayerCtrl@index');
Route::post('admin/players','admin\PlayerCtrl@searchPlayer');

Route::get('admin/player/create','admin\PlayerCtrl@create');
Route::post('admin/player/store','admin\PlayerCtrl@store');
Route::get('admin/player/destroy/{player_id}','admin\PlayerCtrl@destroy');

Route::get('admin/player/{id}','admin\PlayerCtrl@edit');
Route::post('admin/player/update','admin\PlayerCtrl@update');


Route::get('admin/games','admin\GameCtrl@index');
Route::post('admin/games/endgame/{game_id}','admin\GameCtrl@endGame');

Route::get('admin/games/assign/{game_id}','admin\GameCtrl@assign');
Route::get('admin/games/player/remove/{game_id}/{player_id}','admin\GameCtrl@removePlayer');

Route::get('admin/games/boxscore/{game_id}','admin\GameCtrl@boxscore');
Route::get('admin/games/boxscore/stat/{game_id}/{player_id}','admin\GameCtrl@manualStats');
Route::get('admin/games/boxscore/auto/{game_id}/{player_id}/{column}/{team}','admin\GameCtrl@autoStats');
Route::post('admin/games/boxscore/manual','admin\GameCtrl@saveManualStats');

Route::get('admin/games/refresh/{game_id}','admin\GameCtrl@calculate');

Route::get('admin/games/start/{game_id}/{team}','admin\GameCtrl@startGame');

Route::post('admin/games/store','admin\GameCtrl@store');
Route::post('admin/games/assign','admin\GameCtrl@assignPlayer');
Route::get('admin/games/destroy/{game_id}','admin\GameCtrl@destroy');

Route::get('admin/committee','admin\CommCtrl@index');
Route::post('admin/committee','admin\CommCtrl@store');

Route::post('admin/home/fb','admin\NewsCtrl@fbPost');
Route::post('admin/home/award','admin\NewsCtrl@awardPost');
Route::post('admin/home/delete/post','admin\NewsCtrl@deletePost');
Route::post('admin/home/update/post','admin\NewsCtrl@updatePost');
Route::get('admin/home/post/{id}','admin\NewsCtrl@getPost');

Route::get('admin/awardee','admin\AwardCtrl@index');
Route::post('admin/awardee/{type}','admin\AwardCtrl@store');

//PARAM of the GAME
Route::get('game/score/{game_id}/{team}','GameCtrl@getScore');
Route::get('pictures/{folder}/{file}','ParamCtrl@pictures');

Route::get('sample',function(){
    $data = \App\Http\Controllers\ParamCtrl::getPlayerStatsByMonth('3',25);
    print_r($data);
});