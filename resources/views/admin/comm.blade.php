@extends('layouts.app')
@section('content')
    <div class="col-md-3">
        @include('sidebar.quick')
    </div>
    <div class="col-md-6">
        <div class="jim-content">
            <h3 class="page-header">
                {{ $title }}</h3>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ url('admin/committee') }}" method="POST">
                        {{ csrf_field() }}
                    <div class="form-group-sm">
                        <input type="date" required value="{{ date('Y-m-d') }}" name="schedule" class="fom-control" />
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fa fa-users"></i> Generate Committee
                        </button>
                    </div>
                    </form>
                    <hr />
                    @if(count($data))
                        @foreach($data as $row)
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="{{ url('pictures/profile/'.$row->prof_pic) }}" class="img-responsive" />
                                    <div class="text-aqua text-center">
                                        {{ $row->fname }} {{ $row->lname }}<br />
                                        <small class="text-muted">{{ $row->section }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">
                            <span class="text-warning">
                                <i class="fa fa-warning"></i> No Committee Found!
                            </span>
                        </div>
                    @endif
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

