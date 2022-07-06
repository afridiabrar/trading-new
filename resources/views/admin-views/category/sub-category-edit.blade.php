@extends('layouts.back-end.app')

@section('title','Category')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{trans('messages.category')}}</li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('messages.category_form')}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.sub-category.update',[$category['id']])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group lang_form" id="form">
                                        <label class="input-label">{{trans('messages.name')}}</label>
                                        <input type="text" name="name"
                                               value="{!! $category->name !!}"
                                               class="form-control"
                                               placeholder="New Category" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="input-label"
                                               for="exampleFormControlSelect1">{{trans('messages.main')}} {{trans('messages.category')}}
                                            <span class="input-label-secondary">*</span></label>
                                        <select id="exampleFormControlSelect1" name="parent_id"
                                                class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach(\App\Model\Category::where(['position'=>0])->get() as $categories)
                                                <option value="{{$categories['id']}}" {!! ($category->parent_id == $categories['id']) ? 'selected="selected"' : '' !!}>{{$categories['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            <!--image upload only for main category-->
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
                                            @if($category->parent_id > 0)
                                                <img style="width: 30%;border: 1px solid; border-radius: 10px;"
                                                     id="viewer"
                                                     src="{{asset('storage/app/public/category/sub-category')}}/{{$category['icon']}}"
                                                     alt=""/>
                                            @else
                                                <img style="width: 30%;border: 1px solid; border-radius: 10px;"
                                                     id="viewer"
                                                     src="{{asset('storage/app/public/category')}}/{{$category['icon']}}"
                                                     alt=""/>
                                            @endif
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
        $(document).ready(function () {
            $('#dataTable').DataTable();
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
