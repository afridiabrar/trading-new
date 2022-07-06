@extends('layouts.front.app')

@section('title', 'Checkout')

@push('css')
    <style>

        /*.payment-btn {*/
        /*    outline: 0 !important;*/
        /*    background: transparent !important;*/
        /*}*/

        /*.payment-btn:hover {*/
        /*    outline: 0;*/
        /*    background: transparent;*/
        /*    box-shadow: none !important;*/
        /*}*/

        .card0 {
            margin: 40px 12px 15px 12px;
            border: 0
        }

        .card1 {
            margin: 0;
            padding: 15px;
            padding-top: 25px;
            padding-bottom: 0px;
            background: #263238;
            height: 100%
        }

        .bill-head {
            color: #ffffff;
            font-weight: bold;
            margin-bottom: 0px;
            margin-top: 0px;
            font-size: 30px
        }

        .line {
            border-right: 1px grey solid
        }

        .bill-date {
            color: #BDBDBD
        }

        .red-bg {
            margin-top: 25px;
            margin-left: 0px;
            margin-right: 0px;
            background-color: #F44336;
            padding-left: 20px !important;
            padding: 25px 10px 25px 15px
        }

        #total {
            margin-top: 0px;
            padding-left: 7px
        }

        #total-label {
            margin-bottom: 0px;
            color: #ffffff;
            padding-left: 7px
        }

        #heading1 {
            color: #ffffff;
            font-size: 20px;
            padding-left: 10px
        }

        #heading2 {
            font-size: 27px;
            color: #D50000
        }

        .placeicon {
            font-family: fontawesome !important
        }

        .card2 {
            padding: 25px;
            margin: 0;
            height: 100%
        }

        .form-card .pay {
            font-weight: bold
        }

        .form-card input,
        .form-card textarea {
            padding: 10px 8px 10px 8px;
            border: none;
            border: 1px solid lightgrey;
            border-radius: 0px;
            margin-bottom: 25px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            font-size: 14px;
            letter-spacing: 1px
        }

        .form-card input:focus,
        .form-card textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: none;
            font-weight: bold;
            border: 1px solid gray;
            outline-width: 0
        }

        .btn-info {
            color: #ffffff !important
        }

        .radio-group {
            position: relative;
            margin-bottom: 25px
        }

        .radio {
            display: inline-block;
            width: 204;
            height: 64;
            border-radius: 0;
            background: lightblue;
            box-sizing: border-box;
            border: 2px solid lightgrey;
            cursor: pointer;
            margin: 8px 25px 8px 0px
        }

        .radio:hover {
            box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.2)
        }

        .radio.selected {
            box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.4)
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="clmnsxx text-center">
            <h2>Checkout</h2>
        </div>
    </div>
    <section class="check-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="clmnxx">
                        <h3>Select Payment Method</h3>
                        <div class="col-md-12 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 100px">
                                    <div class="col-md-12 col-sm-12 p-0 box">
                                        <div class="card rounded-0 border-0 card2" id="paypage">
                                            <div class="form-card">
                                                <div class="radio-group">
{{--                                                    <div class='radio' data-value="credit">--}}
{{--                                                        <img src="https://i.imgur.com/5TqiRQV.jpg" width="200px"--}}
{{--                                                             height="100px">--}}
{{--                                                    </div>--}}
{{--                                                    <div class='radio' data-value="paypal">--}}
{{--                                                        <img src="https://i.imgur.com/OdxcctP.jpg" width="200px"--}}
{{--                                                             height="100px">--}}
{{--                                                    </div>--}}
                                                    @php $config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'); @endphp
                                                    @if($config['status'])
                                                        <div class='radio' data-value="credit">
                                                            <a href="{!! route('checkout-complete',['payment_method'=>'cash_on_delivery']) !!}"><img
                                                                    src="{!! asset('assets/front-end/img/cod.png') !!}"
                                                                    width="200px"
                                                                    height="100px"></a>
                                                        </div>
                                                    @endif
                                                    @php $config=\App\CPU\Helpers::get_business_settings('paypal'); @endphp
                                                    @if($config['status'])
                                                        <div class='radio' data-value="credit"
                                                             onclick="submitPaypalForm()"><img
                                                                src="https://i.imgur.com/cMk1MtK.jpg"
                                                                width="200px"
                                                                height="100px">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php $config=\App\CPU\Helpers::get_business_settings('paypal'); @endphp
                @if($config['status'])
                    <form class="needs-validation" method="POST"
                          id="payment-paypal-form"
                          action="{{route('pay-paypal')}}">
                        @csrf
                    </form>
                @endif
                @include('web-views.partials._order-summary')
            </div>
        </div>
    </section>
    <!-- end container-->
@endsection

@push('js')
    <script type="text/javascript">
        function submitPaypalForm() {
            $("#payment-paypal-form").submit();
        }
    </script>
@endpush
