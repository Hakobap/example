{{ Form::model($model, ['route' => ['admin.investment.store', $model->id], 'enctype' => 'multipart/form-data']) }}

<div class="form-group has-feedback">
    <a style="font-size: 18px;" href="{{ route('admin.investment.view') }}">Go To Back</a>
</div>

<div class="form-group has-feedback">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', $model->title ,['id' => 'title', 'class' => 'form-control', 'required']) !!}
</div>

<div class="form-group has-feedback">
    {!! Form::label('text', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textArea('text', $model->text ,['id' => 'text', 'class' => 'form-control', 'required']) !!}
</div>

<div class="form-group has-feedback">
    {!! Form::label('file', 'Image (The Image Must Be 92x90 By Pixels):', ['class' => 'control-label']) !!}
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