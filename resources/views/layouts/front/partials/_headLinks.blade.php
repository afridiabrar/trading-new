

<link rel="stylesheet" href="{{ frontFont('Blacksword.otf') }}">
<link href="http://fonts.cdnfonts.com/css/blacksword" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&family=Teko:wght@300&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ frontCss('style.css') }}">
<link rel="stylesheet" href="{{ frontCss('st-style.css') }}">
<link rel="stylesheet" href="{{ frontFiles('slick/slick.css') }}">
<link rel="stylesheet" href="https://unpkg.com/bs-stepper/dist/css/bs-stepper.min.css">
<link rel="stylesheet" href="slick/slick-theme.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js">
<link rel="icon" href="{{ frontImage('logo-cloud.png.png') }}" type="image/png" sizes="16x16">
<link rel="stylesheet" href="{!! asset('assets/back-end/css/toastr.css') !!}"/>

<meta name="csrf-token" content="{!! csrf_token() !!}">

@stack('css')
