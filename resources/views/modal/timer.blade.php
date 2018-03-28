<div class="modal fade" role="dialog" id="shootClockModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-danger">
                    Shoot Clock Violation!
                </div>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="endModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-success">
                    End of the Game!
                </div>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="setTimeModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <label>SET TIME</label>
                <table class="table">
                    <tr>
                        <td><input type="number" min="0" id="minuteTime" class="form-control" placeholder="minutes" value="20" /></td>
                        <td><input type="number" min="0" id="secondsTime" class="form-control" placeholder="seconds" value="0" /></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                <button type="submit" class="btn btn-success btn-sm btn-set" data-dismiss="modal"><i class="fa fa-clock-o"></i> Set</button>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->