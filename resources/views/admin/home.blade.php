@extends('layouts.app')
@section('content')
    <?php
        $status = session('status');
    ?>
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
        .dropdown {
            font-weight: bold;
            padding: 3px 5px;
            cursor: pointer;
        }
    </style>
    <div class="news">
        <div class="col-md-8">
            @if($status=='saved')
            <div class="alert alert-success">
                <span class="text-success">
                    <i class="fa fa-check"></i> Successfully Posted!
                </span>
            </div>
            @endif
            @if($status=='nothing')
                <div class="alert alert-warning">
            <span class="text-warning">
                <i class="fa fa-warning"></i> Nothing to post!
            </span>
                </div>
            @endif

            @if($status=='deleted')
                <div class="alert alert-success">
            <span class="text-success">
                <i class="fa fa-check"></i> Successfully deleted!
            </span>
                </div>
            @endif

            @if($status=='updated')
                <div class="alert alert-success">
            <span class="text-success">
                <i class="fa fa-check"></i> Successfully updated!
            </span>
                </div>
            @endif
            <div class="box box-success">
                <div class="box-header">
                    <span class="text-bold"><i class="fa fa-pencil"></i> Make Post</span>
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary btn-sm" data-target="#fbPost" data-toggle="modal">
                            <i class="fa fa-facebook"></i> Page Post
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-target="#awardPost" data-toggle="modal">
                            <i class="fa fa-trophy"></i> Awardee
                        </button>
                    </div>
                </div>
            </div>
                @if(isset($news))
                    @foreach($news as $row)
                        @if($row->type=='fb')
                            <div class="box box-success text-center">
                                <div class="box-header with-border">
                                    <div class="pull-right">
                                        <div class="dropdown">
                                            <span class="dropdown dropdown-toggle" id="dropdownMenu{{$row->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                ...
                                            </span>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{$row->id}}">
                                                <li><a href="#deleteModal" data-toggle="modal" data-id="{{ $row->id }}">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    {!! $row->link !!}
                                </div>
                            </div>
                        @elseif($row->type=='award')
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <div class="pull-right">
                                        <div class="dropdown">
                                            <span class="dropdown dropdown-toggle" id="dropdownMenu{{$row->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                ...
                                            </span>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{$row->id}}">
                                                <li><a href="#deleteModal" data-toggle="modal" data-id="{{ $row->id }}">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
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
                                    <div class="pull-right">
                                        <div class="dropdown">
                                            <span class="dropdown dropdown-toggle" id="dropdownMenu{{$row->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                ...
                                            </span>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{$row->id}}">
                                                <li><a href="#updatePost" data-toggle="modal" data-id="{{ $row->id }}">Update</a></li>
                                                <li><a href="#deleteModal" data-toggle="modal" data-id="{{ $row->id }}">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="text-center news-title">
                                        {{ $game->home_team }} <span class="score {{ ($game->home_score>$game->away_score) ? 'winner':'text-muted' }}">{{ $game->home_score }}</span> <i class="{{ ($game->home_score>$game->away_score) ? 'fa fa-angle-left':'' }}"></i> Final
                                        <i class="{{ ($game->home_score<$game->away_score) ? 'fa fa-angle-right':'' }}"></i> <span class="text-muted"> <span class="score {{ ($game->home_score<$game->away_score) ? 'winner':'text-muted' }}">{{ $game->away_score }}</span> {{ $game->away_team }}</span>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <h4>{!! $row->contents !!}</h4>
                                </div>
                                <div class="box-footer">
                                    <a href="{{ url('admin/games/boxscore/'.$game->id) }}" class="text-aqua">View Box Score</a>
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
    <div class="col-md-4">
        @include('sidebar.player')
        @include('modal.post')
        @include('modal.updatePost')
    </div>
@endsection

@section('modal')
<label>DELETE POST?</label>
<form method="POST" action="{{ url('admin/home/delete/post') }}">
    {{ csrf_field() }}
    <input type="hidden" id="postID" name="postID" value="" />
    <div class="alert alert-warning" style="margin-bottom: 0px;">
        <font class="text-warning">
            <i class="fa fa-warning"></i> Are you sure?
        </font>
    </div>
@endsection
@section('js')
<script>
    $('a[href="#deleteModal"]').on('click',function(){
        var id = $(this).data('id');
        $('#postID').val(id);
    });

    $('a[href="#updatePost"]').on('click',function(){
        var id = $(this).data('id');
        $.ajax({
            url: "{{ url('admin/home/post') }}/"+id,
            type: "GET",
            success: function(data){
                $('#postUpdateID').val(id);
                $('#contents').val(data);
            }
        })
    });
</script>
@endsection

