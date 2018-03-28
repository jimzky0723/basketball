<div class="modal fade" role="dialog" id="addGame">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('admin/games/store') }}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4>Add Game</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Home Team</label>
                        <input type="text" class="form-control" name="home_team" />
                    </div>
                    <div class="form-group">
                        <label>Away Team</label>
                        <input type="text" class="form-control" name="away_team" />
                    </div>
                    <div class="form-group">
                        <label>Scheduled Match</label>
                        <input type="date" class="form-control" name="date_match" value="{{ date('Y-m-d') }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

