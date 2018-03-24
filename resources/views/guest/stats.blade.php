@extends('layouts.guest')
@section('content')
    <div class="news">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="pull-right">
                        <form action="{{ url('stats') }}" method="POST" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group-sm" style="margin-bottom: 10px;">
                                <label>Sort By : </label>
                                <select name="sort" class="form-control">
                                    <option {{ ($sort=='pts') ? 'selected':'' }} value="scoring">Points</option>
                                    <option {{ ($sort=='ast') ? 'selected':'' }} value="assist">Assist</option>
                                    <option {{ ($sort=='fg_per') ? 'selected':'' }} value="fieldgoal">Field Goal %</option>
                                    <option {{ ($sort=='fg3_per') ? 'selected':'' }} value="3-fieldgoal">3-Field Goal %</option>
                                    <option {{ ($sort=='ft_per') ? 'selected':'' }} value=freethrow>Free Throw %</option>
                                    <option {{ ($sort=='win') ? 'selected':'' }} value=winning>Winning %</option>
                                    <option {{ ($sort=='reb') ? 'selected':'' }} value="rebound">Rebound</option>
                                    <option {{ ($sort=='stl') ? 'selected':'' }} value="steal">Steal</option>
                                    <option {{ ($sort=='blk') ? 'selected':'' }} value="block">Block</option>
                                    <option {{ ($sort=='turnover') ? 'selected':'' }} value="turnover">Turnover</option>
                                </select>
                                <button type="submit" class="btn btn-success btn-sm btn-flat">
                                    <i class="fa fa-sort"></i> Sort
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
                                <th>WIN%</th>
                                <th>PTS</th>
                                <th>2PM</th>
                                <th>2PA</th>
                                <th>FG%</th>
                                <td>3PM</td>
                                <td>3PA</td>
                                <th>3-FG%</th>
                                <th>FT%</th>
                                <th>AST</th>
                                <th>REB</th>
                                <th>STL</th>
                                <th>BLK</th>
                                <th>TO</th>
                            </tr>
                            <?php
                            $rank = 0;
                            $holder = 0;
                            ?>
                            @foreach($data as $row)
                                <?php
                                $player = \App\Players::find($row->player_id);
                                ?>
                                <tr>
                                    @if($holder!=$row->$sort)
                                        <?php
                                        $rank += 1;
                                        $holder = $row->$sort;
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
                                    <td class="{{ ($sort=='win') ? 'bg-gray':'' }}">{{ number_format($row->win*100,1) }}%</td>
                                    <td class="{{ ($sort=='pts') ? 'bg-gray':'' }}">{{ number_format($row->pts,1) }}</td>
                                    <td class="{{ ($sort=='fg_per') ? 'bg-gray':'' }}">{{ number_format($row->fg2m,1) }}</td>
                                    <td class="{{ ($sort=='fg_per') ? 'bg-gray':'' }}">{{ number_format($row->fg2a,1) }}</td>
                                    <td class="{{ ($sort=='pts' || $sort=='fg_per') ? 'bg-gray':'' }}">{{ number_format($row->fg_per*100,1) }}%</td>
                                    <td class="{{ ($sort=='fg3_per') ? 'bg-gray':'' }}">{{ number_format($row->fg3m,1) }}</td>
                                    <td class="{{ ($sort=='fg3_per') ? 'bg-gray':'' }}">{{ number_format($row->fg3a,1) }}</td>
                                    <td class="{{ ($sort=='fg3_per') ? 'bg-gray':'' }}">{{ number_format($row->fg3_per*100,1) }}%</td>
                                    <td class="{{ ($sort=='ft_per') ? 'bg-gray':'' }}">{{ number_format($row->ft_per*100,1) }}%</td>
                                    <td class="{{ ($sort=='ast') ? 'bg-gray':'' }}">{{ number_format($row->ast,1) }}</td>
                                    <td class="{{ ($sort=='reb') ? 'bg-gray':'' }}">{{ number_format($row->reb,1) }}</td>
                                    <td class="{{ ($sort=='stl') ? 'bg-gray':'' }}">{{ number_format($row->stl,1) }}</td>
                                    <td class="{{ ($sort=='blk') ? 'bg-gray':'' }}">{{ number_format($row->blk,1) }}</td>
                                    <td class="{{ ($sort=='turnover') ? 'bg-gray':'' }}">{{ number_format($row->turnover,1) }}</td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

