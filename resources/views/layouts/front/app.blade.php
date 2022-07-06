<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts.front.partials._headLinks')
</head>
<body>
@include('layouts.front.partials._navBar')
@include('layouts.front.partials._header')
{{--loader--}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" style="display: none;">
                <div style="position: fixed;z-index: 9999; left: 40%;top: 37% ;width: 100%">
                    <img width="200" src="{!! asset('assets/front/images/loader.gif') !!}">
                </div>
            </div>
        </div>
    </div>
</div>
{{--loader--}}

@yield('content')

@include('layouts.front.partials._footer')
@include('layouts.front.partials._footerLinks')
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/6102c11ad6e7610a49ad9a8c/1fbpc4kou';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
    jQuery(document).ready(function () {
        $(".hideboth").hide();
        var arrivalscon = $(".arrivalscon").html();
        var blogcon = $(".blogcon").html();
        if (window.location.href.indexOf("blog") > -1) {
            $(".headertbottom").html(blogcon);
        } else {
            $(".headertbottom").html(arrivalscon);
        }
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 500,
            values: [75, 300],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));

        $(document).ready(function () {
            $('#ex1').zoom();

            $('.boxcccc').addClass('highlited');

            $('.canvasx').click(function () {
                $(this).addClass('current');
                $("#openSidebarMenu").prop("checked", true);
                $('.closeDv').show();
            });

            $('.closeDv').click(function(){
                $('.canvasx').removeClass('current');
                $("#openSidebarMenu").prop("checked", false);
                $(this).hide();
            });

            $(".proList").slick({
                arrow: true,
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1
            });

            $(".proList .slick-slide img").click(function(){
                var getImgSrc = $(this).attr('src');
                var setImgSrc = $('.mainPro img').attr('src', getImgSrc);
            });
        });
    });

    function currency_change(currency_code) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '{!! route('currency.change') !!}',
            data: {
                currency_code: currency_code
            },
            success: function (data) {
                toastr.success('Currency changed to ' + data.name);
                location.reload();
            }
        });
    }

    function couponCode() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{!! route('coupon.apply') !!}',
            data: $('#coupon-code-ajax').serializeArray(),
            success: function (data) {
                if (data.status == 1) {
                    let ms = data.messages;
                    ms.forEach(
                        function (m, index) {
                            toastr.success(m, index, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    );
                } else {
                    let ms = data.messages;
                    ms.forEach(
                        function (m, index) {
                            toastr.error(m, index, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    );
                }
                setInterval(function () {
                    location.reload();
                }, 2000);
            }
        });
    }
</script>
</body>
</html>
