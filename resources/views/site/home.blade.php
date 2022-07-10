@extends('layouts.app')

@section('content')
    <section class="generic-section">
        <div class="generic-section-inner container">
            <h2 class="generic-section-inner-title">{{$banner->title}}</h2>
            <p class="generic-section-inner-decoration">{{$banner->text}}</p>
            <div class="home-form">
                <form method="post" action="{{ url('/login') }}">
                    @csrf

                    @if($errors->all() && !empty($errors->all()))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="form-group">
                        <input type="email" name="email" required class="form-control" aria-describedby="emailHelp" placeholder="E-MAIL">
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control"  placeholder="Password">
                    </div>

                    <button type="submit" class="home-form-btn">{{$banner->extra}}</button>

                </form>
            </div>

        </div>
    </section>
    <section class="how-it-works container">
        <h2 class="how-it-works-title">{{$home_text1}}</h2>
        <div class="row">
            @if($howItWorks)
                @foreach($howItWorks as $howItWork)
                    <div class="col-lg-6 col-md-6">
                        <div class="h-w-inner">
                            <div class="decoration-inner">
                                <img src="{{asset($howItWork->file)}}" alt="item">
                                <div class="h-w-decoration">
                                    {{$howItWork->extra}}
                                </div>
                            </div>

                            <h2 class="h-w-title">
                                {{$howItWork->title}}
                            </h2>
                            <p class="h-w-description">
                                {{$howItWork->text}}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
            <a href="#" class="more-btn">Learn More</a>
        </div>
    </section>
    <section class="investment-section">
        <div class="container">
            <h2 class="inv-title">{{$home_text2}}</h2>
            @if($investments)
                <div class="row">
                    @foreach($investments as $investment)
                        <div class="col-lg-3">
                            <img src="{{asset($investment->file)}}" alt="item">
                            <h2 class="investment-title">{{$investment->title}}</h2>
                            <p class="investment-description">{{$investment->text}}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    <section class="faq-section">
        <h2 class="title">{{$faq_title}}</h2>
        <p class="faq-description description">{{$faq_description}}</p>
        <div class="container">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @if($faqs)
                    @php
                    $n=0;
                    @endphp
                    @foreach($faqs as $faq)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading-{{$n}}">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$n}}" aria-expanded="false" aria-controls="collapse-{{$n}}">
                                        {{$faq->question}}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-{{$n}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{$n}}">
                                <div class="panel-body">
                                    {{$faq->answer}}
                                </div>
                            </div>
                        </div>
                        @php
                            $n++;
                        @endphp
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="client-section">
        <div class="container client-section-inner">
            <h2 class="title client-title">{{$home_text5}}</h2>
            @if($clientImages)
                <div class="brands">
                    @foreach($clientImages as $clientImage)
                        <img src="{{asset($clientImage->image)}}" alt="brand {{$clientImage->sort}}">
                    @endforeach
                </div>
            @endif
            <br>
        </div>
    </section>
@endsection
