@extends('layouts.guest')
@section('content')
    <div class="news">
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="pull-right">
                        <form action="{{ url('players') }}" method="POST" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group-sm" style="margin-bottom: 10px;">
                                <label>Filter By : </label>
                                <select name="filter" class="form-control">
                                    <option value="">All</option>
                                    <option {{ ($filter=='PG') ? 'selected':'' }} value="PG">Point Guard</option>
                                    <option {{ ($filter=='SG') ? 'selected':'' }} value="SG">Shooting Guard</option>
                                    <option {{ ($filter=='SF') ? 'selected':'' }} value="SF">Small Forward</option>
                                    <option {{ ($filter=='PF') ? 'selected':'' }} value="PF">Power Forward</option>
                                    <option {{ ($filter=='C') ? 'selected':'' }} value="C">Center</option>
                                </select>
                                <button type="submit" class="btn btn-success btn-sm btn-flat">
                                    <i class="fa fa-sort"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                    <h3>Players</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr class="bg-black">
                                <th>NO.</th>
                                <th>NAME</th>
                                <th>POS</th>
                                <th>AGE</th>
                                <th>HT</th>
                                <th>WT</th>
                                <th>SECTION</th>
                            </tr>
                            @foreach($data as $row)
                                <tr>
                                    <td class="title-info">{{ $row->jersey }}</td>
                                    <td class="title-info">
                                        <a target="_blank" href="{{ url('player/'.$row->id) }}" rel="popover" data-img="{{ asset('public/upload/profile/'.$row->prof_pic.'?img='.date('YmdHis')) }}">
                                            {{ $row->lname }}, {{ $row->fname }} {{ $row->mname }}
                                        </a>
                                    </td>
                                    <td>{{ $row->position }}</td>
                                    <td>{{ \App\Http\Controllers\ParamCtrl::getAge($row->dob) }}</td>
                                    <td>{{ $row->height }}</td>
                                    <td>{{ $row->weight }}</td>
                                    <td>{{ $row->section }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="text-center">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        @include('sidebar.player')
    </div>
@endsection

@section('js')

@endsection

