@extends('layouts.app_dashboard')
@section('top-menu-right')
    <div class="page-main-title">
        <h3>SITES</h3>
    </div>
@endsection
@section('content')
    <div id="add-sites" style="padding-top: 0;" class="employee-container">
        <form method="post" action="{{ route('user.employee.bulk') }}">
            @csrf

            {{--<div class="summery-inner">--}}
            {{--<div class="summery-search">--}}
            {{--<input type="text" class="form-control" placeholder="Search">--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="report-line">
                <div class="align-left">
                    <div class="summery-search">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </div>

                <div class="align-right">
                    <div class="btn-panel">
                        <a style="min-width: 155px;" href="#" data-id="0" class="btn-blue __edit_employee" data-toggle="modal" data-target=".addSiteModal">
                            Add Site
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="mt30">
                    <tr class="table-head">
                        <th scope="row">
                            <div class="check-task">
                                <div class="checkbox">
                                    <label for="checkbox">
                                        Site Name
                                    </label>
                                </div>
                            </div>
                        </th>
                        <th>
                            <p class="date-details1 text-center">Address</p>
                        </th>
                        <th>
                            <p>
                                City
                            </p>
                        </th>
                        <th>
                            State
                        </th>
                        <th>
                            Post Code
                        </th>
                        <th>
                            <p>
                                Phone
                            </p>
                        </th>
                        <th colspan="2">
                            <p>
                                Country
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="mt30">
                    @if($sites->count())
                        @foreach($sites as $site)
                            <tr>
                                <td scope="row">
                                    <div class="check-task">
                                        <div class="checkbox">
                                            <label for="checkbox">
                                                {{ $site->value }}
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="date-details1 text-center">{!! htmlspecialchars($site->address) ?: '<span style="color: red;">Not Set</span>' !!}</p>
                                </td>
                                <td>
                                    <p>
                                        {!! htmlspecialchars($site->city) ?: '<span style="color: red;">Not Set</span>' !!}
                                    </p>
                                </td>
                                <td>
                                    {!! htmlspecialchars($site->state) ?: '<span style="color: red;">Not Set</span>' !!}
                                </td>
                                <td>
                                    {!! htmlspecialchars($site->postcode) ?: '<span style="color: red;">Not Set</span>' !!}
                                </td>
                                <td>
                                    <p>
                                        {!! htmlspecialchars($site->phone) ?: '<span style="color: red;">Not Set</span>' !!}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {!! $site->country->country_name ?? '<span style="color: red;">Not Set</span>' !!}
                                    </p>
                                </td>
                                <td style="min-width: 200px;">
                                    <p style="display: flex; align-items: center;justify-content: space-between">
                                        <a class=" btn btn-info btn-sm view-site-on-map"
                                           data-address="{{ $site->getFullAddress() }}"
                                           style="font-size: 12px;height: 31px;width: 49%"
                                           href="javascript:;"> View on map </a>

                                        <a class="site-item btn btn-primary btn-sm"
                                           style="width: 19%;"
                                           data-id="{{ $site->id }}" data-toggle="modal" data-target=".addSiteModal"
                                           href="javascript:;"> <i class="fa fa-edit"></i> </a>

                                        <a class="site-item btn btn-danger btn-sm"
                                           style="width: 19%;"
                                           onclick="return confirm('Are You sure?');"
                                           href="{{ route('user.sites.delete', $site->id) }}"> <i class="fa fa-trash"></i> </a>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </form>

        <iframe
                id="site-map-view"
                width="100%"
                height="450"
                frameborder="0"
                style="border:0;display: none;"
                src=""
                allowfullscreen>
        </iframe>
    </div>


    <!-- Modal -->
    <div class="modal fade addSiteModal employee-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Site</h4>
                </div>
                <div class="modal-body">
                    <form id="sites-form" action="{{ route('user.sites.store') }}"
                          data-get="{{ route('user.sites.get') }}">
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
                                <button class="cancle-action-btn" data-dismiss="modal"
                                        style="max-width: 48%;margin-top: 16px;">CANCEL
                                </button>
                                <button type="submit" class="btn btn-default blue-btn"
                                        style="max-width: 48%;margin-top: 16px;">Add
                                </button>
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