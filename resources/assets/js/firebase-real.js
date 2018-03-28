
// Firebase cloud database instance
var fbaseCon = firebase.database();
//Firebase get boxscore & game references
var dataRef = fbaseCon.ref('boxscore');
var dataRef2 = fbaseCon.ref('Game');

var fg2m = 0;
var fg2a = 0;
var fg3m = 0;
var fg3a = 0;
var fg23m = 0;
var fg23a = 0;
var ftm = 0;
var fta = 0;
var oreb = 0;
var dreb = 0;
var treb = 0;
var ast = 0;
var stl = 0;
var blk = 0;
var to = 0;
var pf = 0;
var pts = 0;

var t_fg2m =  0;
var t_fg2a =  0;
var t_fg3m = 0;
var t_fg3a =  0;
var t_fgm = 0;
var t_fga = 0;
var t_ftm = 0;
var t_fta = 0;
var t_oreb = 0;
var t_dreb = 0;
var t_reb = 0;
var t_ast = 0;
var t_stl = 0;
var t_blk = 0;
var t_to = 0;
var t_pf = 0;
var t_pts = 0;

function  get_player_boxscore(data, team){
    fg2m = $('.players_status').find('td span#fg2m_' + data.val().player_id).html();
    fg2a = $('.players_status').find('td span#fg2a_' + data.val().player_id).html();
    fg3m = $('.players_status').find('td span#fg3m_' + data.val().player_id).html();
    fg3a = $('.players_status').find('td span#fg3a_' + data.val().player_id).html();
    fg23m = $('.players_status').find('td span#fg23m_' + data.val().player_id).html();
    fg23a = $('.players_status').find('td span#fg23a_' + data.val().player_id).html();
    ftm = $('.players_status').find('td span#ftm_' + data.val().player_id).html();
    fta = $('.players_status').find('td span#fta_' + data.val().player_id).html();
    oreb = $('.players_status').find('td span#oreb_' + data.val().player_id).html();
    dreb = $('.players_status').find('td span#dreb_' + data.val().player_id).html();
    treb = $('.players_status').find('td span#treb_' + data.val().player_id).html();
    ast = $('.players_status').find('td span#ast_' + data.val().player_id).html();
    stl = $('.players_status').find('td span#stl_' + data.val().player_id).html();
    blk = $('.players_status').find('td span#blk_' + data.val().player_id).html();
    to = $('.players_status').find('td span#turnover_' + data.val().player_id).html();
    pf = $('.players_status').find('td span#pf_' + data.val().player_id).html();
    pts = $('.players_status').find('td span#pts_' + data.val().player_id).html();

    t_fg2m =  $('.text-warning').find('th span#'+ data.val().game +'_2fm_' + team.substr(team.length-1)).html();
    t_fg2a =  $('.text-warning').find('th span#'+ data.val().game +'_2fa_' + team.substr(team.length-1)).html();
    t_fg3m =  $('.text-warning').find('th span#'+ data.val().game +'_3fm_' + team.substr(team.length-1)).html();
    t_fg3a =  $('.text-warning').find('th span#'+ data.val().game +'_3fa_' + team.substr(team.length-1)).html();
    t_fgm =  $('.text-warning').find('th span#'+ data.val().game +'_fgm_' + team.substr(team.length-1)).html();
    t_fga =  $('.text-warning').find('th span#'+ data.val().game +'_fga_' + team.substr(team.length-1)).html();
    t_ftm =  $('.text-warning').find('th span#'+ data.val().game +'_ftm_' + team.substr(team.length-1)).html();
    t_fta =  $('.text-warning').find('th span#'+ data.val().game +'_fta_' + team.substr(team.length-1)).html();
    t_oreb =  $('.text-warning').find('th span#'+ data.val().game +'_oreb_' + team.substr(team.length-1)).html();
    t_dreb =  $('.text-warning').find('th span#'+ data.val().game +'_dreb_' + team.substr(team.length-1)).html();
    t_reb =  $('.text-warning').find('th span#'+ data.val().game +'_reb_' + team.substr(team.length-1)).html();
    t_ast =  $('.text-warning').find('th span#'+ data.val().game +'_ast_' + team.substr(team.length-1)).html();
    t_stl =  $('.text-warning').find('th span#'+ data.val().game +'_stl_' + team.substr(team.length-1)).html();
    t_blk =  $('.text-warning').find('th span#'+ data.val().game +'_blk_' + team.substr(team.length-1)).html();
    t_to =  $('.text-warning').find('th span#'+ data.val().game +'_to_' + team.substr(team.length-1)).html();
    t_pf =  $('.text-warning').find('th span#'+ data.val().game +'_pf_' + team.substr(team.length-1)).html();
    t_pts =  $('.text-warning').find('th span#'+ data.val().game +'_pts_' + team.substr(team.length-1)).html();
}


