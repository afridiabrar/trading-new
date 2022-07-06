<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SignUp</title>
    @include('layouts.front.partials._headLinks')
    <link rel="stylesheet" href="{{ frontCss('signup.css') }}">
</head>
<body>

<!-- Signin Section Start Here -->
<section class="signup">
    <div class="container">
        <div class="logoDv">
            <figure><img src="{{ frontImage('trading-logo.png') }}" alt=""></figure>
        </div>
        <div class="signupBox">
            <div class="head">
                <h4>Welcome Back to Trading Centre LTD</h4>
                <h4><strong>Where we provide Best Products</strong></h4>
            </div>
            <div class="actionBtn">
                <p>Already a Member ?<a href="signin.php">Sign In</a></p>
            </div>
            <form>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="tel" class="form-control" placeholder="Phone Number">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password">
                </div>
                <button type="submit">Creat Account</button>
            </form>
            <div class="actionBtn2">
                <p>By Creating Account you are agree to our <a href="refundpolicy.php">Terms & conditions</a></p>
            </div>
        </div>
    </div>
</section>
<!-- Signin Section End Here -->

</body>
</html>
