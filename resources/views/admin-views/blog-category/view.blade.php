@extends('layouts.back-end.app')

@section('title','Blog Categories')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{trans('messages.blog_categories')}}</li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('messages.blog_category_form')}}
                    </div>
                    <div class="card-body">
                        <form action="{!! route('admin.blog-category.store') !!}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group lang_form">
                                        <label class="input-label"
                                               for="exampleFormControlInput1">{{trans('messages.name')}}</label>
                                        <input type="text" name="name" class="form-control"
                                               placeholder="New Category">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">{{trans('messages.submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px" id="cate-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('messages.blog_category_table')}}</h5>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th style="width: 100px">{{ trans('messages.category')}} {{ trans('messages.ID')}}</th>
                                    <th>{{ trans('messages.name')}}</th>
                                    <th>{{ trans('messages.slug')}}</th>
                                    <th class="text-center" style="width:15%;">{{ trans('messages.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td class="text-center">{{$category['id']}}</td>
                                        <td>{{$category['name']}}</td>
                                        <td>{{$category['slug']}}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm edit" style="cursor: pointer;"
                                               href="{{route('admin.blog-category.edit',[$category['id']])}}">
                                                <i class="tio-edit"></i>{{ trans('messages.Edit')}}
                                            </a>
                                            <a class="btn btn-danger btn-sm delete" style="cursor: pointer;"
                                               href="{{route('admin.blog-category.delete',[$category['id']])}}">
                                                <i class="tio-add-to-trash"></i>{{ trans('messages.Delete')}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{$categories->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        {{--$(document).on('click', '.delete', function () {--}}
        {{--    var id = $(this).attr("id");--}}
        {{--    Swal.fire({--}}
        {{--        title: 'Are you sure?',--}}
        {{--        text: "You won't be able to revert this!",--}}
        {{--        showCancelButton: true,--}}
        {{--        confirmButtonColor: '#3085d6',--}}
        {{--        cancelButtonColor: '#d33',--}}
        {{--        confirmButtonText: 'Yes, delete it!'--}}
        {{--    }).then((result) => {--}}
        {{--        if (result.value) {--}}
        {{--            $.ajaxSetup({--}}
        {{--                headers: {--}}
        {{--                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
        {{--                }--}}
        {{--            });--}}
        {{--            $.ajax({--}}
        {{--                url: "{{route('admin.category.delete')}}",--}}
        {{--                method: 'POST',--}}
        {{--                data: {id: id},--}}
        {{--                success: function () {--}}
        {{--                    toastr.success('Category deleted Successfully.');--}}
        {{--                    location.reload();--}}
        {{--                }--}}
        {{--            });--}}
        {{--        }--}}
        {{--    })--}}
        {{--});--}}

        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

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
