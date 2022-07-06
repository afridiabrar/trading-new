@extends('layouts.front.app')
@section('title', 'Contact Us')
@section('content')
    <section class="headingss">
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-12 ">
                    <h1>Request Box </h1>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
    <section class="contact-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="clmnxx">
                        <h3>Request an Item</h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum<br>
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer<br>
                            took a galley of type and scrambled it to make a type specimen book.
                        </p>
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
                                                    <input id="brand_name" type="text" name="brand_name"
                                                           class="form-control" placeholder="Brand Name"
                                                           required="required" data-error="Brand is required.">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="file" class="form-control-file"
                                                           id="exampleFormControlFile1">
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
