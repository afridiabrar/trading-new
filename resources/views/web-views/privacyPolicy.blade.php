@extends('layouts.front.app')
@section('title', 'Privacy Policy')
@section('content')
    <div class="container">
        <div class="clmnsxx text-center">
            <h2>Privacy Policy</h2>
        </div>
    </div>
    <section class="check-sec">
        <div class="container prahx">
            <div class="row">
                <div class="col-sm-12">
                    <div class="clmnxx">
                        {!! $privacy_policy->value !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
@endsection
