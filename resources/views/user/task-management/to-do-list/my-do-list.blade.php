<table class="table">
    <thead>
    <tr>
        <th scope="col">
            <div class="th-inner"> <p class="text-center"><b>My Tasks</b></p></div>
        </th>
        <th>
            <div class="th-inner">  <p class="text-center"><b>Due Date</b></p></div>
        </th>
        <th>
            <div class="th-inner"> <p class="text-center"><b>Notes</b></p></div>
        </th>
        <th>
            <div class="th-inner"> <p class="text-center"><b>Site</b></p></div>
        </th>
        <th>
            <div class="th-inner"> <p class="text-center"><b>Task Status</b></p></div>
        </th>
        <th>
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
                            <span data-attachments="{{ $task->attachments }}" data-toggle="modal" data-target="#attached-files">
                                {{ $task->attachments->count() }}
                            </span>
                            <img onclick="$('#file-{{ $task->id }}').click();" src="{{ asset('/site/images/attach-file.png') }}" width="20" alt="edit">
                        </a>
                        <a class="edit-my-task btn btn-primary btn-sm"
                           data-toggle="modal"
                           data-target=".__add_task_modal"
                           data-id="{{ $task->id }}"
                           href="{{ route('user.task-management.tasks.get', $task->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="delete-my-task  btn-danger btn-sm" data-id="{{ $task->id }}" href="{{ route('user.task-management.tasks.delete', $task->id) }}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                    <div hidden>
                        <input type="file" id="file-{{ $task->id }}" name="file[{{ $task->id }}]" class="attach-files" accept="jpeg, gif, jpg, png, docx, pdf, xlsx, xls, txt">
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="4" align="center"><h1>No Data Found</h1></td></tr>
    @endif
    </tbody>
</table>