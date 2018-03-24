@extends('layouts.guest')
@section('content')
    <style>
        .table-stats {
            font-size: 0.8em;
            font-weight: normal !important;
        }
    </style>
    <div class="col-md-3">
        @include('sidebar.profile')
    </div>
    <div class="news">
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4>Career Stats</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-stats table-striped table-hover">
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
                </div>
            </div>

            <div class="box box-success">
                <div class="box-header with-border">
                    <h4>Game Log</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-stats table-striped table-hover">
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
                                        <a href="{{ url('score/boxscore/'.$log->id) }}" target="_blank">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

