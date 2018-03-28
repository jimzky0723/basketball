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
        Team A vs Team B
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
            font-size: 15em;
            letter-spacing: 10px;
            padding: 0px 5px 0px 20px;
            margin:0px;
        }
        .score {
            color: #ed3626;
            font-size: 17em;
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
            <font class="digital-score team">Team A</font>
            <span class="score border digital-score">32</span>
            <span class="quarter border digital-score">23</span>
            <span class="score border digital-score">26</span>
            <font class="digital-score team">Team B</font>
        </div>
    </div>
<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<script>
    var minutes = 15;
    var seconds = 00;
    var interval = setInterval(function() {
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
            //pause();
            clearInterval(interval);
        }else if(minutes<0){
            clearInterval(interval);
        }else{

        }
    }, 1000);
</script>
<script>
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
</script>
</body>
</html>