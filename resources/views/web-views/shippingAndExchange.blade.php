@extends('layouts.front.app')
@section('title', 'Shipping And Exchange Policy')

@section('content')
    <div class="container text-center glasses-men">
        <h2>Shipping And Exchange Policy</h2>
        <p style="font-size: 14px;">Enjoy fast, easy shipping with RCHIVE. See below for shipping options and details.</p>
    </div>
    <div class="container prahx">
        <div class="row">
            <div class="col-sm-12">
                <div class="clmnxx">
                    {!! $shipping_and_exchange->value !!}
                </div>
            </div>
        </div>
    </div>
    <!-- end container-->
@endsection
