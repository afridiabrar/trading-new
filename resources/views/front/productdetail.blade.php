<?php 
$title =  "Trading";
$keywords = "";
$description ="";
$page = "";
?>
<?php include('inc/header.php'); ?>

<!-- Stylesheet -->
<link rel="stylesheet" href="css/productdetail.css">
<!-- Stylesheet -->

<!-- Product Detail Start Here -->
<section class="productdetail">
    <div class="container">
        <!-- BreadCrumbs Start Here -->
        <div class="breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Page</li>
                </ol>
            </nav>
        </div>
        <!-- BreadCrumbs End Here -->
        <div class="row">
            <div class="col-md-6">
                <div class="img-box">
                    <figure><img src="img/productdetail.png" alt=""></figure>
                </div>
                <div class="productsimages">
                    <ul class="images">
                        <li>
                            <figure><img src="img/productimages.png" alt=""></figure>
                        </li>
                        <li>
                            <figure><img src="img/productimages.png" alt=""></figure>
                        </li>
                        <li>
                            <figure><img src="img/productimages.png" alt=""></figure>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="category">
                    <h5 class="font-15 fw-400">Smart TV</h5>
                </div>

                <div class="info">
                    <div class="name">
                        <h3 class="font-30 fw-700">Samsung Smart TV Lt456</h3>
                    </div>
                    <div class="price">
                        <h3 class="font-30 fw-700">$69.55</h3>
                    </div>
                </div>

                <div class="reviews">
                    <div class="stars">
                        <i class="fa fa-star star"></i>
                        <i class="fa fa-star star"></i>
                        <i class="fa fa-star star"></i>
                        <i class="fa fa-star-o star"></i>
                        <i class="fa fa-star-o star"></i>
                    </div>
                    <div class="clentreviews">
                        <h5 class="font-15 fw-400">3.9 (275 Reviews)</h5>
                    </div>
                </div>

                <div class="description">
                    <h4 class="font-20 fw-500">Discription</h4>
                    <p class="fw-400">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris.
                    </p>
                    <p class="specification fw-400">
                        70 inch HD Touch Screen (4k)<br />
                        Android 4.4 KitKat OS<br />
                        2.4 GHz Quad Core™ Processor<br />
                    </p>
                    <p class="fw-400">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.
                    </p>
                </div>

                <div class="variations">
                    <div class="quantity">
                        <label for="qty">Qty:</label>
                        <input type="number" value="01" id="qty">
                    </div>
                    <div class="spacer"></div>
                    <div class="quantity">
                        <label for="qty">Color:</label>
                        <div class="colors">
                            <span class="colorselect" style="background:#173EF4; height:35px; width:65px;"></span>
                            <div class="arrows">
                                <div class="top"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                                <div class="bottom"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <a class="cart" href="#">Proceed To Checkout <i class="fa fa-shopping-basket"
                            aria-hidden="true"></i></a>
                    <a class="wishlist" href="#">Wishlist <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                </div>

                <div class="share-btn">
                    <label>Share :</label>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Detail End Here -->

