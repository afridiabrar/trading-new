@extends('layouts.front.app')
@section('title', 'Shop')
@push('css')
    <style type="text/css">

    .side-h {
    text-transform: capitalize !important;
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 0;
    color: #000;
    line-height: 0;

    padding-top: 38px;

    }
    p.side-p {
        font-size: 13px !important;
        font-family: Graphik;
        font-style: normal;
        font-weight: normal;
        line-height: 0px !important;
        color: #838383;
    }
        .nav-tabs > .nav-item > .nav-link {
            margin: 0px 10px !important;
            background-color: transparent;
            border: 1px solid #000;
            font-family: Graphik;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            line-height: 20px;
            text-align: center;
            color: #000;
            padding: 12px 0px !important;
            border-radius: 20px;
            width: 280px;
        }

        .pagi-numx ul li a {
            color: #000;
            font-size: 16px;
            font-family: 'Graphik';
            font-weight: 500;
        }
        .pagi-numx ul li {
            display: inline-block;
        }


        .pagi-numx ul li a:hover {
            background-color: #000 !important;
            color: #fff !important;
            text-decoration: none !important;
        }
        .pagi-numx ul li a {
            transition: .8s;
            color: #000;
            font-size: 16px;
            font-family: 'Graphik';
            font-weight: 500;
            background-color: #fff;
            padding: 15px;
            border-radius: 12px;
        }
    </style>
