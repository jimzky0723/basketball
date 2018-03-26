@extends('layouts.app')
@section('content')
    <?php
        $status = session('status');
    ?>
    <div class="col-md-3">
        @include('sidebar.quick')
    </div>
    <div class="col-md-3">
        <div class="jim-content">
            @if($status=='week')
            <div class="alert alert-success">
                <span class="text-success">
                    <i class="fa fa-check"></i> Player of the Week Added!
                </span>
            </div>
            @endif
            <h3 class="page-header">
                Player of the Week</h3>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ url('admin/awardee/week') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="date" required value="{{ date('Y-m-d') }}" name="date" class="fom-control" style="width: 100%" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-success btn-block">
                                <i class="fa fa-users"></i> Generate Awardee
                            </button>
                        </div>
                    </form>
                    <hr />
                    @if(isset($week))
                    <?php
                        $player = \App\Players::find($week->player_id);
                        $week_stats = \App\Http\Controllers\ParamCtrl::getPlayerStats($week->player_id);
                    ?>
                    <div class="thumbnail">
                        <img src="{{ url('pictures/profile/'.$player->prof_pic) }}" class="img-responsive" />
                        <div class="text-center">
                            <span class="title-info">{{ $player->fname }} {{ $player->lname }}</span>
                            <br />
                            <small class="text-muted">Average of
                            @foreach($week_stats['stats'] as $row)
                                {{ number_format($row['count'],1) }} {{ $row['value'] }}
                            @endforeach
                            </small>
                        </div>
                    </div>
                    @else
                        <div class="alert alert-warning">
                            <span class="text-warning">
                                <i class="fa fa-warning"></i> Nothing to display!
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="jim-content">
            @if($status=='month')
                <div class="alert alert-success">
                <span class="text-success">
                    <i class="fa fa-check"></i> Player of the Month Added!
                </span>
                </div>
            @endif
            <h3 class="page-header">
                Player of the Month</h3>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ url('admin/awardee/month') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="date" required value="{{ date('Y-m-d') }}" name="date" class="fom-control" style="width: 100%" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-info btn-block">
                                <i class="fa fa-users"></i> Generate Awardee
                            </button>
                        </div>
                    </form>
                    <hr />
                    @if(isset($month))
                        <?php
                        $player = \App\Players::find($month->player_id);
                        $week_stats = \App\Http\Controllers\ParamCtrl::getPlayerStats($month->player_id);
                        ?>
                        <div class="thumbnail">
                            <img src="{{ url('pictures/profile/'.$player->prof_pic) }}" class="img-responsive" />
                            <div class="text-center">
                                <span class="title-info">{{ $player->fname }} {{ $player->lname }}</span>
                                <br />
                                <small class="text-muted">Average of
                                    @foreach($week_stats['stats'] as $row)
                                        {{ number_format($row['count'],1) }} {{ $row['value'] }}
                                    @endforeach
                                </small>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <span class="text-warning">
                                <i class="fa fa-warning"></i> Nothing to display!
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        @include('sidebar.player')
    </div>
@endsection

@section('js')

@endsection

