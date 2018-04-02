@extends('layouts.app')

@section('content')
    <?php
        $status = session('status');
        $player_id = 0;
        $str = date('mdHis');
        $unique_id = '';
        $fname = '';
        $mname = '';
        $lname = '';
        $dob = '';
        $position = '';
        $jersey = '';
        $height = '';
        $weight = '';
        $section = '';
        $prof_pic = 'prof_default.jpg?image='.$str;
        $portrait_pic = 'portrait_default.jpg?image='.$str;
        $stat = 0;

        if(isset($data))
        {
            $player_id = $data->id;
            $unique_id = $data->unique_id;
            $fname = $data->fname;
            $mname = $data->mname;
            $lname = $data->lname;
            $dob = $data->dob;
            $position = $data->position;
            $jersey = $data->jersey;
            $height = $data->height;
            $weight = $data->weight;
            $section = $data->section;
            $prof_pic = 'profile/'.$data->prof_pic.'?image='.$str;
            $portrait_pic = 'portrait/'.$data->portrait_pic.'?image='.$str;
            $stat = $data->status;
        }
        $url = url('admin/player/update');
        if($title=='Add Player')
        {
            $url = url('admin/player/store');
        }
    ?>
    <style>
        .table-input tr td:first-child {
            background: #f5f5f5;
            text-align: right;
            vertical-align: middle;
            font-weight: bold;
            padding: 3px;
            width:30%;
        }
        .table-input tr td {
            border:1px solid #bbb !important;
        }
        .table-stats {
            font-size: 0.8em;
            font-weight: normal !important;
        }
        .table-stats caption {
            font-size:1.4em;
            font-weight: bold;
        }
    </style>
    <div class="col-md-9">
        <div class="jim-content">
            <h3 class="page-header">
                {{ $title }}</h3>
            <div class="row">
                <div class="col-md-12">
                    @if($status=='saved')
                    <div class="alert alert-success">
                        <font class="text-success">
                            <i class="fa fa-check"></i> 1 player successfully added!
                        </font>
                    </div>
                    @endif

                    @if($status=='updated')
                        <div class="alert alert-success">
                            <font class="text-success">
                                <i class="fa fa-check"></i> Player successfully updated!
                            </font>
                        </div>
                    @endif

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Personal Information</a></li>
                        <li role="presentation"><a href="#stats" aria-controls="history" role="tab" data-toggle="tab">Stats</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <br />
                            <form method="POST" class="form-horizontal form-submit" enctype="multipart/form-data" id="form-submit" action="{{ $url }}">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $unique_id }}" name="unique_id"/>
                                <table class="table-input table table-bordered table-hover" border="1">
                                    <tr class="has-group">
                                        <td>First Name :</td>
                                        <td><input type="text" value="{{ $fname }}" name="fname" class="fname form-control" required /> </td>
                                    </tr>
                                    <tr>
                                        <td>Middle Name :</td>
                                        <td><input type="text" value="{{ $mname }}" name="mname" class="mname form-control" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Last Name :</td>
                                        <td><input type="text" value="{{ $lname }}" name="lname" class="lname form-control" required /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Birth Date :</td>
                                        <td><input type="date"  value="{{ $dob }}" name="dob" class="form-control dob" required /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Position :</td>
                                        <td>
                                            <select name="position" class="form-control" required>
                                                <option {{ ($position=='PG') ? 'selected': '' }} value="PG">Point Guard</option>
                                                <option {{ ($position=='SG') ? 'selected': '' }} value="SG">Shooting Guard</option>
                                                <option {{ ($position=='SF') ? 'selected': '' }} value="SF">Small Forward</option>
                                                <option {{ ($position=='PF') ? 'selected': '' }} value="PF">Power Forward</option>
                                                <option {{ ($position=='C') ? 'selected': '' }} value="C">Center</option>
                                                <option {{ ($position=='PG/SG') ? 'selected': '' }} value="PG/SG">Point/Shooting Guard</option>
                                                <option {{ ($position=='SG/SF') ? 'selected': '' }} value="SG/SF">Shooting Guard/Small Forward</option>
                                                <option {{ ($position=='SF/PF') ? 'selected': '' }} value="SF/PF">Small/Power Forward</option>
                                                <option {{ ($position=='PF/C') ? 'selected': '' }} value="PF/C">Power Forward/Center</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Jersey No. :</td>
                                        <td><input type="text" value="{{ $jersey }}" name="jersey" class="lname form-control" required /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Height (ft):</td>
                                        <td><input type="text" value="{{ $height }}" name="height" class="lname form-control" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Weight (lbs) :</td>
                                        <td><input type="text" value="{{ $weight }}" name="weight" class="lname form-control" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Section :</td>
                                        <td><input type="text" value="{{ $section}}" name="section" class="lname form-control" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Profile Picture :</td>
                                        <td><input type="file" name="prof_pic" class="form-control" accept="image/png" onchange="readProfURL(this);" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Portrait Picture :</td>
                                        <td><input type="file" name="portrait_pic" class="lname form-control" accept="image/png" onchange="readPortraitURL(this);" /> </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Status :</td>
                                        <td>
                                            <select name="status" class="form-control">
                                                <option {{ ($stat==0) ? 'selected': '' }} value="0">Unregistered</option>
                                                <option {{ ($stat==1) ? 'selected': '' }} value="1">Registered</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="has-group">
                                        <td>Payment :</td>
                                        <td>
                                            <label>
                                                <input type="checkbox" name="payment"/>
                                                Put check if payment is done!
                                            </label>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td>
                                            <a href="{{ asset('admin/players') }}" class="btn btn-sm btn-default">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                            @if($title=='Add Player')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa fa-send"></i> Save
                                                </button>
                                            @else
                                                <button data-target="#deleteModal" data-toggle="modal" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa fa-pencil"></i> Update
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="stats">
                            <br />
                            @if(isset($stats))
                            <div class="table-responsive">
                                <table class="table table-stats table-striped table-hover">
                                    <caption>Career Stats</caption>
                                    <tr class="bg-black">
                                        <th>WIN%</th>
                                        <th>GP</th>
                                        <th>FGM-FGA</th>
                                        <th>FG%</th>
                                        <th>3PM-3PA</th>
                                        <th>3P%</th>
                                        <th>FTM-FTA</th>
                                        <th>FT%</th>
                                        <th>APG</th>
                                        <th>RPG</th>
                                        <th>BLKPG</th>
                                        <th>STLPG</th>
                                        <th>PFPG</th>
                                        <th>TOPG</th>
                                        <th>PPG</th>
                                    </tr>

                                    <tr>
                                        <th>{{ number_format($stats->win*100,1) }}%</th>
                                        <th>{{ $stats->gp }}</th>
                                        <th>{{ number_format($stats->fgm,1) }}-{{ number_format($stats->fga,1) }}</th>
                                        <th>{{ number_format($stats->fg_per*100,1) }}%</th>
                                        <th>{{ number_format($stats->fg3m,1) }}-{{ number_format($stats->fg3a,1) }}</th>
                                        <th>{{ number_format($stats->fg3_per*100,1) }}%</th>
                                        <th>{{ number_format($stats->ftm,1) }}-{{ number_format($stats->fta,1) }}</th>
                                        <th>{{ number_format($stats->ft_per*100,1) }}%</th>
                                        <th>{{ number_format($stats->ast,1) }}</th>
                                        <th>{{ number_format($stats->reb,1) }}</th>
                                        <th>{{ number_format($stats->blk,1) }}</th>
                                        <th>{{ number_format($stats->stl,1) }}</th>
                                        <th>{{ number_format($stats->pf,1) }}</th>
                                        <th>{{ number_format($stats->turnover,1) }}</th>
                                        <th>{{ number_format($stats->pts,1) }}</th>
                                    </tr>

                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-stats table-striped table-hover">
                                    <caption>Game Log</caption>
                                    <tr class="bg-black">
                                        <th>DATE</th>
                                        <th>OPP</th>
                                        <th>SCORE</th>
                                        <th>FGM-FGA</th>
                                        <th>FG%</th>
                                        <th>3PM-3PA</th>
                                        <th>3P%</th>
                                        <th>FTM-FTA</th>
                                        <th>FT%</th>
                                        <th>REB</th>
                                        <th>AST</th>
                                        <th>BLK</th>
                                        <th>STL</th>
                                        <th>PF</th>
                                        <th>TO</th>
                                        <th>PTS</th>
                                    </tr>
                                    <?php
                                    $total_fgm = 0;
                                    $total_fga = 0;
                                    $total_3fm = 0;
                                    $total_3fa = 0;
                                    $total_ftm = 0;
                                    $total_fta = 0;
                                    $total_reb = 0;
                                    $total_ast = 0;
                                    $total_stl = 0;
                                    $total_blk = 0;
                                    $total_to = 0;
                                    $total_pf = 0;
                                    $total_pts =0;
                                    $counter = 0;
                                    $total_fP = 0;
                                    $total_3P = 0;
                                    $total_ftP = 0;
                                    ?>
                                    @if(count($game_log))
                                        @foreach($game_log as $log)
                                            <?php $counter += 1; ?>
                                            <tr>
                                                <th>{{ date('m/d',strtotime($log->date_match)) }}</th>
                                                <th>
                                                    <a href="{{ url('admin/games/boxscore/'.$log->id) }}">
                                                    @if($log->myteam == $log->home_team)
                                                        {{ $log->away_team }}
                                                    @else
                                                        {{ $log->home_team }}
                                                    @endif
                                                    </a>
                                                </th>
                                                <th>

                                                    @if($log->winner && $log->winner==$log->myteam)
                                                        <span class="text-success">W</span>
                                                    @elseif($log->winner && $log->winner!=$log->myteam)
                                                        <span class="text-danger">L</span>
                                                    @endif
                                                    <?php
                                                    $home_score = \App\Boxscore::where('game_id',$log->id)->where('team',$log->home_team)->sum('pts');
                                                    $away_score = \App\Boxscore::where('game_id',$log->id)->where('team',$log->away_team)->sum('pts');

                                                    $stats = \App\Boxscore::where('game_id',$log->id)
                                                        ->where('team',$log->myteam)
                                                        ->where('player_id',$player_id)
                                                        ->first();
                                                    $fgm = $stats->fg2m + $stats->fg3m;
                                                    $fga = $stats->fg2a + $stats->fg3a;
                                                    ?>
                                                    {{ $home_score }}-{{ $away_score }}
                                                </th>
                                                <th>
                                                    <?php $total_fgm = $total_fgm + $fgm; ?>
                                                    <?php $total_fga = $total_fga + $fga; ?>
                                                    {{ $fgm }}-{{ $fga }}
                                                </th>
                                                <th>
                                                    @if($fga==0)
                                                        0.0%
                                                    @else
                                                        <?php $total_fP  = $total_fP + number_format(($fgm/$fga)*100,1); ?>
                                                        {{ number_format(($fgm/$fga)*100,1) }}%
                                                    @endif
                                                </th>
                                                <th>
                                                    <?php $total_3fm  = $total_3fm + $stats->fg3m; ?>
                                                    <?php $total_3fa = $total_3fa + $stats->fg3a; ?>
                                                    {{ $stats->fg3m }}-{{ $stats->fg3a }}
                                                </th>
                                                <th>
                                                    @if($stats->fg3a==0)
                                                        0.0%
                                                    @else
                                                        <?php $total_3P  = $total_3P + number_format(($stats->fg3m/$stats->fg3a)*100,1); ?>
                                                        {{ number_format(($stats->fg3m/$stats->fg3a)*100,1) }}%
                                                    @endif
                                                </th>
                                                <th>
                                                    <?php $total_ftm = $total_ftm + $stats->ftm; ?>
                                                    <?php $total_fta = $total_fta + $stats->fta; ?>
                                                    {{ $stats->ftm }}-{{ $stats->fta }}
                                                </th>
                                                <th>
                                                    @if($stats->fta==0)
                                                        0.0%
                                                    @else
                                                        <?php $total_ftP  = $total_ftP + number_format(($stats->ftm/$stats->fta)*100,1); ?>
                                                        {{ number_format(($stats->ftm/$stats->fta)*100,1) }}%
                                                    @endif
                                                </th>
                                                <th>{{ $stats->oreb + $stats->dreb }} <?php $total_reb = $total_reb + $stats->oreb + $stats->dreb; ?></th>
                                                <th>{{ $stats->ast }}<?php $total_ast = $total_ast + $stats->ast; ?></th>
                                                <th>{{ $stats->blk }}<?php $total_blk = $total_blk + $stats->blk; ?></th>
                                                <th>{{ $stats->stl }}<?php $total_stl = $total_stl + $stats->stl; ?></th>
                                                <th>{{ $stats->pf }}<?php $total_pf = $total_pf + $stats->pf; ?></th>
                                                <th>{{ $stats->turnover }}<?php $total_to = $total_to + $stats->turnover; ?></th>
                                                <th class="text-success">{{ $stats->pts }}<?php $total_pts = $total_pts + $stats->pts; ?></th>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-aqua">
                                            <th colspan="3">Last 10 Games</th>
                                            <th>{{ number_format($total_fgm/$counter,1) }}-{{ number_format($total_fga/$counter,1) }}</th>
                                            <th>{{ number_format($total_fP/$counter,1) }}%</th>
                                            <th>{{ number_format($total_3fm/$counter,1) }}-{{ number_format($total_3fa/$counter,1) }}</th>
                                            <th>{{ number_format($total_3P/$counter,1) }}%</th>
                                            <th>{{ number_format($total_ftm/$counter,1) }}-{{ number_format($total_fta/$counter,1) }}</th>
                                            <th>{{ number_format($total_ftP/$counter,1) }}%</th>
                                            <th>{{ number_format($total_reb/$counter,1) }}</th>
                                            <th>{{ number_format($total_ast/$counter,1) }}</th>
                                            <th>{{ number_format($total_blk/$counter,1) }}</th>
                                            <th>{{ number_format($total_stl/$counter,1) }}</th>
                                            <th>{{ number_format($total_pf/$counter,1) }}</th>
                                            <th>{{ number_format($total_to/$counter,1) }}</th>
                                            <th>{{ number_format($total_pts/$counter,1) }}</th>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        @include('sidebar.addPlayer')
    </div>
@endsection

@section('modal')
    <label>DELETE PLAYER?</label>
    <form method="GET" action="{{ url('admin/player/destroy/'.$player_id) }}">
        <div class="alert alert-warning" style="margin-bottom: 0px;">
            <font class="text-warning">
                <i class="fa fa-warning"></i> Are you sure you want to delete this player? All records corresponding to this player will be deleted.
            </font>
        </div>
@endsection

@section('js')
    <script>
        function readProfURL(input)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#prof_pic').attr('src', e.target.result);
                    $('#prof_pic').addClass('img-responsive');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readPortraitURL(input)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#portrait_pic').attr('src', e.target.result);
                    $('#portrait_pic').addClass('img-responsive');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

