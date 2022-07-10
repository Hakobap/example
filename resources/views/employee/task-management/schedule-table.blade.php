@if(!request()->ajax())
    <div data-action="{{ route('employee.dashboard', ['site' => $site_id]) }}" class="report-line">
        <div class="align-left">
            <div class="dropdown">
                <button type="button" class=" dropdown-toggle" data-toggle="dropdown">
                    View:Employee | <span class="selected-d-inter" data-schedule="{{ $calendar_schedule }}">Week</span>
                </button>
                <div class="dropdown-menu selected-inter">
                    <a class="dropdown-item" data-schedule="6" href="#">Week</a>
                    <a class="dropdown-item" data-schedule="13" href="#">2 Week</a>
                    <a class="dropdown-item" data-schedule="27" href="#">4 Week</a>
                    <a class="dropdown-item" data-schedule="{{ $calendar->getDaysInMonth() - 1 }}" href="#">Month</a>
                </div>
            </div>
        </div>
        <div class="align-left" style="margin-right: 10px;">
            <div hidden>
                <div class="drop-decoration">
                    <span class="fa fa-magic"></span>
                    <button type="button">Autos</button>
                    <div class="dropdown">
                        <button type="button" class="sml-toggle dropdown-toggle" data-toggle="dropdown"></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </div>
                </div>
                <a href="#" class="refresh-blue"><img src="{{ asset('/site/images/refresh-blue.png') }}" alt="refresh"></a>
                <div class="drop-decoration">
                    <button type="button">Copy Shifts</button>
                    <div class="dropdown">
                        <button type="button" class="sml-toggle dropdown-toggle" data-toggle="dropdown"></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </div>
                </div>
                <div class="drop-decoration">
                    <span class="fa fa-chart-line"></span>
                    <button type="button">States</button>
                    <div class="dropdown">
                        <button type="button" class="sml-toggle dropdown-toggle" data-toggle="dropdown"></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </div>
                </div>
                <div class="drop-button-decoration">
                    <div class="dropdown">
                        <button type="button" class="sml-toggle dropdown-toggle" data-toggle="dropdown">Export</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </div>
                </div>
                <div class="drop-button-decoration">
                    <div class="dropdown">
                        <button type="button" class="sml-toggle dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-cogs"></i>
                            Option
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Link 1</a>
                            <a class="dropdown-item" href="#">Link 2</a>
                            <a class="dropdown-item" href="#">Link 3</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-panel"><a href="#" class="btn-blue float-right">Publish</a></div>
        </div>
    </div>
@endif



@if(!$task_id)
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
                                     class="inner-decoration {{($task = $employee->setTaskDate($dayDate[$i])->task($site_id)->first()) && $task->trash == 0 ? $task->getTaskStatusColor() : ''}}"
                                     title="{{ $task->description ?? '' }}"
                                     data-id="{{$task ? $task->id : null}}"
                                     style="{{ $task && $task->reject ? 'background: #f9e5ff;' : '' }}"
                                     data-id="{{$task ? $task->id : null}}">
                                    @if($task && $task->trash == 0)
                                        <i class="fa fa-trash delete-item"></i>
                                        <i data-href="{{ route('employee.task-management.schedule.' . ($task->reject ? 'enable' : 'reject'), $task->id) }}"
                                           class="fa {{$task->reject ? 'fa-bell bells-item' : 'fa-bell-slash reject-item'}}"></i>
                                        <i class="fa fa-trash delete-item"></i>
                                        <div class="td-active calendar-day">
                                            <div class="info">
                                                <p class="txt-bold">{{ \Carbon\Carbon::parse($task->start_date)->format('g:i A') . ' - ' . \Carbon\Carbon::parse($task->end_date)->format('g:i A')}}</p>

                                                <div class="td-active">
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
    </div>
@endif


<div class="schedule-modals">
    <div id="modal-dialog" style="height: 470px;" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $taskById ? 'Edit Shift' : 'New Shift' }}  </h4>
                    {{--<h4 class="modal-title">New Shift on Tue 11 Feb 2020  </h4>--}}
                </div>
                <div class="modal-body">
                    <form id="shift-form" class="employee-shift-form">
                        <input type="hidden" name="employee_id" value="">
                        <input type="hidden" name="site_id" value="{{ $site_id }}">
                        <input type="hidden" name="task_id" value="{{ $task_id }}">
                        <input type="hidden" name="row">
                        <div class="input-row">
                            <div class="form-group">
                                <label for="select1">Who is working?</label>
                                <input type="text" readonly class="form-control" value="{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}">

                            </div>
                            <div  class="form-group">
                                <label for="select2">In which area?</label>
                                <input type="text" name="area" value="{{ $taskById->area ?? '' }}" class="form-control" id="select2">
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="form-group">
                                <label for="hours">Hours:</label>
                                <input class="form-control" id="hours" name="hours" value="{{ $taskById->hours ?? '' }}" type="text" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="select5">Position you can work:</label>
                                <select style="position: static;" name="position_id" class="form-control">
                                    @if($positions->count())
                                        @foreach($positions as $id => $position)
                                            <option {{ old('position_id') == $id ? 'selected' : '' }} value="{{ $id }}">{{ $position }}</option>
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
</div>