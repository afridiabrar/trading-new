@extends('layouts.front.app')
@section('title', 'Security')

@section('content')
    @include('web-views.users-profile.partials.account-profile-header')
    <section class="check-sec">
        <div class="container frm-prof">
            <div class="row">
                @include('web-views.users-profile.partials.account-side-menu')
                <div class="col-sm-8">
                    <div class="clmnxx">

                        <div class="cont-formxx un-brdrx Security-frmx">
                            <div class="contact-inner">
                                <form id="contact-form" method="post" action="{!! route('account-security') !!}"
                                      role="form">
                                    @csrf
                                    @method('POST')
                                    <div class="controls">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Current Password</label>
                                                    <input class="form-control" type="password"
                                                           class="form-control" name="current_password" placeholder="Current Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">New Password</label>
                                                    <input class="form-control" type="password"
                                                           class="form-control" name="password" placeholder="New Password">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">ConfirmPassword</label>
                                                    <input class="form-control" type="password"
                                                           class="form-control" name="confirm_password" placeholder="ConfirmPassword">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-dark btn-submit "
                                                       value="Submit">
                                            </div>
                                        </div>
                                    </div><!-- end -->
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
