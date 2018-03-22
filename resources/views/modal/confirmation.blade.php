<div class="modal fade" role="dialog" id="deleteModal">
    <div class="modal-dialog modal-sm" role="document">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-body">
                    @yield('modal')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    <button type="submit" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i> Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->