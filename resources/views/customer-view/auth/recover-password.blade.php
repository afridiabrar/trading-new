@extends('layouts.front.app')

@section('title','Forgot Password')

@section('content')
    <div class="container frmssxx">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="loginsxx">
                    <h2>Forgot Password</h2>
                    <h4></h4>
                    <form id="sign-in-form" action="{!! route('customer.auth.forgot-password') !!}" autocomplete="off" method="post" role="form">
                        @csrf
                        <div class="messages"></div>
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="form_email" type="email" name="email" class="form-control"
                                               placeholder="Email Address" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-dark btn-submit mt-1 mb-4" value="Send Link">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
