@extends('layouts.app_dashboard')

@section('top-menu-right')
    <div class="page-main-title">
        <h3>PEOPLE</h3>
    </div>
@endsection

@section('content')
    <div id="staff" style="display: {{ $errors->count() ? 'none' : 'block' }};">
        <div class="wrapper task-container dashboard">
            <div class="employee-container" style="padding-top: 0;">
                <form method="post" action="{{ route('user.employee.bulk') }}">
                    @csrf

                    <div class="report-line">
                        <div class="align-left">
                            <div class="summery-search">
                                <input type="text" class="form-control" placeholder="Search People">
                            </div>
                            <select class="summery-s filter-employee" placeholder="Filter">
                                <option value="">Filter</option>
                                <option value="">All</option>
                                <option value="invited">Invited</option>
                                <option value="no invitation sent">No invitation sent</option>
                            </select>
                            {{--<select class="summery-s" placeholder="Also Show">--}}
                            {{--<option value="option">Also Show</option>--}}
                            {{--<option value="option">Edit</option>--}}
                            {{--<option value="option">Discard</option>--}}
                            {{--<option value="option">Invite</option>--}}
                            {{--</select>--}}
                            <select name="action" class="summery-s bulk-action" disabled title="Select some people using the checkboxes on the left to bulk action" placeholder="Bulk Action">
                                <option>Bulk Action</option>
                                <option value="discard">Discard</option>
                                <option value="invite">Invite</option>
                            </select>
                        </div>
                        <div class="align-right">
                            <div class="btn-panel"><a style="min-width: 155px;" href="#" data-id="0" class="btn-blue __edit_employee">Add Employee</a></div>
                        </div>
                    </div>
                    <div class="table-responsive" >
                        <table class="table">
                            <tr>
                                <th><p class="text-center"><b>Name</b></p></th>
                                <th><p class="text-center"><b>Status</b></p></th>
                                <th><p class="text-center"><b>Address</b></p></th>
                                <th><p class="text-center"><b>Type</b></p></th>
                                <th><p class="text-center"><b>Email</b></p></th>
                                <th><p class="text-center"><b>Phone</b></p></th>
                            </tr>

                            <tbody class="mt30">
                            <tr>
                                <td scope="row">
                                    <div class="check-task">
                                        <div class="checkbox">
                                            <label for="checkbox">
                                                {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: #ff339d;">invited</span>
                                </td>
                                <td><p class="date-details1 text-center">{!! htmlspecialchars(auth()->user()->address) ?: '<span style="color: red;">Not Set</span>' !!}</p></td>
                                <td>
                                    <p>
                                        System Administrator
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ auth()->user()->email }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ auth()->user()->phone }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <a class="__edit_employee btn btn-primary btn-sm col-lg-12" data-id="{{ auth()->id() }}" href="javascript:;"> <i class="fa fa-edit"></i> </a>
                                    </p>
                                </td>
                            </tr>

                            @if($employees->count())
                                @foreach($employees as $key => $employee)
                                    <tr>
                                        <td scope="row">
                                            <div class="check-task">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="employees[]" value="{{ $employee->id }}" id="checkbox-{{ $key }}" class="checkbox__input">
                                                    <label for="checkbox-{{ $key }}" class="checkbox__label">{{ $employee->first_name . ' ' . $employee->last_name }}</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($employee->invited)
                                                <span style="color: #ff339d;">invited</span>
                                            @else
                                                <span style="color: #ff968a;">no invitation sent</span>
                                            @endif
                                        </td>
                                        <td><p class="date-details1 text-center">{!! htmlspecialchars($employee->address) ?: '<span style="color: red;">Not Set</span>' !!}</p></td>
                                        <td>
                                            <p>
                                                Employee
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $employee->email }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $employee->phone }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                <a class="__edit_employee btn btn-primary btn-sm col-lg-12" data-id="{{ $employee->id }}" href="javascript:;"> <i class="fa fa-edit"></i> </a>
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="__employee_actions">
        @include('user.__user-add-box')
    </div>
@endsection

@section('css')
   <link rel="stylesheet" href="{{ asset('/site/css/staff.css') }}" />
@endsection

@section('js')

@endsection