<!-- Clients Reviews Start Here -->
<section class="ClientsReviewsSec">
    <div class="container">
        <!-- Tabs Start Here -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab"
                    aria-controls="reviews" aria-selected="true">Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="specification-tab" data-toggle="tab" href="#specification" role="tab"
                    aria-controls="specification" aria-selected="false">Specification</a>
            </li>
        </ul>
        <!-- Tabs Start Here -->

        <!-- Tabs Content Start Here -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="head">
                    <h4 class="font-25 fw-600">275 Reviews</h4>
                </div>
                <div class="mainReview">
                    <div class="brieflyReview">
                        <div class="img-box">
                            <figure><img src="img/review1.png" alt=""></figure>
                        </div>
                        <div class="contentDv">
                            <div class="info">
                                <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                <div class="spacer">-</div>
                                <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                            </div>
                            <div class="descrip">
                                <p>
                                    We possess within us two minds. So far I have written only of the conscious mind. I
                                    would now like to introduce you to your second mind, the hidden and mysterious
                                    subconscious. Our subconscious mind contains such power and complexity that it
                                    literally
                                    staggers the imagination.
                                </p>
                                <div class="rating">
                                    <div class="stars">
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star-o star"></i>
                                        <i class="fa fa-star-o star"></i>
                                        <div class="star-count">
                                            <span>3.9</span>
                                        </div>
                                    </div>
                                    <div class="rply-btn">
                                        <a href="#!">Reply</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="replyDv">
                        <!-- Replies -->
                        <div class="brieflyReview">
                            <div class="img-box">
                                <figure><img src="img/review2.png" alt=""></figure>
                            </div>
                            <div class="contentDv">
                                <div class="info">
                                    <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                    <div class="spacer">-</div>
                                    <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                                </div>
                                <div class="descrip">
                                    <p>
                                        We possess within us two minds. So far I have written only of the conscious
                                        mind. I would now like to introduce you to your second mind
                                        , the hidden and mysterious subconscious.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Replies -->

                        <!-- Replies -->
                        <div class="brieflyReview">
                            <div class="img-box">
                                <figure><img src="img/review3.png" alt=""></figure>
                            </div>
                            <div class="contentDv">
                                <div class="info">
                                    <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                    <div class="spacer">-</div>
                                    <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                                </div>
                                <div class="descrip">
                                    <p>
                                        We possess within us two minds. So far I have written only of the conscious
                                        mind. I would now like to introduce you to your
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Replies -->

                        <!-- Replies -->
                        <div class="brieflyReview">
                            <div class="img-box">
                                <figure><img src="img/review4.png" alt=""></figure>
                            </div>
                            <div class="contentDv">
                                <div class="info">
                                    <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                    <div class="spacer">-</div>
                                    <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                                </div>
                                <div class="descrip">
                                    <p>
                                        We possess within us two minds. So far I have written only of the conscious
                                        mind. I would now like to introduce you to your second mind,
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Replies -->
                    </div>
                </div>

                <div class="mainReview pt-5 border-topp">
                    <div class="brieflyReview">
                        <div class="img-box">
                            <figure><img src="img/review1.png" alt=""></figure>
                        </div>
                        <div class="contentDv">
                            <div class="info">
                                <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                <div class="spacer">-</div>
                                <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                            </div>
                            <div class="descrip">
                                <p>
                                    We possess within us two minds. So far I have written only of the conscious mind. I
                                    would now like to introduce you to your second mind, the hidden and mysterious
                                    subconscious. Our subconscious mind contains such power and complexity that it
                                    literally
                                    staggers the imagination.
                                </p>
                                <div class="rating">
                                    <div class="stars">
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star-o star"></i>
                                        <i class="fa fa-star-o star"></i>
                                        <div class="star-count">
                                            <span>3.9</span>
                                        </div>
                                    </div>
                                    <div class="rply-btn">
                                        <a href="#!">Reply</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="specification" role="tabpanel" aria-labelledby="specification-tab">
                <div class="mainReview">
                    <div class="brieflyReview">
                        <div class="img-box">
                            <figure><img src="img/review1.png" alt=""></figure>
                        </div>
                        <div class="contentDv">
                            <div class="info">
                                <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                <div class="spacer">-</div>
                                <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                            </div>
                            <div class="descrip">
                                <p>
                                    We possess within us two minds. So far I have written only of the conscious mind. I
                                    would now like to introduce you to your second mind, the hidden and mysterious
                                    subconscious. Our subconscious mind contains such power and complexity that it
                                    literally
                                    staggers the imagination.
                                </p>
                                <div class="rating">
                                    <div class="stars">
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star-o star"></i>
                                        <i class="fa fa-star-o star"></i>
                                        <div class="star-count">
                                            <span>3.9</span>
                                        </div>
                                    </div>
                                    <div class="rply-btn">
                                        <a href="#!">Reply</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="replyDv">
                        <!-- Replies -->
                        <div class="brieflyReview">
                            <div class="img-box">
                                <figure><img src="img/review2.png" alt=""></figure>
                            </div>
                            <div class="contentDv">
                                <div class="info">
                                    <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                    <div class="spacer">-</div>
                                    <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                                </div>
                                <div class="descrip">
                                    <p>
                                        We possess within us two minds. So far I have written only of the conscious
                                        mind. I would now like to introduce you to your second mind
                                        , the hidden and mysterious subconscious.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Replies -->

                        <!-- Replies -->
                        <div class="brieflyReview">
                            <div class="img-box">
                                <figure><img src="img/review3.png" alt=""></figure>
                            </div>
                            <div class="contentDv">
                                <div class="info">
                                    <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                    <div class="spacer">-</div>
                                    <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                                </div>
                                <div class="descrip">
                                    <p>
                                        We possess within us two minds. So far I have written only of the conscious
                                        mind. I would now like to introduce you to your
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Replies -->

                        <!-- Replies -->
                        <div class="brieflyReview">
                            <div class="img-box">
                                <figure><img src="img/review4.png" alt=""></figure>
                            </div>
                            <div class="contentDv">
                                <div class="info">
                                    <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                    <div class="spacer">-</div>
                                    <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                                </div>
                                <div class="descrip">
                                    <p>
                                        We possess within us two minds. So far I have written only of the conscious
                                        mind. I would now like to introduce you to your second mind,
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Replies -->
                    </div>
                </div>

                <div class="mainReview pt-5 border-topp">
                    <div class="brieflyReview">
                        <div class="img-box">
                            <figure><img src="img/review1.png" alt=""></figure>
                        </div>
                        <div class="contentDv">
                            <div class="info">
                                <h6 class="name" style="font-size:12px;">Joeby Ragpa</h6>
                                <div class="spacer">-</div>
                                <h6 class="date" style="color:#909090; font-size:12px;">12 April, 2014 at 16:50</h6>
                            </div>
                            <div class="descrip">
                                <p>
                                    We possess within us two minds. So far I have written only of the conscious mind. I
                                    would now like to introduce you to your second mind, the hidden and mysterious
                                    subconscious. Our subconscious mind contains such power and complexity that it
                                    literally
                                    staggers the imagination.
                                </p>
                                <div class="rating">
                                    <div class="stars">
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star star"></i>
                                        <i class="fa fa-star-o star"></i>
                                        <i class="fa fa-star-o star"></i>
                                        <div class="star-count">
                                            <span>3.9</span>
                                        </div>
                                    </div>
                                    <div class="rply-btn">
                                        <a href="#!">Reply</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabs Content Start Here -->
    </div>
