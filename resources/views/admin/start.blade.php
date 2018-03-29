<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>START: {{ $data->home_team }} vs. {{ $data->away_team }}</title>
    <link rel="icon" href="{{ asset('resources/img/favicon.png') }}">
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/game.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/style.css') }}" rel="stylesheet">
    <style>
        .team {
            color: #fff !important;
            font-size:1.5em;
            background: #333;
            padding: 5px 10px;
        }
        .score {
            font-size:2.2em;
            background: #333;
            padding: 3px 10px;
        }
        .home_score {
            color: #deea47 !important;
        }
        .away_score {
            color: #ea974c !important;
        }
        .title-info {
            color: #00ca6d;
            font-weight: bold;
            font-size: 1.4em;
        }
        .columns {
            padding:0px !important;
        }

    </style>
</head>
<body>
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">{{ $team }}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                {{--<ul class="nav navbar-nav">--}}
                    {{--<li class="active"><a href="#">Home</a></li>--}}
                    {{--<li><a href="#about">About</a></li>--}}
                    {{--<li><a href="#contact">Contact</a></li>--}}
                    {{--<li class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--<li><a href="#">Action</a></li>--}}
                            {{--<li><a href="#">Another action</a></li>--}}
                            {{--<li><a href="#">Something else here</a></li>--}}
                            {{--<li role="separator" class="divider"></li>--}}
                            {{--<li class="dropdown-header">Nav header</li>--}}
                            {{--<li><a href="#">Separated link</a></li>--}}
                            {{--<li><a href="#">One more separated link</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">
                            <span class="team">{{ $data->home_team }}</span> <span class="score home_score digital-score">00</span>
                            vs
                            <span class="score away_score digital-score">00</span> <span class="team">{{ $data->away_team }}</span>
                        </a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

</header>
<?php
$players = \App\Boxscore::where('game_id',$data->id)
    ->where('team',$team)
    ->get();
?>
<div id="social-platforms">
    @foreach($players as $row)
        <?php
        $player = \App\Players::find($row->player_id);
        ?>
        <a class="btn btn-icon btn-twitter" href="#basketModal" data-player="{{ $player->id }}" data-game="{{ $row->game_id }}" data-team="{{ $row->team }}" data-toggle="modal" style="background:#fff;">
            <i>
                {{ $player->fname[0] }}. {{ $player->lname }}<br /><small>{{ $player->position }} | {{ $player->jersey}}</small>
            </i>
            <span><img src="{{ url('public/upload/profile/'.$player->prof_pic.'?img='.date('YmdHis')) }}" width="80px" class="img-responsive" /></span>
        </a>
    @endforeach
</div>
</body>

<div class="modal fade" role="dialog" id="basketModal">
    <div class="modal-dialog modal-sm" role="document">
        {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-success action" data-action="fg2m">
                        <img src="{{ url('public/upload/icons/2pt.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-success action" data-action="fg3m">
                        <img src="{{ url('public/upload/icons/3pt.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-success action" data-action="ftm">
                        <img src="{{ url('public/upload/icons/ft.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-danger action" data-action="fg2a">
                        <img src="{{ url('public/upload/icons/2pt_x.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-danger action" data-action="fg3a">
                        <img src="{{ url('public/upload/icons/3pt_x.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-danger action" data-action="fta">
                        <img src="{{ url('public/upload/icons/ft_x.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="clearfix"></div>
                <hr />
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-default action" data-action="blk">
                        <img src="{{ url('public/upload/icons/blk.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-default action" data-action="oreb">
                        <img src="{{ url('public/upload/icons/oreb.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-4 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-default action" data-action="dreb">
                        <img src="{{ url('public/upload/icons/dreb.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="clearfix"></div>
                <hr />
                <div class="col-sm-3 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-info action" data-action="stl">
                        <img src="{{ url('public/upload/icons/stl.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-3 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-info action" data-action="ast">
                        <img src="{{ url('public/upload/icons/ast.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-3 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-info action" data-action="turnover">
                        <img src="{{ url('public/upload/icons/ot.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="col-sm-3 columns">
                    <button type="button" data-dismiss="modal" class="btn btn-danger action" data-action="pf">
                        <img src="{{ url('public/upload/icons/pf.png') }}" class="img-responsive" />
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" role="dialog" id="serverModal">
    <div class="modal-dialog modal-sm" role="document">
        {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-warning">
                    <span class="text-warning">
                        <i class="fa fa-warning"></i> Opps! Connection problem! Please pause the game.
                    </span>
                </div>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
<!-- Firebase Connection -->
<script src="https://www.gstatic.com/firebasejs/4.12.0/firebase.js"></script>
<script src="{{ asset('resources/assets/js/firebase-con.js')}}"></script>

<script>
    var team = "{{ $team }}";
    var game_id = "{{ $data->id }}";
    var player_id = 0;
    var action = '';

    //firebase Configuration
    var fbaseCon = firebase.database();

    var gameRef = fbaseCon.ref('Game');
    var home = gameRef.child("{{ $data->id }}").child('home');
    var away = gameRef.child("{{ $data->id }}").child('away');

    home.once('value',function(snapshot){
        if(snapshot.hasChild('score')){
            var data = snapshot.val();
            var score = (data.score<10) ? '0' + data.score: data.score;
            $('.home_score').html(score);
        }else{
            home.set({
                name : "{{ $data->home_team }}",
                score: 0,
                foul: 0
            });
        }

    });

    away.once('value',function(snapshot){
        if(snapshot.hasChild('score')){
            var data = snapshot.val();
            var score = (data.score<10) ? '0' + data.score: data.score;
            $('.away_score').html(score);
        }else{
            away.set({
                name : "{{ $data->away_team }}",
                score: 0,
                foul: 0
            });
        }

    });

    gameRef.on('child_changed',function(snapshot){
        var data = snapshot.val();
        var home_score = (data.home.score<10) ? '0' + data.home.score: data.home.score;
        var away_score = (data.away.score<10) ? '0' + data.away.score: data.away.score;
        $('.home_score').html(home_score);
        $('.away_score').html(away_score);
    });


    getScore();

    function getScore()
    {
        var url = "{{ url('game/score') }}";
        $.ajax({
            url: url+'/'+game_id+'/'+team,
            type: 'GET',
            success: function(data){
                //$('.score').html(data).fadeOut().fadeIn();
            },
            error: function(){
                $('#serverModal').modal('show');
            }
        });
    }

    $('a[href="#basketModal"]').on('click',function(){
        player_id = $(this).data('player');
        game_id = $(this).data('game');
    });

    $('.action').on('click',function(){
        action = $(this).data('action');
        sendData();
    });

    function sendData()
    {
        var url = "{{ url('admin/games/boxscore/auto/') }}";
        $.ajax({
            url: url+'/'+game_id+'/'+player_id+'/'+action+'/'+team,
            type: 'GET',
            success: function(data){
//                $('.score').html(data).fadeOut().fadeIn();
                // console.log(action);
                // console.log(player_id);
                var dataRef = fbaseCon.ref('boxscore');
                dataRef.push({
                    player_id: player_id,
                    action: action,
                    game: game_id,
                    team: team
                });
                dataRef.on('child_added',function(data){
                    console.log(data.key);
                   setTimeout(function(){
                       dataRef.child(data.key).remove();
                   }, 1000);
                });

            },
            error: function(){
                $('#serverModal').modal('show');
            }
        });
    }
</script>
</html>
