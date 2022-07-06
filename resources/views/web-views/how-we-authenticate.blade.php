@extends('layouts.front.app')
@section('title', 'How We Authenticate')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center abss">

            <h2>
                HOW WE AUTHENTICATE
            </h2>

        </div>
    </div>
</div>
<section class="Authenticate how-wex">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 ">
                <img class="img-fluid" src="{{ frontImage('mbl-app.png')}}">
            </div>
            <div class="col-sm-6">
                <h4>
                    Shopping for pre-loved luxury goods <br>
                    online can be a bit of a gamble – which is <br>
                    why authenticating each and every item <br>
                    that enters our store is our top priority. <br>
                </h4>
                <p>
                    At RCHIVE, we are passionate about providing a wide variety of high-quality, new <br>
                    and pre-loved, luxury items. Our inventory consists of the most unique collections<br>
                    – from vintage one-of-a-kind items to high-end designer brands. We have the <br>
                    passion and expertise required to meticulously examine every item, unlike large <br>
                    resale companies that may rush the authentication process simply to maximize <br>
                    sales.</p>
                <p>
                    RCHIVE’s authentication team works diligently to ensure that the quality of our <br>
                    products meets our precise criteria. Our items undergo a thorough examination <br>
                    process where our experts look specifically at the stitching, typography, hardware, <br>
                    authenticity stamp, materials, serial code, and craftsmanship, verifying they are up <br>
                    to the manufacturers’ standards. Once this process is complete, our items are <br>
                    approved for sale, and you can shop with confidence!<br>
                </p>

                <p>
                    We source our goods from reputable vintage stores, designer hot spots, <br>
                    worldwide marketplaces, raffles, and our local consignors. We go through the <br>
                    hassle, so you don’t have to, and with our great competitive rates, anyone can <br>
                    shop without breaking the bank!
                </p>
            </div>
        </div>
    </div>
</section>
<div class="container our-colle">
    <div class="row">
        <div class="col-sm-12 text-center">
            <img src="{{ frontImage('fullsize.png')}}" class="img-fluid">
            <div class="our-clmnx">
                <h4>Our Collection</h4>
                <p>To show our customers how much we stand behind our rigorous authentication process and what we
                    represent, we offer a 100% <br>
                    money-back guarantee return policy if the authenticity, condition, or style of the item is in any
                    way misrepresented in our listing.</p>
                <a href="{!! route('shop') . '?data_from=latest' !!}" class="btnx-1">Shop Collection </a>
            </div>
        </div>
    </div>
</div>

@endsection
