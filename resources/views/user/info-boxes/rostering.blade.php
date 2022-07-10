<div class="thead">{{ $title }}</div>
<table class="table table-default">
    <tbody>
    @if($tasks->count())
        <?php $n = 0; ?>
        @foreach($tasks as $task)
            <tr class="{{ $n % 2 == 1 ? 'purple' : '' }}">
                <td>
                    <div style="display: flex;align-items: center;min-width: 200px;" class="txt3">
                        <span class="circle ros-im">
                            @if ($task->employee->photo)
                                <img width="50px" src="{{ asset('/images/user/' . $task->employee->photo) }}">
                            @else
                                <i class="fa fa-user"></i>
                            @endif
                        </span>
                        <span style="margin-left: 10px;">
                              {{ $task->employee->first_name . ' ' . $task->employee->last_name }}
                        </span>
                    </div>
                </td>
                <td scope="col">
                    <p class="txt1">Start Date</p>
                    <p class="txt2">{{ \Illuminate\Support\Carbon::parse($task->start_date)->format('m/d/Y') }}</p>
                </td>
                <td scope="col">
                    <p class="txt1">On Shift Sites</p>
                    <p class="txt2">{{ implode(', ', $task->employee->employeeOnShiftSites()) ?: 'no site' }}</p>
                </td>
                <td scope="col">
                    <img title="{{ \Carbon\Carbon::parse($task->start_date)->format('g:i A') }} - {{ \Carbon\Carbon::parse($task->end_date)->format('g:i A') .' ' . $task->site->value }}" src="{{asset('/site/images/information.png')}}" alt="logo">
                    <a href="{{ route('user.task-management.delete', $task->id) }}" onclick="return confirm('Are You Sure?');"><img src="{{asset('/site/images/close.png')}}" alt="logo"></a>
                </td>
            </tr>
            <?php $n++; ?>
        @endforeach
    @else
        <h1 class="text-center">No Data Found</h1>
    @endif
    </tbody>
</table>