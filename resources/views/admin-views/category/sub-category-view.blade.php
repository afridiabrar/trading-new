@extends('layouts.back-end.app')

@section('title','Sub Category')

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
                        {{ trans('messages.sub_category_form')}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.sub-category.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
{{--                            @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())--}}
{{--                            @php($language = $language->value ?? null)--}}
{{--                            @php($default_lang = 'en')--}}

{{--                            @php($default_lang = json_decode($language)[0])--}}
{{--                            <ul class="nav nav-tabs mb-4">--}}
{{--                                @foreach(json_decode($language) as $lang)--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}"--}}
{{--                                           href="#"--}}
{{--                                           id="{{$lang}}-link">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
                            <div class="row">
                                <div class="col-6">
{{--                                    @foreach(json_decode($language) as $lang)--}}
{{--                                        <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">--}}
                                        <div class="form-group lang_form" id="form">
{{--                                            <label class="input-label" for="exampleFormControlInput1">{{trans('messages.sub_category')}} {{trans('messages.name')}}({{strtoupper($lang)}})</label>--}}
                                            <label class="input-label" for="exampleFormControlInput1">{{trans('messages.sub_category')}} {{trans('messages.name')}}</label>
{{--                                            <input type="text" name="name[]" class="form-control" placeholder="New Sub Category" {{$lang == $default_lang? 'required':''}}>--}}
                                            <input type="text" name="name" class="form-control" placeholder="New Sub Category">
                                        </div>
{{--                                        <input type="hidden" name="lang[]" value="{{$lang}}">--}}
{{--                                    @endforeach--}}
                                    <input name="position" value="1" style="display: none">
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="input-label"
                                               for="exampleFormControlSelect1">{{trans('messages.main')}} {{trans('messages.category')}}
                                            <span class="input-label-secondary">*</span></label>
                                        <select id="exampleFormControlSelect1" name="parent_id"
                                                class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach(\App\Model\Category::where(['position'=>0])->get() as $category)
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 from_part_2">
                                    <label>{{trans('messages.image')}}</label>
{{--                                    <small style="color: red">( {{trans('messages.ratio')}} 3:1 )</small>--}}
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
                        <h5>{{ trans('messages.sub_category_table')}}</h5>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table
                                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 100px">{{ trans('messages.category')}} {{ trans('messages.ID')}}</th>
                                    <th scope="col">{{ trans('messages.name')}}</th>
                                    <th scope="col">{{ trans('messages.slug')}}</th>
                                    <th scope="col">{{ trans('messages.icon')}}</th>
                                    <th scope="col" class="text-center" style="width: 80px">{{ trans('messages.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $key=>$category)
                                    <tr>
                                        <td class="text-center">{{$category['id']}}</td>
                                        <td>{{$category['name']}}</td>
                                        <td>{{$category['slug']}}</td>
                                        <td>
                                            <img width="64"
                                                 onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                                 src="{{asset('storage/app/public/category/sub-category')}}/{{$category['icon']}}">
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" style="cursor: pointer;"
                                               href="{{route('admin.sub-category.edit',[$category['id']])}}">
                                                <i class="tio-edit"></i> {{ trans('messages.Edit')}}
                                            </a>
                                            <a class="btn btn-danger btn-sm delete" style="cursor: pointer;"
                                               id="{{$category['id']}}">
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
        {{--$(".lang_link").click(function (e) {--}}
        {{--    e.preventDefault();--}}
        {{--    $(".lang_link").removeClass('active');--}}
        {{--    $(".lang_form").addClass('d-none');--}}
        {{--    $(this).addClass('active');--}}

        {{--    let form_id = this.id;--}}
        {{--    let lang = form_id.split("-")[0];--}}
        {{--    console.log(lang);--}}
        {{--    $("#" + lang + "-form").removeClass('d-none');--}}
        {{--    if (lang == '{{$default_lang}}') {--}}
        {{--        $(".from_part_2").removeClass('d-none');--}}
        {{--    } else {--}}
        {{--        $(".from_part_2").addClass('d-none');--}}
        {{--    }--}}
        {{--});--}}

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

    <script>
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: 'Are you sure to delete this sub category?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.sub-category.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('Sub Category deleted Successfully.');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
