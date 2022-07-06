<?php 
$title =  "Trading";
$keywords = "";
$description ="";
$page = "";
?>
<?php include('inc/header.php'); ?>

<!-- Stylesheet -->
<link rel="stylesheet" href="css/deliveryinformation.css">
<!-- Stylesheet -->

<section class="information">
    <div class="container">
        <div class="head pb-5">
            <h2 class="font-50 fw-700 text-center" style="color:#8DC63E;">Delivery Information</h2>
        </div>
        <div class="track-your-order">
            <div class="inputField">
                <input type="text" class="effect-9" placeholder="Write Your Tracking Number">
            </div>
            <div class="steps">
                <ul class="tracking">
                    <li><i class="fa fa-check" aria-hidden="true"></i> Waiting for Driver Assignment</li>
                    <li><i class="fa fa-check" aria-hidden="true"></i> Order Picked Up from location</li>
                    <li><i class="fa fa-circle" aria-hidden="true"></i> Order On Way</li>
                    <li><i class="fa fa-circle" aria-hidden="true"></i> Delivered</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Footer include -->
<?php include('inc/footer.php'); ?>
<!-- Footer include -->