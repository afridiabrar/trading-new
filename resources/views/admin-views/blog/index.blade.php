@extends('layouts.back-end.app')

@section('title','Blog List')

@push('css_or_js')
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
    <div class="content container-fluid">  <!-- Page Heading -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{trans('messages.blog')}}</li>
            </ol>
        </nav>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{trans('messages.blog_table')}}</h5>
                        <a href="{!! route('admin.blog.add-new') !!}" class="btn btn-primary  float-right">
                            <i class="tio-add-circle"></i>
                            <span class="text">{{trans('messages.add_new_blog')}}</span>
                        </a>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{trans('messages.SL#')}}</th>
                                    <th>{{trans('messages.blog_title')}}</th>
{{--                                    <th>{{trans('messages.blog_category')}}</th>--}}
                                    <th>{{trans('messages.blog_image')}}</th>
                                    <th>{{trans('messages.blog_published')}}</th>
                                    <th style="width: 5px" class="text-center">{{trans('messages.Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blogs as $key => $blog)
                                    <tr>
                                        <th scope="row">{{$key+1}}</th>
                                        <td>
                                            <a href="{{route('admin.product.view', $blog->id)}}">
                                                {{substr($blog->title,0,20)}}{{strlen($blog->title)>20?'...':''}}
                                            </a>
                                        </td>
{{--                                        <td>--}}
{{--                                            {!! $blog->blogCategory->name !!}--}}
{{--                                        </td>--}}
                                        <td>
                                            <img width="64"
{{--                                                 onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"--}}
                                                 src="{{$blog->image}}">
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="published"
                                                       id="{!! $blog->id !!}" {!! $blog->published == 1 ? 'checked' :''  !!}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm"
                                               href="{{route('admin.blog.edit', $blog->id)}}">
                                                <i class="tio-edit"></i>{{trans('messages.Edit')}}
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="javascript:"
                                               onclick="form_alert('blog-{!! $blog->id !!}','Want to delete this item ?')">
                                                <i class="tio-add-to-trash"></i> {{trans('messages.Delete')}}
                                            </a>
                                            <form action="{!! route('admin.blog.delete', $blog->id) !!}"
                                                  method="post" id="blog-{!! $blog->id !!}">
                                                @csrf @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{$blogs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

        $(document).on('change', '.published', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var published = 1;
            } else if ($(this).prop("checked") == false) {
                var published = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.blog.published')}}",
                method: 'POST',
                data: {
                    id: id,
                    published: published
                },
                success: function () {
                    toastr.success('Blog published successfully!');
                }
            });
        });

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
                url: "{{route('admin.product.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function () {
                    toastr.success('Status updated successfully');
                }
            });
        });
    </script>
@endpush
