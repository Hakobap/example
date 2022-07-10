@extends('layouts.' . (isset($layout) ? $layout : 'app'))

@section('content')
    <div class="features-bg">
    </div>
    <div class="features-inner features-box  container">
        <h3>Staff Rostering Software</h3>
        <p>
            KeepShift is the simplest most powerful staff rostering tool on the market. Our aim is to save you both time
            and money, so you can get back to running a successful business rather than struggling with paperwork and
            staff communications.
            <br>
            <br>
            The scheduling module has a range of clever features to make the process of building,budgeting and
            communicating employee rosters seamless and efficient.
        </p>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 features-description features-description-left">
                    <img src="{{asset('/site/images/feauters1.png')}}" alt="item">
                    <h2>Staff Availability</h2>
                    <p>The “Daily View” uses beautiful slide bar technology to enable you to visually adjust shift times
                        to
                        meet your budget and business needs. Simply drag the start and finish time of each shift in line
                        with your business requirements and watch while the clever budgeting tool updates all the core
                        statistics live on screen.
                        <br>
                        <br>
                        This perspective makes it easy to see gaps and overlaps on each day allowing forperfect staff
                        coverage across the week all whilst staying within budget.
                    </p>
                </div>
                <div class="col-lg-6 features-description features-description-right">
                    <img src="{{asset('/site/images/feauters1.png')}}" alt="item">
                    <h2>Smart Budgeting</h2>
                    <p>The “Daily View” uses beautiful slide bar technology to enable you to visually adjust shift times
                        to
                        meet your budget and business needs. Simply drag the start and finish time of each shift in line
                        with your business requirements and watch while the clever budgeting tool updates all the core
                        statistics live on screen.

                        This perspective makes it easy to see gaps and overlaps on each day allowing forperfect staff
                        coverage across the week all whilst staying within budget.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 features-middle">
        <h3>KeepShift is the simplest most
            <br>
            powerful staff rostering tool on the market.</h3>
    </div>
    <div class="features-inner container">
        <div class="row">
            <div class="col-lg-6 features-description features-description-left">
                <img src="{{asset('/site/images/feauters1.png')}}" alt="item">
                <h2>Staff Availability</h2>
                <p>The “Daily View” uses beautiful slide bar technology to enable you to visually adjust shift times
                    to
                    meet your budget and business needs. Simply drag the start and finish time of each shift in line
                    with your business requirements and watch while the clever budgeting tool updates all the core
                    statistics live on screen.
                    <br>
                    <br>
                    This perspective makes it easy to see gaps and overlaps on each day allowing forperfect staff
                    coverage across the week all whilst staying within budget.
                </p>
            </div>
            <div class="col-lg-6 features-description features-description-right">
                <img src="{{asset('/site/images/feauters1.png')}}" alt="item">
                <h2>Smart Budgeting</h2>
                <p>The “Daily View” uses beautiful slide bar technology to enable you to visually adjust shift times
                    to
                    meet your budget and business needs. Simply drag the start and finish time of each shift in line
                    with your business requirements and watch while the clever budgeting tool updates all the core
                    statistics live on screen.

                    This perspective makes it easy to see gaps and overlaps on each day allowing forperfect staff
                    coverage across the week all whilst staying within budget.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('css')
    @if(isset($layout))
        <style>
            .top-menu {
                display: none;
            }
        </style>
    @endif
@endsection