@extends('layouts.front.app')

@section('title', 'Checkout Details')
@push('css')
    <style>
        input.form-control.coupon {
            padding: 20px;
        }

        .billing-b {
            background: #E5E5E5 !important;
            border-radius: 10px !important;
            padding: 20px !important;
            top: 0px !important;
        }

        textarea.form-control {
            border-radius: 10px !important;
            height: 120px !important;
            border-color: #0c0c0c !important;
        }

        li.list-group-item.mb-2.mt-2 {
            font-size: 14px;
            padding: 25px;
            border-top: 1px solid #000;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="clmnsxx text-center">
            <h2>Checkout Details</h2>
        </div>
    </div>
    <section class="check-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="clmnxx">
                        <h3>Shipping Method</h3>
                        <div class="card-body" style="padding: 0px !important;">
                            <ul class="list-group">
                                <li class="list-group-item mb-2 mt-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control" id="shipping_method_id"
                                                        onchange="set_shipping_id(this.value)">
                                                    <option value="0">Choose Shipping Method</option>
                                                    @foreach($shipping_methods as $shipping)
                                                        <option
                                                            value="{!! $shipping->id !!}" {!! session()->has('shipping_method_id') ? session('shipping_method_id') == $shipping['id'] ? 'selected' : '' : '' !!}>{!! $shipping['title'].' ('.$shipping['duration'].') ' . '$' . $shipping['cost'] !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <h3>Billing Details</h3>


                        <div class="card-body" style="padding: 0px !important;">
                            <form id="contact-form" method="post"
                                  action="{!! route('customer.process-shipping-address') !!}" role="form">
                                @csrf
                                @method('POST')
                                <ul class="list-group">
                                    @foreach($shipping_addresses as $key => $address)
                                        <li class="list-group-item mb-2 mt-2"
                                            style="cursor: pointer;background: rgba(245,245,245,0.51)"
                                            onclick="$('#sh-{{$address['id']}}').prop( 'checked', true )">
                                            <input type="radio" name="shipping_address_id"
                                                   id="sh-{{$address['id']}}"
                                                   value="{{$address['id']}}" {!! ($key == 0) ? 'checked' : '' !!}>
                                            <label class="badge"
                                                   style="background: #86b672; color:white !important;">{{$address['address_type']}}</label>
                                            <small>
                                                <i class="fa fa-phone"></i> {{$address['phone']}}
                                            </small>
                                            <hr>
                                            <span>{{ trans('messages.contact_person_name')}}: {{$address['contact_person_name']}}</span><br>
                                            <span>{{ trans('messages.address')}} : {{$address['address']}}, {{$address['city']}}, {{$address['zip']}}, {{$address['country']}}.</span>
                                        </li>
                                    @endforeach
                                    <li class="list-group-item mb-2 mt-2" style="cursor: pointer; list-style-type:none;"
                                        onclick="anotherAddress()">
                                        <input type="radio" name="shipping_address_id"
                                               id="sh-0" value="0" data-toggle="collapse"
                                               data-target="#collapseThree" {!! ($shipping_addresses->count() == 0 && old('shipping_address_id') == 0) ? 'checked' : '' !!}>
                                        <label class="badge"
                                               style="background: #86b672; color:white !important;">
                                            <i class="fa fa-plus-circle"></i></label>
                                        <B data-toggle="collapse"
                                           data-target="#collapseThree">{{ trans('messages.Another')}} {{ trans('messages.address')}} </B>
                                        {{-- <button type="button" class="btn btn-dark btn-submitx" data-toggle="collapse"
                                                data-target="#collapseThree">{{ trans('messages.Another')}} {{ trans('messages.address')}}
                                        </button> --}}
                                        <div class="cont-formx" id="accordion">
                                            <div
                                                class="contact-inner collapse {!! ($shipping_addresses->count() == 0 && old('shipping_address_id') == 0) ? 'show' : '' !!}"
                                                id="collapseThree"
                                                aria-labelledby="headingThree"
                                                data-parent="#accordion">
                                                <div class="messages"></div>
                                                <div class="controls">
                                                    <div class="checkboxx">
                                                        <input type="checkbox" name="save_address">
                                                        <label for="save_address"> Save this Information for Next
                                                            Order.</label><br>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" name="contact_person_name"
                                                                       class="form-control"
                                                                       value="{!! old('contact_person_name') !!}"
                                                                       placeholder="Contact Person Name" {!! ($shipping_addresses->count()==0) ? 'required' : '' !!}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" name="phone"
                                                                       class="form-control" value="{!! old('phone') !!}"
                                                                       placeholder="Phone" {!! ($shipping_addresses->count()==0) ? 'required' : '' !!}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <select class="form-control"
                                                                        name="address_type" {!! ($shipping_addresses->count()==0) ? 'required' : '' !!}>
                                                                    <option
                                                                        value="permanent" {!! (old('address_type') == 'permanent') ? "selected" : '' !!}>{{ trans('messages.Permanent')}}</option>
                                                                    <option
                                                                        value="home" {!! (old('address_type') == 'home') ? "selected" : '' !!}>{{ trans('messages.Home')}}</option>
                                                                    <option
                                                                        value="others" {!! (old('address_type') == 'others') ? "selected" : '' !!}>{{ trans('messages.Others')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" name="country"
                                                                       value="{!! old('country') !!}"
                                                                       class="form-control"
                                                                       placeholder="Country" {!! ($shipping_addresses->count()==0) ? 'required' : '' !!}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" name="city"
                                                                       value="{!! old('city') !!}"
                                                                       class="form-control"
                                                                       placeholder="City" {!! ($shipping_addresses->count()==0) ? 'required' : '' !!}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="text" name="zip" value="{!! old('zip') !!}"
                                                                       class="form-control"
                                                                       placeholder="Zip Code" {!! ($shipping_addresses->count()==0) ? 'required' : '' !!}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <textarea name="address"
                                                                          class="form-control"
                                                                          placeholder="Street Address" {!! ($shipping_addresses->count()==0) ? 'required' : '' !!}>{!! old('address') !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 padxx">
                                                        <input type="checkbox"
                                                               name="term_and_condition" {!! ($shipping_addresses->count()==0) ? 'required' : '' !!} {!! (old('term_and_condition') == 'on') ? 'checked' : '' !!}>
                                                        <label for="term_and_condition"> I have read and agree to the
                                                            website
                                                            terms and conditions*</label><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="submit" id="proceedToPayment" class="btn btn-dark btn-submitx"
                                                   value="Proceed to payment">
                                        </div>
                                    </div>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
                @include('web-views.partials._order-summary')
            </div>
        </div>
    </section>
    <!-- end container-->
@endsection

@push('js')
    <script type="text/javascript">
        function anotherAddress() {
            $('#sh-0').prop('checked', true);
            $("#collapseThree").collapse();
        }

        function set_shipping_id(id) {
                @foreach(session()->get('cart') as $key => $item)
            let key = '{{$key}}';
            @break
            @endforeach
            $.ajax({
                url: '{!! route('customer.set-shipping-method') !!}',
                'type': 'get',
                dataType: 'json',
                data: {
                    id: id,
                    key: key
                },
                beforeSend: function () {
                    $('#loading').show();
                    $('#proceedToPayment').attr('disabled', 'disabled');
                },
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success('Shipping method selected', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setInterval(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error('Choose proper shipping method.', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
    </script>
@endpush
