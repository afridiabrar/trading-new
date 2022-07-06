@push('css')
    <style>
        .coupon-body {
            BACKGROUND: #e5e5e5;
            BORDER-RADIUS: 5PX;
        }
    </style>
@endpush
@php $sub_total = 0; @endphp
@php $total_tax = 0;  @endphp
@php $total_shipping_cost = 0;  @endphp
@php $total_discount_on_product = 0 @endphp
<div class="col-sm-5">
    @if(!session()->has('coupon_discount'))
        <div class="card mb-3">
            <div class="card-body coupon-body">
                <form method="post" id="coupon-code-ajax">
                    <div class="form-group"><label>Have coupon?</label>
                        <div class="input-group">
                            <input type="text" class="form-control coupon" type="text" name="code"
                                   placeholder="Coupon code" required>
                            <span class="input-group-append">
                                <button class="btn-proc" type="button" onclick="couponCode()">Apply</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @php $coupon_dis = 0; @endphp
    @endif
    <div class="billing-b billingx">
        <h3 class="text-center">Your Order </h3>
        @if(session()->has('cart') && count( session()->get('cart')) > 0)


            <div class="totalbox">
                {{-- <p><img src="{!! frontImage('Vintage.png') !!}">"I Saw This Future" T-shirt <span>1</span></p>--}}
                @foreach(session()->get('cart') as $key => $cartItem)

                    <p><img onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                            src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $cartItem['thumbnail'] !!}"> {!! $cartItem['name'] !!}
                        <span>{!! $cartItem['quantity'] !!} X @if($cartItem['discount'] > 0) <strike>{!! \App\CPU\Helpers::currency_converter($cartItem['price']) !!}</strike> {!! \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']) !!} @else {!! \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']) !!} @endif </span>
                    </p>
                    @php $sub_total+=($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']; @endphp
                    @php $total_tax+=$cartItem['tax']*$cartItem['quantity']; @endphp
                    @php $total_shipping_cost+=$cartItem['shipping_cost'] @endphp
                    @php $total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'] @endphp
                @endforeach
            </div><!-- end totalbox-->

        @endif
        <div class="totalprice">
            <p>Subtotal <span>{!! \App\CPU\Helpers::currency_converter($sub_total) !!}</span></p>
            <p>Tax <span>{!! \App\CPU\Helpers::currency_converter($total_tax) !!}</span></p>
            <p>Shipping Cost
                <span>{!! \App\CPU\Helpers::currency_converter($total_shipping_cost) !!}</span></p>
            <p>Discount on Product
                <span>- {!! \App\CPU\Helpers::currency_converter($total_discount_on_product) !!}</span></p>
            @if(session()->has('coupon_discount'))
                <p>Coupon Discount
                    <span>- {!! session()->has('coupon_discount')? \App\CPU\Helpers::currency_converter(session('coupon_discount')) : 0 !!}</span>
                </p>
                @php $coupon_dis = session('coupon_discount'); @endphp
            @endif
            <p class="borderlast"></p>
            <div class="grandtotal">
                @php $total = $sub_total + $total_tax + $total_shipping_cost - $coupon_dis - $total_discount_on_product; @endphp
                <p>Total <span>{!! \App\CPU\Helpers::currency_converter($total) !!}</span></p>
            </div>
            {{--                            <a href="Paypal.php" class="btn-pay">Paypal</a>--}}
        </div><!-- end totalbox-->

    </div><!-- end innerdetail -->
</div>
