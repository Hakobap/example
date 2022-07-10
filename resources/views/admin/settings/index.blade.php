@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>Settings</h1>
@stop

@section('content')
    <div>
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

        {{ Form::model($model, ['route' => ['admin.settings.indexStore', $model->id], 'enctype' => 'multipart/form-data']) }}

        <div class="form-group has-feedback">
            {!! Form::label('logo', 'Site Logo: (default site "233x44" by pixels)', ['class' => 'control-label']) !!}
            {!! Form::file('logo' ,['id' => 'logo', 'class' => 'form-control']) !!}
        </div>

        @if(is_file(public_path('assets/site/settings/logo.png')))
            <div style="margin-bottom: 20px;">
                <button type="button" style="display: none;" class="btn btn-primary" onclick="$(this).next().toggle();$(this).toggle();">Show Logo</button>
                <img style="max-width: 100%;" src="{{ asset('assets/site/settings/logo.png') }}" />
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