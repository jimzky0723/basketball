@extends('layouts.guest')

@section('content')
    <?php
    $status = session('status');
    ?>
    <style>
        th {
            vertical-align: middle !important;
        }
        .score {
            font-weight: bold;
            font-size: 1.6em;
        }
    </style>
    <div class="col-md-12">
        <div class="jim-content">
            <div class="text-center">
                <h3 class="page-header">
                    <?php
                    $home_score = \App\Boxscore::where('game_id',$data->id)
                        ->where('team',$data->home_team)
                        ->sum('pts');

                    $away_score = \App\Boxscore::where('game_id',$data->id)
                        ->where('team',$data->away_team)
                        ->sum('pts');
                    ?>
                    {{ $data->home_team }} <font class="text-primary score" id="score_{{ substr($data->home_team, -1) }}">{{ $home_score }}</font> <font class="score"> vs. </font>  <font class="text-primary score" id="score_{{ substr($data->away_team, -1) }}">{{ $away_score }}</font> {{ $data->away_team }}
                </h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($status=='saved')
                        <div class="alert alert-success">
                            <font class="text-success">
                                <i class="fa fa-check"></i> Game successfully added!
                            </font>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <caption class="title-info">{{ $data->home_team }}</caption>
                            <?php
                            $players = \App\Boxscore::where('game_id',$data->id)
                                ->where('team',$data->home_team)
                                ->get();
                            ?>
                            <thead class="bg-success">
                            <tr>
                                <td>Players</td>
                                <td>2PT</td>
                                <td>3PT</td>
                                <td>FG</td>
                                <td>FT</td>
                                <td>OREB</td>
                                <td>DREB</td>
                                <td>REB</td>
                                <td>AST</td>
                                <td>STL</td>
                                <td>BLK</td>
                                <td>TO</td>
                                <td>PF</td>
                                <td>PTS</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_fgm = 0;
                            $total_fga = 0;
                            $total_2fm = 0;
                            $total_2fa = 0;
                            $total_3fm = 0;
                            $total_3fa = 0;
                            $total_ftm = 0;
                            $total_fta = 0;
                            $total_oreb =0;
                            $total_dreb = 0;
                            $total_reb = 0;
                            $total_ast = 0;
                            $total_stl = 0;
                            $total_blk = 0;
                            $total_to = 0;
                            $total_pf = 0;
                            $total_pts =0;
                            ?>
                            @foreach($players as $row)
                                <tr class="players_status">
                                    <?php
                                    $player = \App\Players::find($row->player_id);
                                    ?>
                                    <td>
                                        <span class="text-bold text-info">
                                            #{{$player->jersey}}
                                        </span>
                                        <a href="{{ url('player/'.$player->id) }}" target="_blank">
                                            {{ $player->fname }} {{ $player->lname }}
                                            <small class="text-muted">{{ $player->position }}</small>
                                        </a>
                                    </td>
                                    <td>
                                        <span id="fg2m_{{ $player->id }}">{{ $row->fg2m }}</span>-<span id="fg2a_{{ $player->id }}">{{ $row->fg2a }}</span>
                                        <?php
                                        $total_2fm = $total_2fm + $row->fg2m;
                                        $total_2fa = $total_2fa + $row->fg2a;
                                        ?>
                                    </td>
                                    <td>
                                        <span id="fg3m_{{ $player->id }}">{{ $row->fg3m }}</span>-<span id="fg3a_{{ $player->id }}">{{ $row->fg3a }}</span>
                                        <?php
                                        $total_3fm = $total_3fm + $row->fg3m;
                                        $total_3fa = $total_3fa + $row->fg3a;
                                        ?>
                                    </td>
                                    <td>
                                        <span id="fg23m_{{ $player->id }}">{{ $row->fg2m +  $row->fg3m }}</span>-<span id="fg23a_{{ $player->id }}">{{ $row->fg2a + $row->fg3a }}</span>
                                        <?php
                                        $total_fgm = $total_fgm + $row->fg2m +  $row->fg3m;
                                        $total_fga = $total_fga + $row->fg2a + $row->fg3a;
                                        ?>
                                    </td>
                                    <td>
                                        <span id="ftm_{{ $player->id }}">{{ $row->ftm }}</span>-<span id="fta_{{ $player->id }}">{{ $row->fta }}</span> 
                                        <?php
                                        $total_ftm = $total_ftm + $row->ftm;
                                        $total_fta = $total_fta + $row->fta;
                                        ?>
                                    </td>
                                    <td>
                                        <span id="oreb_{{ $player->id }}">{{ $row->oreb }}</span>
                                        <?php $total_oreb = $total_oreb + $row->oreb; ?>
                                    </td>
                                    <td>
                                        <span id="dreb_{{ $player->id }}">{{ $row->dreb }}</span>
                                        <?php $total_dreb = $total_dreb + $row->dreb; ?>
                                    </td>
                                    <td>
                                        <span id="treb_{{ $player->id }}">{{ $row->oreb + $row->dreb }}</span>
                                        <?php $total_reb = $total_reb + $row->oreb + $row->dreb; ?>
                                    </td>
                                    <td>
                                        <span id="ast_{{ $player->id }}">{{ $row->ast }}</span>
                                        <?php $total_ast = $total_ast + $row->ast; ?>
                                    </td>
                                    <td>
                                        <span id="stl_{{ $player->id }}">{{ $row->stl }}</span>
                                        <?php $total_stl = $total_stl + $row->stl; ?>
                                    </td>
                                    <td>
                                        <span id="blk_{{ $player->id }}">{{ $row->blk }}</span>
                                        <?php $total_blk = $total_blk + $row->blk; ?>
                                    </td>
                                    <td>
                                        <span id="turnover_{{ $player->id }}">{{ $row->turnover }}</span>
                                        <?php $total_to = $total_to + $row->turnover; ?>
                                    </td>
                                    <td>
                                        <span id="pf_{{ $player->id }}">{{ $row->pf }}</span>
                                        <?php $total_pf = $total_pf + $row->pf; ?>
                                    </td>
                                    <td>
                                        <span id="pts_{{ $player->id }}">{{ $row->pts }}</span>
                                        <?php $total_pts = $total_pts + $row->pts; ?>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="text-warning">
                                <th>TOTAL</th>
                                <th><span id="{{ $data->id }}_2fm_{{ substr($data->home_team, -1) }}">{{ $total_2fm }}</span>-<span id="{{ $data->id }}_2fa_{{ substr($data->home_team, -1) }}">{{ $total_2fa }}</span></th>
                                <th><span id="{{ $data->id }}_3fm_{{ substr($data->home_team, -1) }}">{{ $total_3fm }}</span>-<span id="{{ $data->id }}_3fa_{{ substr($data->home_team, -1) }}">{{ $total_3fa }}</span></th>
                                <th><span id="{{ $data->id }}_fgm_{{ substr($data->home_team, -1) }}">{{ $total_fgm }}</span>-<span id="{{ $data->id }}_fga_{{ substr($data->home_team, -1) }}">{{ $total_fga }}</span></th>
                                <th><span id="{{ $data->id }}_ftm_{{ substr($data->home_team, -1) }}">{{ $total_ftm }}</span>-<span id="{{ $data->id }}_fta_{{ substr($data->home_team, -1) }}">{{ $total_fta }}</span></th>
                                <th><span id="{{ $data->id }}_oreb_{{ substr($data->home_team, -1) }}">{{ $total_oreb }}</span></th>
                                <th><span id="{{ $data->id }}_dreb_{{ substr($data->home_team, -1) }}">{{ $total_dreb }}</span></th>
                                <th><span id="{{ $data->id }}_reb_{{ substr($data->home_team, -1) }}">{{ $total_reb }}</span></th>
                                <th><span id="{{ $data->id }}_ast_{{ substr($data->home_team, -1) }}">{{ $total_ast}}</span></th>
                                <th><span id="{{ $data->id }}_stl_{{ substr($data->home_team, -1) }}">{{ $total_stl}}</span></th>
                                <th><span id="{{ $data->id }}_blk_{{ substr($data->home_team, -1) }}">{{ $total_blk}}</span></th>
                                <th><span id="{{ $data->id }}_to_{{ substr($data->home_team, -1) }}">{{ $total_to}}</span></th>
                                <th><span id="{{ $data->id }}_pf_{{ substr($data->home_team, -1) }}">{{ $total_pf}}</span></th>
                                <th><span id="{{ $data->id }}_pts_{{ substr($data->home_team, -1) }}">{{ $total_pts}}</span></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    @if($total_2fa>0)
                                        {{ number_format(($total_2fm / $total_2fa)*100,1) }}%
                                    @else
                                        0.0%
                                    @endif
                                </td>
                                <td>
                                    @if($total_3fa>0)
                                        {{ number_format(($total_3fm / $total_3fa)*100,1) }}%
                                    @else
                                        0.0%
                                    @endif
                                </td>
                                <td>
                                    @if($total_fga>0)
                                        {{ number_format(($total_fgm / $total_fga)*100,1) }}%
                                    @else
                                        0.0%
                                    @endif
                                </td>
                                <td>
                                    @if($total_fta>0)
                                        {{ number_format(($total_ftm / $total_fta)*100,1) }}%
                                    @else
                                        0.0%
                                    @endif
                                </td>
                                <td colspan="9"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <caption class="title-info">{{ $data->away_team }}</caption>
                            <?php
                            $players = \App\Boxscore::where('game_id',$data->id)
                                ->where('team',$data->away_team)
                                ->get();
                            ?>
                            <thead class="bg-success">
                            <tr>
                                <td>Players</td>
                                <td>2PT</td>
                                <td>3PT</td>
                                <td>FG</td>
                                <td>FT</td>
                                <td>OREB</td>
                                <td>DREB</td>
                                <td>REB</td>
                                <td>AST</td>
                                <td>STL</td>
                                <td>BLK</td>
                                <td>TO</td>
                                <td>PF</td>
                                <td>PTS</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_fgm = 0;
                            $total_fga = 0;
                            $total_2fm = 0;
                            $total_2fa = 0;
                            $total_3fm = 0;
                            $total_3fa = 0;
                            $total_ftm = 0;
                            $total_fta = 0;
                            $total_oreb =0;
                            $total_dreb = 0;
                            $total_reb = 0;
                            $total_ast = 0;
                            $total_stl = 0;
                            $total_blk = 0;
                            $total_to = 0;
                            $total_pf = 0;
                            $total_pts =0;
                            ?>
                            @foreach($players as $row)
                                <tr class="players_status">
                                    <?php
                                    $player = \App\Players::find($row->player_id);
                                    ?>
                                    <td>
                                        <span class="text-bold text-info">
                                            #{{$player->jersey}}
                                        </span>
                                        <a href="{{ url('player/'.$player->id) }}" target="_blank">
                                            {{ $player->fname }} {{ $player->lname }}
                                            <small class="text-muted">{{ $player->position }}</small>
                                        </a>
                                    </td>
                                    <td>
                                        <span id="fg2m_{{ $player->id }}">{{ $row->fg2m }}</span>-<span id="fg2a_{{ $player->id }}">{{ $row->fg2a }}</span>
                                        <?php
                                            $total_2fm = $total_2fm + $row->fg2m;
                                            $total_2fa = $total_2fa + $row->fg2a;
                                        ?>
                                    </td>
                                    <td>
                                        <span id="fg3m_{{ $player->id }}">{{ $row->fg3m }}</span>-<span id="fg3a_{{ $player->id }}">{{ $row->fg3a }}</span>
                                        <?php
                                            $total_3fm = $total_3fm + $row->fg3m;
                                            $total_3fa = $total_3fa + $row->fg3a;
                                        ?>
                                    </td>
                                    <td>
                                            <span id="fg23m_{{ $player->id }}">{{ $row->fg2m +  $row->fg3m }}</span>-<span id="fg23a_{{ $player->id }}">{{ $row->fg2a + $row->fg3a }}</span>
                                            <?php
                                                $total_fgm = $total_fgm + $row->fg2m +  $row->fg3m;
                                                $total_fga = $total_fga + $row->fg2a + $row->fg3a;
                                            ?>
                                        </td>
                                        <td>
                                        <span id="ftm_{{ $player->id }}">{{ $row->ftm }}</span>-<span id="fta_{{ $player->id }}">{{ $row->fta }}</span>
                                            <?php
                                                $total_ftm = $total_ftm + $row->ftm;
                                                $total_fta = $total_fta + $row->fta;
                                            ?>
                                        </td>
                                        <td>
                                            <span id="oreb_{{ $player->id }}">{{ $row->oreb }}</span>
                                            <?php $total_oreb = $total_oreb + $row->oreb; ?>
                                        </td>
                                        <td>
                                            <span id="dreb_{{ $player->id }}">{{ $row->dreb }}</span>
                                            <?php $total_dreb = $total_dreb + $row->dreb; ?>
                                        </td>
                                        <td>
                                            <span id="treb_{{ $player->id }}">{{ $row->oreb + $row->dreb }}</span>
                                            <?php $total_reb = $total_reb + $row->oreb + $row->dreb; ?>
                                        </td>
                                        <td>
                                            <span id="ast_{{ $player->id }}">{{ $row->ast }}</span>
                                            <?php $total_ast = $total_ast + $row->ast; ?>
                                        </td>
                                        <td>
                                            <span id="stl_{{ $player->id }}">{{ $row->stl }}</span>
                                            <?php $total_stl = $total_stl + $row->stl; ?>
                                        </td>
                                        <td>
                                            <span id="blk_{{ $player->id }}">{{ $row->blk }}</span>
                                            <?php $total_blk = $total_blk + $row->blk; ?>
                                        </td>
                                        <td>
                                            <span id="turnover_{{ $player->id }}">{{ $row->turnover }}</span>
                                            <?php $total_to = $total_to + $row->turnover; ?>
                                        </td>
                                        <td>
                                            <span id="pf_{{ $player->id }}">{{ $row->pf }}</span>
                                            <?php $total_pf = $total_pf + $row->pf; ?>
                                        </td>
                                        <td>
                                            <span id="pts_{{ $player->id }}">{{ $row->pts }}</span>
                                            <?php $total_pts = $total_pts + $row->pts; ?>
                                        </td>
                                </tr>
                            @endforeach
                            <tr class="text-warning">
                                <th>TOTAL</th>
                                    <th><span id="{{ $data->id }}_2fm_{{ substr($data->away_team, -1) }}">{{ $total_2fm }}</span>-<span id="{{ $data->id }}_2fa_{{ substr($data->away_team, -1) }}">{{ $total_2fa }}</span></th>
                                    <th><span id="{{ $data->id }}_3fm_{{ substr($data->away_team, -1) }}">{{ $total_3fm }}</span>-<span id="{{ $data->id }}_3fa_{{ substr($data->away_team, -1) }}">{{ $total_3fa }}</span></th>
                                    <th><span id="{{ $data->id }}_fgm_{{ substr($data->away_team, -1) }}">{{ $total_fgm }}</span>-<span id="{{ $data->id }}_fga_{{ substr($data->away_team, -1) }}">{{ $total_fga }}</span></th>
                                    <th><span id="{{ $data->id }}_ftm_{{ substr($data->away_team, -1) }}">{{ $total_ftm }}</span>-<span id="{{ $data->id }}_fta_{{ substr($data->away_team, -1) }}">{{ $total_fta }}</span></th>
                                    <th><span id="{{ $data->id }}_oreb_{{ substr($data->away_team, -1) }}">{{ $total_oreb }}</span></th>
                                    <th><span id="{{ $data->id }}_dreb_{{ substr($data->away_team, -1) }}">{{ $total_dreb }}</span></th>
                                    <th><span id="{{ $data->id }}_reb_{{ substr($data->away_team, -1) }}">{{ $total_reb }}</span></th>
                                    <th><span id="{{ $data->id }}_ast_{{ substr($data->away_team, -1) }}">{{ $total_ast}}</span></th>
                                    <th><span id="{{ $data->id }}_stl_{{ substr($data->away_team, -1) }}">{{ $total_stl}}</span></th>
                                    <th><span id="{{ $data->id }}_blk_{{ substr($data->away_team, -1) }}">{{ $total_blk}}</span></th>
                                    <th><span id="{{ $data->id }}_to_{{ substr($data->away_team, -1) }}">{{ $total_to}}</span></th>
                                    <th><span id="{{ $data->id }}_pf_{{ substr($data->away_team, -1) }}">{{ $total_pf}}</span></th>
                                    <th><span id="{{ $data->id }}_pts_{{ substr($data->away_team, -1) }}">{{ $total_pts}}</span></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    @if($total_2fa>0)
                                        {{ number_format(($total_2fm / $total_2fa)*100,1) }}%
                                    @else
                                        0.0%
                                    @endif
                                </td>
                                <td>
                                    @if($total_3fa>0)
                                        {{ number_format(($total_3fm / $total_3fa)*100,1) }}%
                                    @else
                                        0.0%
                                    @endif
                                </td>
                                <td>
                                    @if($total_fga>0)
                                        {{ number_format(($total_fgm / $total_fga)*100,1) }}%
                                    @else
                                        0.0%
                                    @endif
                                </td>
                                <td>
                                    @if($total_fta>0)
                                        {{ number_format(($total_ftm / $total_fta)*100,1) }}%
                                    @else
                                        0.0%
                                    @endif
                                </td>
                                <td colspan="9"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('resources/assets/js/firebase-real.js') }}"></script>
@endsection


