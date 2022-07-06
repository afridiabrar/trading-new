@extends('layouts.front.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center abss">
                <h2>
                    LookBooks
                </h2>
            </div>
        </div>
    </div>
    <section class="Authenticate">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 ">
                    <h4>
                        Target's 20th Anniversary <br>
                        Collection Lookbook
                    </h4>
                    Posted by Dianna Baros August 19, 2020
                    <p>
                        Have you heard? Coming September 14, the Target 20th Anniversary <br>
                        Collection will launch with nearly 300 pieces from past designer <br>
                        collaborations, from Isaac Mizrahi to Lily Pulitzer. We're talking apparel <br>
                        (Rodarte tulle dresses!), home decor (Missoni stripes!) and kitchen <br>
                        essentials (John Derian bug mugs!), ranging in price from $7-$160.
                    </p>
                    <p>
                        As much as I'm enjoying this walk down memory lane, I'm not sure there's <br>
                        anything I "need" from this collection - but you may feel differently! Are you <br>
                        excited for this launch? Are there pieces that "got away" the first time around <br>
                        that you're dying to get your hands on this time? I can't wait to see how some <br>
                        of the newer bloggers style pieces that they were probably too young to wear <br>
                        the first time around, like the Steven Sprouse graffiti gear! Should be <br>
                        interesting to see...
                    </p>
                    <p>
                        Scroll down and see how many of these you can guess the designer for, <br>
                        then head to Target's blog for the "answers"!
                    </p>
                </div>
                <div class="col-sm-6">
                    <img class="img-fluid cv1x" src="{!! frontImage('mbl-app.png') !!}">
                    <div class="next">
                        <a href="#"><h4>Look Book Season 01 <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </h4></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="Lookbook2">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 ">
                    <img class="img-fluid" src="{!! frontImage('lady-1.png') !!}">
                    <div class="next1">
                        <a href="#"><h4>Look Book Season 02 <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </h4></a>
                    </div>
                </div>
                <div class="col-sm-7">
                    <img class="img-fluid" src="{!! frontImage('stall.png') !!}">
                    <div class="next1">
                        <a href="#"><h4>Look Book Season 03 <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </h4></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="Lookbook2 flg">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 ">
                    <img class="img-fluid" src="{!! frontImage('kids.png') !!}">
                    <div class="next1">
                        <a href="#"><h4>Look Book Season 04 <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </h4></a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <img class="img-fluid" src="{!! frontImage('bumboom.png') !!}">
                    <div class="next1">
                        <a href="#"><h4>Look Book Season 05 <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </h4></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