function get_overall_score(){
    
}

function addToView(actInt = [], actions = [], player_id, count, team = '', game = 0){
    var f_count, s_count, t_count, frth_count, fth_count, sth_count, t_fgm, t_fga;

    if(count == 4){
        f_count = parseInt(actInt[0]);
        s_count = parseInt(actInt[1]);
        t_count = parseInt(actInt[2]);
        frth_count = parseInt(actInt[3]);
        fth_count = parseInt(actInt[4]);
        sth_count = parseInt(actInt[5]);
        t_fgm = parseInt(actInt[6]);
        t_fga = parseInt(actInt[7]);

        f_count += 1;
        s_count += 1;
        t_count += 1;
        frth_count += 1;
        fth_count += 1;
        sth_count += 1;
        t_fgm += 1;
        t_fga += 1;

        $('.players_status').find('td span#'+ actions[0] +'_' + player_id).html(f_count);
        $('.players_status').find('td span#'+ actions[1] +'_' + player_id).html(s_count);
        $('.players_status').find('td span#'+ actions[2] +'_' + player_id).html(t_count);
        $('.players_status').find('td span#'+ actions[3] +'_' + player_id).html(frth_count);
        $('.text-warning').find('th span#'+ game +'_' + actions[4] + '_' + team).html(fth_count);
        $('.text-warning').find('th span#'+ game +'_' + actions[5] + '_' + team).html(sth_count);
        $('.text-warning').find('th span#'+ game +'_' + actions[6] + '_' + team).html(t_fgm);
        $('.text-warning').find('th span#'+ game +'_' + actions[7] + '_' + team).html(t_fga);

    }else if(count == 2){
        f_count = parseInt(actInt[0]);
        s_count = parseInt(actInt[1]);
        t_count = parseInt(actInt[2]);
        t_fga = parseInt(actInt[3]);

        f_count += 1;
        s_count += 1;
        t_count += 1;
        t_fga += 1;

        $('.players_status').find('td span#'+ actions[0] +'_' + player_id).html(f_count);
        $('.players_status').find('td span#'+ actions[1] +'_' + player_id).html(s_count);
        $('.text-warning').find('th span#'+ game +'_' + actions[2] + '_' + team).html(t_count);
        $('.text-warning').find('th span#'+ game +'_' + actions[3] + '_' + team).html(t_fga);

        return f_count;

    }else if(count == 1){
        f_count = parseInt(actInt[0]);
        s_count = parseInt(actInt[1]);
        f_count += 1;
        s_count += 1;

        $('.players_status').find('td span#'+ actions[0] +'_' + player_id).html(f_count);
        $('.text-warning').find('th span#'+ game +'_' + actions[1] + '_' + team).html(s_count);
    }
}

function total_calculation(count, player_id, game, team = '', action = []){
        var points = parseInt(action[0]);
        var t_points = parseInt(action[1]);
        points += count;
        t_points += count;
        $('.players_status').find('td span#pts_' + player_id).html(points);
        $('.text-warning').find('th span#'+ game +'_pts_' + team.substr(team.length-1)).html(t_points);
        $('#score_' + team.substr(team.length-1)).html(t_points);

        dataRef2.child(game).once('value', function(data){
            if(data.val().home.team == team){
                fbaseCon.ref('Game/' + game).child('home').update({
                    score: t_points
                });
            }else if(data.val().away.team == team){
                fbaseCon.ref('Game/' + game).child('away').update({    
                    score: t_points
                });
            }
        });
}

