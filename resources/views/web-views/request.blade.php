@extends('layouts.front.app')
@section('title', 'Request')
@section('content')
    <section class="headingss" >
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-12 ">
                    <h1>Request Box </h1>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
    <section class="contact-sec" >
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="clmnxx pl-5">
                        <h3>Request an Item</h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum<br>
                            has been the industry's standard dummy text ever since the 1500s, when an unknown printer<br>
                            took a galley of type and scrambled it to make a type specimen book.
                        </p>
                        <div class="cont-form">
                            <div class="contact-clmn1">
                                <form id="contact-form" method="POST" action="{!! route('request') !!}" role="form">
                                    @csrf
                                    <div class="messages"></div>
                                    <div class="controls">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" maxlength="32" name="first_name" class="form-control" placeholder="First Name" value="{!! old('first_name') !!}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" maxlength="32" name="last_name" class="form-control" placeholder="Last Name" value="{!! old('last_name') !!}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="email" maxlength="128" name="email" class="form-control" placeholder="Email" value="{!! old('email') !!}" required pattern="([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})"
                                                           title="Please provide a valid email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <select class="form-control" name="product" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $key => $product)
                                                            <option value="{!! $product->id !!}" {!! (old('product') == $product->id) ? 'selected="selected"' : '' !!} {!! (isset($_GET['productId']) && $_GET['productId'] == $product->id) ? 'selected="selected"' : '' !!}>{!! $product->name !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <input id="brand_name" type="text" name="brand_name" class="form-control" placeholder="Brand Name" required="required" data-error="Brand is required.">--}}
{{--                                                    <div class="help-block with-errors"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <div class="form-group">--}}

{{--                                                    <input type="file" class="form-control-file" id="exampleFormControlFile1">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea maxlength="1000" name="description" class="form-control" placeholder="Your Item Details" rows="4" required>{!! old('description') !!}</textarea>
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
