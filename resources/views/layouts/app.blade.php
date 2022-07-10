<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rostering</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/style.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/reset.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/phone_prefix/css/intlTelInput.css')}}">

    <style>
        #step1 span,
        #step2 span,
        #step3 span,
        #step4 span,
        #step5 span {
            color: red;
            font-size: 11px;
        }
        #step1 label,
        #step2 label,
        #step3 label,
        #step4 label,
        #step5 label {
            display: flex;
            justify-content: space-between;
        }

        .site-field i, .site-field-2 i {
            cursor: pointer;
        }
        .site-field, .site-field-2 {
            margin-bottom: 10px;
        }
        .site-field:first-child i, .site-field-2:first-child i {
            display: none;
        }
        .step1 {
            max-height: 98%;
            overflow: auto !important;
        }

        #accordion .panel h4 {
            margin-bottom: 0;
            border-bottom: 1px solid #2c46b3;
        }
        #accordion .panel a {
            border-bottom: none;
        }
        #accordion .panel-heading {
            height: 100%;
        }
    </style>

    <script>
        localStorage.setItem('active-step', {{ \App\Services\SessionSteps::getInstance()->activeStep }});

        base_url = '{{url('/')}}';
    </script>
</head>
<body>
<div class="wrapper home">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark container">
            <div class="flex-row d-flex">
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{asset('/assets/site/settings/logo.png')}}" alt="logo"></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="collapsingNavbar">
                <div>
                    <a href="{{ route('home') }}">
                        HOME
                    </a>
                    <a href="{{ route('site.features') }}">
                        FEATURES
                    </a>
                    <a href="{{ route('site.pricing') }}">
                        PRICING
                    </a>
                    <a href="{{ route('site.support') }}">
                        SUPPORT
                    </a>
                    <a href="{{ route('site.more') }}">
                        MORE
                    </a>
                    @if(auth()->check())
                        <a style="padding: 17px;" href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            LOGOUT
                        </a>
                    @endif
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            <div class="flex-container">
                @if(!auth()->check())
                    <button type="button" class="try-btn" data-toggle="modal" data-target="#steps">Try for Free</button>
                    <a href="{{ url('/#home-form') }}" class="login-btn ">
                        Login
                    </a>
                @endif
            </div>
        </nav>
    </header>

    <div>
        @yield('content')
    </div>

    <footer>
        <div class="container">
            <a href="{{ url('/') }}"> <img src="{{asset('/assets/site/settings/logo.png')}}" alt="logo" class="footer-logo">  </a>
            <div class="row">
                <div class="col-lg-4 col-md-6 footer-inner">
                    <a href="{{ url('/') }}">  Home</a>
                    <a onclick="$('.login-btn').click(); return false;" href="">  Login</a>
                    <a href="{{ route('site.pricing') }}">  Pricing</a>
                    <a href="{{ route('site.features') }}">  Features</a>
                    <a href="{{ route('site.more') }}">  More</a>

                </div>
                <div class="col-lg-4 col-md-4 footer-inner">
                    <a href="{{ route('site.about') }}">  About</a>
                    <a href="{{ route('site.contact') }}">  Contact</a>
                    <a href="{{ route('site.support') }}">  Support</a>
                    <a href="{{ route('site.terms-and-conditions') }}">  Terms and Conditions</a>
                    <a href="{{ route('site.privacy-policy') }}">  Privacy Policy</a>
                </div>
                <div class="col-lg-4 col-md-4 footer-inner">
                    <a onclick="$('.login-btn').click(); return false;" href="">  Login</a>
                    <a onclick="$('.try-btn').click();" href="#">  Try for Free</a>
                </div>
            </div>
        </div>
    </footer>
</div>
{{--/***********steps***********/--}}

