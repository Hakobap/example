@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>Home Page Header</h1>
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
    @if ($message = \Illuminate\Support\Facades\Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div style="margin: 20px;">
        {{ Form::model($model, ['route' => ['admin.banners.home.store', $model->id], 'enctype' => 'multipart/form-data']) }}

        <div class="form-group has-feedback">
            {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
            {!! Form::text('title', $model->title ,['id' => 'title', 'class' => 'form-control', 'required']) !!}
        </div>

        <div class="form-group has-feedback">
            {!! Form::label('text', 'Description:', ['class' => 'control-label']) !!}
            {!! Form::textArea('text', $model->text ,['id' => 'text', 'class' => 'form-control', 'required']) !!}
        </div>

        <div class="form-group has-feedback">
            {!! Form::label('extra', 'Button Text:', ['class' => 'control-label']) !!}
            {!! Form::text('extra', $model->extra ,['id' => 'text', 'class' => 'form-control', 'required']) !!}
        </div>

        <div class="form-group has-feedback">
            {!! Form::label('file', 'Banner (The Image Must Be 1922x802 By Pixels):', ['class' => 'control-label']) !!}
            {!! Form::file('file' ,['id' => 'file', 'class' => 'form-control']) !!}
        </div>

        @if(is_file(public_path($model->file)))
            <div style="margin-bottom: 20px;">
                <img style="max-width: 100%;" src="{{ asset($model->file) }}" />
            </div>
        @endif

        <div class="form-group has-feedback">
            {{ Form::submit('Save', ['class' => 'btn btn-primary btn-block btn-flat']) }}
        </div>

        {{ Form::close() }}
    </div>
@stop

@section('css')

@stop

@section('js')

@stop