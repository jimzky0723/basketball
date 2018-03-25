<?php
    $top = \App\Http\Controllers\ParamCtrl::getTopPlayer();
    $player_id = $top['player_id'];
    $stats = $top['stats'];
    $player = \App\Players::find($player_id);

?>
<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Rank 1 Overall Statistics</h3>
    </div>
    <div class="panel-body">
        <div class="thumbnail img-responsive">
            <img src="{{ url('public/upload/portrait/'.$player->portrait_pic) }}" />
            <div class="text-center">
                <span class="title-info">{{ $player->fname }} {{ $player->lname }}</span>
                <br />
                <small class="text-muted">Average of
                @foreach($stats as $row)
                    {{ number_format($row['count'],1) }} {{ $row['value'] }}
                @endforeach
                </small>
            </div>

        </div>

    </div>
</div>
<?php
$player_week = \App\Awards::where('type','week')
        ->orderBy('id','desc')
        ->first();
?>
@if(count($player_week))
<?php
    $player = \App\Players::find($player_week['player_id']);
    $week_stats = $player_week['stats'];
?>
<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Featured Player of the Week</h3>
    </div>
    <div class="panel-body">
        <div class="thumbnail img-responsive">
            <img src="{{ url('pictures/profile/'.$player->prof_pic) }}" />
            <div class="text-center">
                <span class="title-info">{{ $player->fname }} {{ $player->lname }}</span>
                <br />
                <small class="text-muted">Average of
                    @foreach($stats as $row)
                        {{ number_format($row['count'],1) }} {{ $row['value'] }}
                    @endforeach
                </small>
            </div>

        </div>

    </div>
</div>
@endif