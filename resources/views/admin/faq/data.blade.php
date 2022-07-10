@if($model && isset($model))
    @foreach($model as $news)
        <tr>
{{--            <td>{{ $news->id }}</td>--}}
            <td>{{ $news->question }}</td>
            <td>{{ $news->created_at }}</td>
            <td>{{ $news->updated_at }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('admin.faq.update', $news->id) }}">
                    <i class="fa fw fa-pen"></i> Update
                </a>
                <a class="btn btn-danger" onclick="return confirm('Do You confirm this action?')" href="{{ route('admin.faq.remove', $news->id) }} }}">
                    <i class="fa fw fa-trash"></i> Delete
                </a>
            </td>
        </tr>
    @endforeach
@else
    <h1 class="alert alert-info page-title text-center">No Data Found</h1>
@endif