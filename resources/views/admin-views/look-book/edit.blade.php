@extends('layouts.back-end.app')

@section('title','Look Book Update')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{trans('messages.look_book')}}</li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('messages.look_book')}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.lookbook.update',[$look_book->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group lang_form" id="form">
                                        <label class="input-label">{{trans('messages.title')}}</label>
                                        <input type="text" name="title"
                                               value="{!! $look_book->title !!}"
                                               class="form-control"
                                               placeholder="Ex : Look Book Season 1" required>
                                    </div>
                                </div>
                                <!--image upload only for main category-->
                                <div class="col-6 from_part_2">
                                    <label>{{trans('messages.image')}}</label>
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
                                            <img style="width: 30%;border: 1px solid; border-radius: 10px;"
                                                 id="viewer"
                                                 src="{{asset('storage/app/public/look-book').'/'.$look_book->banner}}"
                                                 alt=""/>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">{{trans('messages.update')}}</button>
                        </form>
                    </div>
                </div>
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
    </script>
@endpush
