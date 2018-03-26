@extends('layouts.guest')
@section('content')
    <?php
        $game = array();
        $games = array();
        foreach($data as $row){
            $game = $row;
            $games = \App\Games::where('date_match',$row->date_match)->get();
        }
    ?>
    <div class="news">
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3>{{ $title }}
                        @if($game)
                        <small class="text-muted">
                            {{ date('l', strtotime($game->date_match)) }}, {{ date('M d', strtotime($game->date_match)) }}
                        </small>
                        @endif
                    </h3>
                </div>
                <div class="box-body">
                    @if(isset($data))
                    <div class="table-responsive">
                        @foreach($games as $row)
                        <?php
                            $home = $row->home_team;
                            $away = $row->away_team;
                            $home_score = \App\Boxscore::where('game_id',$row->id)
                                    ->where('team',$home)
                                    ->sum('pts');
                            $away_score = \App\Boxscore::where('game_id',$row->id)
                                ->where('team',$away)
                                ->sum('pts');

                            $home_performer = \App\Boxscore::where('game_id',$row->id)
                                ->where('team',$home)
                                ->orderBy('pts','desc')
                                ->first();
                            $home_player = \App\Players::find($home_performer->player_id);
                            $home_link = url('player/'.$home_player->id);
                            $home_stats = $home_performer->pts.' PTS '.$home_performer->ast.' AST '.($home_performer->oreb+$home_performer->dreb).' REB';
                            if($home_performer->pts==0){
                                $home_player->fname = 'Not';
                                $home_player->lname = 'Available';
                                $home_stats = '';
                                $home_link = '#';
                            }

                            $away_performer = \App\Boxscore::where('game_id',$row->id)
                                ->where('team',$away)
                                ->orderBy('pts','desc')
                                ->first();
                            $away_player = \App\Players::find($away_performer->player_id);
                            $away_link = url('player/'.$away_player->id);
                            $away_stats = $away_performer->pts.' PTS '.$away_performer->ast.' AST '.($away_performer->oreb+$away_performer->dreb).' REB';
                            if($away_performer->pts==0){
                                $away_player->fname = 'Not';
                                $away_player->lname = 'Available';
                                $away_stats = '';
                                $away_link = '#';
                            }

                        ?>
                        <table class="table table-bordered">
                            <tr class="bg-success">
                                <th width="30%">Teams</th>
                                <th>Top Performer</th>
                                <th width="15%"></th>
                            </tr>
                            <tr>
                                <td>
                                    {{ $home }} -
                                    <span class="text-bold text-aqua">{{ $home_score }}</span>
                                </td>
                                <td>
                                    <a target="_blank" href="{{ $home_link }}" class="text-success">{{ $home_player->fname }} {{ $home_player->lname }}</a>
                                    <small class="text-muted">
                                        {{ $home_stats }}
                                    </small>
                                </td>
                                <td rowspan="2">
                                    <a href="{{ url('score/boxscore/'.$row->id) }}" class="text-info btn btn-sm btn-block" style="border: 1px solid #00c0ef;">
                                        Box Score
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $away }} -
                                    <span class="text-bold text-aqua">{{ $away_score }}</span>
                                </td>
                                <td>
                                    <a target="_blank" href="{{ $away_link }}" class="text-success">{{ $away_player->fname }} {{ $away_player->lname }}</a>
                                    <small class="text-muted">
                                        {{ $away_stats }}
                                    </small>
                                </td>
                            </tr>

                        </table>
                        @endforeach
                    </div>
                    <div class="text-center">
                        {{ $data->links() }}
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <span class="text-warning">
                            <i class="fa fa-warning"></i> No Games Scheduled!
                        </span>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        @include('sidebar.quick')
    </div>
@endsection

@section('js')

@endsection