{{--/******step1***********/--}}
<div id="steps" class="steps step1 modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Welcome to KeepShift</h4>
                <p>Let's get rostering setup for your workplace.</p>
            </div>
            <div class="step-inner">
                <ul class="step-flex">
                    <li>
                        <a href="#">
                            <span>Step-1 </span>
                            <div class="step-decoration"></div>
                            <p>Account</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-2 </span>
                            <div class="step-decoration"></div>
                            <p>Sites</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-3 </span>
                            <div class="step-decoration"></div>
                            <p>Positions</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-4 </span>
                            <div class="step-decoration"></div>
                            <p>Staff</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-5 </span>
                            <div class="step-decoration"></div>
                            <p>Roster</p>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="modal-body">
                <form id="step1">
                    <div class="form-group">
                        <label for="f-name">First Name</label>
                        <input name="first_name" value="{{ \App\Services\SessionSteps::getInstance()->getValue(1, 'first_name') }}" type="text" class="form-control" id="f-name"  placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="l-name">Last  Name</label>
                        <input name="last_name" value="{{ \App\Services\SessionSteps::getInstance()->getValue(1, 'last_name') }}" type="text" class="form-control" id="l-name" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value="{{ \App\Services\SessionSteps::getInstance()->getValue(1, 'email') }}" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="phone">Mobile Number</label>
                        <input name="phone" value="{{ \App\Services\SessionSteps::getInstance()->getValue(1, 'phone') }}" type="text" id="phone" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="c-name">Company Name</label>
                        <input name="company" value="{{ \App\Services\SessionSteps::getInstance()->getValue(1, 'company') }}" type="text" class="form-control" id="c-name" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="psw">Create Password</label>
                        <input name="password" value="" type="password" class="form-control" id="psw" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group select-date">
                        <label for="roster_start_time">Start my weekly roster on:</label>
                        <div class="slider-decoration">
                            @php
                            $weekDay = \App\Services\SessionSteps::getInstance()->getValue(1, 'roster_start_time');
                            @endphp
                            <select name="roster_start_time" class="form-control" id="roster_start_time">
                                <option {{ $weekDay == 1 ? 'selected' : ''}} value="1">MONDAY (standard)</option>
                                <option {{ $weekDay == 2 ? 'selected' : ''}} value="2">TUESDAY</option>
                                <option {{ $weekDay == 3 ? 'selected' : ''}} value="3">WEDNESDAY</option>
                                <option {{ $weekDay == 4 ? 'selected' : ''}} value="4">THURSDAY</option>
                                <option {{ $weekDay == 5 ? 'selected' : ''}} value="5">FRIDAY</option>
                                <option {{ $weekDay == 6 ? 'selected' : ''}} value="6">SATURDAY</option>
                                <option {{ $weekDay == 7 ? 'selected' : ''}} value="7">SUNDAY</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-step="1" class="btn btn-default blue-btn next-step">Next Step</button>
            </div>
        </div>
    </div>
</div>
{{--/******end step1***********/--}}
{{--/******step2***********/--}}
<div id="steps" class="modal fade steps step2" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <div class="modal-content" style="overflow: auto; max-height: 463px;">
            <div class="modal-header">
                <h4 class="modal-title">Welcome to KeepShift</h4>
                <p>It's time to create sites for your business. </p>
            </div>
            <div class="step-inner">
                <ul class="step-flex">
                    <li>
                        <a href="#">
                            <span>Step-1 </span>
                            <div class="step-decoration"></div>
                            <p>Account</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-2 </span>
                            <div class="step-decoration"></div>
                            <p>Sites</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-3 </span>
                            <div class="step-decoration"></div>
                            <p>Positions</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-4 </span>
                            <div class="step-decoration"></div>
                            <p>Staff</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-5 </span>
                            <div class="step-decoration"></div>
                            <p>Roster</p>
                        </a>
                    </li>
                </ul>
            </div>

            <?php
            $siteNames = \App\Services\SessionSteps::getInstance()->getValue(2, 'site')
            ?>

            <div class="modal-body">
                <form id="step2">
                    <div class="site-field-errors alert alert-danger" style="display: none;"></div>
                    <div class="form-group">
                        <label for="company">Company Name:</label>
                        <input type="text" value="{{ \App\Services\SessionSteps::getInstance()->getValue(1, 'company') }}" readonly class="form-control" id="company" aria-describedby="emailHelp" placeholder="Displays the entered information of step 1">
                    </div>
                    <div class="form-group site-names">
                        @if($siteNames)
                            @foreach($siteNames as $key => $site)
                                <div class="site-field">
                                    <label for="site">Site Name:</label>
                                    <input type="text" name="site[]" class="form-control" value="{{ $site }}" placeholder="">
                                    <i style="margin-bottom: 10px;margin-bottom: 10px;margin-top: 6px;color: blue;" onclick="$(this).parent().remove();" class="fa fa-trash"> Remove</i>
                                </div>
                            @endforeach
                        @else
                            <div class="site-field">
                                <label for="site">Site Name:</label>
                                <input type="text" name="site[]" class="form-control" placeholder="">
                                <i style="margin-bottom: 10px;margin-bottom: 10px;margin-top: 6px;color: blue;" onclick="$(this).parent().remove();" class="fa fa-trash"> Remove</i>
                            </div>
                        @endif
                    </div>
                </form>
                <a href="#" onclick="$('.site-names').append($('.site-field:first-child').clone().val(''));" class="add-btn">Add Site</a>
            </div>
            <div class="modal-footer">
                <button type="button" data-step="1" class="btn btn-default grey-btn prev-step">Back</button>
                <button type="button" data-step="2" class="btn btn-default blue-btn next-step">Next Step</button>
            </div>
        </div>

    </div>
