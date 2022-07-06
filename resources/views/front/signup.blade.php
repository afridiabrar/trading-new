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
                <p>Already a Member ?<a href="{{ route('customer.auth.login') }}">Sign In</a></p>
            </div>

            <form method="post" action="{{ route('customer.auth.submit.register') }}">
                @csrf
                <div class="form-group">
                    <input type="text" required value="{{ old('first_name') }}" name="first_name" class="form-control" placeholder="First Name">
                </div>
                <div class="form-group">
                    <input type="text" required value="{{ old('last_name') }}" name="last_name" class="form-control" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <input type="email" required value="{{ old('email') }}" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="tel" required value="{{ old('phone') }}" name="phone" class="form-control" placeholder="Phone Number">
                </div>
                <div class="form-group">
                    <input type="password" required value="{{ old('password') }}" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" required value="{{ old('confirm_password') }}" name="confirm_password" class="form-control" placeholder="Confirm Password">
                </div>
                <button type="submit">Create Account</button>
            </form>
        </div>
        <div class="actionBtn2">
            <p>By Creating Account you are agree to our <a href="{{ route('terms-and-conditions') }}">Terms & conditions</a></p>
        </div>
    </div>

</section>
<!-- Signin Section End Here -->
@include('layouts.front.partials._footerLinks')


</body>
</html>
