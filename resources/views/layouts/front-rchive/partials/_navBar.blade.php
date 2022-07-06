<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light top-header">
        <a class="navbar-brand" href="{!! route('home') !!}"><img src="{!! frontImage('fl-logo.png') !!}"></a>
        <form class="form-inline" action="{!! route('shop') !!}" method="GET">
            <input type="hidden" name="data_from" value="search">
            <input class="form-control mr-sm-2 top-field" type="text" name="name" placeholder="Search your Items here"
                   aria-label="Search">
            <button class="btn2 btn-outline-success my-2 my-sm-0" type="submit">S</button>
        </form>

        <ul class="nav navbar-nav navbar-right rightbefore">
            <li class="nav-item"><a class="nav-link" href="{!! route('blog') !!}">Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="{!! url('consign') !!}">Consign</a></li>
            <li class="nav-item"><a class="nav-link" href="{!! route('pull') !!}">Pull</a></li>
            <li class="nav-item">
                <button class="canvasx"><img src="{!! frontImage('cart.png') !!}"></button>
                <span ID="lblCartCount" Class="badge badge-warning"  ForeColor="White"> {!! ((session()->has('cart') && count(session()->get('cart')) > 0)) ? count(session()->get('cart')) : 0 !!}</span>
                <!--
                <a class="canvasx" href="{!! url('cart') !!}">
                    <img src="{!! frontImage('cart.png') !!}">
                </a>
                -->
            </li>
            <li class="nav-item">
                <!-- <div class="canvasx">TT</div> -->
            </li>
            @if(auth('customer')->check())
                <li class="nav-item dropdown">
                    <span class="hello-user">Hello, {!! auth('customer')->user()->f_name !!}</span>
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown-menu-login" href="{!! route('user-account') !!}" role="button" aria-haspopup="true" aria-expanded="false">Dashboard</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{!! route('user-account') !!}">My Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{!! route('customer.auth.logout') !!}">Logout</a>
                    </div>
                </li>
            @else
                <li class="nav-item pl-2 mb-2 mb-md-0">
                    <a href="" data-toggle="modal" data-target="#exampleModal" type="button"
                    class="btn btn-outline-info btn-md btn-rounded btn-navbar waves-effect waves-light login">Login</a>
                </li>
            @endif
        </ul>
    </nav>
</div>


    <input type="checkbox" id="openSidebarMenu">

    <label for="openSidebarMenu" class="sidebarIconToggle">
        <div class="spinner top"></div>
        <div class="spinner middle"></div>
        <div class="spinner bottom"></div>
    </label>

    <div id="sidebarMenu">
        <div class="closeDv" style="display: none;">
            <figure>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z"/>
                        </g>
                    </g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                </svg>
            </figure>
        </div>

        <ul class="menu">
            <input type="checkbox" id="openSidebarMenu">
            <label for="openSidebarMenu" class="sidebarIconToggle">
                <div class="spinner top"></div>
                <div class="spinner middle"></div>
                <div class="spinner bottom"></div>
            </label>

            {{-- <li>
                <a class="canvasx" href="{!! route('shop-cart') !!}">
                    <img src="{!! frontImage('cart.png') !!}">
                </a>
                <input class="form-control mr-sm-2 top-field" type="search" placeholder="Search your Items here" aria-label="Search">
            </li> --}}

            @if(session()->has('cart') && count(session()->get('cart')) > 0)
                @php($sub_total=0)
                @php($total_tax=0)
                @foreach(session()->get('cart') as $key => $cartItem)
                    <div class="cart-item">
                    <a href="{!! route('product.details', $cartItem['slug']) !!}">
                        <div class="imgBox">
                            <figure>
                                <img src="{!! \App\CPU\ProductManager::product_image_path('thumbnail') .'/'. $cartItem['thumbnail'] !!}" alt="{!! $cartItem['name'] !!}">
                            </figure>
                        </div>
                    </a>

                    <div class="cart-spec">
                        @if(isset($cartItem['brand']))
                            <h4 class="title">{!! $cartItem['brand'] !!}</h4>
                        @endif
                        <div class="breifDv">
                            <a href="{!! route('product.details', $cartItem['slug']) !!}">
                                <p class="short-breif">
                                    {!! $cartItem['name'] !!}
                                </p>
                            </a>
                            <p class="price">
                                {!! $cartItem['quantity'] !!} x @if($cartItem['discount'] > 0) <strike>{!! \App\CPU\Helpers::currency_converter($cartItem['price']) !!}</strike> <span>{!! \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']) !!}</span> @else <span>{!! \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']) !!}</span> @endif
                            </p>
{{--                            <p class="price">--}}
{{--                                1 x <strike>$55</strike> <span>$52</span>--}}
{{--                            </p>--}}
                        </div>

                        @if(count($cartItem['variations']) > 0)
                            @foreach($cartItem['variations'] as $key => $variation)
                                <div class="breifDv">
                                    <p class="property">
                                        {!! ucwords($key) !!}
                                    </p>

                                    <p class="value">
                                        {!! ucwords($variation) !!}
                                    </p>
                                </div>
                            @endforeach
                        @endif

