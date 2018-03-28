@extends('layouts.app')

@section('content')
    <?php
    $status = session('status');
    $list = \App\Players::orderBy('lname','asc')->get();
    ?>

    <div class="col-md-6">
        <div class="jim-content">
            @if($status=='left')
            <div class="alert alert-success">
                <font class="text-success">
                    Players Added!
                </font>
            </div>
            @endif
            <div class="pull-right">
                <a href="#playerListA" data-toggle="modal" class="btn btn-sm btn-success">
                    <i class="fa fa-user-plus"></i> Add Player
                </a>
            </div>
            <h3 class="page-header">
                {{ $data->home_team }}<br>
                <small class="text-info">
                    {{ date('l', strtotime($data->date_match)) }}, {{ date('M d',strtotime($data->date_match)) }}
                </small>
            </h3>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $players = \App\Boxscore::where('game_id',$data->id)
                            ->where('team',$data->home_team)
                            ->get();
                    ?>
                    @if(isset($players))
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="bg-success">
                            <tr>
                                <th width="10%">No.</th>
                                <th>Players</th>
                                <th width="10%">POS</th>
                                <th width="5%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($players as $row)
                                <?php
                                    $player = \App\Players::find($row->player_id);
                                ?>
                                <tr>
                                    <td>{{ $player->jersey }}</td>
                                    <td>{{ $player->fname }} {{ $player->lname }}</td>
                                    <td>{{ $player->position }}</td>
                                    <td>
                                        <a href="{{ url('admin/games/player/remove/'.$data->id.'/'.$player->id) }}" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="alert alert-warning">
                            <font class="text-warning">
                                <i class="fa fa-warning"></i> No Player Found!
                            </font>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="jim-content">
            @if($status=='right')
                <div class="alert alert-success">
                    <font class="text-success">
                        Players Added!
                    </font>
                </div>
            @endif
            <div class="pull-right">
                <a href="#playerListB" data-toggle="modal" class="btn btn-sm btn-success">
                    <i class="fa fa-user-plus"></i> Add Player
                </a>
            </div>
            <h3 class="page-header">
                {{ $data->away_team }}
                <br>
                <small class="text-info">
                    {{ date('l', strtotime($data->date_match)) }}, {{ date('M d',strtotime($data->date_match)) }}
                </small>
            </h3>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $players = \App\Boxscore::where('game_id',$data->id)
                        ->where('team',$data->away_team)
                        ->get();
                    ?>
                    @if(isset($players))
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="bg-success">
                                <tr>
                                    <th width="10%">No.</th>
                                    <th>Players</th>
                                    <th width="10%">POS</th>
                                    <th width="5%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($players as $row)
                                    <?php
                                    $player = \App\Players::find($row->player_id);
                                    ?>
                                    <tr>
                                        <td>{{ $player->jersey }}</td>
                                        <td>{{ $player->fname }} {{ $player->lname }}</td>
                                        <td>{{ $player->position }}</td>
                                        <td>
                                            <a href="{{ url('admin/games/player/remove/'.$data->id.'/'.$player->id) }}" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <font class="text-warning">
                                <i class="fa fa-warning"></i> No Player Found!
                            </font>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="jim-content">
            <div class="pull-right">
                <button data-toggle="modal" data-target="#deleteModal" class="btn btn-flat btn-danger">
                    <i class="fa fa-trash"></i> Delete Game
                </button>
                <a href="{{ url('admin/games/boxscore/'.$data->id) }}" class="btn btn-success btn-flat">
                    <i class="fa fa-send"></i> Start Game
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    @include('modal.playerList')
@endsection

@section('modal')
    <label>DELETE GAME?</label>
    <form method="GET" action="{{ url('admin/games/destroy/'.$data->id) }}">
    <div class="alert alert-warning" style="margin-bottom: 0px;">
        <font class="text-warning">
            <i class="fa fa-warning"></i> Are you sure?
        </font>
    </div>
@endsection

@section('js')
<script>
    function filterName()
    {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById('home_search');
        filter = input.value.toUpperCase();
        ul = document.getElementById("home_div");
        li = ul.getElementsByTagName("li");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            //a = li[i].getElementsByTagName("a")[0];
            a = li[i].innerHTML;
            if (a.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
        return li.length;
    }

    function filterNameAway()
    {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById('away_search');
        filter = input.value.toUpperCase();
        ul = document.getElementById("away_div");
        li = ul.getElementsByTagName("li");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            //a = li[i].getElementsByTagName("a")[0];
            a = li[i].innerHTML;
            if (a.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
        return li.length;
    }
</script>
@endsection