</div>
{{--/******end step2***********/--}}

{{--/******step3***********/--}}
<div id="steps" class="steps modal step3 fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content" style="overflow: auto;max-height: 466px;">
            <div class="modal-header">
                <h4 class="modal-title">Welcome to KeepShift</h4>
                <p>Create the types of positions you will roster.
                    These are specific job roles </p>
            </div>
            <div class="step-inner">
                <ul class="step-flex">
                    <li>
                        <a href="#">
                            <span>Step-1 </span>
                            <div class="step-decoration"></div>
                            <p>Account</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-2 </span>
                            <div class="step-decoration"></div>
                            <p>Sites</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-3 </span>
                            <div class="step-decoration"></div>
                            <p>Positions</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-4 </span>
                            <div class="step-decoration"></div>
                            <p>Staff</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-5 </span>
                            <div class="step-decoration"></div>
                            <p>Roster</p>
                        </a>
                    </li>
                </ul>
            </div>

            <?php
            $positions = \App\Services\SessionSteps::getInstance()->getValue(3, 'position')
            ?>

            <div class="modal-body">
                <form id="step3">
                    <div class="site-field-errors alert alert-danger" style="display: none;"></div>
                    <div class="form-group site-names-2">
                        @if($positions)
                            @foreach($positions as $key => $position)
                                <div class="site-field-2">
                                    <label for="usr">Position Title:</label>
                                    <input type="text" name="position[]" class="form-control" value="{{ $position }}" id="position" aria-describedby="emailHelp" placeholder="">
                                    <i style="margin-bottom: 10px;margin-bottom: 10px;margin-top: 6px;color: blue;" onclick="$(this).parent().remove();" class="fa fa-trash"> Remove</i>
                                </div>
                            @endforeach
                        @else
                            <div class="site-field-2">
                                <label for="usr">Position Title:</label>
                                <input type="text" name="position[]" class="form-control" id="position" aria-describedby="emailHelp" placeholder="">
                                <i style="margin-bottom: 10px;margin-bottom: 10px;margin-top: 6px;color: blue;" onclick="$(this).parent().remove();" class="fa fa-trash"> Remove</i>
                            </div>
                        @endif
                    </div>

                </form>
                <a href="#" onclick="$('.site-names-2').append($('.site-field-2:first-child').clone().val(''))" class="add-btn">Add Position</a>
            </div>
            <div class="modal-footer">
                <button type="button" data-step="2" class="btn btn-default grey-btn prev-step">Back</button>
                <button type="button" data-step="3" class="btn btn-default blue-btn next-step">Next Step</button>
            </div>
        </div>

    </div>
