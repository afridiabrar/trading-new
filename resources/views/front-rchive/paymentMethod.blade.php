@extends('layouts.front.app')
@section('title', 'Payment Method')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="teext-w-icn">
                    <img class="img-fluid" src="{!! frontImage('alex.png') !!}">
                    <h4>JOHN DOE <br>
                        <span>User # 12496</span>
                    </h4>
                </div>
            </div>
            <div class="col-md-8">
                <h2 class="text-center">

                    Profile
                </h2>
            </div>
        </div>
    </div>
    <section class="check-sec">
        <div class="container frm-prof">
            <div class="row">
                <div class="col-sm-4">
                    <div class="profilx">
                        <a href="{!! route('user-account') !!}" class="btnx-4">Profile</a>
                        <a href="{!! url('security') !!}" class="btnx-4">Security</a>
                        {{-- <a href="{!! url('payment-method') !!}" class="btnx-4">Payment Method</a> --}}
                        <a href="{!! url('order') !!}" class="btnx-4">Orders</a>
                        <a href="#" class="btnx-4">Orders History</a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="clmnxx all-the-way">
                        <div class="cont-formxx un-brdrx hats-off">
                            <div class="contact-inner">
                                <form id="contact-form" method="post" action="" role="form">
                                    <div class="messages"></div>
                                    <div class="controls">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="clmnxx payment-paypal payment-methodx">
                                                        <div class="cont-formx  secure-payment">
                                                            <div class="contact-inner">
                                                                {{-- <form id="contact-form" method="post" action=""
                                                                      role="form">
                                                                    <div class="messages"></div>
                                                                    <div class="controls">
                                                                        <div class="col-md-12 padxx">

                                                                            <input type="checkbox" name="vehicle1"
                                                                                   value="Bike">
                                                                            <label for="vehicle1"> Add Debit Card or
                                                                                Credit Card <img
                                                                                    class="img-fluid card-img"
                                                                                    src="{!! frontImage('payment-card.png') !!}"></label>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Credit Card
                                                                                                Name</label>
                                                                                            <input id="city_phone"
                                                                                                   type="text"
                                                                                                   name="city"
                                                                                                   class="form-control"
                                                                                                   placeholder="Card Name"
                                                                                                   required="required"
                                                                                                   data-error="City is required.">
                                                                                            <div
                                                                                                class="help-block with-errors"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!-- end -->
                                                                            <div class="col-md-6">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Credit Card
                                                                                                Number</label>
                                                                                            <input id="city_phone"
                                                                                                   type="text"
                                                                                                   name="city"
                                                                                                   class="form-control"
                                                                                                   placeholder="Card Number"
                                                                                                   required="required"
                                                                                                   data-error="City is required.">
                                                                                            <div
                                                                                                class="help-block with-errors"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                                                            <label class="xc">Expiration
                                                                                                Date</label>
                                                                                            <input id="ex_phone"
                                                                                                   type="text"
                                                                                                   name="city"
                                                                                                   class="form-control"
                                                                                                   placeholder="Day"
                                                                                                   required="required"
                                                                                                   data-error="expiration is required.">
                                                                                            <div
                                                                                                class="help-block with-errors"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                                                            <label></label>
                                                                                            <input id="month_phone"
                                                                                                   type="text"
                                                                                                   name="month"
                                                                                                   class="form-control"
                                                                                                   placeholder="Month"
                                                                                                   required="required"
                                                                                                   data-error="month is required.">
                                                                                            <div
                                                                                                class="help-block with-errors"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                                                            <label></label>
                                                                                            <input id="year_phone"
                                                                                                   type="text"
                                                                                                   name="year"
                                                                                                   class="form-control"
                                                                                                   placeholder="Year"
                                                                                                   required="required"
                                                                                                   data-error="year is required.">
                                                                                            <div
                                                                                                class="help-block with-errors"></div>
                                                                                        </div>
                                                                                    </div>


                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 decat">
                                                                                <div class="col-md-8">
                                                                                    <div class="form-group">
                                                                                        <label>CCV</label>
                                                                                        <input id="city_phone"
                                                                                               type="text" name="ccv"
                                                                                               class="form-control"
                                                                                               placeholder="***"
                                                                                               required="required"
                                                                                               data-error="CCV is required.">
                                                                                        <div
                                                                                            class="help-block with-errors"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <p>Your personal data will be used to
                                                                                process your order, support your
                                                                                experience throughout this website, and
                                                                                for other purposes described in our
                                                                                privacy policy.</p>
                                                                            <input type="checkbox" name="vehicle1"
                                                                                   value="Bike">
                                                                            <label class="card-karo" for="vehicle1"> I
                                                                                have read and agree to the website terms
                                                                                and conditions*</label><br>
                                                                        </div><!-- end row-->
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <div
                                                                                        class="help-block with-errors"></div>
                                                                                </div>
                                                                            </div><!-- end col-md-12-->
                                                                            <div class="col-md-12">
                                                                                <input type="submit"
                                                                                       class="btn btn-dark btn-submitx "
                                                                                       value="Add Card">
                                                                            </div>
                                                                        </div><!-- end row -->

                                                                    </div>
                                                                </form> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end -->
                                    <div class="col-md-6">
                                    </div><!-- end row-->

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- end container-->\
@endsection
