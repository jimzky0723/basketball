@extends('layouts.guest')
@section('content')
    <?php
        $weeks = \App\Games::select(DB::raw('WEEK(date_match) week'))
            ->groupBy('week')
            ->orderBy('id','asc')
            ->get();
    ?>
    <div class="news">
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="pull-right">
                        <form action="{{ url('ranking/week') }}" method="POST" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group-sm" style="margin-bottom: 10px;">
                                <label>Filter By : </label>
                                <select name="filter" class="form-control">
                                    <option value="">All</option>
                                    <option {{ ($filter=='PG') ? 'selected':'' }} value="PG">Point Guard</option>
                                    <option {{ ($filter=='SG') ? 'selected':'' }} value="SG">Shooting Guard</option>
                                    <option {{ ($filter=='SF') ? 'selected':'' }} value="SF">Small Forward</option>
                                    <option {{ ($filter=='PF') ? 'selected':'' }} value="PF">Power Forward</option>
                                    <option {{ ($filter=='C') ? 'selected':'' }} value="C">Center</option>
                                </select>
                                <select name="week" class="form-control">
                                    @foreach($weeks as $row)
                                        <?php
                                            $week_name = $row->week;
                                            if(date('Y')=='2018'){
                                                $week_name = $row->week - 10;
                                            }
                                        ?>
                                        <option {{ ($week==$row->week) ? 'selected':'' }} value="{{ $row->week }}">Week #{{ $week_name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-success btn-sm btn-flat">
                                    <i class="fa fa-sort"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                    <h3>{{ $title }}</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr class="bg-black">
                                <th>RANK</th>
                                <th>NAME</th>
                                <th>GP</th>
                                <th>PTS</th>
                                <th>AST</th>
                                <th>REB</th>
                                <th>STL</th>
                                <th>BLK</th>
                                <th>TO</th>
                                <th>EFF</th>
                            </tr>
                            <?php
                            $rank = 0;
                            $holder = 0;
                            $c = 0;
                            ?>
                            @foreach($data as $row)
                                <?php
                                $player = \App\Players::find($row->player_id);
                                $c += 1;
                                ?>
                                <tr class="{{ ($c>15) ? 'bg-gray':'' }}">
                                    @if($holder!=$row->eff)
                                        <?php
                                        $rank += 1;
                                        $holder = $row->eff;
                                        ?>
                                        <td>{{ $rank }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td class="text-bold text-success">
                                        <a href="{{ url('player/'.$player->id) }}" target="_blank">{{ $player->fname }} {{ $player->lname }}</a>,
                                        <span class="text-muted">{{ $player->position }}</span>
                                    </td>
                                    <td>{{ $row->gp }}</td>
                                    <td>{{ $row->pts }}</td>
                                    <td>{{ $row->ast }}</td>
                                    <td>{{ $row->reb }}</td>
                                    <td>{{ $row->stl }}</td>
                                    <td>{{ $row->blk }}</td>
                                    <td>{{ $row->turnover }}</td>
                                    <td>{{ ($row->eff>0) ? '+':'' }}{{ $row->eff }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
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

