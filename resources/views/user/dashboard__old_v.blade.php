@extends('layouts.app_dashboard')

@section('content')
    <div class="container" id="main-page">
        <div class="row">
            <div class="col-lg-6 left-inner-box">
                <div class="thead">ROSTERING</div>
                <table class="table table-default">
                    <tbody>
                    @if($tasks->count())
                        <?php $n = 0; ?>
                        @foreach($tasks as $task)
                            <tr class="{{ $n % 2 == 1 ? 'purple' : '' }}">
                                <td>
                                    <div style="display: flex;align-items: center;min-width: 200px;" class="txt3">
                                        <span class="circle ros-im">
                                            @if ($task->employee->photo)
                                                <img width="50px" src="{{ asset('/images/user/' . $task->employee->photo) }}">
                                            @else
                                                <i class="fa fa-user"></i>
                                            @endif
                                        </span>
                                        <span style="margin-left: 10px;">
                                              {{ $task->employee->first_name . ' ' . $task->employee->last_name }}
                                        </span>
                                    </div>
                                </td>
                                <td scope="col">
                                    <p class="txt1">Start Date</p>
                                    <p class="txt2">{{ \Illuminate\Support\Carbon::parse($task->start_date)->format('m/d/y') }}</p>
                                </td>
                                <td scope="col">
                                    <p class="txt1">Total Time </p>
                                    <p class="txt2">{{ \Carbon\Carbon::parse($task->start_date)->format('g:i A') }} - {{ \Carbon\Carbon::parse($task->end_date)->format('g:i A') }}</p>
                                </td>
                                <td scope="col">
                                    <img title="{{ $task->description }}" src="{{asset('/site/images/information.png')}}" alt="logo">
                                    <a href="{{ route('user.task-management.delete', $task->id) }}" onclick="return confirm('Are You Sure?');"><img src="{{asset('/site/images/close.png')}}" alt="logo"></a>
                                </td>
                            </tr>
                            <?php $n++; ?>
                        @endforeach
                    @else
                        <h1 class="text-center">No Data Found</h1>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 left-inner-box">
                <div class="thead">Time tracking</div>
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
            <div class="col-lg-6 left-inner-box">
                <div class="thead">STAFF AVAILABILITY</div>
                <?php $n = 0; ?>
                @if($employees->count())
                    <table class="table table-default">
                        <tbody>
                        @foreach($employees as $employee)
                            <tr class="_list-item {{ $n % 2 == 0 ? 'default' : 'purple' }}">
                                <td>
                                    <div style="display: flex;align-items: center;min-width: 200px;" class="txt3">
                                       <span class="circle ros-im">
                                        @if ($employee->photo)
                                               <img width="50px" src="{{ asset('/images/user/' . $employee->photo) }}">
                                           @else
                                               <i class="fa fa-user"></i>
                                           @endif
                                        </span>
                                        <span style="margin-left: 10px;">
                                              {{ $employee->first_name . ' ' . $employee->last_name }}
                                        </span>
                                    </div>
                                </td>
                                <td scope="col">
                                    @if($employee->positionsGrouped->count())
                                        @foreach($employee->positionsGrouped as $position)
                                            <p class="txt1">{{ $position->position->value }}</p>
                                        @endforeach
                                    @endif
                                </td>
                                <td scope="col">
                                    <a onclick="return confirm('Are You Sure?');" href="{{ route('user.rostering.delete', $employee->id) }}">
                                        <img src="{{ asset('/site/images/close.png') }}" alt="logo">
                                    </a>
                                </td>
                            </tr>
                            <?php $n++; ?>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($n == 0)
                    <h1 class="text-center">No Data Found</h1>
                @endif
            </div>

            <div class="col-lg-6 left-inner-box">
                <div class="thead">Roster</div>
                @if($employees->count())
                    <table class="table table-default">
                        <tbody>
                        <?php $n=0; ?>
                        @foreach($employees as $employee)
                            <tr class="{{ $n % 2 == 1 ? 'purple' : '' }}">
                                <td>
                                    <div style="display: flex;align-items: center;min-width: 200px;" class="txt3">
                                        <span class="circle ros-im">
                                          @if ($employee->photo)
                                                <img width="50px" src="{{ asset('/images/user/' . $employee->photo) }}">
                                            @else
                                                <i class="fa fa-user"></i>
                                            @endif
                                        </span>
                                        <span style="margin-left: 10px;">
                                              {{ $employee->first_name . ' ' . $employee->last_name }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <p class="txt1">
                                        {{ $employee->tasksCalculated()->hours }} Hrs / ${{ $employee->tasksCalculated()->price }}
                                    </p>
                                </td>
                                <td scope="col">
{{--                                    <a href="{{ route('user.task-management.delete', $task->id) }}" onclick="return confirm('Are You Sure?');"><img src="{{asset('/site/images/close.png')}}" alt="logo"></a>--}}
                                </td>
                            </tr>
                            <?php $n++; ?>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h1>No Data Found</h1>
                @endif
            </div>
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