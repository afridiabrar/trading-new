
<!-- Head Include -->
@extends('layouts.front.app')

@section('title','Welcome To '. $web_config['name']->value.' Contact Us')

@section('content')
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ frontCss('contactus.css') }}">
<!-- Stylesheet -->

<!-- Conversation Form Start Here -->
<section class="Conversationform">
    <div class="container">
        <div class="heading">
            <h1>Let’s Start a Conversation</h1>
            <p>
                Browse our collection of recipes to help inspire healthy cooking in the week.
                Filter by dietary preference and add your favourite meals to your weekly meal planning diary to
                help with grocery shopping and organisation in the week.
            </p>
        </div>
        <form method="post" action="{{ route('contact-us') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First Name*</label>
                        <input type="text" name="first_name" required class="form-control" placeholder="First Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name*</label>
                        <input type="text" name="last_name" required class="form-control" placeholder="Last Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact email*</label>
                        <input type="email" name="email" class="form-control" placeholder="you@example.com">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone Number*</label>
                        <input type="tel" name="phone_number" required class="form-control" placeholder="Company name">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Subject*</label>
                        <input type="text" name="subject" required class="form-control" placeholder="Subject">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Your message*</label><br />
                        <textarea class="form-control" name="message" required placeholder="Type your message…."></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>By submitting this form you agree to our terms and conditions and our Privacy Policy
                            which explains how we may collect, use and disclose your personal information including to
                            third parties.</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Conversation Form Start Here -->

<!-- Faqs Start Here -->
<section class="Faqs">
    <div class="container">
        <div class="head">
            <h3>FAQs</h3>
            <h1>Some Useful information</h1>
        </div>
        <div id="accordion">
            <div class="row">
                @foreach($help_topics as $k=>$v)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" id="heading{{ $k }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $k }}"
                                            aria-expanded="true" aria-controls="collapse{{ $k }}">
                                        <span>{{ $v->question }}</span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{ $k }}" class="collapse {{ ($k == 0)? 'show' : '' }}"
                                 aria-labelledby="heading{{ $k }}"
                                 data-parent="#accordion">
                                <div class="card-body">
                                    {!! $v->answer !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Faqs End Here -->

<!-- Info Section Start Here -->
<section class="infoSec text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="email-box info-box">
                    <div class="img-box">
                        <figure><img src="{{ frontImage('email.png') }}" alt=""></figure>
                    </div>
                    <div class="contentDv">
                        <h4>Email us</h4>
                        <p>
                            Email us for general queries, including marketing and partnership opportunities.
                        </p>
                        <a href="mailto:hello@helpcenter.com">hello@helpcenter.com</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="call-box info-box">
                    <div class="img-box">
                        <figure><img src="{{ frontImage('phone.png') }}" alt=""></figure>
                    </div>
                    <div class="contentDv">
                        <h4>Call us</h4>
                        <p>
                            Call us to speak to a member of our team. We are always happy to help.
                        </p>
                        <a href="tel:+16467865060">+1 (646) 786-5060</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="support-box info-box">
                    <div class="img-box">
                        <figure><img src="{{ frontImage('support.png') }}" alt=""></figure>
                    </div>
                    <div class="contentDv">
                        <h4>Support</h4>
                        <p>
                            Check out helpful resources, FAQs and developer tools.
                        </p>
                        <a href="#">Support Center</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Info Section Start Here -->

<!-- Footer include -->
@endsection
<!-- Footer include -->
