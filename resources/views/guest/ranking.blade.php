@extends('layouts.guest')
@section('content')
    <div class="news">
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header with-border">
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
                            ?>
                            @foreach($data as $row)
                                <?php
                                    $player = \App\Players::find($row->player_id);
                                ?>
                               <tr>
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

