<?php 
$title =  "Trading";
$keywords = "";
$description ="";
$page = "";
?>
<?php include('inc/header.php'); ?>

<!-- Stylesheet -->
<link rel="stylesheet" href="css/stepform.css">
<!-- Stylesheet -->

<!-- Step Form Start Here -->
<section class="setpper-step-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"
                                    aria-expanded="true"><span class="round-tab">1 </span></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"
                                    aria-expanded="false"><span class="round-tab">2</span></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span
                                        class="round-tab">3</span>></a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="main_form">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <h2 class="font-40 fw-600 text-center pb-5">Shipment Address</h2>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="addressDetail">
                                        <div class="head">
                                            <h4 class="font-20 fw-600">Enter Your Address Details</h4>
                                        </div>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Last Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="tel" class="form-control"
                                                            placeholder="Phone Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <select class="region">
                                                            <option>Select a Region</option>
                                                            <option>California</option>
                                                            <option>Manchester</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Postal code"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Postal code"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea placeholder="Enter Your Address"
                                                            class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="list-inline">
                                                <li><button type="button" class="default-btn next-step">Continue to next
                                                        step</button></li>
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="OrderSummary">
                                        <div class="headingg">
                                            <h3 class="font-25 pb-3">Order Summery</h3>
                                        </div>
                                        <div class="order_info">
                                            <div class="itemTotal order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Item Total:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">$50</h5>
                                                </div>
                                            </div>
                                            <div class="shipmentDelivery order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Shipment & Delivery:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">$0</h5>
                                                </div>
                                            </div>
                                            <div class="promoApplied order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Promo Applied:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">-$5</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="orderTotal">
                                            <div class="property">
                                                <h5 class="fw-700" style="font-size:20px; color:#8DC63F;">Order Total
                                                </h5>
                                            </div>
                                            <div class="value">
                                                <h5 class="fw-400" style="font-size:20px;">$45</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step2">
                            <h2 class="font-40 fw-600 text-center pb-5">Payment Details</h2>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="paymentInfo">
                                        <div class="head">
                                            <h4 class="font-20 fw-600">Enter Your Payment Details</h4>
                                        </div>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="tel" class="form-control"
                                                            placeholder="Card Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="Name On Card">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="Expire Date">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="Expire Year">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="CVV">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="payment-cards">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                                        id="inlineradio1" value="option1">
                                                    <label class="form-check-label" for="inlineradio1">
                                                        <figure><img src="img/card1.png" alt=""></figure>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                                        id="inlineradio2" value="option2">
                                                    <label class="form-check-label" for="inlineradio2">
                                                        <figure><img src="img/card2.png" alt=""></figure>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                                        id="inlineradio3" value="option3">
                                                    <label class="form-check-label" for="inlineradio3">
                                                        <figure><img src="img/card3.png" alt=""></figure>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                                        id="inlineradio4" value="option4">
                                                    <label class="form-check-label" for="inlineradio4">
                                                        <figure><img src="img/card4.png" alt=""></figure>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                                        id="inlineradio5" value="option5">
                                                    <label class="form-check-label" for="inlineradio5">
                                                        <figure><img src="img/card5.png" alt=""></figure>
                                                    </label>
                                                </div>
                                            </div>
                                            <ul class="list-inline">
                                                <li><button type="button" class="default-btn next-step">Continue to next
                                                        step</button></li>
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="OrderSummary">
                                        <div class="headingg">
                                            <h3 class="font-25 pb-3">Order Summery</h3>
                                        </div>
                                        <div class="order_info">
                                            <div class="itemTotal order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Item Total:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">$50</h5>
                                                </div>
                                            </div>
                                            <div class="shipmentDelivery order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Shipment & Delivery:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">$0</h5>
                                                </div>
                                            </div>
                                            <div class="promoApplied order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Promo Applied:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">-$5</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="orderTotal">
                                            <div class="property">
                                                <h5 class="fw-700" style="font-size:20px; color:#8DC63F;">Order Total
                                                </h5>
                                            </div>
                                            <div class="value">
                                                <h5 class="fw-400" style="font-size:20px;">$45</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step3">
                            <h2 class="font-40 fw-600 text-center pb-5">Confirm Order</h2>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="productsummary-info">
                                        <div class="topBaR">
                                            <div class="headd">
                                                <h4 class="font-20">Products</h4>
                                            </div>
                                            <div class="iconDvv">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="addproduct">
                                            <div class="imgBox">
                                                <figure><img src="img/summary.png" alt=""></figure>
                                            </div>
                                            <div class="name">
                                                <h5 style="font-size:18px;">F Cadeau homemade Candle</h5>
                                            </div>
                                            <div class="quantity">
                                                <h5 style="font-size:18px; color:#E7ADB3;">X3</h5>
                                            </div>
                                        </div>
                                        <div class="addproduct lst">
                                            <div class="imgBox">
                                                <figure><img src="img/summary.png" alt=""></figure>
                                            </div>
                                            <div class="name">
                                                <h5 style="font-size:18px;">F Cadeau homemade Candle</h5>
                                            </div>
                                            <div class="quantity">
                                                <h5 style="font-size:18px; color:#E7ADB3;">X3</h5>
                                            </div>
                                        </div>
                                        <div class="shipment-Info">
                                            <div class="topBaR">
                                                <div class="headd">
                                                    <h4 class="font-20">Shipment Address</h4>
                                                </div>
                                                <div class="iconDvv">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="uerInfo">
                                                <div class="country info-flex">
                                                    <div class="property">
                                                        <h5 class="fw-500" style="font-size:18px; color:#244638;">
                                                            Country:</h5>
                                                    </div>
                                                    <div class="value">
                                                        <h5 class="fw-300" style="font-size:18px; color:#244638;">
                                                            United States</h5>
                                                    </div>
                                                </div>
                                                <div class="address info-flex">
                                                    <div class="property">
                                                        <h5 class="fw-500" style="font-size:18px; color:#244638;">
                                                            Address:</h5>
                                                    </div>
                                                    <div class="value">
                                                        <h5 class="fw-300" style="font-size:18px; color:#244638;">
                                                            10515 Fox Ave Fairdale, Kentucky(KY), 40118</h5>
                                                    </div>
                                                </div>
                                                <div class="phone info-flex">
                                                    <div class="property">
                                                        <h5 class="fw-500" style="font-size:18px; color:#244638;">
                                                            Phone:</h5>
                                                    </div>
                                                    <div class="value">
                                                        <h5 class="fw-300" style="font-size:18px; color:#244638;">
                                                            +44-123-456-789</h5>
                                                    </div>
                                                </div>
                                                <div class="state info-flex">
                                                    <div class="property">
                                                        <h5 class="fw-500" style="font-size:18px; color:#244638;">
                                                            State:</h5>
                                                    </div>
                                                    <div class="value">
                                                        <h5 class="fw-300" style="font-size:18px; color:#244638;">
                                                            Texas</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-detail">
                                            <div class="topBaR">
                                                <div class="headd">
                                                    <h4 class="font-20">Billing Details</h4>
                                                </div>
                                                <div class="iconDvv">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="card-infoo">
                                                <div class="img-box">
                                                    <figure><img src="img/visacard.png" alt=""></figure>
                                                </div>
                                                <div class="card-number">
                                                    <span>My Personal Card</span><br />
                                                    <input type="text" value="**********1239">
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-inline">
                                            <li><button type="button" onclick="location.href='thankyou.php';" class="default-btn next-step">Confirm & place
                                                    order</button></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="OrderSummary">
                                        <div class="headingg">
                                            <h3 class="font-25 pb-3">Order Summery</h3>
                                        </div>
                                        <div class="order_info">
                                            <div class="itemTotal order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Item Total:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">$50</h5>
                                                </div>
                                            </div>
                                            <div class="shipmentDelivery order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Shipment & Delivery:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">$0</h5>
                                                </div>
                                            </div>
                                            <div class="promoApplied order-flex">
                                                <div class="property">
                                                    <h5 class="fw-500" style="font-size:17px;">Promo Applied:</h5>
                                                </div>
                                                <div class="value">
                                                    <h5 class="fw-300" style="font-size:17px;">-$5</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="orderTotal">
                                            <div class="property">
                                                <h5 class="fw-700" style="font-size:20px; color:#8DC63F;">Order Total
                                                </h5>
                                            </div>
                                            <div class="value">
                                                <h5 class="fw-400" style="font-size:20px;">$45</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Step Form End Here -->

<!-- Footer include -->
<?php include('inc/footer.php'); ?>
<!-- Footer include -->