<table class="table">
    <thead>
    <tr class="dotted">
        <th scope="col">
            <div class="th-inner"> <p class="txt-deco">My Tasks</p></div>
        </th>
        <th>
            <div class="th-inner">  <p class="text-center">Due Date</p></div>
        </th>
        <th>
            <div class="th-inner"> <p class="text-center">Notes</p></div>
        </th>
        <th>
            <div class="th-inner"> <p class="text-center">Site</p></div>
        </th>
        <th>
            <div class="th-inner"> <p class="text-center">Task Status</p></div>
        </th>
        <th>
            <div class="th-inner">  <button type="button" data-id="{{ auth()->id() }}" class="add-task-btn" data-toggle="modal" data-target=".__add_task_modal">Add Task</button></div>
        </th>
    </tr>
    </thead>
    <tbody class="mt30">
    @if(isset($employer_tasks) && $employer_tasks->count())
        @foreach($employer_tasks as $key => $task)
            <tr>
                <td scope="row">
                    <div class="check-task">
                        <div class="checkbox">
                            <input name="done[]" {{ $task->status == 2 ? 'checked' : '' }} value="{{ $task->id }}" type="checkbox" id="checkbox-{{ $uniqid = uniqid() }}" class="checkbox__input">
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
                        <a onclick="return false;" href="#" class="attach-task-file">
                            <span data-toggle="modal" data-target="#attached-files">0</span>
                            <img onclick="$('#file-{{ $task->id }}').click();" src="{{ asset('/site/images/attach-file.png') }}" width="20" alt="edit">
                        </a>
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
        @endforeach
    @else
        <tr><td colspan="4" align="center"><h1>No Data Found</h1></td></tr>
    @endif
    </tbody>
</table>