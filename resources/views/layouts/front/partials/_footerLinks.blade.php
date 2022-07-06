<script src="{!! frontJs('jquery.min.js') !!}"></script>
<script src="https://unpkg.com/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script language="JavaScript" src="{{ frontJs('popper.js') }}"></script>
<script language="JavaScript" src="{{ frontJs('bootstrap.min.js') }}"></script>
<script language="JavaScript" src="{{ frontJs('main.js') }}"></script>
<script language="JavaScript" src="{{ frontJs('scripts.js') }}"></script>
<script type="text/javascript" src="{{ frontFiles('slick/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ frontFiles('slick/slick.js') }}"></script>

{{--Toastr--}}
<script src="{!! asset("public/assets/back-end/js/toastr.js") !!}"></script>
{!! Toastr::message() !!}


<script>
    $(document).ready(function() {
        $(".dropdown").hover(function() {
            var dropdownMenu = $(this).children(".dropdown-menu");
            if (dropdownMenu.is(":visible")) {
                dropdownMenu.parent().toggleClass("open");
            }
        });
    });
</script>
<script>
    $('.count').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>
<script>
    $('.regular').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true,
                arrow: true
            }
        },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrow: true
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 6,
                    arrow: true
                }
            }
        ]
    });

    $(document).ready(function() {
        $(".bannerSlider").slick({
            arrow: true,
            dots: true,
            autoplay: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [{
                breakpoint: 1024,
                settings: {

                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    arrow: true,
                    dots: true,
                    arrow: true
                }
            }]

        });
    });
    // As a jQuery Plugin
    // Vanilla JavaScript
    // ------------step-wizard-------------
    $(document).ready(function() {
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {

            var target = $(e.target);

            if (target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function(e) {

            var active = $('.wizard .nav-tabs li.active');
            active.next().removeClass('disabled');
            nextTab(active);

        });
        $(".prev-step").click(function(e) {

            var active = $('.wizard .nav-tabs li.active');
            prevTab(active);

        });
    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }

    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }


    $('.nav-tabs').on('click', 'li', function() {
        $('.nav-tabs li.active').removeClass('active');
        $(this).addClass('active');
    });
</script>

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
@stack('js')
