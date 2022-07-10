@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>User Profile</h1>
@stop

@section('content')
    <div class="col-md-8">
        @foreach($user as $attribute => $value)
            <p>{{ $attribute . ' : ' . $value }}</p>
        @endforeach
    </div>
@stop

@section('css')

@stop

@section('js')

@stop