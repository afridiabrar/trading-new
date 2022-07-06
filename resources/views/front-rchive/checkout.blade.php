@extends('layouts.front.app')
@section('title', 'Checkout')
@section('content')
    <div class="container">
        <div class="clmnsxx text-center">
            <h2>Checkout</h2>
        </div>
    </div>
    <section class="check-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="clmnxx">
                        <h3>Billing Details</h3>

                        <div class="cont-formx">
                            <div class="contact-inner">
                                <form id="contact-form" method="post" action="" role="form">
                                    <div class="messages"></div>
                                    <div class="controls">
                                        <div class="checkboxx">
                                            <input type="checkbox" name="vehicle1" value="Bike">
                                            <label for="vehicle1"> Save this Information for Next Order.</label><br>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input id="coupon_name" type="text" name="name" class="form-control"
                                                           placeholder="Coupon Code" required="required"
                                                           data-error="coupon is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 dismuss">
                                                <div class="form-group">

                                                    <input type="submit" class="btn btn-dark btn-coupon"
                                                           value="Apply Coupon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input id="form_email" type="email" name="email"
                                                           class="form-control" placeholder="Email" required="required"
                                                           data-error="Valid email is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

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
                                                    <input id="form_lastname" type="text" name="surname"
                                                           class="form-control" placeholder="Last Name"
                                                           required="required" data-error="Lastname is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input id="form_phone" type="text" name="phone" class="form-control"
                                                           placeholder="Phone" required="required"
                                                           data-error="Phone is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input id="address_phone" type="text" name="address"
                                                           class="form-control" placeholder="Street Address"
                                                           required="required" data-error="Address is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input id="country_phone" type="text" name="address"
                                                           class="form-control" placeholder="Country / Region"
                                                           required="required" data-error="Country is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input id="city_phone" type="text" name="city" class="form-control"
                                                           placeholder="Town / City" required="required"
                                                           data-error="City is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input id="province_phone" type="text" name="province"
                                                           class="form-control" placeholder="Province"
                                                           required="required" data-error="province is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input id="province_phone" type="text" name="postal"
                                                           class="form-control" placeholder="Province"
                                                           required="required" data-error="Postal Code* is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 padxx">

                                            <input type="checkbox" name="vehicle1" value="Bike">
                                            <label for="vehicle1"> I have read and agree to the website terms and
                                                conditions*</label><br>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Credit Card Name</label>
                                                            <input id="city_phone" type="text" name="city"
                                                                   class="form-control" placeholder="Card Name"
                                                                   required="required" data-error="City is required.">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end -->
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Credit Card Number</label>
                                                            <input id="city_phone" type="text" name="city"
                                                                   class="form-control" placeholder="Card Number"
                                                                   required="required" data-error="City is required.">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="xc">Expiration Date</label>
                                                            <input id="ex_phone" type="text" name="city"
                                                                   class="form-control" placeholder="Day"
                                                                   required="required"
                                                                   data-error="expiration is required.">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label></label>
                                                            <input id="month_phone" type="text" name="month"
                                                                   class="form-control" placeholder="Month"
                                                                   required="required" data-error="month is required.">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label></label>
                                                            <input id="year_phone" type="text" name="year"
                                                                   class="form-control" placeholder="Year"
                                                                   required="required" data-error="year is required.">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-md-5 xsw">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>CCV</label>
                                                        <input id="city_phone" type="text" name="ccv"
                                                               class="form-control" placeholder="***"
                                                               required="required" data-error="CCV is required.">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="your-personal">Your personal data will be used to process your
                                                order, support your experience throughout this website, and for other
                                                purposes described in our privacy policy.</p>
                                            <input type="checkbox" name="vehicle1" value="Bike">
                                            <label class="tcwe" for="vehicle1"> I have read and agree to the website
                                                terms and conditions*</label><br>
                                        </div><!-- end row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div><!-- end col-md-12-->
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-dark btn-submitx " value="Submit">
                                            </div>
                                        </div><!-- end row -->

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="billingx billing-b">
                        <h3>Your Order </h3>
                        <div class="totalbox">
                            <p><img src="{!! frontImage('walk.png') !!}"> Nylon Jail Jacket <span>x1</span></p>
                            <p><img src="{!! frontImage('Vintage.png') !!}">"I Saw This Future" T-shirt <span>x1</span></p>
                        </div><!-- end totalbox-->
                        <div class="totalprice">
                            <p>Subtotal <span>$385</span></p>
                            <p>Tax <span>$0.00</span></p>
                            <p class="borderlast">Shipping Cost <span>$0.00</span></p>
                            <div class="grandtotal">
                                <p>Tax <span>$385</span></p>
                            </div>
                            <a href="Paypal.php" class="btn-pay">Paypal</a>
                        </div><!-- end totalbox-->
                    </div><!-- end innerdetail -->
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->

@endsection