</div>
{{--/******end step3***********/--}}
{{--/******step4***********/--}}
<div id="steps" style="min-height: 711px;" class="steps step4 modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content" style="overflow: auto; height: 661px;">
            <div class="modal-header">
                <h4 class="modal-title">Welcome to KeepShift</h4>
                <p>Select the sites and positions each employee
                    can work.</p>
            </div>
            <div class="border"></div>
            <div class="step-inner">
                <ul class="step-flex">
                    <li>
                        <a href="#">
                            <span>Step-1 </span>
                            <div class="step-decoration"></div>
                            <p>Account</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-2 </span>
                            <div class="step-decoration"></div>
                            <p>Sites</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-3 </span>
                            <div class="step-decoration"></div>
                            <p>Positions</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-4 </span>
                            <div class="step-decoration"></div>
                            <p>Staff</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-5 </span>
                            <div class="step-decoration"></div>
                            <p>Roster</p>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="modal-body">
                <form id="step4">
                    <div class="form-group">
                        <label for="f-name-2">First Name</label>
                        <input type="text" name="first_name" value="{{ \App\Services\SessionSteps::getInstance()->getValue(4, 'first_name') }}" class="form-control" id="f-name-2" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="l-name-2">Last  Name</label>
                        <input type="text" name="last_name" value="{{ \App\Services\SessionSteps::getInstance()->getValue(4, 'last_name') }}" class="form-control" id="l-name-2" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="email-2">Email</label>
                        <input type="text" name="email" value="{{ \App\Services\SessionSteps::getInstance()->getValue(4, 'email') }}" class="form-control" id="email-2" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="phone">Mobile Number</label>
                        <input name="phone" value="{{ \App\Services\SessionSteps::getInstance()->getValue(4, 'phone') }}" type="text" id="phone_2" class="form-control" />
                    </div>
                    <div style="font-size: 17px;color: #2c46b3;margin-top: 25px;" class="form-group">
                        <i class="fa fa-users"></i> SITES THEY CAN WORK: <i style="cursor: pointer;" class="fa fa-plus add-site pull-right"></i>
                    </div>
                    <div class="form-group field-sites-options" style="display: none;">
                        <div style="display: flex;justify-content: space-between;">

                        </div>
                    </div>
                    <div style="font-size: 17px;color: #2c46b3;" class="form-group">
                        <i class="fa fa-user-plus"></i> POSITIONS THEY CAN WORK: <i style="cursor: pointer;" class="fa fa-plus add-position pull-right"></i>
                    </div>
                    <p id="error-position" style="color: red;font-size: 18px;position: absolute;bottom: 4px;display: none;">Please Add Site And Position Fields.</p>
                    <div class="form-group field-positions-options" style="display: none;">
                        <div style="display: flex;justify-content: space-between;">

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-step="3" class="btn btn-default grey-btn prev-step">Back</button>
                <button type="button" data-step="4" class="btn btn-default blue-btn next-step">Next Step</button>
            </div>
        </div>
    </div>
</div>
{{--/******end step4***********/--}}
{{--/******step5***********/--}}
<div id="steps" class="steps step5 modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Welcome to KeepShift</h4>
                <p>Check our registry.</p>
            </div>
            <div class="step-inner">
                <ul class="step-flex">
                    <li>
                        <a href="#">
                            <span>Step-1 </span>
                            <div class="step-decoration"></div>
                            <p>Account</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-2 </span>
                            <div class="step-decoration"></div>
                            <p>Sites</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-3 </span>
                            <div class="step-decoration"></div>
                            <p>Positions</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-4 </span>
                            <div class="step-decoration"></div>
                            <p>Staff</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Step-5 </span>
                            <div class="step-decoration"></div>
                            <p>Roster</p>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="modal-body">
                <img src="{{asset('/site/images/center1.png')}}" alt="item">
            </div>
            <div class="modal-footer">
                <button type="button" data-step="4" class="btn btn-default grey-btn prev-step">Back</button>
                <button type="button" data-step="5" class="btn btn-default blue-btn next-step">Let's Start</button>
            </div>
        </div>
    </div>
</div>
{{--/******end step5***********/--}}

<script src="{{asset('/site/js/jquery.min.js')}}"></script>
<script src="{{asset('/site/js/bootstrap.js')}}"></script>
<script src="{{asset('/phone_prefix/js/intlTelInput.js')}}"></script>
<script src="{{asset('/site/js/main.js')}}"></script>
</body>
</html>