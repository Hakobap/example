@extends('layouts.employee_dashboard')

@section('content')
<div class="task-container">
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

    <div class="container p0">
        <div class="table-responsive">
            <form
                enctype="multipart/form-data"
                action="{{ route('employee.task-management.tasks.update-task') }}"
                data-action="{{ route('employee.task-management.tasks.update-status') }}"
                method="post"
                class="employee-to-do-list-form"
                id="my-tasks-list">
                @csrf

                @include('employee.task-management.to-do-list.my-do-list')
            </form>
        </div>
    </div>
</div>


@include('employee.task-management.to-do-list.modals')


@endsection


@section('js')

@endsection

@section('css')
    <style>
        .table-responsive .dotted {
            background: #c4cffd;
            color: #2c46b3;
        }
    </style>
@endsection