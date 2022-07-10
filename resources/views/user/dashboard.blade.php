@extends('layouts.app_dashboard')

@section('top-menu-right')
    <div class="page-main-title">
        <h3>DASHBOARD</h3>
    </div>
@endsection


@section('top-menu')
    <div class="dashboard-site-filter">
        <select name="site_id" class="form-control">
            <option value="">Filter by site</option>
            @if ($sites->count())
                @foreach($sites as $site)
                    <option {{ request('site_id') == $site->id ? 'selected' : '' }} value="{{ $site->id }}">{{ $site->value }}</option>
                @endforeach
            @endif
        </select>
    </div>
@endsection

@section('content')
    <div class="container" id="main-page">
        <div class="row">
            <div class="col-lg-6 left-inner-box">
                @include('user.info-boxes.rostering', ['title' => 'ROSTERING'])
            </div>

            {{--<div class="col-lg-6 left-inner-box">--}}
                {{--<div class="thead">Time tracking</div>--}}
                {{--<div id="chartContainer" style="height: 370px; width: 100%;"></div>--}}
            {{--</div>--}}

            <div class="col-lg-6 left-inner-box">
                @include('user.info-boxes.staff-availability', ['title' => 'STAFF AVAILABILITY'])
            </div>

            {{--<div class="col-lg-6 left-inner-box">--}}
                {{--@include('user.info-boxes.roster', ['title' => 'Unbelievable Staff'])--}}
            {{--</div>--}}
        </div>
    </div>
@endsection

@section('js')
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "Chart"
                },
                axisX:{
                    includeZero: false,
                   // interval: 1,
                },
                axisY:{
                    includeZero: false,
                  //  interval: 1,
                },
                data: [{
                    type: "line",
                    indexLabelFontSize: 16,
                    dataPoints: {!! json_encode($diagram) !!}
                }]
            });
            chart.render();
        }
    </script>
@endsection