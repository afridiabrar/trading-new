@extends('layouts.front.app')

@section('title', auth('customer')->user()->f_name.' '.auth('customer')->user()->l_name . ' | ' . 'Profile')

@section('content')

    @include('web-views.users-profile.partials.account-profile-header')

    <section class="check-sec">
        <div class="container frm-prof">
            <div class="row">

                @include('web-views.users-profile.partials.account-side-menu')

                <div class="col-sm-8">
                    <div class="clmnxx">

                        <div class="cont-formxx un-brdrx">
                            <div class="contact-inner">
                                <form id="contact-form" method="post" action="{!! route('user-update') !!}" role="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="messages"></div>
                                    <div class="controls">
                                        <div class="row cont-gapx">
                                            <img id="blah"
                                                 style="border-radius: 50px; margin-left: 7px; width: 50px!important;height: 50px!important;"
                                                 class="rounded-circle border"
                                                 onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                                                 src="{!! asset('storage/app/public/profile/'.auth('customer')->user()->image) !!}">

                                            <div class="col-md-6">
                                                {{--                                            <label for="files" style="cursor: pointer; color:{{$web_config['primary_color']}};" class="">--}}
                                                {{--                                                {{trans('messages.change_your_profile')}}--}}
                                                {{--                                            </label>--}}
                                                {{--                                            <span style="color: red;font-size: 10px">( * Image ratio should be 1:1 )</span>--}}
                                                <label>Upload Image</label>
                                                <input id="files" name="image" type="file">
                                            </div>
                                        </div>

                                        <div class="row cont-gapx">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" name="first_name" class="form-control"
                                                           placeholder="First Name" value="{!! old('first_name', auth('customer')->user()->f_name) !!}" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" name="last_name"
                                                           class="form-control" placeholder="Last Name" value="{!! old('last_name', auth('customer')->user()->l_name) !!}" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row cont-gapx">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control"
                                                           placeholder="Email" value="{!! auth('customer')->user()->email !!}" readonly>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" name="phone"
                                                           class="form-control" value="{!! old('phone', auth('customer')->user()->phone) !!}" placeholder="Phone" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row cont-gapx">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" name="street_address"
                                                           class="form-control" value="{!! old('street_address', auth('customer')->user()->street_address) !!}" placeholder="Street Address">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <input type="text" name="country" class="form-control"
                                                           placeholder="Country" value="{!! old('country', auth('customer')->user()->country) !!}">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row cont-gapx">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" name="city"
                                                           class="form-control" placeholder="City" value="{!! old('city', auth('customer')->user()->city) !!}">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Zip / Postcode</label>
                                                    <input type="text" name="zip" class="form-control"
                                                           placeholder="Zip / Postcode" value="{!! old('zip', auth('customer')->user()->zip) !!}">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-dark btn-submit">Update Profile</button>
                                    </div><!-- end -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
@endsection

@push('js')
    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#files").change(function () {
            readURL(this);
        });

    </script>
@endpush
