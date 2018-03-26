@extends('layouts.guest')
@section('content')
    <div class="col-md-3">
        @include('sidebar.quick')
    </div>
    <style>
        .score {
            font-weight:bold;
            font-size: 1.5em;
        }
        .winner {
            color: #2786bf;
        }
        .news-title {
            font-size:1.2em;
        }
        .news h4 {
            margin:0px !important;
            margin-bottom: 5px !important;
        }
        .news p {
            color: #888;
        }
    </style>
    <div class="news">
        <div class="col-md-6">
            @if(isset($news))
                @foreach($news as $row)
                    @if($row->type=='fb')
                    <div class="box box-success text-center">
                        <div class="box-header with-border">

                        </div>
                        <div class="box-body">
                            {!! $row->link !!}
                        </div>
                    </div>
                    @elseif($row->type=='award')
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div class="news-title">
                                    {{ $row->title }}
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-sm-3">
                                    <?php $player = \App\Players::find($row->player_id); ?>
                                    <img src="{{ url('pictures/profile/'.$player->prof_pic) }}" class="img-responsive" />
                                </div>
                                <p>
                                    <h4>{!! $row->contents !!}</h4>
                                </p>
                            </div>
                        </div>
                    @elseif($row->type=='score')
                    <?php
                        $game = \App\Games::find($row->game_id);
                    ?>
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div class="text-center news-title">
                                    {{ $game->home_team }} <span class="score {{ ($game->home_score>$game->away_score) ? 'winner':'text-muted' }}">{{ $game->home_score }}</span> <i class="{{ ($game->home_score>$game->away_score) ? 'fa fa-angle-left':'' }}"></i> Final
                                    <i class="{{ ($game->home_score<$game->away_score) ? 'fa fa-angle-right':'' }}"></i> <span class="text-muted"> <span class="score {{ ($game->home_score<$game->away_score) ? 'winner':'text-muted' }}">{{ $game->away_score }}</span> {{ $game->away_team }}</span>
                                </div>
                            </div>
                            <div class="box-body">
                                <h4>{!! $row->contents !!}</h4>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="box box-warning text-center">
                    {{ $news->links() }}
                </div>
            @else
                <div class="alert alert-warning">
                    <span class="text-warning">
                        <i class="fa fa-warning"></i> No post yet!
                    </span>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        @include('sidebar.player')
    </div>
@endsection

@section('js')

@endsection

