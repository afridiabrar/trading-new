<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-body">
            <div class="container pt-5 pb-2">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                @php($sub_total=0)
                @php($total_tax=0)
                @php($total_shipping_cost=0)
                @php($total_discount_on_product=0)
                <h6>Item Details ({!! $order->details->count() !!})</h6>

                @foreach ($order_details as $key => $detail)
                    @php($product=json_decode($detail->product_details,true))
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{!! route('product.details', $product['slug']) !!}">
                                    <img class="img-fluid img-o" width="100" src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $product['thumbnail'] !!}">
                                </a>
                            </div>
                            <div class="col-md-6 text-right" style="padding-top: 2vh;">
                                <ul type="none" class="order-d">
                                    <li><b>Name: {!! isset($product['name']) ? $product['name'] : '' !!}</b></li>
                                    @php($product_variations=json_decode($detail->variation,true))
                                    @foreach($product_variations as $key => $variation)
                                        <li><b>{!! ucwords($key) !!}: {!! ucwords($variation) !!}</li>
                                    @endforeach
                                    <li>Price: {!! \App\CPU\Helpers::currency_converter($detail->price) !!}</li>
                                    <li>Qty: {!! $detail->qty !!}</li>
                                </ul>
                            </div>
                        </div>
                    @php($sub_total+=$detail->price*$detail->qty)
                    @php($total_tax+=$detail->tax)
                    @php($total_shipping_cost+=$detail->cost)
                    @php($total_discount_on_product+=$detail->discount)
                @endforeach
                <h6>Order Details</h6>
                <div class="row">
                    <div class="col-md-6 col-xs-6 details-o">
                        <ul type="none">
                            <li class="left">Order#:</li>
                            <li class="left">Date:</li>
                            <li class="left">Subtotal:</li>
                            <li class="left">Tax Fee:</li>
                            <li class="left">Shipping Fee:</li>
                            <li class="left">Discount on Product:</li>
                            <li class="left">Coupon Discount:</li>
                            <li class="left">Total:</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-xs-6 details-r">
                        <ul class="" type="none">
                            <li class="right">{!! $order->id !!}</li>
                            <li class="right">{!! date('F d, Y', strtotime($order->created_at)) !!}</li>
                            <li class="right">{!! \App\CPU\Helpers::currency_converter($sub_total) !!}</li>
                            <li class="right">{!! \App\CPU\Helpers::currency_converter($total_tax) !!}</li>
                            <li class="right">{!! \App\CPU\Helpers::currency_converter($total_shipping_cost) !!}</li>
                            <li class="right">{!! \App\CPU\Helpers::currency_converter($total_discount_on_product) !!}</li>
                            <li class="right">{!! \App\CPU\Helpers::currency_converter($order->discount_amount) !!}</li>
                            <li class="right">{!! \App\CPU\Helpers::currency_converter($order->order_amount) !!}</li>
                        </ul>
                    </div>
                </div>
                <h6>Shipment</h6>
                <div class="row" style="border-bottom: none">
                    <div class="col-md-6">
                        <ul type="none" class="order-d">
                            <li class="left">Estimated arrival</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul type="none" class="order-d">
                            <li class="right">{!! Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$track_order['updated_at'])->format('F d, Y') !!}</li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white p-2 border rounded px-3">
                            <div class="d-flex flex-row justify-content-between align-items-center order">
                                <div class="d-flex flex-column order-details">
                                    <span>You can track your order</span>
{{--                                    <span class="date">by DHFL on 21 Jan, 2020</span>--}}
                                </div>
                                {{-- <div class="tracking-details">
                                    <button class="btn btn-outline-info btn-sm btn-rounded btn-navbar waves-effect waves-light" type="button">View Invoice Details</button>
                                </div> --}}
                            </div>
                            <hr class="divider mb-4">
                            @if($track_order['order_status']!='returned' && $track_order['order_status']!='failed')
                                <div
                                    class="d-flex flex-row justify-content-between align-items-center align-content-center">
                                    <span
                                        class="d-flex justify-content-center align-items-center big-dot dot"><i
                                            class="fa fa-check text-white"></i></span>

                                    <hr class="flex-fill track-line">

                                    @if(($track_order['order_status']=='processing') || ($track_order['order_status']=='processed') || ($track_order['order_status']=='delivered'))
                                        <span
                                            class="d-flex justify-content-center align-items-center big-dot dot"><i
                                                class="fa fa-check text-white"></i></span>
                                    @else
                                        <span class="dot"></span>
                                    @endif

                                    <hr class="flex-fill track-line">

                                    @if(($track_order['order_status']=='processed') || ($track_order['order_status']=='delivered'))
                                        <span
                                            class="d-flex justify-content-center align-items-center big-dot dot"><i
                                                class="fa fa-check text-white"></i></span>
                                    @else
                                        <span class="dot"></span>
                                    @endif

                                    <hr class="flex-fill track-line">

                                    @if(($track_order['order_status']=='delivered'))
                                            <span
                                                class="d-flex justify-content-center align-items-center big-dot dot"><i
                                                    class="fa fa-check text-white"></i></span>
                                    @else
                                        <span class="dot"></span>
                                    @endif
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div class="d-flex flex-column justify-content-center">
                                        <span>Order placed</span>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <span>Processing order</span>
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <span>Product on shipped</span>
                                    </div>
                                    <div class="d-flex flex-column align-items-end">
                                        <span>Product dispatched</span>
                                    </div>
                                </div>
                            @elseif($track_order['order_status']=='returned')
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <span>Product Successfully Returned</span>
                                </div>
                            @else
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <span>Sorry we can't complete your order</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Modal footer -->
        <div class="modal-footer justify-content-center">
            <a href="{!! route('generate-invoice', $order->id) !!}" class="btn btn-dark btn-submit">View Order Invoice</a>
        </div>
    </div>
</div>
</div>
