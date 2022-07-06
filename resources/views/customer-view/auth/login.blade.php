@extends('layouts.front.app')
@section('title','Login')
@section('content')
    <div class="container frmssxx">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="loginsxx">
                    <h2>Login</h2>
                    <h4>Login for a more personalized shopping experience</h4>
                    <form id="sign-in-form" autocomplete="off" method="post" role="form">
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
                                    <div class="form-group">
                                        <div class="input-group" id="show_hide_password">
                                            <input class="form-control" name="password" type="password" class="form-control"
                                                   placeholder="Password" required>
{{--                                            <div class="input-group-addon">--}}
{{--                                                <a class="eyex" href=""><i class="fa fa-eye-slash"--}}
{{--                                                                           aria-hidden="true"></i></a>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>

                                <a class="font-size-sm ml-auto mr-3" href="{{route('customer.auth.recover-password')}}">
                                    {{trans('messages.forgot_password')}}?
                                </a>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-dark btn-submit mt-3" value="Login">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="orxc">
                        <span>OR</span>
                    </div>
                    <div class="Signupx">
                        <a href="#"> Login with Google+</a>
                    </div>
                    <div class="newx">
                        New to Rchive? <a href="{!! route('customer.auth.register') !!}">Signup</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $('#sign-in-form').submit(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('customer.auth.login')}}',
                dataType: 'json',
                method: 'POST',
                data: $('#sign-in-form').serialize(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success(data.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setInterval(function () {
                            location.href = data.url;
                        }, 2000);
                    }
                },
                complete: function () {
                    $('#loading').hide();
                },
                error: function () {
                    toastr.error('Credentials do not match or account has been suspended.', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush
