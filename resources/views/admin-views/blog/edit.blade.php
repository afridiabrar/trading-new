@extends('layouts.back-end.app')

@section('title','Blog Edit')

@push('css_or_js')
    <link href="{{ asset('assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .parcent-margin {
            margin-left: -20px;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #product-images-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        #thumbnail-image-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #product-images-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }

            #thumbnail-image-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }
        }

        @media (max-width: 375px) {
            #product-images-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

            #thumbnail-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }
        }

        @media (max-width: 500px) {
            #product-images-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            #thumbnail-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            .btn-for-m {
                margin-bottom: 10px;
            }

            .parcent-margin {
                margin-left: 0px !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item">{{trans('messages.Edit')}}</li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <form class="product-form" action="{{route('admin.blog.update', $blog->id)}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="lang_form">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="input-label" for="">{{trans('messages.title')}}</label>
                                            <input type="text" name="title"class="form-control" value="{!! old('title', $blog->title) !!}" placeholder="Title" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">{{trans('messages.category')}}</label>
                                            <select
                                                class="js-example-basic-multiple js-states js-example-responsive form-control"
                                                name="blog_category_id" required>
                                                <option value=""></option>
                                                @foreach($categories as $key => $category)
                                                    <option value="{!! $category->id !!}" {!! (old('blog_category_id') == $category->id || $blog->blog_category_id == $category->id) ? 'selected' : '' !!}>{!! $category->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pt-4">
                                    <label class="input-label" for="description">{{trans('messages.content')}}</label>
                                    <textarea name="content" id="editor" class="editor textarea" cols="30"
                                              rows="10" required>{!! old('content', $blog->content) !!}</textarea>
                                </div>
                                <div class="col-6 from_part_2">
                                    <label>{{trans('messages.image')}}</label>
                                    {{--                                    <small style="color: red">( {{trans('messages.ratio')}} 3:1 )</small>--}}
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileEg1"
                                               class="custom-file-input"
                                               accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label"
                                               for="customFileEg1">{{trans('messages.choose')}} {{trans('messages.file')}}</label>
                                    </div>
                                </div>
                                <div class="col-12 from_part_2">
                                    <div class="form-group">
                                        <hr>
                                        <center>
                                            <img
                                                style="width: 30%;border: 1px solid; border-radius: 10px;"
                                                id="viewer"
                                                src="{!! (isset($blog->image)) ? $blog->image : asset('assets/back-end/img/900x400/img1.jpg') !!}"
                                                alt="image"/>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 20px">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });

        $(".js-example-responsive").select2({
            placeholder: 'Select Category',
            width: 'resolve'
        });
    </script>

    {{--ck editor--}}
{{--    <script src="{{asset('/')}}vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>--}}
{{--    <script src="{{asset('/')}}vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>--}}
{{--    <script>$('.textarea').ckeditor();</script>--}}
    {{--ck editor--}}
@endpush
