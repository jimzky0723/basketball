<div class="modal fade" role="dialog" id="fbPost">
    <div class="modal-dialog modal-sm" role="document">
        <form action="{{ url('admin/home/fb') }}" method="POST">
        {{ csrf_field() }}
        <div class="modal-content">

            <div class="modal-body">
                <div class="form-group-sm">
                    <label>Enter FB Embed Code</label>
                    <textarea name="post" class="form-control" style="resize: none;" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-sm" ><i class="fa fa-trash"></i> Post</button>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="awardPost">
    <div class="modal-dialog modal-sm" role="document">
        <form action="{{ url('admin/home/award') }}" method="POST">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group-sm">
                        <label>Select Awardee</label>
                        <select name="awardee" class="form-control" required>
                            <option value="week">Player of the Week</option>
                            <option value="month">Player of the Month</option>
                            <option value="overall">Overall Top Player</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-sm" ><i class="fa fa-trash"></i> Post</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->