{{--                        <div class="breifDv">--}}
{{--                            <p class="property">--}}
{{--                                Type--}}
{{--                            </p>--}}

{{--                            <p class="value">--}}
{{--                                Lillooei--}}
{{--                            </p>--}}
{{--                        </div>--}}

{{--                        <div class="breifDv">--}}
{{--                            <p class="property">--}}
{{--                                Color--}}
{{--                            </p>--}}

{{--                            <p class="value">--}}
{{--                                <span class="color" style="background: #744438;"></span>--}}
{{--                            </p>--}}
{{--                        </div>--}}
                    </div>
                </div>
                @php($sub_total+=($cartItem['price']-$cartItem['discount'])*$cartItem['quantity'])
                @php($total_tax+=$cartItem['tax']*$cartItem['quantity'])
                @endforeach

                <div class="subtotalDv">
                    <h4 class="property">Subtotal</h4>
                    <p class="value">
{{--                        <strike>$110</strike>--}}
                        <span>{!! \App\CPU\Helpers::currency_converter($sub_total) !!}</span>
                    </p>
                </div>
            @else
                <div class="subtotalDv">
                    <p class="value">
                        <span>No Items in your basket!</span>
                    </p>
                </div>
            @endif

{{--            <div class="leftbox01 d-none">--}}
{{--                <img src="{!! frontImage('cvc.jpg') !!}">--}}
{{--                <h3>A.P.C.</h3>--}}
{{--                <p>Gregoire blouson jacket</p>--}}
{{--                <p>1 x <strike>855</strike> <span>$52</span></p>--}}

{{--                <p>Size 2XS.</p> <br/>--}}
{{--                <p>Lillooei</p> <br/><br/>--}}
{{--                <p>#81886</p> <br/>--}}
{{--                <div class="clear"></div>--}}
{{--            </div>--}}
{{--            <div class="leftbox01 d-none">--}}
{{--                <img src="{!! frontImage('cvc.jpg') !!}">--}}
{{--                <h3>A.P.C.</h3>--}}
{{--                <p>Gregoire blouson jacket</p> <br/>--}}
{{--                <p>1 x <strong>855</strong> <span>$52</span></p><br/> <br/>--}}
{{--                <p>Size 2XS.</p> <br/>--}}
{{--                <p>Lillooei</p> <br/><br/>--}}
{{--                <p>#81886</p> <br/>--}}
{{--                <div class="clear"></div>--}}
{{--                <h4>Subtotal <span>$52</span> <strong>$855</strong></h4>--}}
{{--            </div>--}}
            <a class="btn-bv" href="{!! route('shop-cart') !!}">View Bag</a>
        </ul>
    </div>
