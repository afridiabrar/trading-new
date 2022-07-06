<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{!! frontCss('style.css') !!}">
<link rel="stylesheet" href="{!! frontCss('custom.css') !!}">
<link rel="stylesheet" href="{!! frontCss('far.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! frontCss('slick.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! frontCss('slick-theme.css') !!}">
{{--<link rel="shortcut icon" type="image/ftr-lgo.png" href="{!! frontImage('ftr-lgo.png') !!}">--}}
<link rel="apple-touch-icon" sizes="180x180"
      href="{!! asset('storage/app/public/company') .'/'. $web_config['fav_icon']->value !!}">
<link rel="icon" type="image/png" sizes="32x32"
      href="{!! asset('storage/app/public/company') .'/'. $web_config['fav_icon']->value !!}">
<link rel="stylesheet" href="{!! frontCss('jquery.ui.all.css') !!}">
<link rel="stylesheet" href="{!! frontCss('demos.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/back-end/css/toastr.css') !!}"/>
<meta name="csrf-token" content="{!! csrf_token() !!}">

@stack('css')
