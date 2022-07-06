@extends('layouts.front.app')

@section('title', $product->name)

@push('css')
    <style>
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
    <div class="container pro-detail">
        <h2 class="text-center detail-hdng">Product Detail</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="mainPro ">
                    <figure class='zoom' id='ex1'>
                        <img class="img-fluid"
                             src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $product->thumbnail !!}">
                    </figure>
                </div>

                <h5>More Pictures</h5>
                <div class="row product-carousel">
                    {{--                    @foreach(json_decode($product->images) as $key => $image)--}}
                    {{--                        <div class="col-md-3 col-xs-12 d-none">--}}
                    {{--                            <img class="img-fluid" src="{!! \App\CPU\ProductManager::product_image_path('product') .'/'. $image !!}">--}}
                    {{--                        </div>--}}
                    {{--                    @endforeach--}}

                    <div class="proList slider">
                        @foreach(json_decode($product->images) as $key => $image)
                            <div>
                                <img src="{!! \App\CPU\ProductManager::product_image_path('product') .'/'. $image !!}">
                            </div>
                        @endforeach
                        {{--                        <div>--}}
                        {{--                            <img src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $product->thumbnail !!}" >--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <img src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $product->thumbnail !!}" >--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <img src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $product->thumbnail !!}" >--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <img src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $product->thumbnail !!}" >--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @if($product->discount > 0)
                    <div class="d-flex">
                        @if ($product->discount_type == 'percent')
                            <div class="chip text-left">
                                {!! round($product->discount, 2) !!}% Off
                            </div>
                        @elseif($product->discount_type == 'flat')
                            <div class="chip text-left">
                                Sale
                            </div>
                        @endif
                    </div>
                @endif
                @if($product->brand)
                    <a href="{!! route('shop') . '?id=' . $product->brand->id . '&data_from=brand' !!}">

                        <h2 class="pt-5">{!! $product->brand->name !!}</h2>
                    </a>
                @endif
                <h3>{!! $product->name !!}</h3>
                {{--                <img class="detail-img" src="{!! frontImage('candi.png') !!}">--}}
                @if($product->discount > 0)
                    <strike>{!! \App\CPU\Helpers::currency_converter($product['unit_price']) !!}</strike>
                    <h2>{!! \App\CPU\Helpers::currency_converter($product->unit_price-(\App\CPU\Helpers::get_product_discount($product, $product->unit_price))) !!}</h2>
                @else
                    <h2>{!! \App\CPU\Helpers::currency_converter($product->unit_price) !!}</h2>
                @endif

                <form action="{!! route('cart.add') !!}" method="POST">
                    @csrf
                    <input type="hidden" name="slug" value="{!! $product->slug !!}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="buy_now" id="buy_now" value="0">
                    @if(count(json_decode($product->colors)) > 0)
                        <div class="colorDv">
                            <h4 class="label">Color</h4>
                            <div class="colorOpt">
                                @foreach(json_decode($product->colors) as $key => $color)
                                    @if(count(json_decode($product->colors)) == 1)
                                        <label class="container">
                                            <input type="radio" name="color" value="{!! $color !!}" checked="checked"
                                                   required>
                                            <span class="checkmark" style="background-color: {!! $color !!}"></span>
                                        </label>
                                    @else
                                        <label class="container">
                                            <input type="radio" name="color" value="{!! $color !!}" required>
                                            <span class="checkmark" style="background-color: {!! $color !!}"></span>
                                        </label>
                                    @endif
                                @endforeach
                                {{--                            <label class="container">--}}
                                {{--                                <input type="radio" checked="checked" name="radio">--}}
                                {{--                                <span class="checkmark" style="background-color: red"></span>--}}
                                {{--                            </label>--}}

                                {{--                            <label class="container">--}}
                                {{--                                <input type="radio" checked="checked" name="radio">--}}
                                {{--                                <span class="checkmark" style="background-color: blue"></span>--}}
                                {{--                            </label>--}}
                            </div>
                        </div>
                    @endif
                    <div class="sizeDv">
                        @php $choiceOptions = json_decode($product->choice_options, true); @endphp

                        @if (count($choiceOptions) > 0)
                            @foreach($choiceOptions as $key => $choices)
                                <label style="font-size: 20px;font-weight: bolder;">{!! $choices['title'] !!}:</label>
                                @if(count($choices['options']) > 1)
                                    <select class="col-md-12" name="{!! $choices['name'] !!}" id="sizes">
                                        <option value="" selected>{!! 'Select ' . $choices['title'] !!}</option>
                                        @foreach($choices['options'] as $key => $size)
                                            <option value="{!! $size !!}">{!! $size !!}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select class="col-md-12" name="{!! $choices['name'] !!}" id="sizes">
                                        @foreach($choices['options'] as $key => $size)
                                            <option value="{!! $size !!}" selected>{!! $size !!}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <div class="cart">

                        <button type="submit">Add to Cart</button>
                        <button type="submit" id="buy_now_button">Buy Now</button>
                    </div>

                    <div class="text-center" style="font-size:14px ">
                        @if(auth('customer')->check())
                            @if(in_array($product['id'], $wishLists))
                                <a href="{!! route('delete-wishlist', $product['slug']) !!}"> <i
                                        class="fa fa-heart"></i> Remove Wish List</a>
                            @else
                                <a href="{!! route('store-wishlist', $product['slug']) !!}"> <i
                                        class="fa fa-heart-o"></i> Add Wish List</a>
                            @endif
                        @else
                            <a href="{!! route('store-wishlist', $product['slug']) !!}"> <i class="fa fa-heart-o"></i>
                                Add Wish List</a>
                        @endif
                        |
                        <a href="{!! route('request', ['productId' => $product['id']]) !!}" type="button">Request
                            an Item</a>
                    </div>
                </form>
                {{--                <ul class="cart">--}}
                {{--                    <li>--}}
                {{--                        <a href="{!! route('cart.add', ['productSlug' => $product->slug]) !!}">Add to Cart</a>--}}
                {{--                    </li>--}}
                {{--                    <li><a href="#">Buy Now</a></li>--}}
                {{--                </ul>--}}
            </div>
        </div>
    </div>
    <!-- end container-->
    <div class="container pro-describe">
        <div class="row">
            <div class="col-md-12">

                <!-- Nav tabs -->
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#productDescription" role="tab">
                                    Product Description
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#authentication" role="tab">
                                    Authentication
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#shipmentAndReturn" role="tab">
                                    Shipment & Return
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="productDescription" role="tabpanel">
                                {!! $product->details !!}
                            </div>
                            <div class="tab-pane" id="authentication" role="tabpanel">
                                <strong> Authenticity Guaranteed. </strong> <br/><br/>

                                To offer you the luxury of shopping all of our items with confidence regarding authenticity – our experts thoroughly examine every aspect of each item prior to making them available for purchase. <br/><br/>

                                For more information, visit <a href="{!! route('how-we-authenticate') !!}">Authentication</a>.
                            </div>
                            <div class="tab-pane" id="shipmentAndReturn" role="tabpanel">
                                <strong>Shipping</strong><br/>
                                Shipping and taxes calculated at checkout<br/><br/>

                                <strong>Exchange</strong><br/>
                                You may exchange items within 14 days. No returns.<br/>
                                Please visit our shipping and exchange page for more information.<br/><br/>

                                For more information, visit SHIPPING & EXCHANGE
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--            <div class="container pro-comment">--}}
            {{--                <div class="row">--}}
            {{--                    <div class="col-md-12">--}}
            {{--                        <h4>Comments</h4>--}}
            {{--                        <div class="comment-des">--}}
            {{--                            <h4>User <span>02 days ago</span></h4>--}}
            {{--                            <p>--}}
            {{--                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <br>--}}
            {{--                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived <br>--}}
            {{--                                not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the <br>--}}
            {{--                                1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like <br>--}}
            {{--                                Aldus PageMaker including versions of Lorem Ipsum.--}}
            {{--                            </p>--}}
            {{--                        </div>--}}
            {{--                        <div class="comment-des">--}}
            {{--                            <h4>User <span>04 days ago</span></h4>--}}
            {{--                            <p>--}}
            {{--                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <br>--}}
            {{--                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.--}}
            {{--                            </p>--}}
            {{--                        </div>--}}
            {{--                        <div class="comment-des">--}}
            {{--                            <h4>User <span>05 days ago</span></h4>--}}
            {{--                            <p>--}}
            {{--                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <br>--}}
            {{--                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived <br>--}}
            {{--                                not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.--}}
            {{--                            </p>--}}
            {{--                        </div>--}}
            {{--                        <div class="comment-des">--}}
            {{--                            <h4>User <span>06 days ago</span></h4>--}}
            {{--                            <p>--}}
            {{--                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <br>--}}
            {{--                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived <br>--}}
            {{--                                not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the <br>--}}
            {{--                                1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like <br>--}}
            {{--                                Aldus PageMaker including versions of Lorem Ipsum.--}}
            {{--                            </p>--}}
            {{--                        </div>--}}
            {{--                        <div class="comment-des">--}}
            {{--                            <h4>User <span>07 days ago</span></h4>--}}
            {{--                            <p>--}}
            {{--                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <br>--}}
            {{--                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.--}}
            {{--                            </p>--}}
            {{--                        </div>--}}
            {{--                        <div class="comment-des">--}}
            {{--                            <h4>User <span>07 days ago</span></h4>--}}
            {{--                            <p>--}}
            {{--                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text <br>--}}
            {{--                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived <br>--}}
            {{--                                not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.--}}
            {{--                            </p>--}}
            {{--                        </div>--}}
            {{--                        <div class="comment-des comment-here">--}}
            {{--                            <h4>John Deo</h4>--}}
            {{--                            <div class="widget-area no-padding blank">--}}
            {{--                                <div class="status-upload">--}}
            {{--                                    <form>--}}
            {{--                                        <textarea placeholder="Comment" ></textarea>--}}
            {{--                                        <ul>--}}
            {{--                                            <li><a title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Audio"><i class="fa fa-music"></i></a></li>--}}
            {{--                                            <li><a title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Video"><i class="fa fa-video-camera"></i></a></li>--}}
            {{--                                            <li><a title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Sound Record"><i class="fa fa-microphone"></i></a></li>--}}
            {{--                                            <li><a title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Picture"><i class="fa fa-picture-o"></i></a></li>--}}
            {{--                                        </ul>--}}
            {{--                                        <button type="submit" class="btnx-1"> Post</button>--}}
            {{--                                    </form>--}}
            {{--                                </div><!-- Status Upload  -->--}}
            {{--                            </div><!-- Widget Area -->--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}

{{--            <div class="container related-pro">--}}
{{--                @if(count($productsYouViewed) > 0)--}}
{{--                    <h2 class="text-center">Products You Viewed</h2>--}}
{{--                    <div class="row">--}}
{{--                        @foreach($productsYouViewed as $key => $product)--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="acess-box">--}}
{{--                                    @if($product->discount > 0)--}}
{{--                                        <div class="d-flex">--}}
{{--                                            @if ($product->discount_type == 'percent')--}}
{{--                                                <div class="chip text-left">--}}
{{--                                                    {!! round($product->discount, 2) !!}% Off--}}
{{--                                                </div>--}}
{{--                                            @elseif($product->discount_type == 'flat')--}}
{{--                                                <div class="chip text-left">--}}
{{--                                                    Sale--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            --}}{{--                                            <div class="chip1 text-left">--}}
{{--                                            --}}{{--                                               Best Sale--}}
{{--                                            --}}{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    @if(auth('customer')->check())--}}
{{--                                        @if(in_array($product['id'], $wishLists))--}}
{{--                                            <a href="#">--}}
{{--                                                <label class="wrapper">--}}
{{--                                                    <input type="checkbox" checked='checked'--}}
{{--                                                           onclick="window.location.href='{!! route('delete-wishlist', $product['slug']) !!}'">--}}
{{--                                                    <span class="checkmark">--}}
{{--                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt"--}}
{{--                                                                 viewBox="0 -10 511.98645 511" width="511pt">--}}
{{--                                                            <path class="star_border"--}}
{{--                                                                  d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>--}}
{{--                                                            <path class="star_body"--}}
{{--                                                                  d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>--}}
{{--                                                        </span>--}}
{{--                                                </label>--}}
{{--                                            </a>--}}
{{--                                        @else--}}
{{--                                            <a href="#">--}}
{{--                                                <label class="wrapper">--}}
{{--                                                    <input type="checkbox"--}}
{{--                                                           onclick="window.location.href='{!! route('store-wishlist', $product['slug']) !!}'">--}}
{{--                                                    <span class="checkmark">--}}
{{--                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt"--}}
{{--                                                                 viewBox="0 -10 511.98645 511" width="511pt">--}}
{{--                                                            <path class="star_border"--}}
{{--                                                                  d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>--}}
{{--                                                            <path class="star_body"--}}
{{--                                                                  d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>--}}
{{--                                                        </span>--}}
{{--                                                </label>--}}
{{--                                            </a>--}}
{{--                                        @endif--}}
{{--                                    @else--}}
{{--                                        <a href="#">--}}
{{--                                            <label class="wrapper" style="z-index: 100">--}}
{{--                                                <input type="checkbox"--}}
{{--                                                       onclick="window.location.href='{!! route('store-wishlist', $product['slug']) !!}'">--}}
{{--                                                <span class="checkmark">--}}
{{--                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt"--}}
{{--                                                                 viewBox="0 -10 511.98645 511" width="511pt">--}}
{{--                                                            <path class="star_border"--}}
{{--                                                                  d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>--}}
{{--                                                            <path class="star_body"--}}
{{--                                                                  d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>--}}
{{--                                                        </span>--}}
{{--                                            </label>--}}
{{--                                        </a>--}}
{{--                                    @endif--}}

{{--                                    @php $product_images = json_decode($product['images']); @endphp--}}
{{--                                    @if(count($product_images) > 0)--}}
{{--                                        <div class="flip-card">--}}
{{--                                            <div class="flip-card-inner">--}}
{{--                                                @if(isset($product_images[0]))--}}
{{--                                                    <div class="flip-card-front">--}}
{{--                                                        <a href="{!! route('product.details', $product->slug) !!}">--}}
{{--                                                            <img class="img-fluid"--}}
{{--                                                                 onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"--}}
{{--                                                                 src="{!! \App\CPU\ProductManager::product_image_path('product') .'/'. $product_images[0] !!}">--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                                @if(isset($product_images[1]))--}}
{{--                                                    <div class="flip-card-back">--}}
{{--                                                        <a href="{!! route('product.details', $product->slug) !!}">--}}
{{--                                                            <img class="img-fluid"--}}
{{--                                                                 onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"--}}
{{--                                                                 src="{!! \App\CPU\ProductManager::product_image_path('product') .'/'. $product_images[1] !!}">--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    <h4 style="margin-top:100px">--}}
{{--                                        @if($product->brand)--}}
{{--                                            <a href="{!! route('shop') . '?id=' . $product['brand']['id'] . '&data_from=brand' !!}">--}}
{{--                                                <ruby class="d-block pb-1">{!! $product->brand->name !!}</ruby>--}}
{{--                                            </a>--}}
{{--                                        @endif--}}
{{--                                        <br>--}}

{{--                                        <a href="{!! route('product.details', $product->slug) !!}"> {!! $product->name !!} </a>--}}
{{--                                        @if(isset($product['choice_options']))--}}
{{--                                            @php $choicesArray = json_decode($product['choice_options'], true); @endphp--}}
{{--                                        @endif--}}
{{--                                        @if(count($choicesArray) > 0)--}}
{{--                                            @foreach($choicesArray as $key => $choices)--}}
{{--                                                @if(strtolower($choices['title']) == 'size')--}}
{{--                                                    <div class="product-grid3">--}}
{{--                                                        <span--}}
{{--                                                            class="size">{!! implode(" ", $choices['options']) !!}</span>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                        @if($product->discount > 0)--}}
{{--                                            <strike>{!! \App\CPU\Helpers::currency_converter($product->unit_price) !!}</strike>--}}
{{--                                            <span>{!! \App\CPU\Helpers::currency_converter($product->unit_price-(\App\CPU\Helpers::get_product_discount($product, $product->unit_price))) !!}</span>--}}
{{--                                        @else--}}
{{--                                            <span--}}
{{--                                                class="d-block pt-1">{!! \App\CPU\Helpers::currency_converter($product->unit_price) !!}</span>--}}
{{--                                        @endif--}}
{{--                                    </h4>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                @if(count($relatedProducts) > 0)--}}
{{--                    <h2 class="text-center">Related Products</h2>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-12">--}}
{{--                            <div class="row">--}}
{{--                                @foreach($relatedProducts as $key => $relatedProduct)--}}
{{--                                    <div class="col-sm-3">--}}
{{--                                        <div class="acess-box">--}}
{{--                                            @if($relatedProduct->discount > 0)--}}
{{--                                                <div class="d-flex">--}}
{{--                                                    @if ($relatedProduct->discount_type == 'percent')--}}
{{--                                                        <div class="chip text-left">--}}
{{--                                                            {!! round($relatedProduct->discount, 2) !!}% Off--}}
{{--                                                        </div>--}}
{{--                                                    @elseif($relatedProduct->discount_type == 'flat')--}}
{{--                                                        <div class="chip text-left">--}}
{{--                                                            Sale--}}
{{--                                                        </div>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            <a href="{!! route('product.details', $relatedProduct->slug) !!}">--}}
{{--                                                <img--}}
{{--                                                    src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $relatedProduct->thumbnail !!}">--}}
{{--                                            </a>--}}
{{--                                            <h4>--}}
{{--                                                @if($relatedProduct->brand) <a--}}
{{--                                                    href="{!! route('shop') . '?id=' .$relatedProduct->brand->id . '&data_from=brand' !!}">--}}
{{--                                                    <ruby--}}
{{--                                                        class="d-block pb-1">{!! $relatedProduct->brand->name !!}</ruby>--}}
{{--                                                </a> @endif--}}
{{--                                                <br>--}}
{{--                                                <h4><a class="text-black" href="#" style="--}}
{{--                                                color: #f96332;--}}
{{--                                                margin-bottom: 0px !important;--}}
{{--                                                    font-family: Graphik;--}}
{{--                                                    font-style: normal;--}}
{{--                                                    font-weight: 500;--}}
{{--                                                    font-size: 14px;--}}
{{--                                                    line-height: 0px;--}}
{{--                                                    text-align: center;">{!! $relatedProduct->name !!} </a></h4>--}}
{{--                                                <span--}}
{{--                                                    class="d-block pt-1">{!! \App\CPU\Helpers::currency_converter($relatedProduct->unit_price) !!}</span>--}}
{{--                                            </h4>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12 text-center">--}}
{{--                            <a href="{!! route('shop') . '?data_from=latest' !!}" class="btnx-1">Shop More</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
            <!-- end container-->
        </div>
    </div>

    @if(count($productsYouViewed) > 0)
        <section class="sec-filter tabsx-2 related">
            <div class="container">
                <h2 class="text-center">Products You Viewed</h2>
                <div class="row">
                    <div class="col-sm-12">
                        @include('web-views.partials._inline-single-product', ['products' => $productsYouViewed])
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(count($relatedProducts) > 0)
        <section class="sec-filter tabsx-2 related">
            <div class="container">
                <h2 class="text-center">Related Products</h2>
                <div class="row">
                    <div class="col-sm-12">
                        @include('web-views.partials._inline-single-product', ['products' => $relatedProducts])
                    </div>
                    <div class="col-md-12 text-center">
                        <a href="{!! route('shop') . '?data_from=latest' !!}" class="btnx-1">Shop More</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#buy_now_button').click(function () {
                $('#buy_now').val(1);
            });
        });
    </script>
@endpush
