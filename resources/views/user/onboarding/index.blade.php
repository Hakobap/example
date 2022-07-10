@extends('layouts.app_dashboard')

@section('top-menu-right')
    <div class="page-main-title">
        <h3>REPORTS</h3>
    </div>
@endsection

@section('content')
    <div>
        <form id="onboarding-form" method="get" action="{{ route('user.onboarding') }}" class="report-line">
            <input type='text' name="week_date" value="{{ $weekDate = request()->get('week_date', \Carbon\Carbon::now()->format('m/d/Y')) }}" class="form-control" id='datetimepicker2' />
            <div class="form-group div-decoration select2">
                <section>
                    <select name="employee_id" id="potencial1" class="view-select custom-select sources name-select" placeholder="Employee Name">
                        <option {{ request('employee_id') == 0 ? 'selected' : '' }} value="0">All Employees</option>
                        @foreach($employees as $employee)
                            <option {{ request('employee_id') == $employee->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->first_name . ' ' . $employee->last_name }}</option>
                        @endforeach
                    </select>
                </section>
            </div>
            <div class="pull-right btn-group">
                <a href="{{ route('user.onboarding.export-reports', [
                'employee_id' => intval(request('employee_id')),
                 'week_date' => $weekDate
                ]) }}" class="btn btn-info">GENERATE CSV</a>
                <a onclick="$(this).closest('form').submit();" href="#" class="btn btn-primary">Update</a>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table reports-table">
                <thead>
                    <tr>
                        <td><b>Employee</b></td>
                        <td><b>Wage Cost</b></td>
                        <td><b>Time Tracking</b></td>
                        <td><b>Staff Availability</b></td>
                        <td><b>On Shift</b></td>
                        <td><b>Job Tasks Assigned</b></td>
                        <td><b>Job Tasks Completed</b></td>
                        <td><b>Leave</b></td>
                        <td><b>Onboarding Data</b></td>
                    </tr>
                </thead>
                <tbody>
                @if($employees->count())
                    @foreach($employees as $employee)
                        <tr>
                            <td style="min-width: 250px;">
                                <div class="flex-element" style="width: 100%;">
                                    <span style="margin-right: 10px;" class="circle ros-im">
                                        @if ($employee->photo)
                                            <img width="50px" src="{{ asset('/images/user/' . $employee->photo) }}">
                                        @else
                                            <i class="fa fa-user"></i>
                                        @endif
                                        </span>
                                    <div class="employee-details">
                                        <p>{{ $employee->first_name . ' ' . $employee->last_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>-----</td>
                            <td>-----</td>
                            <td>{{ $employee->getStaffAvailability()->count() }}</td>
                            <td>{{ count($employee->employeeOnShiftSites()) }}</td>
                            <td>{{ $employee->toDoList()->count() }}</td>
                            <td>{{ $employee->toDoListCompleted()->count() }}</td>
                            <td>?????</td>
                            <td>?????</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2"><h1 class="text-center">No Data Found</h1></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('js')

@endsection