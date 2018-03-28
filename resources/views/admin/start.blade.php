<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>{{ $data->home_team }} vs. {{ $data->away_team }}</title>
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/game.css') }}" rel="stylesheet">
    <style>
        .team {
            color: #2786bf !important;
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
<?php
$players = \App\Boxscore::where('game_id',$data->id)
    ->where('team',$team)
    ->get();
?>
<div id="social-platforms">
    <h1 class="team">{{ $team }} | <font class="title-info score">0</font> </h1>
    @foreach($players as $row)
    <?php
        $player = \App\Players::find($row->player_id);
    ?>
    <a class="btn btn-icon btn-twitter" href="#basketModal" data-player="{{ $player->id }}" data-game="{{ $row->game_id }}" data-team="{{ $row->team }}" data-toggle="modal">
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

    getScore();

    function getScore()
    {
        var url = "{{ url('game/score') }}";
        $.ajax({
            url: url+'/'+game_id+'/'+team,
            type: 'GET',
            success: function(data){
                $('.score').html(data).fadeOut().fadeIn();
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
                $('.score').html(data).fadeOut().fadeIn();
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
