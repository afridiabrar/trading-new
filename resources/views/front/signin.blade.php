<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SignIn</title>
    @include('layouts.front.partials._headLinks')
    <link rel="stylesheet" href="{{ frontCss('signin.css') }}">
</head>
<body>

<!-- Signin Section Start Here -->
<section class="signin">
    <div class="container">
        <div class="logoDv">
            <figure><img src="{{ frontImage('trading-logo.png') }}" alt=""></figure>
        </div>
        <div class="SigninBox">
            <div class="head">
                <h4>Welcome Back to Trading Centre LTD</h4>
                <h4><strong>Where we provide Best Products</strong></h4>
            </div>
            <div class="actionBtn">
                <p>Not a Member ?<a href="{{ route('customer.auth.register') }}">Sign Up</a></p>
            </div>
            <form method="post" action="{{ route('customer.auth.login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" required class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" required class="form-control" placeholder="Password">
                </div>
                <button type="submit">Submit</button>
            </form>
            <div class="actionBtn2">
                <p>By Creating Account you are agree to our <a href="{{ route('terms-and-conditions') }}">Terms & conditions</a></p>
            </div>
        </div>
    </div>
</section>
<!-- Signin Section End Here -->
@include('layouts.front.partials._footerLinks')



</body>
</html>
