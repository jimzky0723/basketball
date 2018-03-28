
<script src="https://www.gstatic.com/firebasejs/4.12.0/firebase.js"></script>
<script>
    // Initialize Firebase


//    var config = {
//        apiKey: "AIzaSyDeLEikoWBsdYScbjo1xhqsFu3c3xTD3iw",
//        authDomain: "basket-86a60.firebaseapp.com",
//        databaseURL: "https://basket-86a60.firebaseio.com",
//        projectId: "basket-86a60",
//        storageBucket: "basket-86a60.appspot.com",
//        messagingSenderId: "309550367395"
//    };
//    firebase.initializeApp(config);

    var config = {
        apiKey: "AIzaSyDjQaH9U8JjMm3uwHxyUeRVVfMJQ2p9xaI",
        authDomain: "doh-basketball.firebaseapp.com",
        databaseURL: "https://doh-basketball.firebaseio.com",
        projectId: "doh-basketball",
        storageBucket: "doh-basketball.appspot.com",
        messagingSenderId: "366586321047"
    };
    firebase.initializeApp(config);

    var dbRef = firebase.database();

    var gameRef = dbRef.ref('Game');
    var home = gameRef.child('15').child('home');
    var away = gameRef.child('15').child('away');
//    home.set({
//        name : 'Team A',
//        score: 8,
//        foul: 0
//    });
//
//
//    away.set({
//        name : 'Team B',
//        score: 12,
//        foul: 0
//    });


    home.once('value',function(snapshot){
        if(snapshot.hasChild('score')){
            var data = snapshot.val();
            var score = (data.score<10) ? '0' + data.score: data.score;
            $('.home_score').html(score);
        }else{
            home.set({
                name : 'Team A',
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
                name : 'Team B',
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
</script>