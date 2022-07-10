<div class="thead">{{ $title }}</div>
@if($availableOfStaff->count())
    <div class="employee-container" style="padding-top: 0;">
        @foreach($availableOfStaff as $employee)
            <div class="employee-details1">
                 <span style="margin-right: 10px;" class="circle ros-im">
                      @if ($employee->photo)
                         <img width="50px" src="{{ asset('/images/user/' . $employee->photo) }}">
                     @else
                         <i class="fa fa-user"></i>
                     @endif
                </span>
                <div>
                    <p>{{ $employee->first_name . ' ' . $employee->last_name }}</p>
                    <p style="font-size: 10px;">
                        @if ($count = $employee->tasksFromRequest->count())
                            On Shift Sites: {{ implode(', ', $employee->employeesSites()) ?: 'no site' }}
{{--                            On Shift Sites: {{ implode(', ', $employee->employeeOnShiftSites()) ?: 'no site' }}--}}
                        @else
                            Sites: {{ implode(', ', $employee->employeesSites()) ?: 'no site' }}
                        @endif
                    </p>
                </div>
            </div>
            @if ($count)
                <div class="e-decoration e-decoration-green">
                    <span></span>
                    <p>On Shift ({{$count}})</p>
                </div>
            @else
                <div class="e-decoration">
                    <span></span>
                    <p>On Shift ({{0}})</p>
                </div>
            @endif
        @endforeach
    </div>
@else
    <h1 class="text-center">No Data Found</h1>
@endif