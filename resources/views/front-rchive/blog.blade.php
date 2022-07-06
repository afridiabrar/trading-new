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
                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                    Fashion
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                    Life
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                                    Style
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content ">
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <div class="container kanye">
                                    <h2>Latest Articles</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('unsplash.png') !!}">
                                                <span>SURFACED</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('owens.png') !!}">
                                                <span>SURFACED</span>
                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="kanye-clmn">
                                                <img src="{!! frontImage('kanye-1.png') !!}">
                                                <span>Kanye West's Most Influential Outfits</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('unsplash.png') !!}">
                                                <span>SURFACED</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('owens.png') !!}">
                                                <span>SURFACED</span>
                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="kanye-clmn">
                                                <img src="{!! frontImage('kanye-1.png') !!}">
                                                <span>Kanye West's Most Influential Outfits</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                    </div>
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
                            <div class="tab-pane" id="messages" role="tabpanel">
                                <div class="container kanye">
                                    <h2>Latest Articles</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('owens.png') !!}">
                                                <span>SURFACED</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('unsplash.png') !!}">
                                                <span>SURFACED</span>
                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="kanye-clmn">
                                                <img src="{!! frontImage('kanye-1.png') !!}">
                                                <span>Kanye West's Most Influential Outfits</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('unsplash.png') !!}">
                                                <span>SURFACED</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('owens.png') !!}">
                                                <span>SURFACED</span>
                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="kanye-clmn">
                                                <img src="{!! frontImage('kanye-1.png') !!}">
                                                <span>Kanye West's Most Influential Outfits</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end container-->
                                <div class="container delivery">
                                    <div class="row text-center ">
                                        <div class="col-sm-3 ">
                                            <img src="{!! frontImage('delivery.png') !!}">
                                            <p>Free Delivery</p>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <img src="{!! frontImage('customer.png') !!}">
                                            <p>Customer Support</p>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <img src="{!! frontImage('refund.png') !!}">
                                            <p>Money Return</p>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <img src="{!! frontImage('percent.png') !!}">
                                            <p>Amazing Discount</p>
                                        </div>
                                    </div>
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
                            <div class="tab-pane" id="settings" role="tabpanel">
                                <div class="container kanye">
                                    <h2>Latest Articles</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('unsplash.png') !!}">
                                                <span>SURFACED</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('owens.png') !!}">
                                                <span>SURFACED</span>
                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="kanye-clmn">
                                                <img src="{!! frontImage('kanye-1.png') !!}">
                                                <span>Kanye West's Most Influential Outfits</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('unsplash.png') !!}">
                                                <span>SURFACED</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checksx">
                                                <img src="{!! frontImage('owens.png') !!}">
                                                <span>SURFACED</span>
                                                <p>Is the Lace Shirt the Post-Lockdown Piece of the Summer?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="kanye-clmn">
                                                <img src="{!! frontImage('kanye-1.png') !!}">
                                                <span>Kanye West's Most Influential Outfits</span>
                                                <p>The 10 Most In-Demand Items on Grailed This Week</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end container-->
                                <div class="container delivery">
                                    <div class="row text-center ">
                                        <div class="col-sm-3 ">
                                            <img src="{!! frontImage('delivery.png') !!}">
                                            <p>Free Delivery</p>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <img src="{!! frontImage('customer.png') !!}">
                                            <p>Customer Support</p>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <img src="{!! frontImage('refund.png') !!}">
                                            <p>Money Return</p>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <img src="{!! frontImage('percent.png') !!}">
                                            <p>Amazing Discount</p>
                                        </div>
                                    </div>
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
                                                </form>
                                                <button type="submit" class="button">Sign Up</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end container-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
