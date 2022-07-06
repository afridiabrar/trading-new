@extends('layouts.front.app')
@section('title', 'Contact Us')
@section('content')
    <section class="headingss">
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-12 ">
                    <h1>Contact Us</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
    <section class="contact-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="clmnxx pl-5">
                        <h3>Contact Us</h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum<br>
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer<br>
                            took a galley of type and scrambled it to make a type specimen book.
                        </p>
                        <div class="cont-form">
                            <div class="contact-clmn1">
                                <form method="post" action="{!! route('contact-us') !!}" role="form">
                                    @csrf
                                    @method('POST')
                                    <div class="messages"></div>
                                    <div class="controls">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="first_name" class="form-control"
                                                           placeholder="First Name" value="{!! old('first_name') !!}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="last_name"
                                                           class="form-control" placeholder="Last Name" value="{!! old('last_name') !!}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="phone_number" class="form-control"
                                                           placeholder="Phone Number" value="{!! old('phone_number') !!}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="subject"
                                                           class="form-control" placeholder="Subject" value="{!! old('subject') !!}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="email" name="email"
                                                           class="form-control" placeholder="Email" value="{!! old('email') !!}" required pattern="([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})"
                                                           title="Please provide a valid email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                <textarea name="message" class="form-control"
                                                          placeholder="Please leave us a message." rows="4" required>{!! old('message') !!}</textarea>
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
                    </div>
                </div>
                <div class="col-sm-5">
                    <img class="img-fluid req-imgx" src="{!! frontImage('cont-img.png') !!}">
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
@endsection
