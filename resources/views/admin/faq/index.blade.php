@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'FAQ List')

@section('content_header')
    <h1>FAQ List</h1>
@stop

@section('content')
    <a class="btn btn-info" href="{{ url('/admin/faq/create') }}">Create</a>

    <table class="table table-striped">
        <thead>
        <tr>
{{--            <th>Id</th>--}}
            <th>Question</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action Buttons</th>
        </tr>
        </thead>
        <tbody id="post-data">
         @include('admin.faq.data')
        </tbody>
    </table>
    <div class="ajax-load text-center" style="display:none">
        <p><img src="{{ url('/images/loader.gif') }}">Loading More post</p>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script src="{{ url('/js/main.js') }}"></script>
@stop