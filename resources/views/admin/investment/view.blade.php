@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>Investments</h1>
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

    @if($model->count())
        <div style="margin-top: 20px;">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Sort Number</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Buttons</th>
                </tr>
                </thead>
                <tbody>
                @foreach($model as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->text, 100) }}</td>
                        <td>{{ $item->extra }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('admin.investment.update', $item->id) }}">
                                <i class="fa fa-pen"></i> Edit
                            </a>
                            <a class="btn btn-danger" onclick="return confirm('Do You confirm this action?')" href="{{ route('admin.investment.delete', $item->id) }}">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <h1 class="alert alert-info col-md-12 page-title text-center"> No Data Found </h1>
    @endif
@stop

@section('css')

@stop

@section('js')

@stop