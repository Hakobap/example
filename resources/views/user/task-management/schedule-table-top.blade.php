<div data-action="{{ route('user.task-management.schedule', [
    'id' => $site_id,
     'site' => $site_id,
     'employee' => $employee_id,
     'week_date' => request('week_date'),
     'view' => $calendar_schedule]
    ) }}" class="report-line">
    <form method="get" class="align-left">
        <div class="dropdown">
            <button type="button" class=" dropdown-toggle" data-toggle="dropdown">
                View:Employee | <span class="selected-d-inter" data-schedule="{{ $calendar_schedule }}">
                        {{ \App\Services\Calendar::getFilterIntervalName($calendar_schedule) }}
                    </span>
            </button>
            <div class="dropdown-menu selected-inter">
                <a class="dropdown-item" data-schedule="6" href="#">Week</a>
                <a class="dropdown-item" data-schedule="13" href="#">2 Week</a>
                <a class="dropdown-item" data-schedule="27" href="#">4 Week</a>
                <a class="dropdown-item" data-schedule="{{ $calendar->getDaysInMonth() - 1 }}" href="#">Month</a>
            </div>
        </div>

        <div class="dropdown __form" data-ref="#f-site">
            <button type="button" class=" dropdown-toggle" data-toggle="dropdown">
                Filter:Sites |
                <span class="selected-d-inter">{{ $siteSelected->value }}</span>
            </button>
            <div class="dropdown-menu selected-inter">
                @if (auth()->user()->sites->count())
                    @foreach(auth()->user()->sites as $site)
                        <a class="dropdown-item" data-value="{{ $site->id }}" href="#">{{ $site->value }}</a>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="dropdown __form" data-ref="#f-employee">
            <button type="button" class=" dropdown-toggle" data-toggle="dropdown">
                Filter:Employees |
                <span class="selected-d-inter">{{ $employeeSelected ? $employeeSelected->first_name . ' ' . $employeeSelected->last_name : 'all' }}</span>
            </button>
            <div class="dropdown-menu selected-inter">
                <a class="dropdown-item" data-value="0" href="#">all</a>
                @if ($shiftEmployees->count())
                    @foreach($shiftEmployees as $employee)
                        <a class="dropdown-item" data-value="{{ $employee->id }}" href="#">{{ $employee->first_name . ' ' . $employee->last_name }}</a>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="copy-shift-period __form" data-ref="#f-site">
            <button type="button" class=" dropdown-toggle" data-toggle="modal" data-target="#CopyShift">
                <i class="fa fa-copy"></i>
                Copy
            </button>
            <div class="dropdown-menu selected-inter">
                @if (auth()->user()->sites->count())
                    @foreach(auth()->user()->sites as $site)
                        <a class="dropdown-item" data-value="{{ $site->id }}" href="#">{{ $site->value }}</a>
                    @endforeach
                @endif
            </div>
        </div>

        <input type="hidden" id="f-site" value="{{ $site_id }}" name="site">
        <input type="hidden" id="f-employee" value="{{ $employee_id }}" name="employee">
    </form>

    <form method="get" onchange="$(this).submit();" class="align-left">
        @if(!$publishedCount && !$unpublishedCount && !$trashedCount)
            <div class="btn-panel publish-btn disabled">
                <a href="#" class="btn-blue">No Shifts</a>
            </div>
        @elseif($trashedCount)
            <div class="btn-panel publish-btn red" data-toggle="modal" data-target="#publish-shift">
                <a href="#" class="btn-blue">Publish {{ $unpublishedCount + $trashedCount }}</a>
            </div>
        @elseif($unpublishedCount)
            <div class="btn-panel publish-btn yellow" data-toggle="modal" data-target="#publish-shift">
                <a href="#" class="btn-blue">Publish {{ $unpublishedCount + $trashedCount }}</a>
            </div>
        @elseif($publishedCount)
            <div class="btn-panel publish-btn green"><a href="#" class="btn-blue">Published</a></div>
        @endif
    </form>
</div>