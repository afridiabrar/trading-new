<div class="container">
    <div class="hideboth">
        <div class="arrivalscon">
            <nav class="navbar navbar-expand-lg navbar-light bg-broder">
                <a class="navbar-brand" href="{!! route('home') !!}"><img src="{!! frontImage('fl-logo.png') !!}"></a>
                <ul class="nav navbar-nav navbar-right hidden-menu">
                    <li class="nav-item">
                        <button class="canvasx"><img src="{!! frontImage('cart.png') !!}"></button>
                        <!--<a class="canvasx" href="{!! url('url') !!}"><img src="{!! frontImage('cart.png') !!}"></a>-->
                        <span ID="lblCartCount" Class="badge badge-warning"  ForeColor="White">3</span></a>
                    </li>
                </ul>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {!! (isset($_GET['data_from']) && $_GET['data_from'] == 'latest' && Request::is('shop') == 1) ? 'active' : '' !!}"><a class="nav-link" href="{!! route('shop') . '?data_from=latest' !!}">New Arrivals<span
                                    class="sr-only">(current)</span></a></li>
                        <li class="nav-item {!! (Request::is('brands') == 1) ? 'active' : '' !!}"><a class="nav-link" href="{!! route('brands') !!}">Brands</a></li>
                        @foreach(\App\CPU\CategoryManager::parents() as $key => $categories)
                            <li class="nav-item {!! (isset($_GET['slug']) && $_GET['slug'] == $categories->slug && Request::is('shop') == 1) ? 'active' : '' !!}"><a class="nav-link" href="{!! route('shop') . '?id=' . $categories->id . '&slug=' . $categories->slug .'&data_from=category' !!}">{!! $categories->name !!}</a></li>
                        @endforeach

                        <li class="nav-item {!! (isset($_GET['data_from']) && $_GET['data_from'] == 'sale' && Request::is('shop') == 1) ? 'active' : '' !!}"><a class="nav-link" href="{!! route('shop') . '?data_from=sale' !!}">SALE</a></li>
                        <li class="nav-item"><a class="nav-link hidden-menu" href="{!! route('blog') !!}">Blog</a></li>
                        <li class="nav-item"><a class="nav-link hidden-menu" href="{!! route('consign') !!}">Consign</a></li>
                        <li class="nav-item"><a class="nav-link hidden-menu" href="{!! route('pull') !!}">Pull</a></li>
                        <li class="nav-item pl-2 mb-2 mb-md-0 hidden-menu">
                            <a href="" data-toggle="modal" data-target="#exampleModal" type="button"
                               class="btn btn-outline-info btn-md btn-rounded btn-navbar waves-effect waves-light login">Login</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item pl-2 mb-2 mb-md-0">
                            <a href="{!! route('request') !!}" type="button"
                               class="btn btn-outline-info btn-md btn-rounded btn-navbar waves-effect waves-light">Request
                                an Item</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div><!-- end arrivalscon-->
        <div class="blogcon">
            <nav class="navbar navbar-expand-lg navbar-light bg-broder">
                <a class="navbar-brand" href="{!! route('home') !!}"><img alt="{!! $web_config['name']->value!!}"
                                                                          onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'"
                                                                          src="{!! asset("storage/app/public/company") .'/'. $web_config['web_logo']->value !!}"></a>
                <ul class="nav navbar-nav navbar-right hidden-menu">
                    <li class="nav-item">
                        <button class="canvasx"><img src="{!! frontImage('cart.png') !!}"></button>
                        <span ID="lblCartCount" Class="badge badge-warning"  ForeColor="White">3</span>
                        <!--<a class="canvasx" href="{!! url('cart') !!}"><img src="{!! frontImage('cart.png') !!}"></a>-->
                    </li>
                </ul>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item b-shop"><a class="nav-link" href="{!! route('shop') . '?data_from=latest' !!}"><img
                                    src="{!! frontImage('arrow-big2.png') !!}"> Back to Shop</a></li>
                    </ul>
                    <ul class="navbar-nav mr-auto blog-menu">
                        <li class="nav-item {!! (isset($_GET['data_from']) && $_GET['data_from'] == 'latest' && Request::is('shop') == 1) ? 'active' : '' !!}"><a class="nav-link" href="{!! route('shop') . '?data_from=latest' !!}">New Arrivals<span
                                    class="sr-only">(current)</span></a></li>
                        <li class="nav-item {!! (Request::is('brands') == 1) ? 'active' : '' !!}"><a class="nav-link" href="{!! url('brand') !!}">Brands</a></li>
                        @foreach(\App\CPU\CategoryManager::parents() as $key => $categories)
                            <li class="nav-item {!! (isset($_GET['slug']) && $_GET['slug'] == $categories->slug && Request::is('shop') == 1) ? 'active' : '' !!}"><a class="nav-link" href="{!! route('shop') . '?id=' . $categories->id . '&slug=' . $categories->slug . '&data_from=category' !!}">{!! $categories->name !!}</a></li>
                        @endforeach

                        <li class="nav-item {!! (isset($_GET['data_from']) && $_GET['data_from'] == 'sale' && Request::is('shop') == 1) ? 'active' : '' !!}"><a class="nav-link" href="{!! route('shop') . '?data_from=sale' !!}">SALE</a></li>
                        <li class="nav-item"><a class="nav-link hidden-menu" href="{!! route('blog') !!}">Blog</a></li>
                        <li class="nav-item"><a class="nav-link hidden-menu" href="{!! route('consign') !!}">Consign</a></li>
                        <li class="nav-item"><a class="nav-link hidden-menu" href="{!! route('pull') !!}">Pull</a></li>
                        <li class="nav-item pl-2 mb-2 mb-md-0 hidden-menu">
                            <a href="" data-toggle="modal" data-target="#exampleModal" type="button"
                               class="btn btn-outline-info btn-md btn-rounded btn-navbar waves-effect waves-light login">Login</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right blog-menu">
                        <li class="nav-item pl-2 mb-2 mb-md-0">
                            <a href="{!! route('request') !!}" type="button"
                               class="btn btn-outline-info btn-md btn-rounded btn-navbar waves-effect waves-light">Request
                                an Item</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item pl-2 mb-2 mb-md-0">
                            <a href="#!" type="button"
                               class="btn btn-outline-info btn-md btn-rounded btn-navbar waves-effect waves-ligh subscribe-btn">Subscribe</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div><!-- end blogcon-->
    </div>
    <div class="headertbottom">! Note: Do Not Delete It; this div is for (jQuery)</div>
</div><!-- Nav Container -->
