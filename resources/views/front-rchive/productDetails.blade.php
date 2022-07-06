@extends('layouts.front.app')
@section('title', 'Product Details')
@section('content')
    <div class="container pro-detail">
        <h2 class="text-center detail-hdng">Product Detail</h2>
        <div class="row">
            <div class="col-md-6">
                <img class="img-fluid" src="{!! frontImage('red-shoe.png') !!}">
                <h5>More Pictures</h5>
                <div class="row product-carousel">
                    <div class="col-md-3 col-xs-12"><img class="img-fluid" src="{!! frontImage('red-shoe-2.png') !!}"></div>
                    <div class="col-md-3 col-xs-12"><img class="img-fluid" src="{!! frontImage('red-shoe-3.png') !!}"></div>
                    <div class="col-md-3 col-xs-12"><img class="img-fluid" src="{!! frontImage('red-shoe-2.png') !!}"></div>
                    <div class="col-md-3 col-xs-12"><img class="img-fluid" src="{!! frontImage('red-shoe-3.png') !!}"></div>
                </div>
            </div>
            <div class="col-md-6">
                <h3><span>Sale</span><br>
                    Nike Sportswear Premium Hooded <br>M65 Jacket</h3>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting <br>
                    industry. Lorem Ipsum has been the industry's standard dummy text <br>
                    ever since the 1500s, when an unknown printer took a galley of type <br>
                    and scrambled it to make a type specimen book.
                </p>

                <img class="detail-img" src="{!! frontImage('') !!}candi.png">
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting <br>
                    industry. Lorem Ipsum has been the industry's standard
                </p>
                <h2>$80.00</h2>
                <h6>$130.00</h6>
                <ul class="cart">
                    <li><a href="#">Add to Cart</a></li>
                    <li><a href="#">Buy Now</a></li>
                </ul>
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
                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                    Product Description
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                    Shipment & Return
                                </a>
                            </li>
                            <!--             <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                    Messages
                                </a>
                            </li> -->
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <h3>What is Lorem Ipsum?</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy text <br> ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen
                                    bookLorem Ipsum is simply dummy text of the <br>
                                    printing and typesetting industry. Lorem Ipsum has been the industry's standard
                                    dummy text ever since the 1500s, when an unknown <br>
                                    printer took a galley of type and scrambled it to make a type specimen book.</p>
                                <h3>Why do we use it?</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy text <br> ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen
                                    bookLorem Ipsum is simply dummy text of the <br>
                                    printing and typesetting industry. Lorem Ipsum has been the industry's standard
                                    dummy text ever since the 1500s, when an unknown <br>
                                    printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="tab-pane" id="profile" role="tabpanel">
                                <h3>What is Lorem Ipsum?</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy text <br> ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen
                                    bookLorem Ipsum is simply dummy text of the <br>
                                    printing and typesetting industry. Lorem Ipsum has been the industry's standard
                                    dummy text ever since the 1500s, when an unknown <br>
                                    printer took a galley of type and scrambled it to make a type specimen book.</p>
                                <h3>Why do we use it?</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy text <br> ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen
                                    bookLorem Ipsum is simply dummy text of the <br>
                                    printing and typesetting industry. Lorem Ipsum has been the industry's standard
                                    dummy text ever since the 1500s, when an unknown <br>
                                    printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <!--             <div class="tab-pane" id="messages" role="tabpanel">
                                <p>I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. So when you get something that has the name Kanye West on it, it’s supposed to be pushing the furthest possibilities. I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus.</p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="container pro-comment">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Comments</h4>
                        <div class="comment-des">
                            <h4>User <span>02 days ago</span></h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text <br>
                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to
                                make a type specimen book. It has survived <br>
                                not only five centuries, but also the leap into electronic typesetting, remaining
                                essentially unchanged. It was popularised in the <br>
                                1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                recently with desktop publishing software like <br>
                                Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                        </div>
                        <div class="comment-des">
                            <h4>User <span>04 days ago</span></h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text <br>
                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to
                                make a type specimen book.
                            </p>
                        </div>
                        <div class="comment-des">
                            <h4>User <span>05 days ago</span></h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text <br>
                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to
                                make a type specimen book. It has survived <br>
                                not only five centuries, but also the leap into electronic typesetting, remaining
                                essentially unchanged.
                            </p>
                        </div>
                        <div class="comment-des">
                            <h4>User <span>06 days ago</span></h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text <br>
                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to
                                make a type specimen book. It has survived <br>
                                not only five centuries, but also the leap into electronic typesetting, remaining
                                essentially unchanged. It was popularised in the <br>
                                1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                recently with desktop publishing software like <br>
                                Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                        </div>
                        <div class="comment-des">
                            <h4>User <span>07 days ago</span></h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text <br>
                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to
                                make a type specimen book.
                            </p>
                        </div>
                        <div class="comment-des">
                            <h4>User <span>07 days ago</span></h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text <br>
                                ever since the 1500s, when an unknown printer took a galley of type and scrambled it to
                                make a type specimen book. It has survived <br>
                                not only five centuries, but also the leap into electronic typesetting, remaining
                                essentially unchanged.
                            </p>
                        </div>
                        <div class="comment-des comment-here">
                            <h4>John Deo</h4>

                            <div class="widget-area no-padding blank">
                                <div class="status-upload">
                                    <form>
                                        <textarea placeholder="Comment"></textarea>
                                        <ul>
                                            <li><a title="" data-toggle="tooltip" data-placement="bottom"
                                                   data-original-title="Audio"><i class="fa fa-music"></i></a></li>
                                            <li><a title="" data-toggle="tooltip" data-placement="bottom"
                                                   data-original-title="Video"><i class="fa fa-video-camera"></i></a>
                                            </li>
                                            <li><a title="" data-toggle="tooltip" data-placement="bottom"
                                                   data-original-title="Sound Record"><i
                                                        class="fa fa-microphone"></i></a></li>
                                            <li><a title="" data-toggle="tooltip" data-placement="bottom"
                                                   data-original-title="Picture"><i class="fa fa-picture-o"></i></a>
                                            </li>
                                        </ul>
                                        <button type="submit" class="btnx-1"> Post</button>
                                    </form>
                                </div><!-- Status Upload  -->
                            </div><!-- Widget Area -->
                        </div>


                    </div>
                </div>
            </div>
            <div class="container related-pro">
                <h2 class="text-center">Product You Viewed</h2>
                <div class="row">
                    <div class="col-sm-3">

                        <div class="acess-box">
                            <img src="{!! frontImage('nike-3.png') !!}">
                            <h4>
                                <ruby>New Arrival</ruby>
                                <br>
                                Nike Sportswear Premium Hooded M65 Jacket
                            </h4>
                            <span>$130.00</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="acess-box">
                            <img src="{!! frontImage('nike-3.png') !!}">
                            <h4>
                                <ruby>New Arrival</ruby>
                                <br>
                                Nike Sportswear Premium Hooded M65 Jacket
                            </h4>
                            <span>$130.00</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="acess-box">
                            <img src="{!! frontImage('nike-1.png') !!}">
                            <h4>
                                <ruby>Popular</ruby>
                                <br>
                                Nike Sportswear Premium Hooded M65 Jacket
                            </h4>
                            <span>$130.00</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="acess-box">
                            <img src="{!! frontImage('nike-2.png') !!}">
                            <h4>
                                <ruby>New Arrival</ruby>
                                <br>
                                Nike Sportswear Premium Hooded M65 Jacket
                            </h4>
                            <span>$130.00</span>
                        </div>
                    </div>
                </div>
                <h2 class="text-center">Related Products</h2>
                <div class="row">
                    <div class="col-sm-3">

                        <div class="acess-box">
                            <img src="{!! frontImage('nike-3.png') !!}">
                            <h4>
                                <ruby>New Arrival</ruby>
                                <br>
                                Nike Sportswear Premium Hooded M65 Jacket
                            </h4>
                            <span>$130.00</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="acess-box">
                            <img src="{!! frontImage('nike-3.png') !!}">
                            <h4>
                                <ruby>New Arrival</ruby>
                                <br>
                                Nike Sportswear Premium Hooded M65 Jacket
                            </h4>
                            <span>$130.00</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="acess-box">
                            <img src="{!! frontImage('nike-1.png') !!}">
                            <h4>
                                <ruby>Popular</ruby>
                                <br>
                                Nike Sportswear Premium Hooded M65 Jacket
                            </h4>
                            <span>$130.00</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="acess-box">
                            <img src="{!! frontImage('nike-2.png') !!}">
                            <h4>
                                <ruby>New Arrival</ruby>
                                <br>
                                Nike Sportswear Premium Hooded M65 Jacket
                            </h4>
                            <span>$130.00</span>
                        </div>
                    </div>
                    <a href="#" class="btnx-1">Shop More</a>
                </div>
            </div>
            <!-- end container-->
@endsection
