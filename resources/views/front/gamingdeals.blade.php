<?php 
$title =  "Trading";
$keywords = "";
$description ="";
$page = "";
?>
<?php include('inc/header.php'); ?>
<!-- Stylesheet -->
<link rel="stylesheet" href="css/gamingdeals.css">
<!-- Stylesheet -->

<!-- Banner Section Start Here -->
<section class="banner universal-banner">
    <div class="container">
        <div class="breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">GamingDeals</li>
                </ol>
            </nav>
        </div>
        <div class="Banner">
            <div class="banner-box">
                <figure><img src="img/gaming.png" alt=""></figure>
            </div>
            <div class="contentDv">
                <div class="contentFlex">
                    <p>Lorem ipsum dolor sit amet</p>
                    <h2 class="fw-600 font-80 line-height-50">30 %<span class="font-40 fw-400">Off on</span></h2>
                    <h3 class="fw-600 font-80 line-height-50 subtitle">Gadgets</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section Start Here -->

<!-- Product Slider Start Here -->
<div class="container">
    <div class="row pb-4">
        <div class="col-md-6">
            <h5 class="sub-heading fw-600 font-20">Some Best Products</h5>
        </div>
    </div>
    <div class="regular">
        <div><img src="img/i-1.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-2.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-3.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-4.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-5.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-1.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-2.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-3.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-4.jpg" class="img-fluid" alt=""></div>
        <div><img src="img/i-5.jpg" class="img-fluid" alt=""></div>
    </div>
</div>
<!-- Product Slider End Here -->

