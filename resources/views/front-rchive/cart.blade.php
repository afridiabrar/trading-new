@extends('layouts.front.app')
@section('title', 'Cart')
@section('content')
    <div class="container">
        <div class="clmnsxx text-center">
            <h2>Shopping Cart</h2>
        </div>
    </div><!-- end container-->
    <section class="check-sec">
        <div class="container">
            <div class="row borderit">
                <div class="col-sm-8">
                    <div class="cont-formx">
                        <div class="contact-inner">
                            <form id="contact-form" method="post" action="" role="form">





                                <div class="row innerborderx xd-1">
                                    <div class="col-md-6">

                                        <h4>Product Details</h4>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <h4>Quantity</h4>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <h4>Price</h4>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <h4>Total</h4>
                                    </div>
                                </div>
                                <div class="row innerborderx2 ">
                                    <div class="col-md-6">
                                        <h4 class="magical">Product Details</h4>
                                        <div class="leftbox02">
                                            <img src="{!! frontImage('t1.png') !!}">
                                            <h3>PALMIERE</h3>
                                            <p>Product Code: 00000</p>
                                            <h2>Remove</h2>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <h4 class="magical">Quantity</h4>
                                        <input class="qtyx" type="number" value="1" min="0" max="20" step="1">

                                    </div>
                                    <div class="col-md-2 text-right">
                                        <h4 class="magical">Price</h4>
                                        <h5>$85</h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h4 class="text-right magical">Total</h4>
                                        <h5>$85</h5>
                                        <h6>Edit</h6>
                                        <span>Save For Later</span>
                                    </div>

                                </div>
                                <div class="row innerborderx2">
                                    <div class="col-md-6">
                                        <h4 class="magical">Product Details</h4>
                                        <div class="leftbox02">
                                            <img src="{!! frontImage('t1.png') !!}">
                                            <h3>PALMIERE</h3>
                                            <p>Product Code: 00000</p>
                                            <h2>Remove</h2>
                                            <div class="clear"></div>
                                        </div>

                                    </div>
                                    <div class="col-md-2 text-center">
                                        <h4 class="magical">Quantity</h4>
                                        <input class="qtyx" type="number" value="1" min="0" max="20" step="1">

                                    </div>
                                    <div class="col-md-2 text-right">
                                        <h4 class="magical">Price</h4>
                                        <h5>$85</h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h4 class="text-right magical">Total</h4>
                                        <h5>$85</h5>
                                        <h6>Edit</h6>
                                        <span>Save For Later</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- end cont-formx-->
                </div><!-- end col-sm-7-->
                <div class="col-sm-4">
                    <div class="innerdetail inx">
                        <h3>Cart Total </h3>
                        <div class="totalprice totalprice-in cart-all-detailx">
                            <p>Subtotal <span>$385</span></p>
                            <p class="borderlast">Tax <span>$0.00</span></p>
                            <div class="grandtotal">
                                <p>Total <span>$385</span></p>
                            </div>
                            <p align="center" class="center-block">Shipping calculated at next step*</p>
                            <a href="billing.php" class="btn-proc">Proceed to Checkout</a>
                            <a href="paypal.php" class="btn-pay">Paypal</a>
                            <div class="clear"></div>
                        </div><!-- end totalbox-->
                    </div><!-- end innerdetail -->
                </div><!--end col-sm-5-->
            </div>
        </div>
    </section>
    <!-- end container-->
    <div class="container">
        <div class="spacein text-center">
            <h2>Related Products</h2>
        </div>
        <div class="col-sm-12 text-center ">
            <div class="row">
                <div class="col-sm-3">
                    <div class="mini-box">
                        <img src="{!! frontImage('jacket-6.png') !!}">
                        <h4>A.P.C.<br>
                            Gregoire blouson jacket</h4>
                        <span>$240</span>
                        <fieldset class="rating">
                            <input type="radio" id="star1" name="rating" value="1"/><label class="full" for="star1"
                                                                                           title="Sucks big time - 1 star"></label>
                        </fieldset>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mini-box">
                        <img src="{!! frontImage('jacket.png') !!}">
                        <h4>A.P.C.<br>
                            Gregoire blouson jacket</h4>
                        <span>$240</span>
                        <fieldset class="rating">
                            <input type="radio" id="star2" name="rating" value="2"/><label class="full" for="star2"
                                                                                           title="Kinda bad - 2 stars"></label>
                        </fieldset>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mini-box">
                        <img src="{!! frontImage('jacket.png') !!}">
                        <h4>A.P.C.<br>
                            Gregoire blouson jacket</h4>
                        <span>$240</span>
                        <fieldset class="rating">
                            <input type="radio" id="star2" name="rating" value="2"/><label class="full" for="star2"
                                                                                           title="Kinda bad - 2 stars"></label>
                        </fieldset>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mini-box">
                        <img src="{!! frontImage('jacket-3.png') !!}">
                        <h4>Off-White <br>
                            graphic-print cotton bomber</h4>
                        <span>$440</span>
                        <fieldset class="rating">
                            <input type="radio" id="star3" name="rating" value="3"/><label class="full" for="star3"
                                                                                           title="Kinda bad - 3 stars"></label>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container midspace">
        <div class="spacein text-center">
            <h2>Recent Products</h2>
        </div>
        <div class="col-sm-12 text-center ">
            <div class="row">
                <div class="col-sm-3">
                    <div class="mini-box">
                        <img src="{!! frontImage('jacket-6.png') !!}">
                        <h4>A.P.C.<br>
                            Gregoire blouson jacket</h4>
                        <span>$240</span>
                        <fieldset class="rating">
                            <input type="radio" id="star1" name="rating" value="1"/><label class="full" for="star1"
                                                                                           title="Sucks big time - 1 star"></label>
                        </fieldset>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mini-box">
                        <img src="{!! frontImage('jacket.png') !!}">
                        <h4>A.P.C.<br>
                            Gregoire blouson jacket</h4>
                        <span>$240</span>
                        <fieldset class="rating">
                            <input type="radio" id="star2" name="rating" value="2"/><label class="full" for="star2"
                                                                                           title="Kinda bad - 2 stars"></label>
                        </fieldset>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mini-box">
                        <img src="{!! frontImage('jacket.png') !!}">
                        <h4>A.P.C.<br>
                            Gregoire blouson jacket</h4>
                        <span>$240</span>
                        <fieldset class="rating">
                            <input type="radio" id="star2" name="rating" value="2"/><label class="full" for="star2"
                                                                                           title="Kinda bad - 2 stars"></label>
                        </fieldset>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mini-box">
                        <img src="{!! frontImage('jacket-3.png') !!}">
                        <h4>Off-White <br>
                            graphic-print cotton bomber</h4>
                        <span>$440</span>
                        <fieldset class="rating">
                            <input type="radio" id="star3" name="rating" value="3"/><label class="full" for="star3"
                                                                                           title="Kinda bad - 3 stars"></label>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
