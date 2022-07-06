@extends('layouts.front.app')

@section('title','Reset Password')

@section('content')
    <div class="container frmssxx">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="loginsxx">
                    <h2>Reset Password</h2>
                    <h4></h4>
                    <form id="sign-in-form" action="{!! route('customer.auth.password-recovery') !!}" autocomplete="off" method="post" role="form">
                        @csrf
                        <input type="hidden" name="token" value="{!! $token !!}">
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control"
                                               placeholder="Password">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="password" name="confirm_password" class="form-control"
                                               placeholder="Confirm Password">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-dark btn-submit mt-1 mb-4" value="Reset Password">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
