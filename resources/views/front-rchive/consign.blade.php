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
                        <form id="contact-form" method="post" action="" role="form">
                            <div class="messages"></div>
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="form_name" type="text" name="name" class="form-control"
                                                   placeholder="First Name" required="required"
                                                   data-error="Firstname is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="form_lastname" type="text" name="surname" class="form-control"
                                                   placeholder="Last Name" required="required"
                                                   data-error="Lastname is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="form_email" type="email" name="email" class="form-control"
                                                   placeholder="Email" required="required"
                                                   data-error="Valid email is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea id="form_message" name="message" class="form-control"
                                                      placeholder="Your Item Details" rows="4" required
                                                      data-error="Please,leave us a message."></textarea>
                                            <div class="help-block with-errors"></div>
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
                        <p style="font-size:1.33em; font-weight: 300;">Email us: <a href="mailto:consign@rchive.ca">consign@rchive.ca </a> </p>
                        <img src="{!! frontImage('camera.png') !!}">
                        <p>
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
                        <p>
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
                        <p>
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
                        <p>
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
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            What is consignment?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod tempor incididunt ut labore et dolore magna ali
                                        qua. Ut enim ad minim veniam, quis nostrud exercitation ulla
                                        mco laboris nisi ut aliquip ex ea commodo consequat.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                                           aria-controls="collapseTwo">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            What items do you accept?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod tempor incididunt ut labore et dolore magna ali
                                        qua. Ut enim ad minim veniam, quis nostrud exercitation ulla
                                        mco laboris nisi ut aliquip ex ea commodo consequat.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapseThree" aria-expanded="false"
                                           aria-controls="collapseThree">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            How do you price?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod tempor incididunt ut labore et dolore magna ali
                                        qua. Ut enim ad minim veniam, quis nostrud exercitation ulla
                                        mco laboris nisi ut aliquip ex ea commodo consequat.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingfour">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapsefour" aria-expanded="false"
                                           aria-controls="collapsefour">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            How much will I earn?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapsefour" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingfour">
                                    <div class="panel-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod tempor incididunt ut labore et dolore magna ali
                                        qua. Ut enim ad minim veniam, quis nostrud exercitation ulla
                                        mco laboris nisi ut aliquip ex ea commodo consequat.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingfive">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapsefive" aria-expanded="false"
                                           aria-controls="collapsefive">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            Can anyone consign?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapsefive" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingfive">
                                    <div class="panel-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod tempor incididunt ut labore et dolore magna ali
                                        qua. Ut enim ad minim veniam, quis nostrud exercitation ulla
                                        mco laboris nisi ut aliquip ex ea commodo consequat.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingsix">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapsesix" aria-expanded="false"
                                           aria-controls="collapsesix">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            What if my items don't sell?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapsesix" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingsix">
                                    <div class="panel-body">
                                        So, what gems do you have hidden in your closet? Do you have something valuable,
                                        but you just don’t wear it? Consider consigning with us!
                                    </div>
                                </div>
                            </div>
                        </div><!-- panel-group -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
@endsection
