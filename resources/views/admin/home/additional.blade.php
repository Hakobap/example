@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>Additional</h1>
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

    {{ Form::model($model, ['route' => ['admin.settings.homeStore', $model->id], 'enctype' => 'multipart/form-data']) }}

    <div class="form-group has-feedback">
        {!! Form::label('text1', 'Text 1 (default - How it Works):', ['class' => 'control-label']) !!}
        {!! Form::textArea('home_text1', \App\Option::item('home_text1', old('home_text1')) ,['id' => 'text1', 'style' => 'max-height: 50px;', 'class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group has-feedback">
        {!! Form::label('text2', 'Text 2 (default - The Best Investment You Will Make):', ['class' => 'control-label']) !!}
        {!! Form::textArea('home_text2', \App\Option::item('home_text2', old('home_text2')) ,['id' => 'text', 'style' => 'max-height: 50px;', 'class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group has-feedback">
        {!! Form::label('text3', 'Text 3 (default - FAQ):', ['class' => 'control-label']) !!}
        {!! Form::textArea('home_text3', \App\Option::item('faq_title', old('home_text1')) ,['id' => 'text', 'style' => 'max-height: 50px;', 'class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group has-feedback">
        {!! Form::label('text4', 'Text 4 (default - Our clever \'perfect match\' algorithm does all the thinking for you, based on your staff availabilities. The best qualified and available staff for each roster you publish.):', ['class' => 'control-label']) !!}
        {!! Form::textArea('home_text4', \App\Option::item('faq_description', old('home_text1')) ,['id' => 'text', 'style' => 'max-height: 50px;', 'class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group has-feedback">
        {!! Form::label('text5', 'Text 5 (default - Client):', ['class' => 'control-label']) !!}
        {!! Form::textArea('home_text5', \App\Option::item('home_text5', old('home_text5')) ,['id' => 'text', 'style' => 'max-height: 50px;', 'class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group has-feedback">
        {{ Form::submit('Save', ['class' => 'btn btn-primary btn-block btn-flat']) }}
    </div>

    {{ Form::close() }}
@stop

@section('css')

@stop

@section('js')

@stop