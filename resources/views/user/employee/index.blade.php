@extends('layouts.app_dashboard')

@section('content')
    <div class="container employee-container">
        <div class="row">
            <div class="col-lg-8 ">
                <div class="e-heading">
                    <h2 class="report-title">Employee Onboarding</h2>
                    <button type="button" class="add-employee" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</button>
                </div>
                <div class="employee-left">
                    @if($employeesGlobal && $employeesGlobal->count())
                        <input class="employee-search" type="text" placeholder="Search"/>
                        <table>
                            @foreach($employeesGlobal as $employee)
                                <tr>
                                    <td>
                                        <div class="employee-detail-box">
                                            <p class="user"> {{$employee->first_name . ' ' . $employee->last_name}}</p>
                                            <?php $n = 0; ?>
                                            @foreach($employee->positions as $position)
                                                <?php $n++; ?>
                                                <p>Position {{$n}}: {{$position->value}}</p>
                                            @endforeach
                                            <?php $n = 0; ?>
                                            @foreach($employee->sites as $site)
                                                <?php $n++; ?>
                                                <p>Site {{$n}}: {{$site->value}}</p>
                                            @endforeach
                                            <p>Invited</p>
                                        </div>
                                    </td>
                                    <td class="view-details">
                                        <span class="employee-view-btn"> View</span>
                                        <section class="select-decoration">
                                            <select data-id="{{ $employee->id }}" class="custom-select sources employee-actions" placeholder="Options">
                                                <option value="revert">Action</option>
                                                <option value="edit">Edit</option>
                                                <option value="discard">Discard</option>
{{--                                                <option value="option">Invite</option>--}}
                                            </select>
                                        </section>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <h2 class="text-center">No Data Found</h2>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 p0">
                <h2 class="report-title"> Availability</h2>
{{--                <h2 class="report-title"> Employee availability</h2>--}}
                <div class="e-right-banner">
                    @if($employeesGlobal && $employeesGlobal->count())
                        {{--                    <h2 class="e-c-name">Company Name</h2>--}}
                        @foreach($employeesGlobal as $employee)
                            @if($employee->tasksFromRequest && $count = $employee->tasksFromRequest->count())
                                <?php $n = 0; $k = 0; ?>
                                @foreach($employee->tasksFromRequest as $task)
                                    @if(\Carbon\Carbon::parse($task->start_date)->timestamp - \Carbon\Carbon::now()->timestamp >= 0)
                                        <div class="e-decoration">
                                            <span></span>
                                            <p>Late</p>
                                        </div>
                                        <div class="employee-details1">
                                            <div class="grey-deco"></div>
                                            <div>
                                                <p>{{ $employee->first_name . ' ' . $employee->last_name }}</p>
                                                <p style="font-size: 10px;">{{ $task->start_date . ' - ' . $task->end_date }}</p>
                                            </div>
                                        </div>
                                        <?php $k++; ?>
                                    @elseif(\Carbon\Carbon::parse($task->end_date)->timestamp - \Carbon\Carbon::now()->timestamp >= 0)
                                        @if($n == 0)
                                        <div class="e-decoration e-decoration-green">
                                            <span></span>
                                            <p>On Shift ({{$count}})</p>
                                        </div>
                                        @endif
                                        <div class="employee-details1">
                                            <div class="grey-deco"></div>
                                            <div>
                                                <p>{{ $employee->first_name . ' - ' . $employee->last_name }}</p>
                                                <p style="font-size: 10px;">{{ $task->start_date . ' - ' . $task->end_date }}</p>
                                            </div>
                                        </div>
                                        <?php $n++; ?>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif

                    @if(!isset($n, $k) || (!$n && !$k))
                        <br>
                        <h5 style="text-align: center;">No Data Found</h5>
                        <br>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="addEmployeeModal" style="min-height: 550px;" class="modal fade employee-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <!--                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                    <h4 class="modal-title">Add Employee</h4>
                </div>
                <div class="modal-body">
                    <form id="add-employee" action="{{ route('user.employee.store') }}">
                        <div class="form-group">
                            <input placeholder="First Name" name="first_name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <input placeholder="Last Name" name="last_name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <input placeholder="Phone Number" name="phone" type="text" id="phone" class="form-control">
                        </div>

                        <div class="form-group">
                            <select name="site_id" class="form-control" style="position: static;margin-bottom: 15px;">
                                <option value="0">Site They Can Work</option>
                                @if($sitesForEmployees && $sitesForEmployees->count())
                                    @foreach($sitesForEmployees as $site)
                                        <option value="{{ $site->id }}">{{ $site->value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="position_id" class="form-control" style="position: static;margin-bottom: 15px;">
                                <option value="0">Position They Can Work</option>
                                @if($positions && $positions->count())
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <input placeholder="E-Mail" name="email" type="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <input placeholder="Password" name="password" type="password" class="form-control">
                        </div>

                        <div class="form-group select-date">
                            <div class="slider-decoration">
                                <select name="roster_start_time" class="form-control" id="roster_start_time">
                                    <option value="1">MONDAY (standard)</option>
                                    <option value="2">TUESDAY</option>
                                    <option value="3">WEDNESDAY</option>
                                    <option value="4">THURSDAY</option>
                                    <option value="5">FRIDAY</option>
                                    <option value="6">SATURDAY</option>
                                    <option value="7">SUNDAY</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;justify-content: space-between;align-items: center;">
                            <button class="cancle-action-btn" data-dismiss="modal" style="max-width: 48%;">CANCEL </button>
                            <button type="submit" class="btn btn-default blue-btn" style="max-width: 48%;">Add</button>
                        </div>
                    </form>
                </div>
                <!--            <div class="modal-footer">-->
                <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <!--            </div>-->
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

@section('css')

@endsection