dataRef.on('child_added', function(data){
    var team = data.val().team;

    fg2m = $('.players_status').find('td span#fg2m_' + data.val().player_id).html();
    fg2a = $('.players_status').find('td span#fg2a_' + data.val().player_id).html();
    fg3m = $('.players_status').find('td span#fg3m_' + data.val().player_id).html();
    fg3a = $('.players_status').find('td span#fg3a_' + data.val().player_id).html();
    fg23m = $('.players_status').find('td span#fg23m_' + data.val().player_id).html();
    fg23a = $('.players_status').find('td span#fg23a_' + data.val().player_id).html();
    ftm = $('.players_status').find('td span#ftm_' + data.val().player_id).html();
    fta = $('.players_status').find('td span#fta_' + data.val().player_id).html();
    oreb = $('.players_status').find('td span#oreb_' + data.val().player_id).html();
    dreb = $('.players_status').find('td span#dreb_' + data.val().player_id).html();
    treb = $('.players_status').find('td span#treb_' + data.val().player_id).html();
    ast = $('.players_status').find('td span#ast_' + data.val().player_id).html();
    stl = $('.players_status').find('td span#stl_' + data.val().player_id).html();
    blk = $('.players_status').find('td span#blk_' + data.val().player_id).html();
    to = $('.players_status').find('td span#turnover_' + data.val().player_id).html();
    pf = $('.players_status').find('td span#pf_' + data.val().player_id).html();
    pts = $('.players_status').find('td span#pts_' + data.val().player_id).html();

    t_fg2m =  $('.text-warning').find('th span#'+ data.val().game +'_2fm_' + team.substr(team.length-1)).html();
    t_fg2a =  $('.text-warning').find('th span#'+ data.val().game +'_2fa_' + team.substr(team.length-1)).html();
    t_fg3m =  $('.text-warning').find('th span#'+ data.val().game +'_3fm_' + team.substr(team.length-1)).html();
    t_fg3a =  $('.text-warning').find('th span#'+ data.val().game +'_3fa_' + team.substr(team.length-1)).html();
    t_fgm =  $('.text-warning').find('th span#'+ data.val().game +'_fgm_' + team.substr(team.length-1)).html();
    t_fga =  $('.text-warning').find('th span#'+ data.val().game +'_fga_' + team.substr(team.length-1)).html();
    t_ftm =  $('.text-warning').find('th span#'+ data.val().game +'_ftm_' + team.substr(team.length-1)).html();
    t_fta =  $('.text-warning').find('th span#'+ data.val().game +'_fta_' + team.substr(team.length-1)).html();
    t_oreb =  $('.text-warning').find('th span#'+ data.val().game +'_oreb_' + team.substr(team.length-1)).html();
    t_dreb =  $('.text-warning').find('th span#'+ data.val().game +'_dreb_' + team.substr(team.length-1)).html();
    t_reb =  $('.text-warning').find('th span#'+ data.val().game +'_reb_' + team.substr(team.length-1)).html();
    t_ast =  $('.text-warning').find('th span#'+ data.val().game +'_ast_' + team.substr(team.length-1)).html();
    t_stl =  $('.text-warning').find('th span#'+ data.val().game +'_stl_' + team.substr(team.length-1)).html();
    t_blk =  $('.text-warning').find('th span#'+ data.val().game +'_blk_' + team.substr(team.length-1)).html();
    t_to =  $('.text-warning').find('th span#'+ data.val().game +'_to_' + team.substr(team.length-1)).html();
    t_pf =  $('.text-warning').find('th span#'+ data.val().game +'_pf_' + team.substr(team.length-1)).html();
    t_pts =  $('.text-warning').find('th span#'+ data.val().game +'_pts_' + team.substr(team.length-1)).html();

    //get_player_boxscore(data, team);

    if(data.val().action == 'fg2m'){
       
        var actionsInt = [fg2m, fg2a, fg23m, fg23a, t_fg2m, t_fg2a, t_fgm, t_fga];
        var actions = ['fg2m', 'fg2a', 'fg23m', 'fg23a', '2fm', '2fa', 'fgm', 'fga'];
        var pts_act = [pts, t_pts];

        addToView(actionsInt, actions, data.val().player_id, 4, team.substr(team.length-1), data.val().game);
        total_calculation(2, data.val().player_id, data.val().game, team, pts_act);
             
        
    }else if(data.val().action == 'fg2a'){
        
        var actionsInt = [fg2a, fg23a, t_fg2a, t_fga];
        var actions = ['fg2a', 'fg23a', '2fa', 'fga'];
        addToView(actionsInt, actions, data.val().player_id, 2, team.substr(team.length-1), data.val().game);

    }else if(data.val().action == 'fg3m'){

        var actionsInt = [fg3m, fg3a, fg23m, fg23a, t_fg3m, t_fg3a, t_fgm, t_fga];
        var actions = ['fg3m', 'fg3a', 'fg23m', 'fg23a', '3fm', '3fa', 'fgm', 'fga'];
        var pts_act = [pts, t_pts];

        addToView(actionsInt, actions, data.val().player_id, 4, team.substr(team.length-1), data.val().game);
        total_calculation(3, data.val().player_id, data.val().game, team, pts_act);

    }else if(data.val().action == 'fg3a'){

        var actionsInt = [fg3a, fg23a, t_fg3a, t_fga];
        var actions = ['fg3a', 'fg23a', '3fa', 'fga'];

        addToView(actionsInt, actions, data.val().player_id, 2, team.substr(team.length-1), data.val().game);
       
    }else if(data.val().action == 'ftm'){
     
        var actionsInt = [ftm, fta, t_ftm, t_fta];
        var actions = ['ftm', 'fta', 'ftm', 'fta'];
        var pts_act = [pts, t_pts];

        addToView(actionsInt, actions, data.val().player_id, 2, team.substr(team.length-1), data.val().game);
        total_calculation(1, data.val().player_id, data.val().game, team, pts_act);

    }else if(data.val().action == 'fta'){
      
        var actionsInt = [fta, t_fta];
        var actions = ['fta', 'fta'];
        addToView(actionsInt, actions, data.val().player_id, 1, team.substr(team.length-1), data.val().game);

    }else if(data.val().action == 'oreb'){
       
        var actionsInt = [oreb, treb, t_oreb, t_reb];
        var actions = ['oreb', 'treb', 'oreb', 'reb'];
        addToView(actionsInt, actions, data.val().player_id, 2, team.substr(team.length-1), data.val().game);

    }
    else if(data.val().action == 'dreb'){
      
        var actionsInt = [dreb, treb, t_dreb, t_reb];
        var actions = ['dreb', 'treb', 'dreb', 'reb'];
        addToView(actionsInt, actions, data.val().player_id, 2, team.substr(team.length-1), data.val().game);

    }else if(data.val().action == 'ast'){
        
        var actionsInt = [ast, t_ast];
        var actions = ['ast', 'ast'];
        addToView(actionsInt, actions, data.val().player_id, 1, team.substr(team.length-1), data.val().game);

    }else if(data.val().action == 'stl'){
      
        var actionsInt = [stl, t_stl];
        var actions = ['stl', 'stl'];
        addToView(actionsInt, actions, data.val().player_id, 1, team.substr(team.length-1), data.val().game);

    }else if(data.val().action == 'blk'){
   
        var actionsInt = [blk, t_blk];
        var actions = ['blk', 'blk'];
        addToView(actionsInt, actions, data.val().player_id, 1, team.substr(team.length-1), data.val().game);

    }else if(data.val().action == 'turnover'){
       
        var actionsInt = [to, t_to];
        var actions = ['turnover', 'to'];
        addToView(actionsInt, actions, data.val().player_id, 1, team.substr(team.length-1), data.val().game);

    }else if(data.val().action == 'pf'){
      
        var actionsInt = [pf, t_pf];
        var actions = ['pf', 'pf'];
        addToView(actionsInt, actions, data.val().player_id, 1, team.substr(team.length-1), data.val().game);
    }

    setTimeout(function(){
        dataRef.child(data.key).remove();
    }, 2000);
    
    console.log(data.key);
}); 
