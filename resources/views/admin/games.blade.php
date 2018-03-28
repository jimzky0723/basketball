@extends('layouts.app')

@section('content')
    <?php
        $status = session('status');
    ?>
    <style>
        th {
            vertical-align: middle !important;
        }
    </style>
    <div class="col-md-12">
        <div class="jim-content">
            <div class="pull-right">
                <a href="#addGame" data-toggle="modal" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Add Game
                </a>
            </div>
            <h3 class="page-header">
                {{ $title }}</h3>
            <div class="row">
                <div class="col-md-12">
                    @if($status=='saved')
                        <div class="alert alert-success">
                            <font class="text-success">
                                <i class="fa fa-check"></i> Game successfully added!
                            </font>
                        </div>
                    @endif

                    @if($status=='deleted')
                        <div class="alert alert-success">
                            <font class="text-success">
                                <i class="fa fa-check"></i> Game successfully deleted!
                            </font>
                        </div>
                    @endif
                    @if(isset($data))
                        @foreach($data as $row)
                            <?php
                                $day = date('l', strtotime($row->date_match));
                                $games = \App\Games::where('date_match',$row->date_match)->get();
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <caption class="title-info">{{ $day }}, {{ date('M d',strtotime($row->date_match)) }}</caption>
                                    <thead class="bg-success">
                                    <tr>
                                        <th width="22%">MATCHUP</th>
                                        <th width="22%">RESULT</th>
                                        <th width="22%">WINNER HIGH</th>
                                        <th width="22%">LOSER HIGH</th>
                                        <th width="12%"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($games as $game)
                                    <tr>
                                        <td class="text-primary text-bold teams">
                                            <a href="{{ url('admin/games/assign/'.$game->id) }}">
                                                <span id="home-team">{{ $game->home_team }}</span> vs. <span id="away-team">{{ $game->away_team }}</span> 
                                            </a>
                                        </td>
                                        <td>
                                            @if($game->home_score && $game->away_score)
                                                {{ $game->home_team }} <span class="text-primary">{{ $game->home_score }}</span>,
                                                {{ $game->away_team }} <span class="text-primary">{{ $game->away_score }}</span>
                                            @else
                                                <span class="text-danger">No Available Data</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($game->winner_id)
                                                <?php
                                                    $user = \App\Players::find($game->winner_id);
                                                ?>
                                                <a href="{{ url('admin/player/'.$game->winner_id) }}" class="text-info">{{ $user->fname }} {{ $user->lname }}</a>, {{ $game->winner_score }} <small>Pts</small>
                                            @else
                                                <span class="text-danger">No Available Data</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if($game->losser_id)
                                                <?php
                                                $user = \App\Players::find($game->losser_id);
                                                ?>
                                                <a href="{{ url('admin/player/'.$game->losser_id) }}" class="text-info">{{ $user->fname }} {{ $user->lname }}</a>, {{ $game->losser_score }} <small>Pts</small>
                                            @else
                                                <span class="text-danger">No Available Data</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($game->status)
                                            <a href="{{ url('admin/games/boxscore/'.$game->id) }}" class="btn btn-xs btn-info btn-block">
                                                <i class="fa fa-table"></i> Box Score
                                            </a>
                                            @else
                                            <!-- {{ url('admin/games/boxscore/'.$game->id) }} -->
                                            <a href="{{ url('admin/games/boxscore/'.$game->id) }}" id="start-game" data-id="" onclick="setFirebase({{ $game }})" class="btn btn-xs btn-success btn-block">
                                                <i class="fa fa-send"></i> Start Game
                                            </a>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                        <div class="text-center">
                            {{ $data->links() }}
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <font class="text-warning">
                                <i class="fa fa-warning"></i> No Game Found!
                            </font>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('modal.addGame')
@endsection

@section('js')
    <script>
        // Firebase Connection or Instance
        var firebaseCon = firebase.database();
        var dataRef = firebaseCon.ref('Game');

        function setFirebase(game){
            dataRef.child(game['id']).once('value', function(data){
                if(data.val() == null){
                    addGame(game);
                    console.log('Game added!');
                }else{
                    console.log('Game already exists!');
                }
            });     
        }

        function addGame(game){
            dataRef.child(game['id']).set({
                home:{
                    team: game['home_team'],
                    score: 0,
                    foul: 0
                },
                away:{
                    team: game['away_team'],
                    score: 0,
                    foul: 0
                }
            });  
        }

    </script>
@endsection

