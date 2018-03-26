@extends('layouts.app')

@section('content')
    <style>
        th {
            vertical-align: middle !important;
        }
    </style>
    <?php
    $status = session('status');
    ?>
    <div class="col-md-12">
        <div class="jim-content">
            <div class="pull-right">
                <button class="btn btn-sm btn-warning">
                    <i class="fa fa-search"></i> Filter
                </button>
                <a href="{{ url('admin/player/create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-user-plus"></i> Add
                </a>
            </div>
            <h3 class="page-header">
                Player List</h3>
            <div class="row">
                <div class="col-md-12">
                @if($status=='deleted')
                    <div class="alert alert-success">
                        <font class="text-success">
                            <i class="fa fa-check"></i> Player successfully deleted!
                        </font>
                    </div>
                @endif
                @if(isset($data))
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="bg-success">
                                <tr>
                                    <th>NO.</th>
                                    <th>NAME</th>
                                    <th>POS</th>
                                    <th>AGE</th>
                                    <th>HT</th>
                                    <th>WT</th>
                                    <th>SECTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td class="title-info">{{ $row->jersey }}</td>
                                    <td class="title-info">
                                        <a href="{{ url('admin/player/'.$row->id) }}" rel="popover" data-img="{{ asset('public/upload/profile/'.$row->prof_pic.'?img='.date('YmdHis')) }}">
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
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        {{ $data->links() }}
                    </div>
                @else
                    <div class="alert alert-warning">
                        <font class="text-warning">
                            <i class="fa fa-warning"></i> No Player Found!
                        </font>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('a[rel=popover]').popover({
        html: true,
        trigger: 'hover',
        placement: 'bottom',
        content: function(){return '<img src="'+$(this).data('img') + '" width="100px" />';}
    });
</script>
@endsection

