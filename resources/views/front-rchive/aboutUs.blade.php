@extends('layouts.front.app')
@section('title', 'About Us')
@section('content')
    <section class="about-banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>
                        Rchive is the one-stop destination for <br>
                        buying, selling and exploring.
                    </h3>
                </div>
            </div>
        </div>
    </section>
    <div class="teamx">
        <div class="container bestxx">
            <div class="col-sm-12">
                <h4 class="hx">Our Collection</h4>
            </div>
            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                    <!-- <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li> -->
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="x2" src="{!! frontImage('slide.jpg') !!}" class="d-block w-100" alt="...">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col-sm-5 offset-lg-2 leftc text-left">
                                    <div class="the-bestx">
                                        <h4>The Best Selection, at the Best Prices</h4>
                                        <p>Browse our marketplace for incredible new and used <br>
                                            clothing that you can’t find anywhere else. We curate the <br>
                                            largest men’s fashion marketplace, with new products <br>
                                            arriving every day. Rchive, with help from community, <br>
                                            ensures all items are authentic. If anything goes wrong, <br>
                                            every transaction conducted through Rchive with PayPal <br>
                                            is eligible for a full refund. </p>
                                        <a href="#" class="btnx-1">Browse Shop</a>
                                        <a href="#" class="btnx">Buyer Protection</a>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <img class="img-fluid" src="{!! frontImage('hoodies.png') !!}">
                                </div>
                            </div><!-- ROW col-sm-6 -->
                        </div><!-- end carousel-caption-->
                    </div><!-- end carousel-item -->
                    <div class="carousel-item">
                        <img class="x2" src="{!! frontImage('slide.jpg') !!}" class="d-block w-100" alt="...">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col-sm-5 offset-lg-2 leftc text-left">
                                    <div class="the-bestx">
                                        <h4>The Best Selection, at the Best Prices</h4>
                                        <p>Browse our marketplace for incredible new and used <br>
                                            clothing that you can’t find anywhere else. We curate the <br>
                                            largest men’s fashion marketplace, with new products <br>
                                            arriving every day. Rchive, with help from community, <br>
                                            ensures all items are authentic. If anything goes wrong, <br>
                                            every transaction conducted through Rchive with PayPal <br>
                                            is eligible for a full refund. </p>
                                        <a href="#" class="btnx-1">Browse Shop</a>
                                        <a href="#" class="btnx">Buyer Protection</a>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <img src="{!! frontImage('cate.png') !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end carousel-caption-->
                    <!-- end carousel-item -->
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="container bestxx">
            <div class="row">
                <div class="col-sm-5 offset-sm-1">
                    <div class="makex">
                        <img class="img-fluid" src="{!! frontImage('cate.png') !!}">
                    </div>
                </div>
                <div class="col-sm-5 ">
                    <div class="the-bestx">
                        <h4>
                            The Best Selection, at the Best Prices
                        </h4>
                        <p>
                            Browse our marketplace for incredible new and used <br>
                            clothing that you can’t find anywhere else. We curate the <br>
                            largest men’s fashion marketplace, with new products <br>
                            arriving every day. Rchive, with help from community, <br>
                            ensures all items are authentic. If anything goes wrong, <br>
                            every transaction conducted through Rchive with PayPal <br>
                            is eligible for a full refund.
                        </p>
                        <a href="#" class="btnx-1">Browse Shop</a>
                        <a href="#" class="btnx">Buyer Protection</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container bestxx">
            <div class="row">
                <div class="col-sm-5">
                    <div class="makex">
                        <img class="img-fluid" src="{!! frontImage('mbl.png') !!}">
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="the-bestx dryx">
                        <h4>
                            Shop, Study, Stay in the Know
                        </h4>
                        <p>
                            Dry Clean Only, our exclusive editorial platform, provides unique <br>
                            perspective on designers, drops and more. From designer archives to <br>
                            celebrity closet sales, it’s yourspringboard to shop the best pieces on
                            <br>the planet.
                        </p>
                        <a href="#" class="btnx-1">Latest Articles</a>
                    </div>
                    <img class="img-fluid singlexx" src="{!! frontImage('collection.png') !!}">
                </div>
            </div>
        </div>
        <section class="be-social">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3>
                            Be Social
                        </h3>
                        <h5>
                            Follow us on Instagram and Twitter to keep <br>
                            up on the biggest drops and best pieces. Get <br>
                            inspired by our community who love to share <br>
                            their style.
                        </h5>
                        <a href="#" class="btnx-1">Join Instagram</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
