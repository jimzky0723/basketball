<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('resources/img/favicon.png') }}">
    <meta http-equiv="cache-control" content="max-age=0" />
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/style.css') }}" rel="stylesheet">
    <title>
        {{ $game->home_team }} vs {{ $game->away_team }}
    </title>

    <style>
        body {
            background: #000;
        }
        .wrapper {
            margin-top: 50px;
        }
        .border {
            border:3px solid #fff;
        }
        .time {
            color: #f5da2a;
            font-size: 17em;
            letter-spacing: 10px;
            padding: 0px 5px 0px 20px;
            margin:0px;
        }
        .score {
            color: #ed3626;
            font-size: 18em;
            letter-spacing: 10px;
            padding: 0px 5px 0px 20px;
            margin:0px;
        }
        .quarter {
            color: #4a832e;
            font-size: 10em;
            letter-spacing: 10px;
            padding: 0px 5px 0px 20px;
            margin:0px;
        }
        .team {
            color: #fff;
            font-size: 5em;
            padding: 0px 5px 0px 20px;
            margin:0px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px; /* Set the fixed height of the footer here */
            line-height: 60px; /* Vertically center the text there */
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="text-center">
            <span class="time border digital-score minutes">00</span>
            <span class="time digital-score">:</span>
            <span class="time border digital-score seconds">00</span>
        </div>

        <div class="text-center">
            <font class="digital-score team">{{ $game->home_team }}</font>
            <span class="score border digital-score">00</span>
            <span class="quarter border digital-score shootClock">24</span>
            <span class="score border digital-score">00</span>
            <font class="digital-score team">{{ $game->away_team }}</font>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="text-center">
                <button class="btn btn-lg btn-success btn-time">
                    <i class="fa fa-play"></i>
                </button>
                <button class="btn btn-lg btn-info btn-refresh">
                    <i class="fa fa-refresh"></i>
                </button>
                <button class="btn btn-lg btn-warning btn-clock">
                    <i class="fa fa-clock-o"></i>
                </button>
                <button class="btn btn-lg btn-primary btn-horn">
                    <i class="fa fa-bullhorn"></i>
                </button>
                <button class="btn btn-lg btn-primary btn-settings">
                    <i class="fa fa-gear"></i>
                </button>
            </div>
        </div>
    </footer>
@include('modal.timer')
<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
<script>
    var minutes = 20;
    var seconds = 0;
    var pauseTime = true;
    var shootClockPause = true;
    var shootSeconds = 24;
    var tmp_min = (minutes < 10) ? '0'+minutes: minutes;
    seconds = (seconds < 10) ? '0' + seconds : seconds;
    shootSeconds = (shootSeconds < 10) ? '0' + shootSeconds : shootSeconds;
    $('.minutes').html(tmp_min);
    $('.seconds').html(seconds);
    $('.shootClock').html(shootSeconds);


    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', "{{ url('public/upload/sound/buzzer.mp3') }}");
    audioElement.addEventListener('ended', function() {
        this.play();
    }, false);
    //play();
    function play()
    {
        audioElement.play();
        setTimeout(function(){
            audioElement.pause();
        },3000);
    }
    function pause()
    {
        audioElement.pause();
    }

    var interval = setInterval(function() {

        if(!pauseTime){
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
            //minutes = (minutes < 10) ? '0'+minutes: minutes;
            if (minutes < 0) clearInterval(interval);
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            //minutes = (minutes < 10) ?  minutes : minutes;
            $('.timer').html(minutes + ':' + seconds);

            var tmp_min = (minutes < 10) ? '0'+minutes: minutes;
            $('.minutes').html(tmp_min);
            $('.seconds').html(seconds);

            if(minutes<1 && seconds<=0){
                play();
                $('#endModal').modal();
                clearInterval(interval);
                $('.btn-time').removeClass('btn-default').addClass('btn-success');
                $('.btn-clock').removeClass('btn-default').addClass('btn-warning');
                $('.btn-time').find('i').removeClass('fa-pause').addClass('fa-play');
            }else if(minutes<0){
                clearInterval(interval);
            }else{

            }
        }

    }, 1000);

    var shootInterval = setInterval(function() {
        if(!shootClockPause){
            --shootSeconds;
            shootSeconds = (shootSeconds < 0) ? 24 : shootSeconds;
            shootSeconds = (shootSeconds < 10) ? '0' + shootSeconds : shootSeconds;
            $('.shootClock').html(shootSeconds);

            if(shootSeconds<=0){
                $('#shootClockModal').modal();
                play();
                pauseTime = true;
                shootClockPause = true;
                $('.btn-time').removeClass('btn-default').addClass('btn-success');
                $('.btn-clock').removeClass('btn-default').addClass('btn-warning');
                $('.btn-time').find('i').removeClass('fa-pause').addClass('fa-play');
                if(minutes<=0 && seconds<25){
                    $('.shootClock').addClass('text-muted').html('--');
                    $('.shootClock').removeClass('shootClock');
                    shootClockPause = true;
                    clearInterval(shootInterval);
                }
            }

        }
    }, 1000);
</script>
<script>
    $('.btn-time').on('click',function(){
        var value = $(this).find('i');
        if(value.hasClass('fa-play')){
            value.removeClass('fa-play').addClass('fa-pause');
            $(this).removeClass('btn-success').addClass('btn-default');
            pauseTime = false;
            shootClockPause = false;
            $('.btn-clock').removeClass('btn-warning').addClass('btn-default');

            if(minutes<=0 && seconds>=24 && shootSeconds==0){
                console.log('here');
                shootSeconds = 24;
            }else if(minutes>0){
                shootSeconds = 24;
            }

        }else{
            value.removeClass('fa-pause').addClass('fa-play');
            pauseTime = true;
            shootClockPause = true;
            $(this).removeClass('btn-default').addClass('btn-success');
            $('.btn-clock').removeClass('btn-default').addClass('btn-warning');
        }
    })

    $('.btn-clock').on('click',function(){
        var value = $(this).hasClass('btn-warning');

        if(value && shootClockPause){
            $(this).removeClass('btn-warning').addClass('btn-default');
            shootClockPause = false;
        }else{
            $(this).removeClass('btn-default').addClass('btn-warning');
            shootClockPause = true;
        }
    });

    $('.btn-refresh').on('click',function(){
        if(minutes<=0 && seconds<25){
            shootSeconds = 0;
            $('.shootClock').addClass('text-muted').html('--');
            $('.shootClock').removeClass('shootClock');
            shootClockPause = true;
            clearInterval(shootInterval);
        }else{
            $('.shootClock').html(24);
            shootSeconds = 24;
        }
    });
    $('.btn-horn').on('click',function(){
        play();
    });

    $('.btn-settings').on('click',function(){
        $('#setTimeModal').modal();
    });

    $('.btn-set').on('click',function(){
        var min = $('#minuteTime').val();
        var sec = $('#secondsTime').val();
        minutes = min;
        seconds = sec;
        var tmp_min = (minutes < 10) ? '0'+minutes: minutes;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        $('.seconds').html(seconds);
        $('.minutes').html(tmp_min);
    });
</script>
</body>
</html>