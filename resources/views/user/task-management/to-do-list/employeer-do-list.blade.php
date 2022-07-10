@if(isset($employee_tasks) && $employee_tasks->count())
    @foreach($employee_tasks as $key => $task)
        <?php
        $isSamePrevEmployeeId = isset($employee_tasks[$key - 1]) && $employee_tasks[$key - 1]->employee_id == $task->employee_id;
        $isSameNextEmployeeId = isset($employee_tasks[$key + 1]) && $employee_tasks[$key + 1]->employee_id == $task->employee_id;
        ?>

        @if(!$isSamePrevEmployeeId)
            <table class="table mt30">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="th-inner"><p class="text-center"><b>{{ $task->employee->first_name . ' ' . $task->employee->last_name }}</b></p></div>
                    </th>
                    <th>
                        <div class="th-inner"> <p class="text-center"><b>Due Date</b></p></div>
                    </th>
                    <th>
                        <div class="th-inner"><p class="text-center"><b>Notes</b></p></div>
                    </th>
                    <th>
                        <div class="th-inner"> <p class="text-center"><b>Site</b></p></div>
                    </th>
                    <th>
                        <div class="th-inner">  <p class="text-center"><b>Task Status</b></p></div>
                    </th>
                    <th>
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


                @if(!$isSameNextEmployeeId)
                </tbody>
            </table>
        @endif

    @endforeach
@endif