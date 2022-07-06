@extends('layouts.back-end.app')

@section('title','Gallery Add')

@push('css_or_js')

    <style>
        #product-images-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #product-images-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }
        }

        @media (max-width: 375px) {
            #product-images-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }
        }

        @media (max-width: 500px) {
            #product-images-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
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
                <li class="breadcrumb-item" aria-current="page">{{trans('messages.look_book')}}
                </li>
                <li class="breadcrumb-item">{{trans('messages.Add')}} {{trans('messages.New')}} </li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <form class="product-form" action="{!! route('admin.lookbook.look_book_gallery', $look_book->id) !!}" method="POST"
                      enctype="multipart/form-data"
                      id="product_form">
                    @csrf
                    <div class="card mt-2 rest-part">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{trans('messages.Upload product images')}}</label>
                                        {{--                                        <small style="color: red">* ( {{trans('messages.ratio')}} 1:1 )</small>--}}
                                    </div>

                                    @if(count($look_book->gallery) > 0)
                                        <div class="p-2 border border-dashed" style="max-width:430px;">
                                            <div class="row" id="coba">
                                                @foreach ($look_book->gallery as $key => $photo)
                                                    <div class="col-6">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <img style="width: 100%" height="auto"
                                                                     onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                                                     src="{{asset("storage/app/public/look-book/gallery") .'/'. $photo['image']}}"
                                                                     alt="Product image">
                                                                <a href="{{route('admin.lookbook.gallery_image_remove',['id'=>$photo['id']])}}"
                                                                   class="btn btn-danger btn-block">Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-2 border border-dashed" style="max-width:430px;">
                                            <div class="row" id="coba">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-footer">
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 20px">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{asset('assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                // maxCount: 10,
                rowHeight: 'auto',
                allowedExt:'png|jpg|jpeg',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>

    <script src="{{asset('/')}}vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
@endpush
