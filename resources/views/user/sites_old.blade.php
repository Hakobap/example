@extends('layouts.app_dashboard')

@section('content')
    <div class="container">
        <div class="row" id="add-sites">
            <div class="col-lg-3 col-xs-6 col-md-6 site-item" data-id="" data-toggle="modal" data-target=".addSiteModal">
                <div class="content">
                    <div><i class="fa fa-street-view"></i></div>
                    <div>
                        ADD SITE
                    </div>
                </div>
            </div>

            @if($sites->count())
                @foreach($sites as $site)
                    <div class="site-item col-lg-3 col-xs-6 col-md-6" data-id="{{ $site->id }}">
                        <a class="remove-item" onclick="return confirm('Are You Sure?');" href="{{ route('user.sites.delete', $site->id) }}"><i class="fa fa-trash"></i></a>
                        <div data-toggle="modal" data-target=".addSiteModal" class="content">
                            <div><i class="fa fa-street-view"></i></div>
                            <div>
                                <p>{{ $site->value }}</p>
                                <p>{{ $site->address ?: 'No Address' }}</p>
                                <p>{{ $site->phone ?: 'No Phone' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Modal -->
        <div style="min-height: 500px;" class="modal fade addSiteModal employee-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Site</h4>
                    </div>
                    <div class="modal-body">
                        <form id="sites-form" action="{{ route('user.sites.store') }}" data-get="{{ route('user.sites.get') }}">
                            <input type="hidden" name="id">

                            <div class="form-group">
                                <input name="value" placeholder="Site Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="address" placeholder="Site Address(number, street)" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="state" placeholder="State" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="postcode" placeholder="PostCode" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="phone" placeholder="Site Phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="city" placeholder="City" class="form-control">
                            </div>
                            <div class="form-group">
                                <select name="country_id" class="form-control">
                                    <option value="">Select Country</option>
                                    @if($countries->count())
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <div style="display: flex;justify-content: space-between;align-items: center;width: 100%;margin-top: 50px;">
                                    <button class="cancle-action-btn" data-dismiss="modal" style="max-width: 48%;margin-top: 16px;">CANCEL </button>
                                    <button type="submit" class="btn btn-default blue-btn" style="max-width: 48%;margin-top: 16px;">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('css')

@endsection

@section('js')

@endsection