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
@if ($message = \Illuminate\Support\Facades\Session::get('alert-success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

<div class="col-md-8" style="margin: 20px;">
    {{ Form::open(['url' => '/admin/faq/save/' . intval($model->id)]) }}
    <div class="form-group has-feedback">
        {!! Form::label('question', 'Question:', ['class' => 'control-label']) !!}
        {!! Form::text('question', $model->question, ['id' => 'question', 'class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group has-feedback">
        {!! Form::label('answer', 'Answer:', ['class' => 'control-label']) !!}
        {!! Form::textarea('answer', $model->answer, ['id' => 'answer', 'class' => 'form-control']) !!}
    </div>
    <div class="form-group has-feedback">
        {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-block btn-flat']) }}
    </div>
    {{ Form::close() }}
</div>


@section('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 250px;
        }
    </style>
@stop

@section('js')
    <script src="{{ url('/js/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
                .create( document.querySelector( '#answer' ) )
                .then(function (editor) {
                })
                .catch(function (error) {
                    console.error( error );
                } );
    </script>
@stop