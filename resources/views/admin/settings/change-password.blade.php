@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    <h1>Change Password</h1>
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Errors<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = \Illuminate\Support\Facades\Session::get('alert-success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="col-md-8" style="margin: 20px;">
        {{ Form::open(['action' => 'Admin\\AdminController@changePassword']) }}
        <div class="form-group has-feedback">
            {!! Form::label('old_password', 'Old password:', ['class' => 'control-label']) !!}
            {!! Form::password('old_password', ['id' => 'old_password', 'class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group has-feedback">
            {!! Form::label('password', 'New password:', ['class' => 'control-label']) !!}
            {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group has-feedback">
            {!! Form::label('password_confirmation', 'Password Confirmation:', ['class' => 'control-label']) !!}
            {!! Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group has-feedback">
            {{ Form::submit('Change', ['class' => 'btn btn-primary btn-block btn-flat']) }}
        </div>
        {{ Form::close() }}
    </div>

@stop

@section('css')

@stop

@section('js')

@stop