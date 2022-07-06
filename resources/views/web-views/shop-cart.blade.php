@extends('layouts.front.app')
@section('title', 'Shop Cart')

@push('css')
    <style>
        input.form-control.coupon {
            padding: 20px;
        }

        .cssTable td {
            font-family: 'Graphik';
            color: #000;
            font-size: 16px;
            font-weight: 400;
        }

        .cont-formx input {
            border: 1px solid #000;
            border-radius: 15px;
            height: 47px;
            padding: 8px 0px 5px 10px;
        }

        .cssTable td {

            text-align: left;
        }

        .acess-box h4 {
            margin-bottom: 4px;
            font-family: Graphik;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            line-height: 15px;
            text-align: center;
            color: #000000;
            margin-top: 5px;
        }

        .acess-box .product-grid3 .size {
            width: 120px;
            padding: 0;
            margin: 0 auto;
            list-style: none;
            opacity: 0;
            position: absolute;
            right: 0;
            left: 0;
            bottom: 94px !important;
            font-size: 6px !important;
            transform: scale(1);
            transition: all .3s ease 0s;
            background: #fff;
            line-height: 1;
        }
    </style>
@endpush


@section('content')
    <div class="container">
        <div class="clmnsxx text-center">
            <h2>Shopping Cart</h2>
        </div>
    </div><!-- end container-->
    <section class="check-sec">
        <div class="container">
            <div class="row borderit">
                <div class="col-sm-8">
                    <div class="cont-formx">
                        <div class="contact-inner">
                            @php $sub_total = 0; @endphp
                            @php $total_tax = 0;  @endphp
                            @php $total_discount_on_product = 0;  @endphp
                            @if(session()->has('cart') && count( session()->get('cart')) > 0)
                                <div class="table-responsive">
                                    <div class="table-wrapper">
                                        <table class="table table-striped dark table-hover cssTable">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th><h5>Product Details</h5></th>
                                                <th><h5>Quantity</h5></th>
                                                <th><h5>Price</h5></th>
                                                <th><h5>Total</h5></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(session()->get('cart') as $key => $cartItem)
                                                <form method="POST" action="{!! route('cart.updateQuantity') !!}"
                                                      role="form">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="key" value="{!! $key !!}">
                                                    <tr>
                                                        <td>
                                                            <a href="{!! route('product.details', $cartItem['slug']) !!}"
                                                               class="text-g"><img width="50"
                                                                                   src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') . '/' . $cartItem['thumbnail'] !!}"
                                                                                   alt="{!! $cartItem['name'] !!}"> </a>
                                                        </td>
                                                        <td class="pt-5">
                                                            <h5>{!! $cartItem['name'] !!}</h5>
                                                            @if(count($cartItem['variations']) > 0)
                                                                @foreach($cartItem['variations'] as $varkey => $variation)
                                                                    <span>{!! ucwords($varkey) !!}: {!! ucwords($variation) !!}</span>
                                                                    <br>
                                                                @endforeach
                                                            @endif
                                                            <br><a href="{!! route('cart.remove', $key) !!}">Remove</a>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-2 text-center">
                                                                <h4 class="magical">Quantity</h4>
                                                                <input class="qtyx mt-0" type="number" name="quantity"
                                                                       value="{!! $cartItem['quantity'] !!}" min="1"
                                                                       max="20" step="1">
                                                            </div>
                                                        </td>
                                                        <td>@if($cartItem['discount'] > 0) <strike>{!! \App\CPU\Helpers::currency_converter($cartItem['price']) !!}</strike> {!! \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])) !!} @else {!! \App\CPU\Helpers::currency_converter($cartItem['price']) !!} @endif</td>
                                                        <td>
                                                            @if($cartItem['discount'] > 0) {!! \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']) !!} @else {!! \App\CPU\Helpers::currency_converter($cartItem['price']*$cartItem['quantity']) !!} @endif
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn-proc">Edit</button>
                                                        </td>
                                                    </tr>
                                                </form>
                                                @php $sub_total+=($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']; @endphp
                                                @php $total_tax+=$cartItem['tax']*$cartItem['quantity']; @endphp
                                                @php $total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'] @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif


                            {{--                            <div class="row innerborderx xd-1">--}}
                            {{--                                <div class="col-md-6">--}}
                            {{--                                    <h4>Product Details</h4>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-2 text-center">--}}
                            {{--                                    <h4>Quantity</h4>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-2 text-right">--}}
                            {{--                                    <h4>Price</h4>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-2 text-right">--}}
                            {{--                                    <h4>Total</h4>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            @php $sub_total = 0; @endphp--}}
                            {{--                            @php $total_tax = 0;  @endphp--}}
                            {{--                            @if(session()->has('cart') && count( session()->get('cart')) > 0)--}}
                            {{--                                @foreach(session()->get('cart') as $key => $cartItem)--}}
                            {{--                                    <form method="POST" action="{!! route('cart.updateQuantity') !!}" role="form">--}}
                            {{--                                        @csrf--}}
                            {{--                                        <input type="hidden" name="key" value="{!! $key !!}">--}}
                            {{--                                        <div class="row innerborderx2">--}}
                            {{--                                            <div class="col-md-6">--}}
                            {{--                                                <div class="leftbox02">--}}
                            {{--                                                    <a href="{!! route('product.details', $cartItem['slug']) !!}"><img--}}
                            {{--                                                            src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') . '/' . $cartItem['thumbnail'] !!}"></a>--}}
                            {{--                                                    <a href="{!! route('product.details', $cartItem['slug']) !!}">--}}
                            {{--                                                        <h3>{!! $cartItem['name'] !!}</h3></a>--}}
                            {{--                                                    @if(count($cartItem['variations']) > 0)--}}
                            {{--                                                        @foreach($cartItem['variations'] as $varkey => $variation)--}}
                            {{--                                                            <p>{!! ucwords($varkey) !!}: {!! ucwords($variation) !!}</p>--}}
                            {{--                                                        @endforeach--}}
                            {{--                                                    @endif--}}
                            {{--                                                    <a href="{!! route('cart.remove', $key) !!}">Remove</a>--}}
                            {{--                                                    <div class="clear"></div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="col-md-2 text-center">--}}
                            {{--                                                <h4 class="magical">Quantity</h4>--}}
                            {{--                                                <input class="qtyx" type="number" name="quantity"--}}
                            {{--                                                       value="{!! $cartItem['quantity'] !!}" min="1" max="20" step="1">--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="col-md-2 text-right">--}}
                            {{--                                                <h4 class="magical">Price</h4>--}}
                            {{--                                                <h5>${!! number_format($cartItem['price'], 2) !!}</h5>--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="col-md-2">--}}
                            {{--                                                <h4 class="text-right magical">Total</h4>--}}
                            {{--                                                <h5>--}}
                            {{--                                                    ${!! number_format($cartItem['price'] * $cartItem['quantity'], 2) !!}</h5>--}}
                            {{--                                                <button>Edit</button>--}}
                            {{--                                                --}}{{--                                        <span>Save For Later</span>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </form>--}}
                            {{--                                    @php $sub_total+=($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']; @endphp--}}
                            {{--                                    @php $total_tax+=$cartItem['tax']*$cartItem['quantity']; @endphp--}}
                            {{--                                @endforeach--}}
                            {{--                            @endif--}}
                        </div>
                    </div><!-- end cont-formx-->
                </div><!-- end col-sm-7-->
                <div class="col-sm-4">

                    <div class="innerdetail inx">
                        {{--                        <div class="card mb-3">--}}
                        {{--                            <div class="card-body">--}}
                        {{--                                <form>--}}
                        {{--                                    <div class="form-group"><label>Have coupon?</label>--}}
                        {{--                                        <div class="input-group"><input type="text" class="form-control coupon" name=""--}}
                        {{--                                                                        placeholder="Coupon code"> <span--}}
                        {{--                                                class="input-group-append"> <button--}}
                        {{--                                                    class="btn-proc">Apply</button> </span></div>--}}
                        {{--                                    </div>--}}
                        {{--                                </form>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <h3>Cart Total </h3>
                        <div class="totalprice totalprice-in cart-all-detailx">
                            <p>Subtotal <span>{!! \App\CPU\Helpers::currency_converter($sub_total) !!}</span></p>
                            <p>Tax
                                <span>{!! \App\CPU\Helpers::currency_converter($total_tax) !!}</span></p>
                            <p class="borderlast">Discount on Product
                                <span>- {!! \App\CPU\Helpers::currency_converter($total_discount_on_product) !!}</span></p>
                            <div class="grandtotal">
                                <p>Total <span>{!! \App\CPU\Helpers::currency_converter($sub_total + $total_tax - $total_discount_on_product) !!}</span></p>
                            </div>
                            <p align="center" class="center-block">Shipping calculated at next step*</p>
                            <a href="{!! route('checkout') !!}" class="btn-proc">Proceed to Checkout</a>
                            {{--                            <a href="paypal.php" class="btn-pay">Paypal</a>--}}
                            <div class="clear"></div>
                        </div><!-- end totalbox-->

                    </div><!-- end innerdetail -->
                </div><!--end col-sm-5-->
            </div>
        </div>
    </section>
    <!-- end container-->

    @if(count($related_products) > 0)
        <section class="sec-filter tabsx-2 related">
            <div class="container">
                <h2 class="text-center">Related Products</h2>
                <div class="row">
                    <div class="col-sm-12">
                        @include('web-views.partials._inline-single-product', ['products' => $related_products])
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(count($recent_products) > 0)
        <section class="sec-filter tabsx-2 related">
            <div class="container">
                <h2 class="text-center">Recent Products</h2>
                <div class="row">
                    <div class="col-sm-12">
                        @include('web-views.partials._inline-single-product', ['products' => $recent_products])
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{--    @if(count($related_products) > 0)--}}
    {{--        <div class="container">--}}
    {{--            <div class="spacein text-center">--}}
    {{--                <h2>Related Products</h2>--}}
    {{--            </div>--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-sm-12">--}}
    {{--                    <div class="row">--}}
    {{--                        @foreach($related_products as $key => $relatedProduct)--}}
    {{--                            <div class="col-sm-3">--}}
    {{--                                <div class="acess-box">--}}

    {{--                                    <a href="{!! route('product.details', $relatedProduct->slug) !!}">--}}
    {{--                                        <img src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $relatedProduct->thumbnail !!}">--}}
    {{--                                    </a>--}}
    {{--                                    <h4>--}}
    {{--                                        @if($relatedProduct->brand) <a href="{!! route('shop') . '?id=' .$relatedProduct->brand->id . '&data_from=brand' !!}"><ruby class="d-block pb-1">{!! $relatedProduct->brand->name !!}</ruby></a> @endif--}}
    {{--                                        <h4><a href="#" style="--}}
    {{--                                                color: #f96332;--}}
    {{--                                                margin-bottom: 0px !important;--}}
    {{--                                                    font-family: Graphik;--}}
    {{--                                                    font-style: normal;--}}
    {{--                                                    font-weight: 500;--}}
    {{--                                                    font-size: 14px;--}}
    {{--                                                    line-height: 0px;--}}
    {{--                                                    text-align: center;">{!! $relatedProduct->name !!} </a></h4>--}}
    {{--                                        <span class="d-block pt-1">{!! \App\CPU\Helpers::currency_converter($relatedProduct->unit_price) !!}</span>--}}
    {{--                                    </h4>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        @endforeach--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    @endif--}}

    {{--    @if(count($recent_products) > 0)--}}
    {{--        <div class="container">--}}
    {{--            <div class="spacein text-center">--}}
    {{--                <h2>Recent Products</h2>--}}
    {{--            </div>--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-sm-12">--}}
    {{--                    <div class="row">--}}
    {{--                        @foreach($recent_products as $key => $recentProduct)--}}
    {{--                            <div class="col-sm-3">--}}
    {{--                                <div class="acess-box">--}}

    {{--                                    <a href="{!! route('product.details', $recentProduct->slug) !!}">--}}
    {{--                                        <img src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $recentProduct->thumbnail !!}">--}}
    {{--                                    </a>--}}
    {{--                                    <h4>--}}
    {{--                                        @if($recentProduct->brand) <a href="{!! route('shop') . '?id=' .$recentProduct->brand->id . '&data_from=brand' !!}"><ruby class="d-block pb-1">{!! $recentProduct->brand->name !!}</ruby></a> @endif--}}
    {{--                                        <h4><a href="#" style="--}}
    {{--                                                color: #f96332;--}}
    {{--                                                margin-bottom: 0px !important;--}}
    {{--                                                    font-family: Graphik;--}}
    {{--                                                    font-style: normal;--}}
    {{--                                                    font-weight: 500;--}}
    {{--                                                    font-size: 14px;--}}
    {{--                                                    line-height: 0px;--}}
    {{--                                                    text-align: center;">{!! $recentProduct->name !!} </a></h4>--}}
    {{--                                        <span class="d-block pt-1">{!! \App\CPU\Helpers::currency_converter($recentProduct->unit_price) !!}</span>--}}
    {{--                                    </h4>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        @endforeach--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    @endif--}}
@endsection

