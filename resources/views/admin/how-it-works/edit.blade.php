@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>How It Works</h1>
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

    @include('admin.how-it-works.form')

@stop

@section('css')

@stop

@section('js')

@stop