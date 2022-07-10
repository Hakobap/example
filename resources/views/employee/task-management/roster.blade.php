@extends('layouts.employee_dashboard')

@section('content')
    <div class="container roster">
        <div class="row" id="add-sites">
            @if($sites->count())
                @foreach($sites as $site)
                    <div data-id="{{ $site->id }}"
                         data-href="{{ route('user.task-management.schedule', $site->id) }}"
                         class="add-task col-lg-3 col-xs-6 col-md-6">
                        <div class="content">
                            <div><i class="fa fa-street-view"></i></div>
                            <div>
                                <p>{{ $site->value }}</p>
                                <p>{{ $site->address ?: 'No Address' }}</p>
                                <p>{{ $site->phone ?: 'No Phone' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-lg-12"><h2>You must add a site before do this action</h2></div>
                <div class="col-lg-12"><h4>All your tasks must be linked any of existing sites.</h4></div>
                <p class="col-lg-2">
                    <a style="margin-top: 10px;" class="btn btn-blue btn-primary" href="{{ route('user.sites') }}">Add Site</a>
                </p>
            @endif
        </div>
@endsection

@section('css')

@endsection

@section('js')

@endsection