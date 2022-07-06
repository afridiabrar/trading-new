@extends('layouts.front.app')

@section('title', 'Gallery')

@section('content')
    <div class="container sec-filter">
        <h2>The First Season</h2>
    </div>
    <div class="container imgx">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="row text-center">
                    <div class="col-sm-3">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image2.png') !!}">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                    </div>
                    <div class="col-sm-3">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image2.png') !!}">
                    </div>
                    <div class="col-sm-3">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image2.png') !!}">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                    </div>
                    <div class="col-sm-3">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                        <img class="img-fluid" src="{!! frontImage('image2.png') !!}">
                        <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-3">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image2.png') !!}">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
            </div>
            <div class="col-sm-3">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image2.png') !!}">
            </div>
            <div class="col-sm-3">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image2.png') !!}">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
            </div>
            <div class="col-sm-3">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
                <img class="img-fluid" src="{!! frontImage('image2.png') !!}">
                <img class="img-fluid" src="{!! frontImage('image1.jpg') !!}">
            </div>
            <a href="https://demo-client-websites.com/rchive/look-book.php" class="btnx-1 look-back">Back To Look
                Book's</a>
        </div>
    </div>
    </div>
    </div>
    <!-- END BOX-1 -->
    <!--
    <div class="container imgx">
    <div class="row">
    <div class="col-md-12 text-center">
      <div class="row text-center">
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
      </div>
    </div>
    <div class="col-md-12 positionx-box">
      <div class="row">
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2 positionx-h">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2 positionx-h">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image2.png">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
      </div>
    </div>
    <div class="col-md-12 positionx-box">
      <div class="row">
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image2.png">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image2.png">
        </div>
        <div class="col-sm-2">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/image1.jpg">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/gal01.png">
        </div>
        <div class="col-sm-2">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/gal02.png">
        </div>
        <div class="col-sm-2">
        </div>
        <div class="col-sm-2 positionx">
          <img class="img-fluid" src="images/gal03.png">
        </div>
      </div>
    </div>
    </div>
    </div> -->
    <div class="container sec-filter">
        <h2>Saw Something you liked?</h2>
    </div>
    <div class="container">
        <div class="row innercol">
            <div class="col-sm-3">
                <div class="acess-box">
                    <img src="{!! frontImage('gr-1.png') !!}">
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
                    <img src="{!! frontImage('gr-2.png') !!}">
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
                    <img src="{!! frontImage('gr-1.png') !!}">
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
                    <img src="{!! frontImage('gr-2.png') !!}">
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
                    <img src="{!! frontImage('gr-1.png') !!}">
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
                    <img src="{!! frontImage('gr-2.png') !!}">
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
                    <img src="{!! frontImage('gr-1.png') !!}">
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
                    <img src="{!! frontImage('gr-2.png') !!}">
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
                    <img src="{!! frontImage('gr-1.png') !!}">
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
                    <img src="{!! frontImage('gr-2.png') !!}">
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
                    <img src="{!! frontImage('gr-1.png') !!}">
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
                    <img src="{!! frontImage('gr-2.png') !!}">
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
                    <img src="{!! frontImage('gr-1.png') !!}">
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
                    <img src="{!! frontImage('gr-2.png') !!}">
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
                    <img src="{!! frontImage('gr-1.png') !!}">
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
                    <img src="{!! frontImage('gr-2.png') !!}">
                    <h4>
                        <ruby>Popular</ruby>
                        <br>
                        Nike Sportswear Premium Hooded M65 Jacket
                    </h4>
                    <span>$130.00</span>
                </div>
            </div>
        </div><!-- end row -->
    </div><!--end container -->
@endsection
