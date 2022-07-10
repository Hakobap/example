{{-- My Tasks Modal --}}

<div id="myTasks" class="modal fade modal-addTask __my_tasks_modal" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    <span class="title-for-add">My Tasks</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @if (isset($employer_tasks) && $employer_tasks->count())
                    @foreach($employer_tasks as $key => $task)
                        @if ($key > 0)
                            <hr>
                        @endif
                        <section class="task-details-view" style="display: flex;justify-content: space-between;align-items: center;margin-bottom: 20px;">
                            <div style="display: flex;align-items: center;">
                                <input data-status-id="{{ $task->id }}" {{ $task->status==2 ? 'checked' : '' }} type="checkbox">
                                <label style="position: relative;left: 12px;top: 4px;font-size: 13px;{{ $task->status==2 ? 'text-decoration: line-through' : '' }};">{{ $task->title }}</label>
                            </div>
                            <div style="display: flex;justify-content: space-between;align-items: center;min-width: 218px;padding-left: 22px;">
                                @if (\Carbon\Carbon::parse($task->due_date)->format('M d, Y'))
                                    <div style="color: #ff577e;margin-right: 20px;">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    </div>
                                @endif
                                <div class="name-circle" style="margin-right: 20px;">{{ substr($task->employee->first_name, 0, 1) . substr($task->employee->last_name, 0, 1) }}</div>
                                <div style="font-size: 20px;margin-top: 5px">
                                    <a data-edit-id="{{ $task->id }}" href="#"><i class="fa fa-edit"></i></a>
                                    <a data-del-id="{{ $task->id }}" style="color: black;" href="#"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </section>
                    @endforeach
                @else
                    <div class="text-center">
                        <h3>No Data Found - Add a task</h3>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ./  My Tasks Modall --}}

{{-- My Tasks Modal --}}

<div id="assignedTasks" class="modal modal-addTask fade __assigned_tasks_modal" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    <span class="title-for-add">Assigned Tasks</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @if (isset($employee_tasks) && $employee_tasks->count())
                    @foreach($employee_tasks as $key => $task)
                        @if ($key > 0)
                            <hr>
                        @endif
                        <section class="task-details-view" style="display: flex;justify-content: space-between;align-items: center;margin-bottom: 20px;">
                            <div style="display: flex;align-items: center;">
                                <input data-status-id="{{ $task->id }}" {{ $task->status==2 ? 'checked' : '' }} type="checkbox">
                                <label style="position: relative;left: 12px;top: 4px;font-size: 13px;{{ $task->status==2 ? 'text-decoration: line-through' : '' }};">{{ $task->title }}</label>
                            </div>
                            <div style="display: flex;justify-content: space-between;align-items: center;min-width: 218px;padding-left: 22px;">
                                @if (\Carbon\Carbon::parse($task->due_date)->format('M d, Y'))
                                    <div style="color: #ff577e;margin-right: 20px;">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    </div>
                                @endif
                                <div class="name-circle" style="margin-right: 20px;">{{ substr($task->employee->first_name, 0, 1) . substr($task->employee->last_name, 0, 1) }}</div>
                                <div style="font-size: 20px;margin-top: 5px">
                                    <a data-edit-id="{{ $task->id }}" href="#"><i class="fa fa-edit"></i></a>
                                    <a data-del-id="{{ $task->id }}" style="color: black;" href="#"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </section>
                    @endforeach
                @else
                    <div class="text-center">
                        <h3>No Data Found - Add a task</h3>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ./  My Tasks Modall --}}

{{-- Add Task Modal --}}

<div id="addTask" class="modal fade modal-addTask __add_task_modal" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    <span class="title-for-add">Add Task</span>
                    <span class="title-for-edit" style="display: none;">Edit Task</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add-task-tdl" action="{{ route('user.task-management.tasks.store') }}" method="post">
                    <input type="hidden" name="id">

                    <div class="form-group">
                        <label for="text">Task Title</label>
                        <input name="title" type="text" class="form-control">
                    </div>

                    <div class="form-group add-task-select">
                        <label for="assign">Assign to</label>
                        <select name="employee_id" class="form-control" id="assign">
                            @if($employees->count())
                                <option value="{{ auth()->id() }}">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                                    (Admin)
                                </option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->first_name . ' ' . $employee->last_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group add-task-select" id="assign-site">
                        <label for="assign">Assign Site</label>
                        <select name="site_id" class="form-control">
                            <option>
                                non site
                            </option>

                            @if($sitesForEmployees->count())
                                @foreach($sitesForEmployees as $site)
                                    <option value="{{ $site->id }}">{{ $site->value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="text">Due Date</label>
                        <input name="due_date" type="date" min="{{ \Carbon\Carbon::now() }}" class="form-control">
                    </div>

                    <label for="text">Notes</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </form>
            </div>
            <div class="a-flex-footer modal-footer">
                <button type="button" class="close-btn" data-dismiss="modal">Close</button>
                <button onclick="$('#add-task-tdl').submit();" type="submit" class="save-add-btn">Save</button>
            </div>
        </div>

    </div>
</div>

{{-- ./ Add Task Modal --}}

{{-- The Task attached files --}}

<div id="attached-files" class="modal fade modal-attached-files modal-addTask" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">
                    <span class="title-for-add">Attached Files</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body task-container">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="dotted">
                            <tr align="center">
                                <th>User</th>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ./ The Task attached files --}}