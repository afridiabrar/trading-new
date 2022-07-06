@extends('layouts.back-end.app')
@section('title','Look Book')
@push('css_or_js')
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

    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page"> {{ trans('messages.look_book')}}</li>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('messages.look_book')}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.lookbook.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">

                                        <label for="title">{{ trans('messages.Title')}}</label>
                                        <input type="text" name="title" required class="form-control" id="title"
                                               placeholder="Ex : Look Book Season 1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 from_part_2">
                                        <label>{{trans('messages.Image')}}</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="customFileEg1"
                                                   class="custom-file-input"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
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
                                                    src="{{asset('assets/back-end/img/900x400/img1.jpg')}}"
                                                    alt="image"/>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit"
                                        class="btn btn-primary ">{{ trans('messages.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--modal-->

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('messages.look_book')}} {{ trans('messages.Table')}}</h5>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{ trans('messages.SL#')}}</th>
                                    <th>{{ trans('messages.Title')}}</th>
                                    <th>{{ trans('messages.banner')}}</th>
                                    <th></th>
                                    <th>{{ trans('messages.status')}}</th>
                                    <th style="width: 50px">{{ trans('messages.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($look_books as $key => $look_book)
                                    <tr>
                                        <th scope="row">{!! $key+1 !!}</th>
                                        <td>{{$look_book->title}}</td>
                                        <td>
                                            <img width="64"
                                                 onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                                 src="{{asset('storage/app/public/look-book') .'/'. $look_book->banner}}">
                                        </td>
                                        <td>
                                            <a href="{{route('admin.lookbook.add-product',[$look_book->id])}}"
                                               class="btn btn-primary btn-sm">
                                                Add Product
                                            </a>
                                            <a href="{{route('admin.lookbook.look_book_gallery',[$look_book->id])}}"
                                               class="btn btn-primary btn-sm">
                                                Add Gallery
                                            </a>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="status"
                                                       id="{{$look_book->id}}" {{$look_book->status == 1?'checked':''}}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.lookbook.edit',[$look_book->id])}}"
                                               class="btn btn-primary btn-sm">
                                                {{ trans ('Edit')}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{$look_books->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
        {{--$(document).on('change', '.featured', function () {--}}
        {{--    var id = $(this).attr("id");--}}
        {{--    if ($(this).prop("checked") == true) {--}}
        {{--        var featured = 1;--}}
        {{--    } else if ($(this).prop("checked") == false) {--}}
        {{--        var featured = 0;--}}
        {{--    }--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        url: "{{route('admin.deal.featured-update')}}",--}}
        {{--        method: 'POST',--}}
        {{--        data: {--}}
        {{--            id: id,--}}
        {{--            featured: featured--}}
        {{--        },--}}
        {{--        success: function () {--}}
        {{--            toastr.success('Status updated successfully');--}}
        {{--            // location.reload();--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.lookbook.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function () {
                    toastr.success('Status updated successfully');
                    location.reload();
                }
            });
        });

    </script>

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