<!-- Hot Deals Products Start Here -->
<section class="hotdeals">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="filters">
                    <div class="filters-head filter-border py-2">
                        <h3 class="font-35 text-black">Apply Filters</h3>
                    </div>
                    <div class="categories">
                        <div class="head py-3">
                            <h4 class="font-25">Categories</h4>
                        </div>

                        <!--  -->
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="ToggleOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#mainToggle"
                                            aria-expanded="false" aria-controls="mainToggle">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    <div class="name">
                                                        <span>Lorem</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="angls">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </button>
                                    </h5>
                                </div>
                                <div id="mainToggle" class="collapse show" aria-labelledby="ToggleOne"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- inner Accordion -->
                                        <div id="accordion-inner">
                                            <div class="card">
                                                <div class="card-header" id="innerToggle">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link pl-4" data-toggle="collapse"
                                                            data-target="#InnerToggleOne" aria-expanded="false"
                                                            aria-controls="InnerToggleOne">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                    id="defaultCheck2">
                                                                <label class="form-check-label" for="defaultCheck2">
                                                                    <div class="name">
                                                                        <span>Lorem</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="angls">
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            </div>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="InnerToggleOne" class="collapse" aria-labelledby="innerToggle"
                                                    data-parent="#accordion-inner">
                                                    <div class="card-body">
                                                        <div class="inner-content card card-body inner-text">
                                                            <a href="#settings">
                                                                Lorem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- inner Accordion -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="ToggleTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#mainToggle2"
                                            aria-expanded="false" aria-controls="mainToggle2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck2">
                                                <label class="form-check-label" for="defaultCheck2">
                                                    <div class="name">
                                                        <span>Lorem</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="angls">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </button>
                                    </h5>
                                </div>
                                <div id="mainToggle2" class="collapse" aria-labelledby="ToggleTwo"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- inner Accordion -->
                                        <div id="accordion-inner">
                                            <div class="card">
                                                <div class="card-header" id="innerToggle">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link pl-4" data-toggle="collapse"
                                                            data-target="#InnerToggleTwo" aria-expanded="false"
                                                            aria-controls="InnerToggleTwo">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                    id="defaultCheck2">
                                                                <label class="form-check-label" for="defaultCheck2">
                                                                    <div class="name">
                                                                        <span>Lorem</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="angls">
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            </div>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="InnerToggleTwo" class="collapse" aria-labelledby="innerToggle"
                                                    data-parent="#accordion-inner">
                                                    <div class="card-body">
                                                        <div class="inner-content card card-body inner-text">
                                                            <a href="#settings">
                                                                Lorem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- inner Accordion -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="ToggleThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#mainToggle3"
                                            aria-expanded="false" aria-controls="mainToggle3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck3">
                                                <label class="form-check-label" for="defaultCheck3">
                                                    <div class="name">
                                                        <span>Lorem</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="angls">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </button>
                                    </h5>
                                </div>
                                <div id="mainToggle3" class="collapse" aria-labelledby="ToggleThree"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- inner Accordion -->
                                        <div id="accordion-inner">
                                            <div class="card">
                                                <div class="card-header" id="innerToggle">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link pl-4" data-toggle="collapse"
                                                            data-target="#InnerToggleThree" aria-expanded="false"
                                                            aria-controls="InnerToggleThree">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                    id="defaultCheck2">
                                                                <label class="form-check-label" for="defaultCheck2">
                                                                    <div class="name">
                                                                        <span>Lorem</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="angls">
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            </div>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="InnerToggleThree" class="collapse"
                                                    aria-labelledby="innerToggle" data-parent="#accordion-inner">
                                                    <div class="card-body">
                                                        <div class="inner-content card card-body inner-text">
                                                            <a href="#settings">
                                                                Lorem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- inner Accordion -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="ToggleFour">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#mainToggle4"
                                            aria-expanded="false" aria-controls="mainToggle4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck4">
                                                <label class="form-check-label" for="defaultCheck4">
                                                    <div class="name">
                                                        <span>Lorem</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="angls">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </button>
                                    </h5>
                                </div>
                                <div id="mainToggle4" class="collapse" aria-labelledby="ToggleFour"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- inner Accordion -->
                                        <div id="accordion-inner">
                                            <div class="card">
                                                <div class="card-header" id="innerToggle">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link pl-4" data-toggle="collapse"
                                                            data-target="#InnerToggleFour" aria-expanded="false"
                                                            aria-controls="InnerToggleFour">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                    id="defaultCheck2">
                                                                <label class="form-check-label" for="defaultCheck2">
                                                                    <div class="name">
                                                                        <span>Lorem</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="angls">
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            </div>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="InnerToggleFour" class="collapse" aria-labelledby="innerToggle"
                                                    data-parent="#accordion-inner">
                                                    <div class="card-body">
                                                        <div class="inner-content card card-body inner-text">
                                                            <a href="#settings">
                                                                Lorem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- inner Accordion -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="ToggleFive">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#mainToggle5"
                                            aria-expanded="false" aria-controls="mainToggle5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck5">
                                                <label class="form-check-label" for="defaultCheck5">
                                                    <div class="name">
                                                        <span>Lorem</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="angls">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </button>
                                    </h5>
                                </div>
                                <div id="mainToggle5" class="collapse" aria-labelledby="ToggleFive"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- inner Accordion -->
                                        <div id="accordion-inner">
                                            <div class="card">
                                                <div class="card-header" id="innerToggle">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link pl-4" data-toggle="collapse"
                                                            data-target="#InnerToggleFive" aria-expanded="false"
                                                            aria-controls="InnerToggleFive">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                    id="defaultCheck2">
                                                                <label class="form-check-label" for="defaultCheck2">
                                                                    <div class="name">
                                                                        <span>Lorem</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="angls">
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            </div>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="InnerToggleFive" class="collapse" aria-labelledby="innerToggle"
                                                    data-parent="#accordion-inner">
                                                    <div class="card-body">
                                                        <div class="inner-content card card-body inner-text">
                                                            <a href="#settings">
                                                                Lorem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- inner Accordion -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="ToggleSix">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#mainToggle6"
                                            aria-expanded="false" aria-controls="mainToggle6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck6">
                                                <label class="form-check-label" for="defaultCheck6">
                                                    <div class="name">
                                                        <span>Lorem</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="angls">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </button>
                                    </h5>
                                </div>
                                <div id="mainToggle6" class="collapse" aria-labelledby="ToggleSix"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- inner Accordion -->
                                        <div id="accordion-inner">
                                            <div class="card">
                                                <div class="card-header" id="innerToggle">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link pl-4" data-toggle="collapse"
                                                            data-target="#InnerToggleSix" aria-expanded="false"
                                                            aria-controls="InnerToggleSix">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                    id="defaultCheck2">
                                                                <label class="form-check-label" for="defaultCheck2">
                                                                    <div class="name">
                                                                        <span>Lorem</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="angls">
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            </div>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="InnerToggleSix" class="collapse" aria-labelledby="innerToggle"
                                                    data-parent="#accordion-inner">
                                                    <div class="card-body">
                                                        <div class="inner-content card card-body inner-text">
                                                            <a href="#settings">
                                                                Lorem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- inner Accordion -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="ToggleSeven">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#mainToggle7"
                                            aria-expanded="false" aria-controls="mainToggle7">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck7">
                                                <label class="form-check-label" for="defaultCheck7">
                                                    <div class="name">
                                                        <span>Lorem</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="angls">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </button>
                                    </h5>
                                </div>
                                <div id="mainToggle7" class="collapse" aria-labelledby="ToggleSeven"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- inner Accordion -->
                                        <div id="accordion-inner">
                                            <div class="card">
                                                <div class="card-header" id="innerToggle">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link pl-4" data-toggle="collapse"
                                                            data-target="#InnerToggleSeven" aria-expanded="false"
                                                            aria-controls="InnerToggleSeven">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                    id="defaultCheck2">
                                                                <label class="form-check-label" for="defaultCheck2">
                                                                    <div class="name">
                                                                        <span>Lorem</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="angls">
                                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                            </div>
                                                        </button>
                                                    </h5>
                                                </div>

                                                <div id="InnerToggleSeven" class="collapse"
                                                    aria-labelledby="innerToggle" data-parent="#accordion-inner">
                                                    <div class="card-body">
                                                        <div class="inner-content card card-body inner-text">
                                                            <a href="#settings">
                                                                Lorem
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- inner Accordion -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="price-filter">
                        <div class="head filter-border pt-4">
                            <h4 class="font-25">Price</h4>
                        </div>
                        <div class="range-head">
                            <p>Range:</p>
                            <p class="fw-600">$1 - $900</p>
                        </div>
                        <div class="range-slide pb-3">
                            <div class="from">
                                <label for="from">From</label><br />
                                <input type="number" value="1" id="from">
                            </div>
                            <div class="spacer"></div>
                            <div class="from">
                                <label for="to">To</label><br />
                                <input type="number" id="to" value="900">
                            </div>
                        </div>
                    </div>

                    <div class="brand-filter">
                        <div class="head filter-border py-3">
                            <h4 class="font-25">Brands</h4>
                        </div>
                        <div class="brands">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck8">
                                <label class="form-check-label" for="defaultCheck8">
                                    <div class="name">
                                        <span class="font-14">Lorem</span>
                                    </div>
                                </label>
                            </div>
                            <div class="brandCount">
                                <span class="font-14">120</span>
                            </div>
                        </div>
                        <div class="brands">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck9">
                                <label class="form-check-label" for="defaultCheck9">
                                    <div class="name">
                                        <span class="font-14">Lorem</span>
                                    </div>
                                </label>
                            </div>
                            <div class="brandCount">
                                <span class="font-14">120</span>
                            </div>
                        </div>
                        <div class="brands">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck10">
                                <label class="form-check-label" for="defaultCheck10">
                                    <div class="name">
                                        <span class="font-14">Lorem</span>
                                    </div>
                                </label>
                            </div>
                            <div class="brandCount">
                                <span class="font-14">120</span>
                            </div>
                        </div>
                        <div class="brands">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck11">
                                <label class="form-check-label" for="defaultCheck11">
                                    <div class="name">
                                        <span class="font-14">Lorem</span>
                                    </div>
                                </label>
                            </div>
                            <div class="brandCount">
                                <span class="font-14">120</span>
                            </div>
                        </div>
                    </div>

                    <div class="ads-banner">
                        <figure><img src="img/ad1.png" alt=""></figure>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="topBar">
                    <div class="heading">
                        <h2 class="font-60">Hot Deals</h2>
                    </div>
                    <div class="sort-btn">
                        <button class="font-20">Sort By: High To low</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <div class="card-img-actions"> <a href="productpage.php"><img src="img/redled.png" class="card-img img-fluid"
                                        width="96" height="350" alt=""></a> </div>
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
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <span class="notify-badge">20 % off</span>
                                <div class="card-img-actions"> <img src="img/pr-2.jpg" class="card-img img-fluid"
                                        width="96" height="350" alt=""> </div>
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
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <span class="notify-badge">20 % off</span>
                                <div class="card-img-actions"> <img src="img/pr-3.jpg" class="card-img img-fluid"
                                        width="96" height="350" alt=""> </div>
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

                <div class="row">
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <div class="card-img-actions"> <img src="img/redled.png" class="card-img img-fluid"
                                        width="96" height="350" alt=""> </div>
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
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <span class="notify-badge">20 % off</span>
                                <div class="card-img-actions"> <img src="img/pr-2.jpg" class="card-img img-fluid"
                                        width="96" height="350" alt=""> </div>
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
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <span class="notify-badge">20 % off</span>
                                <div class="card-img-actions"> <img src="img/pr-3.jpg" class="card-img img-fluid"
                                        width="96" height="350" alt=""> </div>
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

                <div class="box py-4">
                    <img src="img/mobilephone.png" class="img-fluid" alt="" style="width:100%; height:342px;">
                    <div class="bottom-left"><a href="#" class="btnbl text-black font-12" tabindex="-1">Lorem ipsum
                            dolor
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 30 30">
                                <g id="Group_4119" data-name="Group 4119" transform="translate(-336 -1971)">
                                    <g id="Group_47" data-name="Group 47" transform="translate(-5 2)">
                                        <g id="Ellipse_5" data-name="Ellipse 5" transform="translate(341 1969)"
                                            fill="none" stroke="#000" stroke-width="1">
                                            <circle cx="15" cy="15" r="15" stroke="none" />
                                            <circle cx="15" cy="15" r="14.5" fill="none" />
                                        </g>
                                        <path id="Icon_awesome-arrow-right" data-name="Icon awesome-arrow-right"
                                            d="M.187,3.154l.385-.385a.414.414,0,0,1,.587,0L4.527,6.136a.414.414,0,0,1,0,.587L1.159,10.091a.414.414,0,0,1-.587,0L.187,9.706a.416.416,0,0,1,.007-.594L2.281,7.123H-9.584A.415.415,0,0,1-10,6.707V6.153a.415.415,0,0,1,.416-.416H2.281L.194,3.748A.413.413,0,0,1,.187,3.154Z"
                                            transform="translate(358.94 1977.355)" fill="#000" />
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>

                    <div class="m-centered">
                        <p class="text-black line-height-1 font-25">Lorem ipsum dolor</p>
                        <h2 class="text-black line-height-1 font-35">Mobile Phones</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <div class="card-img-actions"> <img src="img/redled.png" class="card-img img-fluid"
                                        width="96" height="350" alt=""> </div>
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
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <span class="notify-badge">20 % off</span>
                                <div class="card-img-actions"> <img src="img/pr-2.jpg" class="card-img img-fluid"
                                        width="96" height="350" alt=""> </div>
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
                    <div class="col-md-4 pt-2">
                        <div class="card product">
                            <div class="card-body">
                                <span class="notify-badge">20 % off</span>
                                <div class="card-img-actions"> <img src="img/pr-3.jpg" class="card-img img-fluid"
                                        width="96" height="350" alt=""> </div>
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

                <div class="pagination">
                    <div class="pafination-Flex">
                        <ul class="items">
                            <li class="pagi arrow prev-arrow"><a href="#!"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <li class="pagi"><a href="#!">1</a></li>
                            <li class="pagi active"><a href="#!">2</a></li>
                            <li class="pagi"><a href="#!">...</a></li>
                            <li class="pagi"><a href="#!">12</a></li>
                            <li class="pagi arrow next-arrow"><a href="#!"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hot Deals Products End Here -->

<!-- Footer include -->
<?php include('inc/footer.php'); ?>
<!-- Footer include -->