</section>
<!-- Clients Reviews End Here -->

<!-- Similar Products Start Here -->
<section class="similar_products">
    <div class="container">
        <div class="topBar">
            <div class="heading">
                <h2 class="font-60">Similar Products</h2>
            </div>
            <div class="view-btn">
                <a href="#">View All</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 pt-2">
                <div class="card product">
                    <div class="card-body">
                        <div class="card-img-actions"> <img src="img/tv1.png" class="card-img img-fluid" width="96"
                                height="350" alt=""> </div>
                    </div>
                    <hr class="p-0 m-0">
                    <div class="card-body">
                        <span class="notify-badge">20 % off</span>
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="bd-highlight">
                                <p class="text-muted">By Lorem</p>
                            </div>
                            <div class="bd-highlight"></div>
                            <div class="bd-highlight">
                                <div>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star-o star"></i>
                                    <i class="fa fa-star-o star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <h6 class="font-weight-semibold">
                                <a href="#" class="text-black product-title" data-abc="true">Lorem ipsum dolor
                                    sit amet,
                                    conse adipiscing elit</a>
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="p-2 bd-highlight">
                                <h3 class="mb-0 font-weight-semibold price">$158.07 <span><strike>$192.07
                                        </strike></span> </h3>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight"> <button type="button" class="btn bg-cart"><i
                                        class="fa fa-cart-plus mr-2"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 pt-2">
                <div class="card product">
                    <div class="card-body">
                        <span class="notify-badge">20 % off</span>
                        <div class="card-img-actions"> <img src="img/tv2.png" class="card-img img-fluid" width="96"
                                height="350" alt=""> </div>
                    </div>
                    <hr class="p-0 m-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="bd-highlight">
                                <p class="text-muted">By Lorem</p>
                            </div>
                            <div class="bd-highlight"></div>
                            <div class="bd-highlight">
                                <div>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star-o star"></i>
                                    <i class="fa fa-star-o star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <h6 class="font-weight-semibold">
                                <a href="#" class="text-black product-title" data-abc="true">Lorem ipsum dolor
                                    sit amet,
                                    conse adipiscing elit</a>
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="p-2 bd-highlight">
                                <h3 class="mb-0 font-weight-semibold price">$158.07 <span><strike>$192.07
                                        </strike></span> </h3>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight"> <button type="button" class="btn bg-cart"><i
                                        class="fa fa-cart-plus mr-2"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 pt-2">
                <div class="card product">
                    <div class="card-body">
                        <span class="notify-badge">20 % off</span>
                        <div class="card-img-actions"> <img src="img/tv3.png" class="card-img img-fluid" width="96"
                                height="350" alt=""> </div>
                    </div>
                    <hr class="p-0 m-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="bd-highlight">
                                <p class="text-muted">By Lorem</p>
                            </div>
                            <div class="bd-highlight"></div>
                            <div class="bd-highlight">
                                <div>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star-o star"></i>
                                    <i class="fa fa-star-o star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <h6 class="font-weight-semibold">
                                <a href="#" class="text-black product-title" data-abc="true">Lorem ipsum dolor
                                    sit amet,
                                    conse adipiscing elit</a>
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="p-2 bd-highlight">
                                <h3 class="mb-0 font-weight-semibold price">$158.07 <span><strike>$192.07
                                        </strike></span> </h3>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight"> <button type="button" class="btn bg-cart"><i
                                        class="fa fa-cart-plus mr-2"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 pt-2">
                <div class="card product">
                    <div class="card-body">
                        <span class="notify-badge">20 % off</span>
                        <div class="card-img-actions"> <img src="img/tv3.png" class="card-img img-fluid" width="96"
                                height="350" alt=""> </div>
                    </div>
                    <hr class="p-0 m-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="bd-highlight">
                                <p class="text-muted">By Lorem</p>
                            </div>
                            <div class="bd-highlight"></div>
                            <div class="bd-highlight">
                                <div>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star star"></i>
                                    <i class="fa fa-star-o star"></i>
                                    <i class="fa fa-star-o star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <h6 class="font-weight-semibold">
                                <a href="#" class="text-black product-title" data-abc="true">Lorem ipsum dolor
                                    sit amet,
                                    conse adipiscing elit</a>
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="p-2 bd-highlight">
                                <h3 class="mb-0 font-weight-semibold price">$158.07 <span><strike>$192.07
                                        </strike></span> </h3>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight"> <button type="button" class="btn bg-cart"><i
                                        class="fa fa-cart-plus mr-2"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Similar Products Start Here -->

<!-- Footer include -->
<?php include('inc/footer.php'); ?>
<!-- Footer include -->