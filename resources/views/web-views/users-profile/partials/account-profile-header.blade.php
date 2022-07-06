<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="teext-w-icn">
                <img class="img-fluid rounded-circle border"
                     style="border-radius: 50px; margin-left: 7px; width: 50px!important;height: 50px!important;"
                     onerror="this.src='{{asset('assets/front-end/img/image-place-holder.png')}}'"
                     src="{!! asset('storage/app/public/profile/'.auth('customer')->user()->image) !!}">
                {{--                    <img class="img-fluid"--}}
                {{--                         src="{!! asset('storage/app/public/profile/'.auth('customer')->user()->image) !!}">--}}
                <h4>{!! auth('customer')->user()->f_name .' '. auth('customer')->user()->l_name !!}<br>
                    {{--                        <span>User # 12496</span>--}}
                </h4>
            </div>
        </div>
        <div class="col-md-8">
            <h2 class="text-center">
                Profile
            </h2>
        </div>
    </div>
</div>
