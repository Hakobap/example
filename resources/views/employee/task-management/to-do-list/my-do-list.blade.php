<table class="table">
    <thead>
    <tr class="dotted">
        <th scope="col"  style="width:340px">
            <p class="txt-deco">My Tasks</p>
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
            <button type="button" data-id="{{ auth()->id() }}" class="add-task-btn" data-toggle="modal" data-target=".__add_task_modal">Add Task</button>
        </th>
    </tr>
    </thead>
    <tbody class="mt30">
    @if(isset($tasks) && $tasks->count())
        @foreach($tasks as $key => $task)
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
                            <span data-attachments="{{ $task->attachments }}" data-toggle="modal" data-target="#attached-files">
                                {{ $task->attachments->count() }}
                            </span>
                            <img onclick="$('#file-{{ $task->id }}').click();" src="{{ asset('/site/images/attach-file.png') }}" width="20" alt="edit">
                        </a>
                        <a class="edit-my-task"
                           data-toggle="modal"
                           data-target=".__add_task_modal"
                           data-id="{{ $task->id }}"
                           href="{{ route('employee.task-management.tasks.get', $task->id) }}">
                            <img src="{{ asset('/site/images/edit.svg') }}" width="20" alt="edit">
                        </a>
                        <a class="delete-my-task" data-id="{{ $task->id }}" href="{{ route('employee.task-management.tasks.delete', $task->id) }}">
                            <img src="{{ asset('/site/images/close.png') }}" width="20" alt="close">
                        </a>
                        <div hidden>
                            <input type="file" id="file-{{ $task->id }}" name="file[{{ $task->id }}]" class="attach-files" accept="jpeg, gif, jpg, png, docx, pdf, xlsx, xls, txt">
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="4" align="center"><h1>No Data Found</h1></td></tr>
    @endif
    </tbody>
</table>