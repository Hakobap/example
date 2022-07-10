<div class="report-line" style="margin-bottom: 20px;">
    <form method="get" class="align-left">
        <input id="date-range-top" class="form-control" type="text" name="daterange" value="{{ request('daterange')  }}" />

        <div class="dropdown __form" data-ref="#f-employee">
            <button type="button" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Filter:Employees |
                <span class="selected-d-inter">{{ $employeeSelected ? $employeeSelected->first_name . ' ' . $employeeSelected->last_name : 'all' }}</span>
            </button>
            <div class="dropdown-menu selected-inter" x-placement="bottom-start">
                <a class="dropdown-item" data-value="0" href="#">all</a>
                @foreach($employees as $employee)
                    <a class="dropdown-item" data-value="{{ $employee->id }}" href="#">{{ $employee->first_name . ' ' . $employee->last_name }}</a>
                @endforeach
            </div>
        </div>

        <div class="dropdown __form" data-ref="#f-site">
            <button type="button" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Filter:Sites |
                <span class="selected-d-inter">{{ $siteSelected ? $siteSelected->value : 'all' }}</span>
            </button>
            <div class="dropdown-menu selected-inter" x-placement="bottom-start">
                <a class="dropdown-item" data-value="0" href="#">all</a>
                @if($sitesForEmployees->count())
                    @foreach($sitesForEmployees as $site)
                        <a class="dropdown-item" data-value="{{ $site->id }}" href="#">{{ $site->value }}</a>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="dropdown __form" data-ref="#f-status">
            <button type="button" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Filter:Status |
                <span class="selected-d-inter">{{ \App\Models\Task::$STATUS[request('status')] ?? 'all' }}</span>
            </button>
            <div class="dropdown-menu selected-inter" x-placement="bottom-start">
                @foreach(\App\Models\Task::$STATUS as $statusId => $status)
                    <a class="dropdown-item" data-value="{{ $statusId }}" href="#">{{ $status }}</a>
                @endforeach
            </div>
        </div>



        <input type="hidden" id="f-employee" value="{{ request('employee_id') }}" name="employee_id">
        <input type="hidden" id="f-site" value="{{ request('site_id') }}" name="site_id">
        <input type="hidden" id="f-status" value="{{ request('status') }}" name="status">
    </form>
    <form method="get" onchange="$(this).submit();" class="align-left">
        <div class="btn-panel add-task" data-id="{{ auth()->id() }}" data-toggle="modal" data-target=".__add_task_modal"><a href="#" class="btn-blue">Add Task</a></div>
    </form>
</div>