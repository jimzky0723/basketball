<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Quick Links</h3>
    </div>
    <div class="panel-body">
        <div class="list-group">
            <a href="{{ asset('ranking') }}" class="list-group-item clearfix">
                Player Rankings
            </a>
            <a href="{{ asset('stats') }}" class="list-group-item clearfix">
                Player Stats
            </a>
        </div>

    </div>
</div>


<?php
$comm = \App\Http\Controllers\ParamCtrl::getCommitteeOfTheWeek();
?>
@if(count($comm['comm']))
<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Committee of the Week</h3>
        <small>{{ date('l M d, Y',strtotime($comm['date'])) }}</small>
    </div>
    <div class="panel-body">
        <div class="list-group">
            @foreach($comm['comm'] as $row)
                <?php $player = \App\Players::find($row->player_id); ?>
                <a href="#" class="list-group-item clearfix">
                    <div class="col-xs-8">
                        <span class="text-success text-bold">{{ $player->fname }} {{ $player->lname }}</span>
                        <br />
                        <span class="text-warning text-bold">{{ $player->section }}</span>
                    </div>
                    <div class="col-xs-4">
                        <img src="{{ url('pictures/profile/'.$player->prof_pic) }}" class="img-responsive">
                    </div>

                </a>
            @endforeach
        </div>

    </div>
</div>
@endif
