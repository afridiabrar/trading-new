@extends('layouts.front.app')
@section('title', 'Blog')
@section('css')
    <style type="text/css">
        .newsletter .newsletter-form {
            position: relative;
            width: 52% !important;
            margin-top: 23px;
            z-index: 999;
            margin: 0px auto;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 mr-auto">
                <!-- Nav tabs -->
                <div class="card article-tabsx">
                    <div class="card-header">
                        {{-- <ul class="nav nav-tabs justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link {!! (isset($_GET['category']) && $_GET['category'] == 'all') ? 'active' : '' !!}" href="{!! route('blog').'?category=all' !!}">
                                    All
                                </a>
                            </li>
                            @foreach($blogCategories as $key => $blogCategory)
                                <li class="nav-item">
                                    <a class="nav-link {!! (isset($_GET['category']) && $_GET['category'] == $blogCategory->id) ? 'active' : '' !!}" href="{!! route('blog').'?category='.$blogCategory->id !!}">
                                        {!! $blogCategory->name !!}
                                    </a>
                                </li>
                            @endforeach
                            <li class="nav-item">
                                <select class="form-controlx searchByCategory" onchange="searchByCategory()" name="category" id="exampleSelect1">
                                    <option value="all" {!! (isset($_GET['category']) && $_GET['category'] == 'all') ? 'selected="selected"' : '' !!}>All</option>
                                    @foreach($blogCategories as $key => $blogCategory)
                                        <option value="{!! $blogCategory->id !!}" {!! (isset($_GET['category']) && $_GET['category'] == $blogCategory->id) ? 'selected="selected"' : '' !!}>{!! $blogCategory->name !!}</option>
                                    @endforeach
                                </select>
                            </li>
                        </ul> --}}
                    </div>
                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="container kanye">
                                    <h2>Latest Articles</h2>
                                    @foreach($blogsArray as $key => $blogs)
                                        <div class="row">
                                            @foreach($blogs as $blogKey => $blog)
                                                <div class="col-sm-6">
                                                    <div class="checksx">
                                                        <img src="{!! asset('storage/app/public/blog/'.$blog['image']) !!}">
                                                        <span>{!! Str::limit($blog['title'], 50) !!}</span>
                                                        <p>{!! Str::limit(strip_tags($blog['content']), 60, ' <a class="text-black bold d-block" href="'.route('blog-details', $blog['id']).'">Read More...</a>') !!}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
{{--                                    <a class="btn btn-outline-info btn-md btn-rounded btn-navbar waves-effect waves-light" id="blogsLoadMore">Load More</a>--}}
                                </div>
                                <!-- end container-->
                                <div class="container email">
                                    <div class="row ">
                                        <div class="col-sm-12 text-center">
                                            <h2>Become an Rchive Member </h2>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum <br>
                                                has been the industry's standard dummy text ever since the 1500s, when
                                                an unknown<br>
                                                printer took a galley of type and scrambled it to make a type specimen
                                                book.</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="newsletter js-rollover" data-radius="50">
                                                <form method="GET" action="https://kikk.us6.list-manage.com/subscribe"
                                                      class="newsletter-form" target="_blank">
                                                    <input type="hidden" name="u" value="d08fe605a9149dc54a3c13f44">
                                                    <input type="hidden" name="id" value="96f67efdeb">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                                               aria-describedby="emailHelp"
                                                               placeholder="Enter your Email Address">
                                                    </div>
                                                    <button type="submit" class="button">Sign Up</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end container-->
                            </div>
{{--                            <div class="tab-pane" id="messages" role="tabpanel">--}}
{{--                                <div class="container kanye">--}}
{{--                                    <h2>Latest Articles</h2>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="checksx">--}}
{{--                                                <img src="{!! frontImage('owens.png') !!}">--}}
{{--                                                <span>SURFACED</span>--}}
{{--                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="checksx">--}}
{{--                                                <img src="{!! frontImage('unsplash.png') !!}">--}}
{{--                                                <span>SURFACED</span>--}}
{{--                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="kanye-clmn">--}}
{{--                                                <img src="{!! frontImage('kanye-1.png') !!}">--}}
{{--                                                <span>Kanye West's Most Influential Outfits</span>--}}
{{--                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="checksx">--}}
{{--                                                <img src="{!! frontImage('unsplash.png') !!}">--}}
{{--                                                <span>SURFACED</span>--}}
{{--                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="checksx">--}}
{{--                                                <img src="{!! frontImage('owens.png') !!}">--}}
{{--                                                <span>SURFACED</span>--}}
{{--                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="kanye-clmn">--}}
{{--                                                <img src="{!! frontImage('kanye-1.png') !!}">--}}
{{--                                                <span>Kanye West's Most Influential Outfits</span>--}}
{{--                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!-- end container-->--}}
{{--                                <div class="container delivery">--}}
{{--                                    <div class="row text-center ">--}}
{{--                                        <div class="col-sm-3 ">--}}
{{--                                            <img src="{!! frontImage('delivery.png') !!}">--}}
{{--                                            <p>Free Delivery</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-3 ">--}}
{{--                                            <img src="{!! frontImage('customer.png') !!}">--}}
{{--                                            <p>Customer Support</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-3 ">--}}
{{--                                            <img src="{!! frontImage('refund.png') !!}">--}}
{{--                                            <p>Money Return</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-3 ">--}}
{{--                                            <img src="{!! frontImage('percent.png') !!}">--}}
{{--                                            <p>Amazing Discount</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!-- end container-->--}}
{{--                                <div class="container email">--}}
{{--                                    <div class="row ">--}}
{{--                                        <div class="col-sm-12 text-center">--}}
{{--                                            <h2>Become an Rchive Member </h2>--}}
{{--                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting--}}
{{--                                                industry. Lorem Ipsum <br>--}}
{{--                                                has been the industry's standard dummy text ever since the 1500s, when--}}
{{--                                                an unknown<br>--}}
{{--                                                printer took a galley of type and scrambled it to make a type specimen--}}
{{--                                                book.</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="newsletter js-rollover" data-radius="50">--}}
{{--                                                <form method="GET" action="https://kikk.us6.list-manage.com/subscribe"--}}
{{--                                                      class="newsletter-form" target="_blank">--}}
{{--                                                    <input type="hidden" name="u" value="d08fe605a9149dc54a3c13f44">--}}
{{--                                                    <input type="hidden" name="id" value="96f67efdeb">--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <label for="exampleInputEmail1">Email</label>--}}
{{--                                                        <input type="email" class="form-control" id="exampleInputEmail1"--}}
{{--                                                               aria-describedby="emailHelp"--}}
{{--                                                               placeholder="Enter your Email Address">--}}
{{--                                                    </div>--}}
{{--                                                    <button type="submit" class="button">Sign Up</button>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!-- end container-->--}}
{{--                            </div>--}}
{{--                            <div class="tab-pane" id="settings" role="tabpanel">--}}
{{--                                <div class="container kanye">--}}
{{--                                    <h2>Latest Articles</h2>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="checksx">--}}
{{--                                                <img src="{!! frontImage('unsplash.png') !!}">--}}
{{--                                                <span>SURFACED</span>--}}
{{--                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="checksx">--}}
{{--                                                <img src="{!! frontImage('owens.png') !!}">--}}
{{--                                                <span>SURFACED</span>--}}
{{--                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="kanye-clmn">--}}
{{--                                                <img src="{!! frontImage('kanye-1.png') !!}">--}}
{{--                                                <span>Kanye West's Most Influential Outfits</span>--}}
{{--                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="checksx">--}}
{{--                                                <img src="{!! frontImage('unsplash.png') !!}">--}}
{{--                                                <span>SURFACED</span>--}}
{{--                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="checksx">--}}
{{--                                                <img src="{!! frontImage('owens.png') !!}">--}}
{{--                                                <span>SURFACED</span>--}}
{{--                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="kanye-clmn">--}}
{{--                                                <img src="{!! frontImage('kanye-1.png') !!}">--}}
{{--                                                <span>Kanye West's Most Influential Outfits</span>--}}
{{--                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!-- end container-->--}}
{{--                                <div class="container delivery">--}}
{{--                                    <div class="row text-center ">--}}
{{--                                        <div class="col-sm-3 ">--}}
{{--                                            <img src="{!! frontImage('delivery.png') !!}">--}}
{{--                                            <p>Free Delivery</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-3 ">--}}
{{--                                            <img src="{!! frontImage('customer.png') !!}">--}}
{{--                                            <p>Customer Support</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-3 ">--}}
{{--                                            <img src="{!! frontImage('refund.png') !!}">--}}
{{--                                            <p>Money Return</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-3 ">--}}
{{--                                            <img src="{!! frontImage('percent.png') !!}">--}}
{{--                                            <p>Amazing Discount</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!-- end container-->--}}
{{--                                <div class="container email">--}}
{{--                                    <div class="row ">--}}
{{--                                        <div class="col-sm-12 text-center">--}}
{{--                                            <h2>Become an Rchive Member </h2>--}}
{{--                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting--}}
{{--                                                industry. Lorem Ipsum <br>--}}
{{--                                                has been the industry's standard dummy text ever since the 1500s, when--}}
{{--                                                an unknown<br>--}}
{{--                                                printer took a galley of type and scrambled it to make a type specimen--}}
{{--                                                book.</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="newsletter js-rollover" data-radius="50">--}}
{{--                                                <form method="GET" action="https://kikk.us6.list-manage.com/subscribe"--}}
{{--                                                      class="newsletter-form" target="_blank">--}}
{{--                                                    <input type="hidden" name="u" value="d08fe605a9149dc54a3c13f44">--}}
{{--                                                    <input type="hidden" name="id" value="96f67efdeb">--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <label for="exampleInputEmail1">Email</label>--}}
{{--                                                        <input type="email" class="form-control" id="exampleInputEmail1"--}}
{{--                                                               aria-describedby="emailHelp"--}}
{{--                                                               placeholder="Enter your Email Address">--}}
{{--                                                    </div>--}}
{{--                                                </form>--}}
{{--                                                <button type="submit" class="button">Sign Up</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!-- end container-->--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        function searchByCategory () {
            let queryString = window.location.search;
            let params = new URLSearchParams(queryString);
            params.delete('category')
            params.append('category', $('.searchByCategory').val());
            document.location.href = "?" + params.toString();
        }
    </script>
@endpush