@endpush
@section('content')
    <section class="sec-filter tabsx-2">
        <div class="container">
            @if(!empty($mainCategory))
            <div class="clmnsxx text-center">
                <h2>{!! $mainCategory->name !!}</h2>
                <p>Explore the complete size? selection of footwear and apparel for men, featuring the latest from
                    sportswear giants Nike, adidas<br>
                    Originals and New Balance, as well as staple streetwear pieces from the likes of Stussy, Carhartt
                    WIP, The North Face and Parlez.</p>
            </div>
            <ul class="nav nav-tabs justify-content-center cv-1" role="tablist">
                @foreach($mainCategory->childes as $key => $childCategory)
                    <li class="nav-item">
                        <a class="nav-link {!! ($_GET['id'] == $childCategory->id && $_GET['data_from'] == 'category') ? 'active' : '' !!}" href="{!! route('shop') . '?id=' . $childCategory->id . '&slug=' . $mainCategory->slug . '&data_from=category' !!}" role="tab" aria-selected="true">
                            {!! $childCategory->name !!}
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr class=" quickkss"></hr>
            @endif
            <div class="row infield">
                <div class="col-sm-1">
                    <label>Sort by:</label>
                </div>
                <div class="col-sm-2">
                    <div class="form-group arrowxx">
                        <select class="form-controlx sortBy" onchange="sortByFilter()" id="exampleSelect1" name="sort_by">
                            <option value="">Select</option>
                            <option value="latest" {!! (isset($_GET['sort_by']) && $_GET['sort_by'] == 'latest') ? 'selected="selected"' : '' !!}>Latest</option>
                            <option value="low-high" {!! (isset($_GET['sort_by']) && $_GET['sort_by'] == 'low-high') ? 'selected="selected"' : '' !!}>Price Low to High</option>
                            <option value="high-low" {!! (isset($_GET['sort_by']) && $_GET['sort_by'] == 'high-low') ? 'selected="selected"' : '' !!}>Price High to Low</option>
                            <option value="a-z" {!! (isset($_GET['sort_by']) && $_GET['sort_by'] == 'a-z') ? 'selected="selected"' : '' !!}>A - Z</option>
                            <option value="z-a" {!! (isset($_GET['sort_by']) && $_GET['sort_by'] == 'z-a') ? 'selected="selected"' : '' !!}>Z - A</option>
                        </select>

                    </div>
                </div>
                <div class="col-sm-1">
                    <label>Filter:</label>
                </div>
                <div class="col-sm-2">
                    <div class="form-group arrowxx">
                        <select class="form-controlx categoryFilter" onchange="categoryFilter()" id="exampleSelect1">
                            <option value="">Select</option>
                            @foreach($categories as $key => $category)
                                <option value="{!! $category->id !!}" {!! (isset($_GET['id']) && $_GET['id'] == $category->id) ? 'selected="selected"' : '' !!}>{!! $category->name !!}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach($categories as $key => $category)
                            <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{!! $category->id !!}"
                                       aria-controls="collapseOne">
                                        {!! $category->name !!}
                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne{!! $category->id !!}" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="clmnssx-1">
                                        @foreach($category->childes as $childKey => $childCategory)
                                            <div class="form-check radio-round">
                                                <a href="{!! route('shop') . '?id=' . $childCategory->id .'&slug='. $category->slug . '&data_from=category' !!}">{!! $childCategory->name !!}</a>
{{--                                                <label><input type="radio" name="radio"> <span class="label-text">{!! $childCategory->name !!} ({!! $childCategory->products_count !!})</span></label>--}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        </div>
                        @endforeach


                        <h4 style="padding: 30px 0px 10px 0px; color: #E09370 !important; font-size: 20px; font-weight: 600;">Recent Products</h4>
                        @foreach($latest_products as $key => $product)
                            <div class="leftbox">
                                <a href="{!! route('product.details', $product->slug) !!}">
                                    <img onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                     src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $product->thumbnail !!}" />
                                </a>
                                @if($product->brand) <a href="{!! route('shop') . '?id=' . $product->brand->id . '&data_from=brand' !!}">
                                    <h3>{!! \Str::limit($product->brand->name, 20, '...') !!}</h3></a> @endif
                                <a href="{!! route('product.details', $product->slug) !!}"><p>{!! $product->name !!}</p></a>
                                <div class="clear"></div>
                            </div>
                        @endforeach
                    </div>
                </div><!-- panel-group -->
                <div class="col-sm-9">
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel">
                            <div class="row">
                                @foreach($products as $key => $product)
                                    <div class="col-sm-4">
                                    <div class="acess-box">
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
                                        @if(auth('customer')->check())
                                            @if(in_array($product['id'], $wishLists))
                                                <a href="#">
                                                    <label class="wrapper">
                                                        <input type="checkbox" checked='checked' onclick="window.location.href='{!! route('delete-wishlist', $product['slug']) !!}'">
                                                        <span class="checkmark">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt" viewBox="0 -10 511.98645 511" width="511pt">
                                                            <path  class="star_border" d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>
                                                            <path  class="star_body" d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>
                                                        </span>
                                                    </label>
                                                </a>
                                            @else
                                                <a href="#">
                                                    <label class="wrapper">
                                                        <input type="checkbox" onclick="window.location.href='{!! route('store-wishlist', $product['slug']) !!}'">
                                                        <span class="checkmark">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt" viewBox="0 -10 511.98645 511" width="511pt">
                                                            <path  class="star_border" d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>
                                                            <path  class="star_body" d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>
                                                        </span>
                                                    </label>
                                                </a>
                                            @endif
                                        @else
                                            <a href="#">
                                                <label class="wrapper" style="z-index: 100">
                                                    <input type="checkbox" onclick="window.location.href='{!! route('store-wishlist', $product['slug']) !!}'">
                                                    <span class="checkmark">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="511pt" viewBox="0 -10 511.98645 511" width="511pt">
                                                            <path  class="star_border" d="m499.574219 188.503906c-3.199219-9.921875-11.988281-16.9375-22.398438-17.898437l-141.355469-12.84375-55.894531-130.835938c-4.117187-9.578125-13.503906-15.765625-23.933593-15.765625-10.433594 0-19.820313 6.207032-23.9375 15.808594l-55.890626 130.816406-141.378906 12.839844c-10.386718.941406-19.175781 7.957031-22.378906 17.878906-3.21875 9.921875-.234375 20.777344 7.617188 27.648438l106.859374 93.695312-31.511718 138.773438c-2.300782 10.199218 1.664062 20.734375 10.136718 26.878906 4.519532 3.328125 9.875 4.992188 15.230469 4.992188 4.628907 0 9.238281-1.234376 13.355469-3.710938l121.898438-72.894531 121.875 72.875c8.917968 5.351562 20.160156 4.882812 28.609374-1.238281 8.46875-6.144532 12.4375-16.683594 10.132813-26.882813l-31.507813-138.769531 106.859376-93.699219c7.847656-6.867187 10.835937-17.726563 7.613281-27.667969zm0 0"/>
                                                            <path  class="star_body" d="m114.617188 491.136719c-5.632813 0-11.203126-1.746094-15.957032-5.183594-8.855468-6.398437-12.992187-17.429687-10.582031-28.09375l32.9375-145.066406-111.703125-97.964844c-8.210938-7.1875-11.347656-18.515625-7.976562-28.90625 3.371093-10.367187 12.542968-17.726563 23.402343-18.730469l147.820313-13.417968 58.410156-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.410156 136.769532 147.796875 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.386718.253906 21.738281-7.980469 28.90625l-111.679688 97.941406 32.9375 145.066406c2.414063 10.667969-1.726562 21.695313-10.578125 28.09375-8.8125 6.378906-20.566406 6.914063-29.890625 1.324219l-127.464843-76.160156-127.445313 76.203125c-4.308594 2.582031-9.109375 3.859375-13.929687 3.859375zm141.375-112.871094c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.769532 1.089843-19.925782 8.621093-26.515625l105.472657-92.523438-139.542969-12.671875c-10.003906-.894531-18.667969-7.1875-22.59375-16.46875l-55.101562-129.046875-55.148438 129.066407c-3.902344 9.238281-12.5625 15.53125-22.589844 16.429687l-139.519531 12.671875 105.46875 92.519531c7.554687 6.59375 10.839844 16.769531 8.621094 26.539063l-31.082031 136.941406 120.277343-71.9375c4.328125-2.558594 9.128907-3.859375 13.972657-3.859375zm-84.585938-221.824219v.019532zm169.152344-.066406v.023438s0 0 0-.023438zm0 0"/></svg>
                                                        </span>
                                                </label>
                                            </a>
                                        @endif

                                        @php $product_images = json_decode($product['images']); @endphp
                                            @if(count($product_images) > 0)
                                                <div class="flip-card">
                                                    <div class="flip-card-inner">
                                                        @if(isset($product_images[0]))
                                                            <div class="flip-card-front">
                                                                <a href="{!! route('product.details', $product->slug) !!}">
                                                                    <img class="img-fluid"
                                                                         onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                                                         src="{!! \App\CPU\ProductManager::product_image_path('product') .'/'. $product_images[0] !!}">
                                                                </a>
                                                            </div>
                                                        @endif
                                                        @if(isset($product_images[1]))
                                                            <div class="flip-card-back">
                                                                <a href="{!! route('product.details', $product->slug) !!}">
                                                                    <img class="img-fluid"
                                                                         onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                                                         src="{!! \App\CPU\ProductManager::product_image_path('product') .'/'. $product_images[1] !!}">
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        <h4 style="margin-top:100px">
                                            @if($product->brand)
                                                <a href="{!! route('shop') . '?id=' . $product['brand']['id'] . '&data_from=brand' !!}">
                                                    <ruby class="d-block pb-1">{!! $product->brand->name !!}</ruby>
                                                </a>
                                            @endif
                                            <br>

                                            <a href="{!! route('product.details', $product->slug) !!}"> {!! $product->name !!} </a>
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
                                            @if($product->discount > 0)
                                                <strike>{!! \App\CPU\Helpers::currency_converter($product->unit_price) !!}</strike>
                                                <span>{!! \App\CPU\Helpers::currency_converter($product->unit_price-(\App\CPU\Helpers::get_product_discount($product, $product->unit_price))) !!}</span>
                                            @else
                                                <span class="d-block pt-1">{!! \App\CPU\Helpers::currency_converter($product->unit_price) !!}</span>
                                            @endif
                                        </h4>

                                    </div>
                                </div>
                                @endforeach
                            </div><!--end row-tab-->
                        </div><!--end pan-tab-->
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row infield">
                        {!! $products->appends($_GET)->links('vendor.pagination.default') !!}
{{--                    <div class="col-sm-6 text-right">--}}
{{--                        <a href="#"><img class="img-fluid text-right" src="{!! frontImage('cc.PNG') !!}"/></a>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </section><!-- end container-->
    <section class="bg-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="blue-bg">
                        <span>Huge Summer Sale</span>
                        <h2>
                            upto 70% off
                        </h2>
                        <a href="{!! route('sellers') !!}" class="btnx-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- end container-->
    <a href="" id="setUrl"></a>
@endsection

@push('js')
    <script type="text/javascript">
        function sortByFilter () {
            if ($('.sortBy').val() != "") {
                let queryString = window.location.search;
                let params = new URLSearchParams(queryString);
                params.delete('sort_by')
                params.append('sort_by', $('.sortBy').val());
                document.location.href = "?" + params.toString();
            }
            return false;
        }

        function categoryFilter () {
            if ($('.categoryFilter').val() != "") {
                let queryString = window.location.search;
                let params = new URLSearchParams(queryString);
                params.delete('id')
                params.append('id', $('.categoryFilter').val());
                document.location.href = "?" + params.toString();
            }
            return false;
        }
    </script>
@endpush
