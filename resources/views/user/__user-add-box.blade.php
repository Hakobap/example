<form id="add-employee-block" style="display: {{ $errors->count() ? 'block' : 'none' }};" method="post"
      data-id="{{ $id ?? 0 }}"
      data-action="{{ route('user.employee.form') }}"
      action="{{ route('user.employee.store', $employeeModel->id) }}">
    @csrf

    <div id="user-add-box" class="container tab-panel">
        <div class="tab tab-inner">
            <div class="user-deco"> {!! $employeeModel->photo ? '<img width="70px" src="'. asset('/images/user/' . $employeeModel->photo) .'" />' : '<i class="fa fa-user"></i>' !!}</div>
            <h2 class="t-user-name"> <span>{{ $employeeModel->first_name ?: 'New' }}</span> <span>{{ $employeeModel->last_name ?: 'User' }}</span> </h2>
            <button class="tablinks tab1-btn" onclick="openTab(event, 'tab1')" id="defaultOpen">General <span style="color: #ff5451;">*</span></button>
            <button class="tablinks tab2-btn" onclick="openTab(event, 'tab2')">Job Information <span style="color: #ff5451;">*</span></button>
            <button class="tablinks tab3-btn" onclick="openTab(event, 'tab3')">Profile Photo</button>
            <button class="tablinks tab4-btn" onclick="openTab(event, 'tab4')">Contact</button>
            <button class="tablinks tab5-btn" onclick="openTab(event, 'tab5')">Pay Rates & Leave</button>
            <button class="tablinks tab6-btn" onclick="openTab(event, 'tab6')">Other</button>
            {{--<button class="tablinks tab7-btn" onclick="openTab(event, 'tab7')">HR Forms</button>--}}
            <a href="#" class="back-link"> <i class="fa fa-chevron-left"></i> Back to People</a>
        </div>
        <div id="tab1" class="tabcontent">
            <h3 class="tab-title">General</h3>

            <div class="form-group">
                <label>First Name</label>
                <input value="{{ $employeeModel->first_name }}" name="first_name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input value="{{ $employeeModel->last_name }}" name="last_name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>E-Mail</label>
                <input value="{{ $employeeModel->email }}" name="email" type="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Password <p class="pull-right">The password field needs to include 6-25 charsets</p></label>
                <input name="password" type="password" autocomplete="off" class="form-control">
            </div>
            <div class="form-group">
                <label>Mobile</label>
                <input value="{{ $employeeModel->phone }}" name="phone" type="text" id="phone" class="form-control">
            </div>
            <div style="display: flex;justify-content: flex-end;" class="form-group">
                <button type="button" style="min-width: 80px;" onclick="changeTab(2, 1)" class="btn btn-primary">Next</button>
            </div>

            <button type="button" class="tab-close" data-toggle="modal" data-target="#myModal">X</button>
        </div>
        <div id="tab2" class="tabcontent">
            <h3 class="tab-title">Job Information</h3>
            <div class="form-group">
                <label style="margin-top: 10px;">Roster Start Time</label>
                <div class="slider-decoration">
                    <select name="roster_start_time" class="form-control" id="roster_start_time">
                        <option {{ $employeeModel->roster_start_time == 1 ? 'selected' : '' }} value="1">MONDAY (standard)</option>
                        <option {{ $employeeModel->roster_start_time == 2 ? 'selected' : '' }} value="2">TUESDAY</option>
                        <option {{ $employeeModel->roster_start_time == 3 ? 'selected' : '' }} value="3">WEDNESDAY</option>
                        <option {{ $employeeModel->roster_start_time == 4 ? 'selected' : '' }} value="4">THURSDAY</option>
                        <option {{ $employeeModel->roster_start_time == 5 ? 'selected' : '' }} value="5">FRIDAY</option>
                        <option {{ $employeeModel->roster_start_time == 6 ? 'selected' : '' }} value="6">SATURDAY</option>
                        <option {{ $employeeModel->roster_start_time == 7 ? 'selected' : '' }} value="7">SUNDAY</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Site They Can Work</label>
                <select size="3" multiple name="site_id[]" class="form-control" style="position: static;margin-bottom: 15px;">
                    @if($sitesForEmployees && $sitesForEmployees->count())
                        @foreach($sitesForEmployees as $site)
                            <option {{ $employeeModel->checkSite($site->id) ? 'selected' : '' }} value="{{ $site->id }}">{{ $site->value }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>Position They Can Work</label>
                <select size="3" multiple name="position_id[]" class="form-control" style="position: static;margin-bottom: 15px;">
                    @if($positions->count())
                        @foreach($positions as $position)
                            <option {{ $employeeModel->checkPosition($position->id) ? 'selected' : '' }} value="{{ $position->id }}">{{ $position->value }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>Add Position</label>
                <div class="row">
                    <div class="col-lg-12">
                        <input type="text" class="form-control add-position col-lg-8 col-md-8 col-sm-8 pull-left">
                        <button type="button" data-url="{{ route('user.employee.add-position') }}" class="save-btn col-lg-3 col-md-3 col-sm-3 pull-right">Add</button>
                    </div>
                </div>
            </div>
            <div style="display: flex;justify-content: space-between;" class="form-group">
                <button type="button" style="min-width: 80px;" onclick="changeTab(1, 2)" class="btn btn-primary">Previous</button>
                <button type="button" style="min-width: 80px;" onclick="changeTab(3, 2)" class="btn btn-primary">Next</button>
            </div>
        </div>
        <div id="tab3" class="tabcontent">
            <h3 class="tab-title">Upload Photo</h3>
            <section>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Drag a photo here</p>
                                    </div>
                                    <input id="photo-input" accept=".jpg, .jpeg, .png" type="file" name="photo" class="dropzone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 upload-decoration">
                            <button type="button" onclick="$('#photo-input').click();" class="upload-btn"><i class="fa fa-camera"></i> Upload Photo</button>
                            <div>
                                JPG,JPEG,PNG accepted
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <div style="display: flex;justify-content: space-between;" class="form-group">
                <button type="button" style="min-width: 80px;" onclick="changeTab(2, 3)" class="btn btn-primary">Previous</button>
                <button type="button" style="min-width: 80px;" onclick="changeTab(4, 3)" class="btn btn-primary">Next</button>
            </div>
        </div>
        <div id="tab4" class="tabcontent">
            <h3 class="tab-title">Main Address</h3>

            <div class="form-group">
                <label>Address</label>
                <input value="{{ $employeeModel->address }}" name="address" type="text" class="form-control">
            </div>
            <div class="form-group col-lg-8 col-sm-12  p0">
                <label>Country</label>
                <select name="country_id" class="form-control form-control-sm tab-select">
                    <option>Select Country</option>
                    @if($countries->count())
                        @foreach($countries as $country)
                            <option {{ $employeeModel->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-d">
                <div style="padding-left: 10px;" class="form-group">
                    <label>City</label>
                    <input value="{{ $employeeModel->city }}" name="city" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Post Code</label>
                    <input value="{{ $employeeModel->post_code }}" name="post_code" type="number" class="form-control">
                </div>
            </div>
            <h3 class="tab-title mt30">Emergency Contact</h3>
            <div class="form-group">
                <label>Emergency Control Name</label>
                <input value="{{ $employeeModel->emergency_control_name }}" name="emergency_control_name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Emergency Phone</label>
                <input value="{{ $employeeModel->emergency_phone }}" name="emergency_phone" type="text" class="form-control">
            </div>
            <div style="display: flex;justify-content: space-between;" class="form-group">
                <button type="button" style="min-width: 80px;" onclick="changeTab(3, 4)" class="btn btn-primary">Previous</button>
                <button type="button" style="min-width: 80px;" onclick="changeTab(5, 4)" class="btn btn-primary">Next</button>
            </div>
        </div>
        <div id="tab5" class="tabcontent">
            <h3 class="tab-title">Pay Rates and Leave</h3>

            <div class="form-group rate-inner">
                <label>Mondays</label>
                <input value="{{ $employeeModel->payRate ? $employeeModel->payRate->value1 : null }}" name="value1" type="text" class="form-control">
                <span class="rate-decoration">$per hour</span>
            </div>
            <div class="form-group rate-inner">
                <label>Tuesdays</label>
                <input value="{{ $employeeModel->payRate ? $employeeModel->payRate->value2 : null }}" name="value2" type="text" class="form-control">
                <span class="rate-decoration">$per hour</span>
            </div>
            <div class="form-group rate-inner">
                <label>Wednesdays</label>
                <input value="{{ $employeeModel->payRate ? $employeeModel->payRate->value3 : null }}" name="value3" type="text" class="form-control">
                <span class="rate-decoration">$per hour</span>
            </div>
            <div class="form-group rate-inner">
                <label>Thursdays</label>
                <input value="{{ $employeeModel->payRate ? $employeeModel->payRate->value4 : null }}" name="value4" type="text" class="form-control">
                <span class="rate-decoration">$per hour</span>
            </div>
            <div class="form-group rate-inner">
                <label>Fridays</label>
                <input value="{{ $employeeModel->payRate ? $employeeModel->payRate->value5 : null }}" name="value5" type="text" class="form-control">
                <span class="rate-decoration">$per hour</span>
            </div>
            <div class="form-group rate-inner">
                <label>Saturdays</label>
                <input value="{{ $employeeModel->payRate ? $employeeModel->payRate->value6 : null }}" name="value6" type="text" class="form-control">
                <span class="rate-decoration">$per hour</span>
            </div>
            <div class="form-group rate-inner">
                <label>Sundays</label>
                <input value="{{ $employeeModel->payRate ? $employeeModel->payRate->value7 : null }}" name="value7" type="text" class="form-control">
                <span class="rate-decoration">$per hour</span>
            </div>
            <div class="form-group rate-inner">
                <label>Public Holidays</label>
                <input value="{{ $employeeModel->payRate ? $employeeModel->payRate->public_holidays : null }}" name="public_holidays" type="text" class="form-control">
                <span class="rate-decoration">$per hour</span>
            </div>
            <div style="display: flex;justify-content: space-between;" class="form-group">
                <button type="button" style="min-width: 80px;" onclick="changeTab(4, 5)" class="btn btn-primary">Previous</button>
                <button type="button" style="min-width: 80px;" onclick="changeTab(6, 5)" class="btn btn-primary">Next</button>
            </div>
        </div>
        <div id="tab6" class="tabcontent">
            <h3 class="tab-title">Other</h3>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control form-control-sm">
                    <option {{ $employeeModel->gender == 0 ? 'selected' : '' }} value="0">Male</option>
                    <option {{ $employeeModel->gender == 1 ? 'selected' : '' }} value="1">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input value="{{ $employeeModel->date_of_birth }}" name="date_of_birth" type="date" class="form-control">
            </div>
            <div class="form-group">
                <label>Hired on</label>
                <input value="{{ $employeeModel->hired_date ?: \Carbon\Carbon::now()->format('Y-m-d') }}" name="hired_date" type="date" class="form-control">
            </div>
            <div style="display: flex;justify-content: space-between;" class="form-group">
                <button type="button" style="min-width: 80px;" onclick="changeTab(5, 6)" class="btn btn-primary">Previous</button>
                <button type="button" onclick="$(this).closest('form').submit();" class="save-btn">Save Details</button>
            </div>
        </div>
        {{--<div id="tab7" class="tabcontent">--}}
        {{--<h3 class="tab-title">tab7</h3>--}}
        {{--</div>--}}
    </div>
    {{--<div class="save-div">--}}
        {{--<button type="submit" class="save-btn">Save Details</button>--}}
    {{--</div>--}}
</form>