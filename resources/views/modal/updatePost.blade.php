<div class="modal fade" role="dialog" id="updatePost">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ url('admin/home/update/post') }}">
        <input type="hidden" id="postUpdateID" name="postUpdateID" value="" />
        {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-body">
                <label>UPDATE POST</label>
                <textarea style="resize: none" rows="4" class="form-control" name="contents" id="contents"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                <button type="submit" class="btn btn-success btn-sm" ><i class="fa fa-check"></i> Yes</button>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->