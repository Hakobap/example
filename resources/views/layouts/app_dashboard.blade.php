<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Web Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/multiple-select/src/jquerysctipttop.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/multiple-select/src/styles.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/style.css?v=' . $script_v = 148)}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/reset.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/phone_prefix/css/intlTelInput.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/bootstrap-datetimepicker.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/dashboard.css?v=' . $script_v)}}"/>

    <style>
        .body-spinner {
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            width: 100%;
            height: 100%;
            opacity: .8;
            z-index: 1000000000000000;
        }
        .body-spinner + .spinner {
            position: fixed;
            top: 0;
            left: 0;
            background: transparent;
            width: 100%;
            height: 100%;
            opacity: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000000000000000;
        }

        input, select, label {
            font-size: 14px;
        }

        .dashboard .modal input:-ms-input-placeholder { /* Internet Explorer 10-11 */
            color:  #000 !important;
        }

        .dashboard .modal input::placeholder {
            color:  #000 !important;
        }
        #datetimepicker1 {
            color:  white !important;
        }
        .top-menu-item2 {
            margin-right: 20px;
        }
        .dashboard-site-filter select, .top-menu-item2 select {
            min-width: 155px;
            color: #2c46b3 !important;
        }
        .dashboard-site-filter select option, .top-menu-item2 select option {
            min-width: 155px;
            color: #000 !important;
        }
    </style>

    <script>
        base_url = '{{ url('/') }}';
    </script>
    @yield('css')
</head>
<body>
<div style="display:none;" id="__spinner">
    <div class="body-spinner"></div>
    <div class="spinner">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
<div class="wrapper dashboard onboarding">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark container">
            <div class="flex-row d-flex">
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('/site/images/logo.png') }}" alt="logo"></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="collapsingNavbar">
                <div>
                    <a href="{{ route('user.dashboard') }}">
                        <span class="icon dashboard"> Dashboard </span>
                    </a>

                    <a href="{{ route('user.staff') }}">
                        {{-- Roster Page| For choise employee time period  --}}
                        <span class="icon managment"> People</span>
                    </a>

                    <a href="{{ route('user.sites') }}">
                        <span class="icon rostering"> Sites</span>
                    </a>

                    <a href="{{ route('user.onboarding') }}">
                        <span class="icon tracking"> Reports</span>
                    </a>

                    <a href="{{ route('user.task-management.roster') }}">
                        <span class="icon managment"> Roster</span>
                    </a>

                    <a href="{{ route('user.task-management.tasks') }}">
                        <span class="icon to-do-list"> Tasks</span>
                    </a>

                    <a href="#">
                        <span class="icon award"> Award</span>
                    </a>

                    <a href="#">
                        <span class="icon integration"> Integration</span>
                    </a>

                    <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <span class="icon logout"> Logout</span>
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <div class="top-menu">
        @yield('top-menu-right')

        <form id="top-menu-form-filter" method="get">
            <div class="top-select-row" style="margin-left: 150px;">
                <div class="div-decoration datapicker">
                    <input type="text" class="form-control" id="datetimepicker1" name="week_date" value="{{ request('week_date', $calendarDayStart) }}" data-value="{{ request('week_date', $calendarDayStart) }}">
                </div>

                @yield('top-menu')

                <div class="position-absolute right-menu">
                    <div class="chat-icon"><img src="{{ asset('/site/images/question.png') }}" height="20px" width="20px" alt="question">
                        <div class="txt-hidden">Live Chat</div>
                    </div>
                    <div class="support-icon"><img src="{{ asset('/site/images/alert.png') }}" height="20px" width="20px" alt="alert">
                        <div class="txt-hidden">Read Support</div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @yield('content')
</div>

<script src="{{asset('/site/js/jquery.min.js')}}"></script>
<script src="{{asset('/multiple-select/src/jquery.multi-select.min.js')}}"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="{{asset('/phone_prefix/js/intlTelInput.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="{{asset('/site/js/bootstrap.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script src="{{ asset('/site/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{asset('/site/js/main.js?v=' . $script_v)}}"></script>
<script src="{{asset('/site/js/schedule.js?v=' . $script_v)}}"></script>
@yield('js')
</body>
</html>