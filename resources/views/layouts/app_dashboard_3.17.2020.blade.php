<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Web Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/style.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/reset.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/phone_prefix/css/intlTelInput.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/bootstrap-datetimepicker.min.css')}}">
    <script>
        base_url = '{{ url('/') }}';
    </script>

    <style>
        .iti.iti--allow-dropdown {
            width: 100%;
        }
        .canvasjs-chart-credit {
            display: none;
        }
    </style>
    @yield('css')
</head>
<body>
<div class="wrapper  dashboard-container">
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
                    <a href="{{ route('user.dashboard') }}">
                        HOME
                    </a>
{{--                    <a href="{{ route('user.features') }}">--}}
{{--                        FEATURES--}}
{{--                    </a>--}}
                    <a href="{{ route('user.staff') }}">
                        STAFF
                    </a>
                    <a href="{{ route('user.task-management.schedule') }}">
                        SCHEDULE
                    </a>
                    <a href="{{ route('user.onboarding') }}">
                        ONBOARDING
                    </a>
                    <a href="#">
                        PRICING
                    </a>
                    <a href="#">
                        SUPPORT
                    </a>
                    <a href="#">
                        MORE
                    </a>
                    <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        LOGOUT
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            <div class="flex-container">
                @if(!auth()->check())
                    <button type="button" class="try-btn" data-toggle="modal" data-target="#steps">Try for Free</button>
                    <a href="{{ url('/login') }}" class="login-btn">
                        Login
                    </a>
                @endif
            </div>
        </nav>
    </header>
    <div class="top-menu">
        <div class="container top-select-row">
            <div class="form-group div-decoration">
                <section>
                    <select name="potencial" name="company" id="potencial" class="custom-select sources" placeholder="Company Name">
                        @if($usersGlobal && !empty($usersGlobal))
                            @foreach($usersGlobal as $user)
                                <option value="{{ $user->id }}">{{ $user->company }}</option>
                            @endforeach
                        @endif
                    </select>
                </section>
            </div>
            <div class="div-decoration datapicker">
                <input type="text" class="form-control" id="datetimepicker1">
            </div>
            <div class="form-group div-decoration select2">
                <section>
                    <select name="potencial1" name="employee_week" id="potencial1" class="view-select custom-select sources" placeholder="Employee / Week">
                        @if($usersGlobal && !empty($usersGlobal))
                            @foreach($usersGlobal as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </section>
            </div>
            <div class="div-decoration">
                <a href="#" class="refresh-icon"> </a>
            </div>
            <div class="position-absolute right-menu">
                <div class="chat-icon"><img src="{{ asset('/site/images/question.png') }}" height="20px" width="20px" alt="question"><div class="txt-hidden">Live Chat</div></div>
                <div class="support-icon"><img src="{{ asset('/site/images/alert.png') }}" height="20px" width="20px" alt="alert"><div class="txt-hidden">Read Support</div></div>
            </div>

        </div>
    </div>

    @yield('content')
</div>

<script src="{{asset('/site/js/jquery.min.js')}}"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="{{asset('/phone_prefix/js/intlTelInput.js')}}"></script>
<script src="{{asset('/site/js/bootstrap.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script src="{{ asset('/site/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{asset('/site/js/main.js')}}"></script>
@yield('js')
</body>
</html>