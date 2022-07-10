@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'FAQ Update')

@section('content_header')
    <h1>FAQ Update</h1>
@stop

@section('content')
    <a class="btn btn-info" href="{{ url('/admin/faq') }}">Back FAQ List</a>

    <div class="row">
        @include('admin.faq.form', ['model' => $model])
    </div>
@stop

@section('css')

@stop

@section('js')

@stop