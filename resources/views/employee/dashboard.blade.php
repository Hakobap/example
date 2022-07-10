@extends('layouts.employee_dashboard')

@section('top-menu')
    <div class="top-menu-item2">
        <form method="get" onchange="$(this).submit();">
            <select name="site" class="form-control">
                <option disabled selected value="0">Filter by site: {{$sites[$site_id] ?? ''}}</option>
                @if ($sites->count())
                    @foreach($sites as $id => $site)
                        <option {{ request('site') == $id ? 'selected' : '' }} value="{{ $id }}">{{ $site }}</option>
                    @endforeach
                @endif
            </select>
        </form>
    </div>
@endsection

@section('content')
    <div class="user-board container">
        <div class="user-board-details">
            @if($employee->photo)
                <img src="{{ asset('/images/user/' . $employee->photo) }}" alt="user">
            @else
                <img src="{{ asset('/site/images/user.jpg') }}" alt="user">
            @endif

            <h3>{{ $employee->first_name . ' ' . $employee->last_name }}</h3>
            <p>
                <button type="button" class="shift-btn">Start Shift</button>
        </div>
        <div class="table-responsive container p0" id="home-table-main">
            <div class="thead">
                Dashboard
            </div>
            <div class="container user-dashboard-line">
                <div class="row">
                    <div class="col-4">
                        <p>Sites</p>
                        @if(!empty($sites))
                            @foreach($sites as $site)
                                <input type="text" class="form-control" readonly placeholder="{{ $site }}">
                            @endforeach
                        @endif
                    </div>

                    <div class="col-4 bordererd">
                        <p>Positions</p>
                        @if(!empty($positions))
                            @foreach($positions as $position)
                                <input type="text" class="form-control" readonly placeholder="{{ $position }}">
                            @endforeach
                        @endif
                    </div>
                    <div class="col-4">
                        <p>Report
                        <div class="report-details-line date-line">
                            <span>Mon</span>
                            <span>Tue</span>
                            <span>Wed</span>
                            <span>Thu</span>
                            <span>Fri</span>
                            <span>Sat</span>
                            <span>San</span>
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="7:23H">
                        </div>
                        <div class="report-details-line">
                            <label>Day Summary:</label>
                            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="7:23H">
                            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="$45">
                        </div>
                        <div class="report-details-line">
                            <label>Week Summary:</label>
                            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="7:23H">
                            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="$45">
                        </div>
                    </div>
                </div>
            </div>
            <div class="thead">
                Calendar
            </div>
            <div class="user-dashboard-panel">
                <input type="text" class="form-control" readonly aria-describedby="emailHelp" placeholder="{{$sites[$site_id] ?? ''}}">
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="No upcoming shifts">
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Available Shifts">
            </div>
            @include('employee.task-management.schedule-table')
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.reject-item, .bells-item').click(function () {
            location.href = $(this).data('href');
        });
    </script>
@endsection

@section('css')
    <style>
        i {
            cursor: pointer;
        }
        .inner-decoration .reject-item, .inner-decoration .delete-item, .inner-decoration .bells-item {
            position: absolute;
            right: -10px;
            top: -20px;
            float: right;
            margin-top: 6px;
            font-size: 23px;
            color: #cc4141;
            z-index: 5;
        }
        .inner-decoration .reject-item, .inner-decoration .bells-item {
            right: 125px;
            top: -20px;
            color: #5078e0;
        }
        .inner-decoration {
            padding: 22px 10px;
            height: 104px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .wrapper {
            overflow-x: hidden;
        }
    </style>
@endsection