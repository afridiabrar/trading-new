@extends('layouts.front.app')
@section('title', 'Consign')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center abss">
                <h2>
                    Consign Now
                </h2>
            </div>
        </div>
    </div><!-- end container-->
    <div class="container Consign">
        <div class="row">
            <div class="col-sm-5">
                <img class="img-fluid" src="{!! frontImage('hanger.png') !!}">
            </div>
            <div class="col-sm-7  ">
                <h4>Do you have items you’re looking to part ways<br>
                    with but still want to get your money’s worth?</h4>
                <div class="cont-form">
                    <div class="contact-clmn1">
                        <form method="POST" action="{!! route('consign') !!}" role="form">
                            @csrf
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="first_name" type="text" name="first_name" class="form-control"
                                                   placeholder="First Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="last_name" type="text" name="last_name" class="form-control"
                                                   placeholder="Last Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="email" type="email" name="email" class="form-control"
                                                   placeholder="Email" pattern="([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})"
                                                   title="Please provide a valid email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea id="form_message" name="details" class="form-control"
                                                      placeholder="Your Item Details" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-dark btn-submit " value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <h5>IT’S EASY. YOU CAN EARN UP TO 85%</h5>
                <p>
                    Consignment has become increasingly popular within the fashion industry, and we are so excited to
                    <br>
                    be a part of it! As we are all trying to avoid fast fashion brands, consignment is changing the
                    industry <br>
                    by re-purposing high-quality, valuable goods. We understand that with consignment comes a great <br>
                    deal of trust, which is why we work hard to nurture strong relationships with our consignors. <br>
                </p>
                <p>
                    We’ve created a simple consignment process that makes selling your clothes online hassle-free! We
                    <br>
                    accept a wide variety of brands and items (clothing, footwear, accessories) at great competitive
                    rates <br>
                    and with complete transparency. At RCHIVE, we pride ourselves on our carefully selected, authentic
                    <br>
                    collections, and with sustainability being one of our central values, we’re also mindful of our <br>
                    environmental impact. By consigning with us, not only are you extending the life cycle of your <br>
                    valuable goods, but you’re also showcasing them to a pre-existing and loyal customer base. <br>
                </p>
            </div>
        </div>
    </div><!-- end container-->
    <section class="send-us">
        <div class="container">
            <div class="row">
                <div class="col-sm-1 text-center">
                </div>
                <div class="col-sm-5 text-center">
                    <div class="photo">
                        <h4>SEND US PHOTOS</h4>
                        <p class="text-center line-height-1">Email us: <a href="mailto:consign@rchive.ca">consign@rchive.ca </a> </p>
                        <img src="{!! frontImage('camera.png') !!}">
                        <p class="center">
                            We accept a wide variety of items <br>
                            (clothing, footwear, accessories) <br>
                            and brands at great competitive <br>
                            rates and with complete <br>
                            transparency. See our Brand <br>
                            Directory
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center">
                    <div class="photo1">
                        <h4>AUTHENTICATION + QUOTE</h4>
                        <img src="{!! frontImage('original.png') !!}">
                        <p class="center">
                            Items must get approval from our <br>
                            authenticators before being <br>
                            accepted. For more information, <br>
                            please see our Authentication <br>
                            Process
                        </p>
                    </div>
                </div>
                <div class="col-sm-1 text-center">
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
    <section class="send-us">
        <div class="container">
            <div class="row">
                <div class="col-sm-1 text-center">
                </div>
                <div class="col-sm-5 text-center">
                    <div class="photo2">
                        <h4>SHIP / DELIVER</h4>
                        <img src="{!! frontImage('shipped.png') !!}">
                        <p class="center">
                            As we are a Toronto based brand, <br>
                            we offer at home pick-up service <br>
                            for those in the GTA area. You can <br>
                            also ship your items to us for free.<br>
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center">
                    <div class="photo3">
                        <h4>GET PAID!</h4>
                        <img src="{!! frontImage('paid.png') !!}">
                        <p class="center">
                            Choose to be paid by direct <br>
                            deposit, mailed cheque or in- <br>
                            store credit. Get paid when <br>
                            your item sells.
                        </p>
                    </div>
                </div>
                <div class="col-sm-1 text-center">
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
    <section class="faqxx">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="faqsss-tabs">
                        <h2>FAQ</h2>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            @foreach($help_topics as $key => $help_topic)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne{!! $key !!}">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseOne{!! $key !!}" aria-expanded="true" aria-controls="collapseOne{!! $key !!}">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                {!! $help_topic->question !!}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne{!! $key !!}" class="panel-collapse collapse" role="tabpanel"
                                         aria-labelledby="headingOne{!! $key !!}">
                                        <div class="panel-body">
                                            {!! $help_topic->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- panel-group -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
@endsection
