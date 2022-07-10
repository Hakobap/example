<div class="thead">{{ $title }}</div>
@if($rosters->count())
    <table class="table table-default">
        <tbody>
        <?php $n=0; $hours=0;$prices=0 ?>
        @foreach($rosters as $employee)
            <?php
            $hours +=  $employee->tasksCalculated()->hours;
            $prices +=  $employee->tasksCalculated()->price;
            ?>
            <tr class="{{ $n % 2 == 1 ? 'purple' : '' }}">
                <td>
                    <div style="display: flex;align-items: center;min-width: 200px;" class="txt3">
                        <span class="circle ros-im">
                          @if ($employee->photo)
                                <img width="50px" src="{{ asset('/images/user/' . $employee->photo) }}">
                            @else
                                <i class="fa fa-user"></i>
                            @endif
                        </span>
                        <span style="margin-left: 10px;">
                              {{ $employee->first_name . ' ' . $employee->last_name }}
                        </span>
                    </div>
                </td>
                <td>
                    <p class="txt1">
                        {{ $employee->tasksCalculated()->hours }} Hrs / ${{ $employee->tasksCalculated()->price }}
                    </p>
                </td>
                {{--<td scope="col">--}}
                {{--<a href="{{ route('user.task-management.delete', $task->id) }}" onclick="return confirm('Are You Sure?');"><img src="{{asset('/site/images/close.png')}}" alt="logo"></a>--}}
                {{--</td>--}}
            </tr>
            <?php $n++; ?>
        @endforeach
        </tbody>
    </table>
    <div class="col-sm-12 total-tfoot">
        <div class="txt1">
            TOTALS
        </div>
        <div class="txt1">
            {{ $hours }} Hrs / ${{ $prices }}
        </div>
    </div>
@else
    <h1>No Data Found</h1>
@endif