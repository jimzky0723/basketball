<div class="modal fade" role="dialog" id="playerListModal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('admin/games/random') }}" id="randomPlayers">
                {{ csrf_field() }}
                <input type="hidden" name="home_team" value="{{ $data->home_team }}" />
                <input type="hidden" name="away_team" value="{{ $data->away_team }}" />
                <input type="hidden" name="game_id" value="{{ $data->id }}" />
                <input type="hidden" name="side" value="left" />
                <div class="modal-header">
                    <h4>Select Players : <span class="text-success count_players">0</span> </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="home_search" onkeyup="filterName()" class="form-control" placeholder="Search Name..." />
                    <hr />
                    <div style="max-height: 400px;overflow-y: scroll">

                        <ul class="list-group" id="home_div">
                            @foreach($list as $row)
                                <li class="list-group-item clearfix">
                                    <label class="">
                                        <input type="checkbox" class="count_players" value="{{ $row->id }}" name="players[]"> <span class="title-info">{{ $row->lname }}, {{ $row->fname }}</span>,
                                        <span class="text-primary">{{ $row->position }} </span> | {{ $row->jersey }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-users"></i> Shuffle</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="playerListA">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('admin/games/assign') }}">
                {{ csrf_field() }}
                <input type="hidden" name="team" value="{{ $data->home_team }}" />
                <input type="hidden" name="game_id" value="{{ $data->id }}" />
                <input type="hidden" name="side" value="left" />
                <div class="modal-header">
                    <h4>{{ $data->home_team }}</h4>
                </div>
                <div class="modal-body">
                    <div style="max-height: 600px;overflow-y: scroll">
                        <input type="text" id="home_search" onkeyup="filterName()" class="form-control" placeholder="Search Name..." />
                        <hr />
                        <ul class="list-group" id="home_div">
                            @foreach($list as $row)
                            <li class="list-group-item clearfix">
                                <label class="">
                                    <input type="checkbox" value="{{ $row->id }}" name="players[]"> <span class="title-info">{{ $row->lname }}, {{ $row->fname }}</span>,
                                    <span class="text-primary">{{ $row->position }} </span> | {{ $row->jersey }}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-user-plus"></i> Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="playerListB">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('admin/games/assign') }}">
                {{ csrf_field() }}
                <input type="hidden" name="team" value="{{ $data->away_team }}" />
                <input type="hidden" name="game_id" value="{{ $data->id }}" />
                <input type="hidden" name="right" value="left" />
                <div class="modal-header">
                    <h4>{{ $data->away_team }}</h4>
                </div>
                <div class="modal-body">
                    <div style="max-height: 600px;overflow-y: scroll">
                        <input type="text" id="away_search" onkeyup="filterNameAway()" class="form-control" placeholder="Search Name..." />
                        <hr />
                        <ul class="list-group" id="away_div">
                            @foreach($list as $row)
                                <li class="list-group-item clearfix">
                                    <label>
                                        <input type="checkbox" value="{{ $row->id }}" name="players[]"> <span class="title-info">{{ $row->lname }}, {{ $row->fname }}</span>,
                                        <span class="text-primary">{{ $row->position }} </span> | {{ $row->jersey }}
                                    </label>
                                </li>

                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-user-plus"></i> Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

