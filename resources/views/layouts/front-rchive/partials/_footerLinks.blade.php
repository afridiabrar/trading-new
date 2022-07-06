<script src="{!! frontJs('jquery.min.js') !!}"></script>
<script src="{!! frontJs('bootstrap.min.js') !!}"></script>
{{--<script src="{!! frontJs('jquery-1.10.2.js') !!}"></script>--}}
<script src="{!! frontJs('jquery.ui.core.js') !!}"></script>
<script src="{!! frontJs('jquery.ui.widget.js') !!}"></script>
<script src="{!! frontJs('jquery.ui.mouse.js') !!}"></script>
<script src="{!! frontJs('jquery.ui.slider.js') !!}"></script>
<script src="{!! frontJs('slick.js') !!}" type="text/javascript" charset="utf-8"></script>
<script src="{!! frontJs('custom.js') !!}" type="text/javascript" charset="utf-8"></script>
{{--Toastr--}}
<script src="{!! asset("public/assets/back-end/js/toastr.js") !!}"></script>
<script src="{!! frontJs('jquery.zoom.js') !!}"></script>

{!! Toastr::message() !!}

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
