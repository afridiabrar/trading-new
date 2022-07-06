@extends('layouts.front.app')

@section('title','Welcome To '. $web_config['name']->value.' Home')

@section('content')
    <div class="sec-hero">
        <div class="container">
            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach($banners as $key => $banner)
                        <li data-target="#carouselExampleCaptions" data-slide-to="{!! $key !!}" class="active"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($banners as $key => $banner)
                        <div class="carousel-item {!! ($key == 0) ? 'active' : '' !!} ">
                            <div class="carousel-caption">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="middlex">
                                            <div class="inflex">
                                                <h5>{!! $banner->title !!}</h5>
                                                <h2>{!! $banner->sub_title !!}</h2>
                                                <p>
                                                    {!! $banner->description !!}
                                                </p>

                                                <a href="{!! $banner->url !!}" class="btnx-1">Shop Now</a>
                                                <a href="{!! route('request') !!}" class="btnx">Request an Item</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-sm-6-->

                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="imgBox">
                                            <figure>
                                                <img class="img-fluid"
                                                     src="{!! asset('storage/app/public/banner') .'/'. $banner->photo !!}">
                                            </figure>
                                        </div>
                                    </div>
                                    <!-- end col-sm-6-->
                                </div><!-- ROW col-sm-6 -->
                            </div><!-- end carousel-caption-->
                        </div>
                    @endforeach

                </div>
                <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <div class="d-flex chevronBtn">
                            <div class="chevronBtn">
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button"
                                   data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button"
                                   data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Carousel Container -->

    <section class="sec-filter">
        <div class="container home">
            <h2>Quick Shop</h2>
            <p>
            <hr class="quickkss"></hr>
            </p>
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <!-- <h5>FILTER</h5> -->
{{--                        <div class="panel panel-default">--}}
{{--                            <div class="panel-heading" role="tab" id="headingOneCategory">--}}
{{--                                <h4 class="panel-title">--}}
{{--                                    <a role="button" data-toggle="collapse" data-parent="#accordion"--}}
{{--                                       href="#collapseOneCategory"--}}
{{--                                       aria-controls="collapseOneCategory">--}}
{{--                                        Category--}}
{{--                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>--}}
{{--                                    </a>--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div id="collapseOneCategory" class="panel-collapse collapse"--}}
{{--                                 role="tabpanel"--}}
{{--                                 aria-labelledby="headingOneCategory">--}}
{{--                                <div class="panel-body">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            Men--}}
{{--                                            <ul>--}}
{{--                                                <li>Top</li>--}}
{{--                                                <li>Bottom</li>--}}
{{--                                                <li>Shoes</li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            Women--}}
{{--                                            <ul>--}}
{{--                                                <li>Top</li>--}}
{{--                                                <li>Bottom</li>--}}
{{--                                                <li>Shoes</li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            Accessories--}}
{{--                                            <ul>--}}
{{--                                                <li>Top</li>--}}
{{--                                                <li>Bottom</li>--}}
{{--                                                <li>Shoes</li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            Style--}}
{{--                                            <ul>--}}
{{--                                                <li>Top</li>--}}
{{--                                                <li>Bottom</li>--}}
{{--                                                <li>Shoes</li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="panel panel-default">--}}
{{--                            <div class="panel-heading" role="tab" id="headingOneSize">--}}
{{--                                <h4 class="panel-title">--}}
{{--                                    <a role="button" data-toggle="collapse" data-parent="#accordion"--}}
{{--                                       href="#collapseOneSize"--}}
{{--                                       aria-controls="collapseOneSize">--}}
{{--                                        Size--}}
{{--                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>--}}
{{--                                    </a>--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div id="collapseOneSize" class="panel-collapse collapse"--}}
{{--                                 role="tabpanel"--}}
{{--                                 aria-labelledby="headingOneSize">--}}
{{--                                <div class="panel-body">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            L--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            S--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            M--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="panel panel-default">--}}
{{--                            <div class="panel-heading" role="tab" id="headingOneColor">--}}
{{--                                <h4 class="panel-title">--}}
{{--                                    <a role="button" data-toggle="collapse" data-parent="#accordion"--}}
{{--                                       href="#collapseOneColor"--}}
{{--                                       aria-controls="collapseOneColor">--}}
{{--                                        Color--}}
{{--                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>--}}
{{--                                    </a>--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div id="collapseOneColor" class="panel-collapse collapse"--}}
{{--                                 role="tabpanel"--}}
{{--                                 aria-labelledby="headingOneColor">--}}
{{--                                <div class="panel-body">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            L--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            S--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            M--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="panel panel-default">--}}
{{--                            <div class="panel-heading" role="tab" id="headingOneDiscount">--}}
{{--                                <h4 class="panel-title">--}}
{{--                                    <a role="button" data-toggle="collapse" data-parent="#accordion"--}}
{{--                                       href="#collapseOneDiscount"--}}
{{--                                       aria-controls="collapseOneDiscount">--}}
{{--                                        Sale Discount--}}
{{--                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>--}}
{{--                                    </a>--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div id="collapseOneDiscount" class="panel-collapse collapse"--}}
{{--                                 role="tabpanel"--}}
{{--                                 aria-labelledby="headingOneDiscount">--}}
{{--                                <div class="panel-body">--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            L--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            S--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            M--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        @foreach($categories as $key => $category)
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne{!! $category->id !!}">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapseOne{!! $category->id !!}"
                                           aria-controls="collapseOne{!! $category->id !!}">
                                            {!! $category->name !!}
                                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne{!! $category->id !!}" class="panel-collapse collapse"
                                     role="tabpanel"
                                     aria-labelledby="headingOne{!! $category->id !!}">
                                    <div class="panel-body">
                                        <ul>
                                            @foreach($category->childes as $childKey => $childCategory)
                                                <li>
                                                    <a class="boldit"
                                                       href="{!! route('shop') . '?id=' . $childCategory->id . '&slug=' . $category->slug . '&data_from=category' !!}">
                                                        {!! $childCategory->name !!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- panel-group -->

                <div class="col-sm-9 text-center">

                    <style>

                    </style>


                    @php $productsArray = array_chunk($latest_products->toArray(), 3); @endphp
                    @foreach($productsArray as $key => $products)
                        <div class="row {!! ($key > 0) ? 'flt-2' : '' !!}">
                            @foreach($products as $prodKey => $product)
                                <div class="col-sm-4">

                                    <div class="mini-box">
                                        @if($product['discount'] > 0)
                                            <div class="d-flex">
                                                @if ($product['discount_type'] == 'percent')
                                                    <div class="chip text-left">
                                                        {!! round($product['discount'],2) !!}% Off
                                                    </div>
                                                @elseif($product['discount_type'] == 'flat')
                                                    <div class="chip text-left">
                                                        Sale
                                                    </div>
                                                @endif
    {{--                                            <div class="chip1 text-left">--}}
    {{--                                               Best Sale--}}
    {{--                                            </div>--}}
                                            </div>
                                        @endif
                                        <div class="flip-card">
                                            <div class="flip-card-inner">
                                                @php $product_images = json_decode($product['images']); @endphp
                                                @if(count($product_images) > 0)
                                                    @if(isset($product_images[0]))
                                                        <div class="flip-card-front">
                                                            <a href="{!! route('product.details', $product['slug']) !!}">
                                                                <img class="img-fluid rotateimg180"
                                                                     onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                                                     src="{!! \App\CPU\ProductManager::product_image_path('product') .'/'. $product_images[0] !!}">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if(isset($product_images[1]))
                                                        <div class="flip-card-back">
                                                            <a href="{!! route('product.details', $product['slug']) !!}">
                                                                <img class="img-fluid rotateimg180"
                                                                 onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                                                 src="{!! \App\CPU\ProductManager::product_image_path('product') .'/'. $product_images[1] !!}">
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>


                                        @if($product['brand'])
                                            <a href="{!! route('shop') . '?id=' . $product['brand']['id'] . '&data_from=brand' !!}"><span
                                                    class="d-block color-or text-center font-14">{!! $product['brand']['name'] !!}</span></a>
                                            @if(isset($product['choice_options']))
                                                @php $choicesArray = json_decode($product['choice_options'], true); @endphp
                                            @endif
                                            @if(count($choicesArray) > 0)
                                                @foreach($choicesArray as $key => $choices)
                                                    @if(strtolower($choices['title']) == 'size')
                                                        <div class="product-grid3">
                                                            <span class="size">{!! implode(" ", $choices['options']) !!}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                        <h4>
                                            <a href="{!! route('product.details', $product['slug']) !!}">{!! $product['name'] !!}</a>
                                        </h4>
                                        {{--                                        <span>${!! number_format($product['unit_price']) !!}</span>--}}
                                        @if($product['discount'] > 0)
                                            <strike>{!! \App\CPU\Helpers::currency_converter($product['unit_price']) !!}</strike>
                                            <span>{!! \App\CPU\Helpers::currency_converter($product['unit_price']-(\App\CPU\Helpers::get_product_discount((object) $product, $product['unit_price']))) !!}</span>
                                        @else
                                            <span>{!! \App\CPU\Helpers::currency_converter($product['unit_price']) !!}</span>
                                        @endif
                                        {{--                                        <fieldset class="rating">--}}
                                        {{--                                            <input type="radio" id="star2" name="rating" value="2"/>--}}
                                        {{--                                            <label class="full"--}}
                                        {{--                                                   for="star2"--}}
                                        {{--                                                   title="Kinda bad - 2 stars"></label>--}}
                                        {{--                                        </fieldset>--}}
                                        @if(auth('customer')->check())
                                            @if(in_array($product['id'], $wishLists))
                                                <a href="#">
                                                    <label class="wrapper">
                                                        <input type="checkbox" checked='checked'
                                                               onclick="window.location.href='{!! route('delete-wishlist', $product['slug']) !!}'">
                                                        <span class="checkmark">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt"
                                                                 viewBox="0 -10 511.98645 511" width="511pt">
                                                            <path class="star_border"
                                                                  d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>
                                                            <path class="star_body"
                                                                  d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>
                                                        </span>
                                                    </label>
                                                </a>
                                            @else
                                                <a href="#">
                                                    <label class="wrapper">
                                                        <input type="checkbox"
                                                               onclick="window.location.href='{!! route('store-wishlist', $product['slug']) !!}'">
                                                        <span class="checkmark">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt"
                                                                 viewBox="0 -10 511.98645 511" width="511pt">
                                                            <path class="star_border"
                                                                  d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>
                                                            <path class="star_body"
                                                                  d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>
                                                        </span>
                                                    </label>
                                                </a>
                                            @endif
                                        @else
                                            <a href="#">
                                                <label class="wrapper">
                                                    <input type="checkbox"
                                                           onclick="window.location.href='{!! route('store-wishlist', $product['slug']) !!}'">
                                                    <span class="checkmark">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt"
                                                                 viewBox="0 -10 511.98645 511" width="511pt">
                                                            <path class="star_border"
                                                                  d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>
                                                            <path class="star_body"
                                                                  d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>
                                                        </span>
                                                </label>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{!! route('shop') . '?data_from=latest' !!}" class="btnx-1">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->

    <section class="bg-imgx">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="baggs-bg">
                        <h2>
                            The Smart Money is on<br>
                            Selling now
                        </h2>
                        <p>Earn $100 extra for a Baf, Watch or Jewellery Item.</p>
                        <a href="{!! route('consign') !!}" class="btnx-4">Start Earning</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->

    <section class="join-ours">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mailsx">
                        <h2>
                            Join Our<br>
                            Mailing List
                        </h2>

                        <p>
                            <span>Get the Latest news on Deals, Products <br>
                            launches, Collaborations and more.</span>
                        </p>

                        <a href="{!! route('customer.auth.register') !!}" class="btnx-3">Sign Up for Emails</a>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="chucks">
                        <h2>
                            Chuck<br> 70
                        </h2>

                        <p>
                            Pride your way with Chucks. Choose <br>
                            from prints inspired
                            by All Stars
                        </p>

                        <a href="{{ url('how-we') }}" class="btnx">
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            Shop All Trending Styles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->

    <section class="bg-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="blue-bg">
                        <span>Huge Summer Sale</span>

                        <h2>
                            upto 70% off
                        </h2>

                        <a href="#" class="btnx-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->

    @if(!empty($home_categories))
        <section class="shp-cate">
            <div class="container">
                <h2>Shop by Category</h2>
                @php $categoryArray = array_chunk($home_categories->childes->toArray(), 4) @endphp
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
{{--                    <ol class="carousel-indicators">--}}
{{--                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>--}}
{{--                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>--}}
{{--                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>--}}
{{--                    </ol>--}}
                    <div class="carousel-inner">
                        @foreach($categoryArray as $pKey => $homeCategories)
                            <div class="carousel-item {!! ($pKey == 0) ? 'active' : '' !!}">
                                <div class="row">
                                    @foreach($homeCategories as $cKey => $childCategory)
                                        <div class="col-md-3">
                                            <img class="d-block w-100"
                                                 onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                                 src="{!! asset("storage/app/public/category/sub-category/" . $childCategory['icon']) !!}"
                                                 alt="{!! $childCategory['name'] !!}" class="img-fluid">
                                            <h6>
                                                <a class="text-black" href="{!! route('shop') . '?id=' . $childCategory['id'] . '&slug=' . $home_categories->slug . '&data_from=category' !!}">{!! $childCategory['name'] !!}</a>
                                            </h6>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(count($categoryArray) > 1)
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if(!empty($shop_by_style))
        <section class="shp-cate">
            <div class="container">
                <h2>Shop by Style</h2>
                @php $shopCategoryArray = array_chunk($shop_by_style->childes->toArray(), 4) @endphp
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    {{--                    <ol class="carousel-indicators">--}}
                    {{--                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>--}}
                    {{--                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>--}}
                    {{--                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>--}}
                    {{--                    </ol>--}}
                    <div class="carousel-inner">
                        @foreach($shopCategoryArray as $pKey => $shopCategories)
                            <div class="carousel-item {!! ($pKey == 0) ? 'active' : '' !!}">
                                <div class="row">
                                    @foreach($shopCategories as $cKey => $shopChildCategory)
                                        <div class="col-md-3">
                                            <img class="d-block w-100"
                                                 onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                                 src="{!! asset("storage/app/public/category/sub-category/" . $shopChildCategory['icon']) !!}"
                                                 alt="{!! $shopChildCategory['name'] !!}" class="img-fluid">
                                            <h6>
                                                <a class="text-black" href="{!! route('shop') . '?id=' . $shopChildCategory['id'] . '&slug=' . $shop_by_style->slug .'&data_from=category' !!}">{!! $shopChildCategory['name'] !!}</a>
                                            </h6>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(count($shopCategoryArray) > 1)
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if(count($look_books) > 0)
            <div class="container threess">
                <div id="carouselExampleCaptions1" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($look_books as $key => $look_book)
                            <li data-target="#carouselExampleCaptions{!! $key !!}" data-slide-to="{!! $key !!}" @if($key == 0) class="active" @endif></li>
                        @endforeach
{{--                        <li data-target="#carouselExampleCaptions1" data-slide-to="1"></li>--}}
                    </ol>

                    <div class="carousel-inner">
                        @foreach($look_books as $key => $look_book)
                            <div class="carousel-item {!! ($key == 0) ? 'active' : '' !!}">
                                <img class="x" src="{!! frontImage('slide.jpg') !!}" class="d-block w-100" alt="...">
                                <div class="carousel-caption">
                                    <div class="row align-items-center">
                                        <div class="col-sm-6">
                                            <div class="youngx">
                                                <h4>{!! $look_book->title !!}</h4>
                                                <a href="{!! route('look_book_gallery', $look_book->slug) !!}" class="btnx-1">{!! $look_book->title !!}</a>
                                            </div>
                                        </div>
                                        <!-- end col-sm-6-->
                                        <div class="col-sm-6">
                                            <img class="img-fluid"
                                                 onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                                 src="{!! asset("storage/app/public/look-book/" . $look_book->banner) !!}">
                                        </div>
                                        <!-- end col-sm-6-->
                                    </div>
                                    <!-- ROW col-sm-6 -->
                                </div>
                                <!-- end carousel-caption-->
                            </div>
                        @endforeach
                    </div>

                    <div class="chevronBtn en-btn">
                        <div class="chevronBtn en-btn">
                            <a class="carousel-control-prev" href="#carouselExampleCaptions1" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleCaptions1" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    @endif
            <div class="container featurex">
                <h2>Featured Collections</h2>

                <div class="row text-center">
                    <div class="col-sm-6">
                        <div class="herosxx">
                            <img src="{!! frontImage('hero.png') !!}">
                            <div class="text-blck">
                                <h6>Margiela, Balenciaga & Vetements Under $400</h6>
                                <a href="#" class="icon"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> </a>
                                <p>
                                    What links Maison Margiela, Balenciaga and Vetements, you <br>
                                    ask? Georgian designer Demna Gvasalia. After cutting his teeth<br>
                                    at Margiela (and later Louis Vuitton), Gvasalia became a...
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <img src="{!! frontImage('nb.png') !!}">
                        <div class="text-blck">
                            <h6>New Balance Under $250</h6>
                            <a href="#" class="icon"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> </a>
                            <p>
                                New Balance has been killing it as of late. From classic<br>
                                silhouettes like the 990 and 993 to well-executed collabs such<br>
                                as Casablanca's take on the 327 or Aimé Leon Dore's...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end container-->

            @if(count($latest_blogs) > 0)
                <div class="container Latest">
                    <h2>Latest Articles</h2>

                    <div class="row">
                        @foreach($latest_blogs as $key => $blog)
                            <div class="col-sm-6">
                                <div class="checksx">
                                    <img src="{!! asset('storage/app/public/blog/'.$blog->image) !!}">
                                    <span>{!! Str::limit($blog->title, 50) !!}</span>
                                    <p>{!! Str::limit(strip_tags($blog->content), 60, ' <a class="text-black bold d-block" href="'.route('blog-details', $blog->id).'">Read More...</a>') !!}</p>
                                </div>
                            </div>
                        @endforeach
                        {{--            <div class="col-sm-6">--}}
                        {{--                <div class="checksx">--}}
                        {{--                    <img src="{!! frontImage('owens.png') !!}">--}}
                        {{--                    <span>SURFACED</span>--}}
                        {{--                    <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>--}}
                        {{--                </div>--}}
                        {{--            </div>--}}

                        <a class="art-readx" href="{!! route('blog') !!}">View All</a>
                    </div>
                </div>
                <!-- end container-->
            @endif

            <section class="how-to-shop">
                <div class="container">
                    <div class="row ">
                        <div class="col-sm-4">
                            <a href="{!! route('shop') . '?data_from=latest' !!}"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> How To Shop</a>
                        </div>

                        <div class="col-sm-4">
                            <a href="{!! route('faq') !!}"> <i class="fa fa-question-circle-o" aria-hidden="true"></i> FAQ's</a>
                        </div>

                        <div class="col-sm-4">
                            <a href="{!! route('contact-us') !!}"> <i class="fa fa-comments" aria-hidden="true"></i> Need Help?</a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="container email">
                <div class="row ">
                    <div class="col-sm-12 text-center">
                        <h2>Become an Rchive Member </h2>

                        <p>Sign up for tailored new arrivals, exciting launches <br> and exclusive early sale access</p>

                        <div class="form-group row">
                            <div class="form-check col-sm-6 rad-women">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                       value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Womenswear
                                </label>
                            </div>

                            <div class="form-check col-sm-6 rad-men">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                       value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Menswear
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="newsletter js-rollover" data-radius="50">
                            <form method="GET" action="https://kikk.us6.list-manage.com/subscribe"
                                  class="newsletter-form" target="_blank">
                                <input type="hidden" name="u" value="d08fe605a9149dc54a3c13f44">
                                <input type="hidden" name="id" value="96f67efdeb">

                                <div class="form-group newsletter-form">
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                           aria-describedby="emailHelp" placeholder="Enter your Email Address">
                                </div>

                                <br/>

                                <button type="submit" class="button">Sign Up</button>

                                <p>
                                    By signing up you agree with our Terms & Conditions and Privacy Policy.<br>
                                    Click Unsubscribe to opt out
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@push('js')
    <script type="text/javascript">
        $('#carouselExampleCaptions1').carousel({
            interval: 1000
        });
    </script>
@endpush
