<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">Player Profile</h3>
    </div>
    <div class="panel-body">
        <div class="thumbnail img-responsive">
            <img src="{{ url('public/upload/profile/'.$data->prof_pic.'/?img='.date('YmdHis')) }}" />
            <div class="text-center">
                <span class="title-info">{{ $data->fname }} {{ $data->lname }}
                <br />
                <small class="text-muted">
                    #{{ $data->jersey }} <span class="text-bold">{{ $data->position }}</span> | {{ $data->height }}, {{ $data->weight }}<br />
                    {{ $data->section }}
                </small>
                </span>
            </div>

        </div>

    </div>
</div>
<style>
    .table-stat tr td:first-child {
        background: #111;
        color: #fff;
        text-align: right;
        vertical-align: middle;
        font-weight: bold;
        padding: 5px;
        width:40%;
    }

    .table-stat tr td:nth-child(2) {
        color: #443ff5;
        vertical-align: middle;
        font-weight: bold;
        padding: 5px;
    }

    .table-stats tr td {
        border:1px solid #bbb !important;
    }
</style>
<div class="panel panel-jim">
    <div class="panel-heading">
        <h3 class="panel-title">2018 Career</h3>
    </div>
    <div class="panel-body">
        <table class="table table-stat" style="margin-bottom: 0px;">
            <tr>
                <td>GP</td>
                <td>{{ $stats->gp }}</td>
            </tr>
            <tr>
                <td>PPG</td>
                <td>{{ number_format($stats->pts,1) }}</td>
            </tr>
            <tr>
                <td>APG</td>
                <td>{{ number_format($stats->ast,1) }}</td>
            </tr>
            <tr>
                <td>RPG</td>
                <td>{{ number_format($stats->reb,1) }}</td>
            </tr>
        </table>
    </div>
</div>