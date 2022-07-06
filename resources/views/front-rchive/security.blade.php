@extends('layouts.front.app')
@section('title', 'Security')

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
                        <a href="{!! url('payment-method') !!}" class="btnx-4">Payment Method</a>
                        <a href="{!! url('order') !!}" class="btnx-4">Orders</a>
                        <a href="#" class="btnx-4">Orders History</a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="clmnxx">

                        <div class="cont-formxx un-brdrx Security-frmx">
                            <div class="contact-inner">
                                <form id="contact-form" method="post" action="" role="form">
                                    <div class="messages"></div>
                                    <div class="controls">

                                        <form id="contact-form" method="post" action="" role="form">
                                            <div class="messages"></div>
                                            <div class="controls">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Current Password</label>
                                                            <input class="form-control" type="password"
                                                                   class="form-control" placeholder="Current Password"
                                                                   required="required"
                                                                   data-error="Valid email is required.">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">New Password</label>
                                                            <input class="form-control" type="password"
                                                                   class="form-control" placeholder="New Password"
                                                                   required="required"
                                                                   data-error="Valid email is required.">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">ConfirmPassword</label>
                                                            <input class="form-control" type="password"
                                                                   class="form-control" placeholder="ConfirmPassword"
                                                                   required="required"
                                                                   data-error="Valid email is required.">
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn btn-dark btn-submit "
                                                               value="Submit">
                                                    </div>

                                                </div>
                                        </form>
                                    </div><!-- end -->
                                    <div class="col-md-6">
                                    </div><!-- end row-->
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- end container-->
@endsection
