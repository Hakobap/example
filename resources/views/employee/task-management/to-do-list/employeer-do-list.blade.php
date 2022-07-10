@if(isset($employee_tasks) && $employee_tasks->count())
    @foreach($employee_tasks as $key => $task)
        <?php
        $isSamePrevEmployeeId = isset($employee_tasks[$key - 1]) && $employee_tasks[$key - 1]->employee_id == $task->employee_id;
        $isSameNextEmployeeId = isset($employee_tasks[$key + 1]) && $employee_tasks[$key + 1]->employee_id == $task->employee_id;
        ?>

        @if(!$isSamePrevEmployeeId)
            <table class="table mt30">
                <thead>
                <tr class="dotted">
                    <th scope="col"  style="width:340px">
                        <p class="txt-deco">{{ $task->employee->first_name . ' ' . $task->employee->last_name }}</p>
                    </th>
                    <th style="width:155px">
                        <p class="text-center">Due Date</p>
                    </th>
                    <th style="width:580px">
                        <p class="text-center">Notes</p>
                    </th>
                    <th style="width: 200px;">
                        <p class="text-center">Site</p>
                    </th>
                    <th style="width: 200px;">
                        <p class="text-center">Task Status</p>
                    </th>
                    <th style="width:120px">
                        <button type="button" data-id="{{ $task->employee_id }}" class="add-task-btn" data-toggle="modal" data-target="#addTask">Add Task</button>
                    </th>
                </tr>
                </thead>
                <tbody>
                @endif

                <tr>
                    <td scope="row">
                        <div class="check-task">
                            <div class="checkbox">
                                <input {{ $task->status == 2 ? 'checked' : '' }} name="done[]" value="{{ $task->id }}" type="checkbox" id="checkbox-{{ $uniqid = uniqid() }}" class="checkbox__input">
                                <label for="checkbox-{{ $uniqid }}" class="checkbox__label">{{ $task->title }}</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="date-details1 text-center">
                            {!! $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : '<span style="color: #b34242;">Not Set</span>' !!}
                        </p>
                    </td>
                    <td>
                        <p>
                            {!! htmlspecialchars($task->description) ?: '<span style="color: #b34242;">Not Set</span>' !!}
                        </p>
                    </td>
                    <td>
                        {!! $task->site->value ?? '<span style="color: #b34242;">Not Set</span>' !!}
                    </td>
                    <td>
                        {{ $task->getStatus() }}
                    </td>
                    <td>
                        <div class="icon-flex">
                            <a class="edit-my-task"
                               data-toggle="modal"
                               data-target=".__add_task_modal"
                               data-id="{{ $task->id }}"
                               href="{{ route('user.task-management.tasks.get', $task->id) }}">
                                <img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit">
                            </a>
                            <a class="delete-my-task" data-id="{{ $task->id }}" href="{{ route('user.task-management.tasks.delete', $task->id) }}">
                                <img src="{{ asset('/site/images/close.png') }}" width="20" alt="close">
                            </a>
                        </div>
                    </td>
                </tr>


                @if(!$isSameNextEmployeeId)
                </tbody>
            </table>
        @endif

    @endforeach
@endif