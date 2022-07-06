@extends('layouts.front.app')
@section('title', 'Pull')

@section('content')
    <div class="container">
        <div class="clmnsxx text-center">
            <h2>PULL</h2>
        </div>
    </div>
    <section class="check-sec">
        <div class="container prahx">
            <div class="row">
                <div class="col-sm-12">
                    <div class="clmnxx">
                        {!! $pull->value !!}
                        <!-- <h4 class="text-center">This Privacy Policy describes how your personal <br>
                        information is collected, used, and shared when you <br>
                        visit or make a purchase from rchive.ca (the “Site”).
                        </h4>
                        -->
{{--                        <h3>PERSONAL INFORMATION WE COLLECT</h3>--}}
{{--                        <p>When you visit the Site, we automatically collect certain information about your device,--}}
{{--                            including information about your web browser, IP address, time zone, and some of the cookies--}}
{{--                            that are installed on your device. Additionally, as you browse the Site, we collect--}}
{{--                            information about the individual web pages or products that you view, what websites or--}}
{{--                            search terms referred you to the Site and information about how you interact with the Site.--}}
{{--                            We refer to this automatically-collected information as “Device Information.”</p>--}}
{{--                        <p>We collect Device Information using the following technologies:</p>--}}
{{--                        <p>“Cookies” are data files that are placed on your device or computer and often include an--}}
{{--                            anonymous unique identifier. For more information about cookies, and how to disable cookies,--}}
{{--                            visit http://www.allaboutcookies.org.</p>--}}
{{--                        <p>Additionally, when you make a purchase or attempt to make a purchase through the Site, we--}}
{{--                            collect certain information from you, including your name, billing address, shipping--}}
{{--                            address, payment information, email address, and phone number. We refer to this information--}}
{{--                            as “Order Information.”</p>--}}
{{--                        <p>When we talk about “Personal Information” in this Privacy Policy, we are talking both about--}}
{{--                            Device Information and Order Information.</p>--}}
{{--                        <h3>HOW DO WE USE YOUR PERSONAL INFORMATION?</h3>--}}
{{--                        <p>We use the Order Information that we collect generally to fulfill any orders placed through--}}
{{--                            the Site (including processing your payment information, arranging for shipping, and--}}
{{--                            providing you with invoices and/or order confirmations). Additionally, we use this Order--}}
{{--                            Information to:</p>--}}
{{--                        <p>Communicate with you;</p>--}}
{{--                        <p>Screen our orders for potential risk or fraud; and</p>--}}
{{--                        <p>When in line with the preferences you have shared with us, provide you with information or--}}
{{--                            advertising relating to our products or services.</p>--}}
{{--                        <p>We use the Device Information that we collect to help us screen for potential risk and fraud--}}
{{--                            (in particular, your IP address), and more generally to improve and optimize our Site (for--}}
{{--                            example, by generating analytics about how our customers browse and interact with the Site,--}}
{{--                            and to assess the success of our marketing and advertising campaigns).</p>--}}
{{--                        <h3>SHARING YOUR PERSONAL INFORMATION</h3>--}}
{{--                        <p>We share your Personal Information with third parties to help us use your Personal--}}
{{--                            Information, as described above. For example, we use WordPress to power our online store–you--}}
{{--                            can read more about how WordPress uses your Personal Information here:--}}
{{--                            https://automattic.com/privacy/ We also use Google Analytics to help us understand how our--}}
{{--                            customers use the Site–you can read more about how Google uses your Personal Information--}}
{{--                            here: https://www.google.com/intl/en/policies/privacy/. You can also opt-out of Google--}}
{{--                            Analytics here: https://tools.google.com/dlpage/gaoptout.</p>--}}
{{--                        <p>Finally, we may also share your Personal Information to comply with applicable laws and--}}
{{--                            regulations, to respond to a subpoena, search warrant or other lawful requests for--}}
{{--                            information we receive, or to otherwise protect our rights.</p>--}}
{{--                        <!-- <h3>DO NOT TRACK</h3>--}}
{{--                        <p>Please note that we do not alter our Site’s data collection and use practices when we see a Do Not Track signal from your browser.</p>--}}
{{--                        <h3>YOUR RIGHTS</h3>--}}
{{--                        <p>If you are a European resident, you have the right to access personal information we hold about you and to ask that your personal information be corrected, updated, or deleted. If you would like to exercise this right, please contact us through the contact information below.</p>--}}
{{--                        <p>Additionally, if you are a European resident we note that we are processing your information in order to fulfill contracts we might have with you (for example if you make an order through the Site), or otherwise to pursue our legitimate business interests listed above.  Additionally, please note that your information will be transferred outside of Europe, including to Canada and the United States.</p> -->--}}
{{--                        <h3>DATA RETENTION & CHANGES</h3>--}}
{{--                        <p>When you place an order through the Site, we will maintain your Order Information for our--}}
{{--                            records unless and until you ask us to delete this information.--}}
{{--                            We may update this privacy policy from time to time in order to reflect, for example,--}}
{{--                            changes to our practices or for other operational, legal or regulatory reasons.</p>--}}
{{--                        <h3>CONTACT US</h3>--}}
{{--                        <p>For more information about our privacy practices, if you have questions, or if you would like--}}
{{--                            to make a complaint, please contact us by e-mail at info@rchive.ca</p>--}}
{{--                        <div class="cont-formx smallit">--}}
{{--                            <div class="contact-inner">--}}
{{--                                <form id="contact-form" method="post" action="" role="form">--}}
{{--                                    <div class="messages"></div>--}}
{{--                                    <div class="controls">--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="form_name" type="text" name="name" class="form-control"--}}
{{--                                                           placeholder="First Name" required="required"--}}
{{--                                                           data-error="Firstname is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="form_email" type="email" name="email"--}}
{{--                                                           class="form-control" placeholder="Email" required="required"--}}
{{--                                                           data-error="Valid email is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-12">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="form_phone" type="text" name="phone" class="form-control"--}}
{{--                                                           placeholder="Phone" required="required"--}}
{{--                                                           data-error="Phone is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-12">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="address_phone" type="text" name="address"--}}
{{--                                                           class="form-control" placeholder="Street Address"--}}
{{--                                                           required="required" data-error="Address is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-12">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="country_phone" type="text" name="address"--}}
{{--                                                           class="form-control"--}}
{{--                                                           placeholder="Media Outlet, Publication or Company"--}}
{{--                                                           required="required" data-error="Country is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="instagram_name" type="text" name="instagram"--}}
{{--                                                           class="form-control" placeholder="Instagram Username"--}}
{{--                                                           required="required" data-error="Firstname is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="form_email" type="email" name="website"--}}
{{--                                                           class="form-control" placeholder="Website or Portfolio"--}}
{{--                                                           required="required" data-error="Valid email is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-4">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="pull_name" type="text" name="pull" class="form-control"--}}
{{--                                                           placeholder="Pull Date" required="required"--}}
{{--                                                           data-error="Firstname is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-4">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="shoot_email" type="email" name="shoot"--}}
{{--                                                           class="form-control" placeholder="Shoot Date"--}}
{{--                                                           required="required" data-error="Valid email is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-4">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="return_name" type="text" name="return"--}}
{{--                                                           class="form-control" placeholder="Return Date*"--}}
{{--                                                           required="required" data-error="Firstname is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-12">--}}
{{--                                                <div class="form-group">--}}
{{--                                                <textarea id="form_message" name="message" class="form-control"--}}
{{--                                                          placeholder="Your Item Details" rows="4" required=""--}}
{{--                                                          data-error="Please,leave us a message."--}}
{{--                                                          spellcheck="false"></textarea>--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-12 padxx">--}}
{{--                                            <input type="checkbox" name="vehicle1" value="Bike">--}}
{{--                                            <label for="vehicle1"> I have read and agree to the website terms and--}}
{{--                                                conditions*</label><br>--}}
{{--                                        </div>--}}
{{--                                    </div><!-- end row-->--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <div class="help-block with-errors"></div>--}}
{{--                                            </div>--}}
{{--                                        </div><!-- end col-md-12-->--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <input type="submit" class="btn btn-dark btn-submitx " value="Submit">--}}
{{--                                        </div>--}}
{{--                                    </div><!-- end row -->--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
    <div class="container-fluid insta-feed">
        <div class="row">
            <div class="col-md-2">
                <div class="our-gllryx">
                    <img class="image-fluid" src="{!! frontImage('sc-r.png') !!}">
                </div>
                <div class="this-insta-icon">
                    <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="our-gllryx">
                    <img class="image-fluid" src="{!! frontImage('p-2.png') !!}">
                    <div class="this-insta-icon">
                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="our-gllryx">
                    <img class="image-fluid" src="{!! frontImage('nike-1.png') !!}">
                    <div class="this-insta-icon">
                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="our-gllryx">
                    <img class="image-fluid" src="{!! frontImage('sc-e.png') !!}">
                    <div class="this-insta-icon">
                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="our-gllryx">
                    <img class="image-fluid" src="{!! frontImage('sc-f.png') !!}">
                    <div class="this-insta-icon">
                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="our-gllryx">
                    <img class="image-fluid" src="{!! frontImage('p-1.png') !!}">
                    <div class="this-insta-icon">
                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
