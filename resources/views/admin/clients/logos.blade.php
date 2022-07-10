@push('css')

@push('js')

@extends('adminlte::page')

@section('title', 'User Profile')

@section('content_header')
    <h1>Client Logos</h1>
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

    <div>
        {{ Form::model($model, ['route' => ['admin.clients.store', $model->id], 'enctype' => 'multipart/form-data']) }}

        <div class="panel panel-primary">
            <div class="panel-heading">To Upload A Logo</div>
            <div class="panel-body">
                <div class="form-group has-feedback">
                    {!! Form::label('sort', 'Sort Number:', ['class' => 'control-label']) !!}
                    {!! Form::text('sort', $model->sort ,['id' => 'sort', 'class' => 'form-control', 'required']) !!}
                </div>

                <div class="form-group has-feedback">
                    {!! Form::label('url', 'Url:', ['class' => 'control-label']) !!}
                    {!! Form::url('url', $model->url ,['id' => 'sort', 'class' => 'form-control', 'required']) !!}
                </div>

                <div class="form-group has-feedback">
                    {!! Form::label('image', 'Image (The Image Must Be 10x10 By Pixels):', ['class' => 'control-label']) !!}
                    {!! Form::file('image' ,['id' => 'image', 'class' => 'form-control']) !!}
                </div>

                @if(is_file(public_path($model->file)))
                    <div style="margin-bottom: 20px;">
                        <img style="max-width: 100%;" src="{{ asset($model->file) }}" />
                    </div>
                @endif
            </div>
            <div class="panel-footer">
                {{ Form::submit('Save', ['class' => 'btn btn-primary btn-block btn-flat']) }}
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading">Home Page | Client Logos</div>
            <div class="panel-body">
                @if(isset($images) && $images)
                    @foreach($images as $image)
                        <div class="col-md-3">
                           <div>
                               <img style="max-width: 100%;" src="{{ asset($image->image) }}" />
                           </div>
                            <div>
                               <p>Sort: <strong>{{ $image->sort }}</strong></p>
                               <p>Url: <strong style="font-size: 10px;">{{ asset($image->url) }}</strong></p>
                            </div>
                            <a onclick="return confirm('Do You confirm this action?');" href="{{ route('admin.clients.delete', $image->id) }}" class="btn btn-danger"><i class="fa fw fa-trash"></i> Remove</a>
                        </div>
                    @endforeach
                @else
                    <h1 class="alert page-title text-center">No Data Found</h1>
                @endif
            </div>
            <div class="panel-footer">
               These Images Will Appears In Home Page Bottom Bar
            </div>
        </div>

        {{ Form::close() }}
    </div>
@stop

@section('css')

@stop

@section('js')

@stop