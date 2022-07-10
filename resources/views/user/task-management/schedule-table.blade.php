@if(!$task_id)
    <section id="schedule-table-content">
        @include('user.task-management.schedule-table-top')

        <div class="table-responsive p0" id="home-table">
            <table id="schedule-table" class="table separate">
                <thead>
                <tr>
                    <th scope="col" class="search">
                        <input id="search-employee" type="text" placeholder="Search">
                    </th>
                    <?php $dayDate = []; ?>
                    @for($d = 0; $d <= $calendar_schedule; $d++)
                        <?php $dayDate[$d] = $calendar->getStartDate()->addDays($d); ?>

                        <th scope="col" class="text-center"><div class="test">  {{$dayDate[$d]->dayName . ' ' . $dayDate[$d]->isoFormat('Do')}} </div></th>
                    @endfor
                </tr>
                </thead>
                <tbody>
                @if($employees->count())
                    @foreach($employees as $employee)
                        <tr data-row="{{ $employee->id }}">
                            <td style="min-width: 250px;">
                                <div class="inner-decoration">
                                    <div class="decoration">
                                        <div class="user-icon" style="display: flex;justify-content: center;align-items: center;width: 50px;height: 50px;overflow: hidden;">
                                            @if ($employee->photo)
                                                <img width="50px" src="{{ asset('/images/user/' . $employee->photo) }}">
                                            @else
                                                <i class="fa fa-user"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <p style="font-size: 12px; line-height: 20px;" class="user">{{ $employee->first_name . ' ' . $employee->last_name }}</p>
                                            <p style="font-size: 12px; line-height: 20px;" class="user">
                                                {{ implode(', ', \App\Models\EmployeeAction::getPositions($employee->id, $site_id)->pluck('position.value', 'position.value')->toArray()) }}
                                            </p>
                                            <p class="hours-decoration"> {{ $employee->tasksCalculated()->hours }} Hrs / ${{ $employee->tasksCalculated()->price }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @for($i = 0; $i <= $calendar_schedule; $i++)
                                <td style="position: relative;" class="text-center">
                                    <div
                                        class="inner-decoration {{($task = $employee->setTaskDate($dayDate[$i])->task($site_id)->first()) ? $task->getTaskStatusColor() : ''}}"
                                        title="{{ $task->description ?? '' }}"
                                        data-id="{{$task ? $task->id : null}}">
                                        @if($task && !empty($task))
                                            <i class="fa fa-trash delete-item"></i>
                                            <div class="td-active calendar-day">
                                                <div class="info">
                                                    <p class="txt-bold">{{ \Carbon\Carbon::parse($task->start_date)->format('g:i A') . ' - ' . \Carbon\Carbon::parse($task->end_date)->format('g:i A')}}</p>
                                                    <div style="line-height: 25px;">
                                                        @if($task->meal_break)
                                                            <p>Meal break(mins) {{ $task->meal_break }}</p>
                                                        @endif
                                                        @if($task->rest_break)
                                                            <p>Rest break(mins) {{ $task->rest_break }}</p>
                                                        @endif

                                                        <p>{{ \Illuminate\Support\Str::limit($task->description, 15) }}</p>
                                                    </div>
                                                </div>
                                                <div class="hover-event" data-id="{{ $task->id }}">
                                                    <button class="btn btn-sm edit-btn btn-primary">Edit</button>
                                                    <button class="btn btn-sm copy-btn btn-success">Copy</button>
                                                </div>
                                            </div>
                                        @else
                                            <i class="fa fa-plus m-plus"
                                               data-pos="{{ route('user.task-management.employee-positions') }}"
                                               data-toggle="modal" data-target="#modal-dialog"></i>
                                        @endif
                                    </div>
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                @else
                    <tr align="center">
                        <td colspan="8">
                            <div class="col-lg-12"><h2>No Data Found - Before do an action need to add an employee in the shift</h2></div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>

            <div id="CopyShift" class="modal fade modal-addTask" role="dialog">

                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center">
                                <span class="title-for-add">Copy shifts</span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="copyToForm">
                                <label class="radio-container">
                                    Copy to next {{ str_replace(' ', '-', strtolower(\App\Services\Calendar::getFilterIntervalName($calendar_schedule))) }}
                                    <input class="ctype" type="radio" checked="checked" name="ctype" value="1">
                                    <span class="checkmark"></span>
                                </label>

                                <div class="text-center modal-divider"><span>Or</span></div>

                                <section style="margin-bottom: 20px;">
                                    <h6 class="text-center">Select the dates you want to copy these shifts into</h6>
                                </section>

                                <label class="radio-container">
                                    Copy to other {{ str_replace(' ', '-', strtolower(\App\Services\Calendar::getFilterIntervalName($calendar_schedule))) }}(s)
                                    <input class="ctype" type="radio" name="ctype" value="2">
                                    <span class="checkmark"></span>
                                </label>

                                <?php $schedule = $interval = $calendar_schedule + 1; ?>
                                @for($i = 1; $i <= 5; $i++)
                                    <?php
                                    $interval = ($i + 1) * $calendar_schedule + $i;
                                    $startDate = $calendar->getStartDate()->addDays($interval - $calendar_schedule)->format('d/m/Y');
                                    $endDate = $calendar->getStartDate()->addDays($interval)->format('d/m/Y');
                                    ?>
                                    <section class="checkbox-dates">
                                        <section class="form-control checkbox-row">
                                            <input disabled id="copyTo-{{ $i }}" type="checkbox" name="copyTo[]" value="{{ $i }}">
                                            <label for="copyTo-{{ $i }}">
                                                {{ $startDate }} - {{  $endDate }}
                                            </label>
                                        </section>
                                    </section>
                                @endfor

                                <div>
                                    <button style="margin-top: 20px;" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


<div class="schedule-modals">
    <div id="modal-dialog" style="height: 470px;" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $taskById ? 'Edit Shift' : 'New Shift' }}</h4>
                </div>
                <div class="modal-body">
                    <form id="shift-form">
                        <input type="hidden" name="week_date" value="{{ request('week_date') }}">
                        <input type="hidden" name="site_id" value="{{ $site_id }}">
                        <input type="hidden" name="task_id" value="{{ $task_id }}">
                        <input type="hidden" name="calendar_schedule" value="{{ $calendar_schedule }}">
                        <input type="hidden" name="row">
                        <div class="select-row">
                            <div class="form-group">
                                <label for="select1">Who is working?</label>
                                <select name="employee_id" class="form-control" id="select1">
                                    @if($employees && !empty($employees))
                                        @foreach($employees as $employee)
                                            <option {{ old('employee_id', $taskById->employee_id ?? 0) == $employee->id ? 'selected' : '' }} value="{{ $employee->id }}">{{ $employee->first_name . ' ' . $employee->last_name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="select2">In which area?</label>
                                <input type="text" name="area" style="position: relative; top: 10px;" value="{{ $taskById->area ?? '' }}" class="form-control" id="select2">
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="form-group">
                                <label for="hours">Hours:</label>
                                <input readonly class="form-control" id="hours" name="hours" value="{{ $taskById->getWorkHours() }}" type="text" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="select5">Position they can work:</label>
                                <select style="position: static;" name="position_id" class="form-control">
                                    @if (isset($taskById->employeeAction))
                                        @foreach($taskById->employeeAction as $employeeAction)
                                            <option {{ $site_id == $employeeAction->user_site_id ? 'selected' : '' }} value="{{ $employeeAction->position->id }}">{{ $employeeAction->position->value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="form-group">
                                <label for="select3">Start:</label>
                                <input value="{{ \Carbon\Carbon::parse($taskById->start_date ?? \Carbon\Carbon::now())->format('H:i') }}" name="start_date" style="max-width: 131px;" type="time" class="form-control" id="select3">
                            </div>
                            <div class="form-group">
                                <label for="select4">Finish:</label>
                                <input value="{{ \Carbon\Carbon::parse($taskById->end_date ?? \Carbon\Carbon::now()->addHours(8))->format('H:i') }}" name="end_date" style="max-width: 131px;" type="time"  class="form-control" id="select4">
                            </div>
                            <div class="form-group">
                                <label for="select5">Meal break (mins):</label>
                                <input name="meal_break" type="number" min="0" value="{{ $taskById->meal_break ?? '' }}" class="form-control" id="select5">
                            </div>
                            <div class="form-group">
                                <label for="select6">Rest break (mins):</label>
                                <input name="rest_break" type="number" min="0" value="{{ $taskById->rest_break ?? '' }}" class="form-control" id="select6">
                            </div>
                        </div>
                        <div class="textarea-row">
                            <div class="form-group">
                                <label for="comment">Notes:</label>
                                <textarea class="form-control" rows="5" id="comment" name="description">{{ $taskById->description ?: '' }}</textarea>
                                <button type="submit" class="form-btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="close" data-dismiss="modal"><img src="{{asset('/site/images/close-icon.png')}}" alt="close" height="" width=""></button>
        </div>
    </div>

    <div id="publish-shift" style="height: 470px;" class="modal modal-addTask fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Publish Shifts</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="publish-shift-form">
                        @csrf

                       <div class="fom-group">
                           <label style="margin-bottom: 40px;">Publish to employees:</label>
                       </div>

                        <div class="form-group">
                            <label for="rd-1">Only where shift has changed (YELLOW AND RED)</label>
                            <input checked id="rd-1" name="publish" type="radio" value="1">
                        </div>

                        <div class="form-group">
                            <label for="rd-2">Only where shift deleted (RED ONLY)</label>
                            <input id="rd-2" name="publish" type="radio" value="2">
                        </div>

                        <div>
                            <button style="margin-top: 20px;" type="submit" class="btn btn-primary">Publish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="close" data-dismiss="modal"><img src="{{asset('/site/images/close-icon.png')}}" alt="close" height="" width=""></button>
        </div>
    </div>
</div>