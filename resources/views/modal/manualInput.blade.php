<style>
    .table-stats tr td:first-child {
        background: #f5f5f5;
        text-align: right;
        vertical-align: middle;
        font-weight: bold;
        padding: 3px;
        width:30%;
    }
    .table-stats tr td {
        border:1px solid #bbb !important;
    }
</style>
<div class="modal fade" role="dialog" id="manualInput">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('admin/games/boxscore/manual') }}">
                {{ csrf_field() }}
                <input type="hidden" id="game_id" name="game_id" />
                <input type="hidden" id="player_id" name="player_id" />
                <input type="hidden" id="team" name="team_name" />
                <div class="modal-header">
                    <h4>Add Stats Manually</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-stats table-hover">
                        <tr>
                            <td width="40%">&nbsp;</td>
                            <td width="30%">Made</td>
                            <td width="30%">Attempt</td>
                        </tr>
                        <tr>
                            <td>2PT</td>
                            <td>
                                <input type="text" class="form-control" id="f2m" name="f2m" />
                            </td>
                            <td>
                                <input type="text" class="form-control" id="f2a" name="f2a" />
                            </td>
                        </tr>
                        <tr>
                            <td>3PT</td>
                            <td>
                                <input type="text" class="form-control" id="f3m" name="f3m" />
                            </td>
                            <td>
                                <input type="text" class="form-control" id="f3a" name="f3a" />
                            </td>
                        </tr>
                        <tr>
                            <td>FT</td>
                            <td>
                                <input type="text" class="form-control" id="ftm" name="ftm" />
                            </td>
                            <td>
                                <input type="text" class="form-control" id="fta" name="fta" />
                            </td>
                        </tr>
                        <tr>
                            <td>OREB</td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="oreb" name="oreb" />
                            </td>
                        </tr>
                        <tr>
                            <td>DREB</td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="dreb" name="dreb" />
                            </td>
                        </tr>
                        <tr>
                            <td>AST</td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="ast" name="ast" />
                            </td>
                        </tr>
                        <tr>
                            <td>STL</td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="stl" name="stl" />
                            </td>
                        </tr>
                        <tr>
                            <td>BLK</td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="blk" name="blk" />
                            </td>
                        </tr>
                        <tr>
                            <td>TO</td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="turnover" name="turnover" />
                            </td>
                        </tr>
                        <tr>
                            <td>PF</td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="pf" name="pf" />
                            </td>
                        </tr>
                        <tr>
                            <td>PTS</td>
                            <td>
                                <input type="text" readonly class="form-control" id="pts" name="pts" />
                            </td>
                            <td>
                                <button onclick="calculate()" type="button" class="btn btn-defualt btn-flat btn-block">
                                    <i class="fa fa-calculator"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" onclick="calculate_manual()"; class="btn btn-sm btn-success btn-flat"><i class="fa fa-arrows-alt"></i> Update</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

