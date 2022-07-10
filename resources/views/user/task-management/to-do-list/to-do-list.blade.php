@extends('layouts.app_dashboard')

@section('top-menu-right')
    <div class="page-main-title">
        <h3>TASKS</h3>
    </div>
@endsection

@section('content')
<div class="task-container">
    @include('user.task-management.to-do-list.search')

    @if(!empty($errors->all()))
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="p0">
        <div class="table-responsive">
            <form enctype="multipart/form-data" action="{{ route('user.task-management.tasks.update-task') }}" data-action="{{ route('user.task-management.tasks.update-status') }}" method="post" id="my-tasks-list">
                @csrf

                @include('user.task-management.to-do-list.my-do-list')
                @include('user.task-management.to-do-list.employeer-do-list')
            </form>
        </div>
    </div>
</div>


@include('user.task-management.to-do-list.modals')


@endsection



@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('.daterangepicker').daterangepicker();
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
//            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD/MM/YYYY') + ' to ' + end.format('DD/MM/YYYY'));
        });

        $(document).delegate('.applyBtn', 'click', function() {
            $('#search-tasks').submit();
        });

        $(document).delegate('#search-tasks select', 'change', function() {
            $('#search-tasks').submit();
        });
    });
</script>
@endsection

@section('css')

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .table-responsive .dotted {
            background: #c4cffd;
            color: #2c46b3;
        }
    </style>
@endsection