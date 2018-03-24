@extends('layouts.app')
@section('content')
    <style>
        .score {
            font-weight:bold;
            font-size: 1.5em;
        }
        .winner {
            color: #2786bf;
        }
        .news-title {
            font-size:1.2em;
        }
        .news h4 {
            margin:0px !important;
            margin-bottom: 5px !important;
        }
        .news p {
            color: #888;
        }
    </style>
    <div class="news">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="text-center news-title">
                        Team A <span class="score winner">42</span> <i class="fa fa-angle-left"></i> Final
                        <span class="text-muted"> <span class="score">30</span> Team B</span>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-sm-4">
                        <img src="{{ url('public/upload/news/1.jpg') }}" class="img-responsive" />
                    </div>
                    <h4>Pangcatan Night: "Team C" Cetner posts rare 20-20</h4>
                    <p>
                        With a 22-point, 20-rebound night, Team C's Asnaui Pangcatan became the first player in DOH Basketball Club to have a 20-20 night.
                    </p>
                </div>
            </div>

            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="news-title">
                        Cabellos's 10 things: Cabiluna's brilliance, Team A's big find and the best fast breaks
                    </div>
                    <p>
                        This week's highlights include a high-IQ Celtic, bad names and NBA mimes.
                    </p>
                </div>
                <div class="box-body">
                    <img src="{{ url('public/upload/news/2.jpg') }}" class="img-responsive" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        @include('sidebar.player')
    </div>
@endsection

@section('js')

@endsection

