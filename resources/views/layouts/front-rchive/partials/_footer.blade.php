<section class="footer-1">
    <div class="container">
        <div class="row ">
            @php
                \App\CPU\Helpers::currency_load();
                   $currency_code = session('currency_code');
                   $currency_symbol= session('currency_symbol');
                   if ($currency_symbol=="")
                   {
                       $system_default_currency_info = \session('system_default_currency_info');
                       $currency_symbol = $system_default_currency_info->symbol;
                       $currency_code = $system_default_currency_info->code;
                   }
            @endphp
            <div class="col-xl-2 col-md-12 col-sm-12 fl">
                <img class="img-fluid ftx-logo" alt="{!! $web_config['name']->value !!}"
                     src="{!! asset("storage/app/public/company/") .'/'. $web_config['footer_logo']->value !!}"
                     onerror="this.src='{!! asset('assets/front-end/img/image-place-holder.png') !!}'">
                <h5>Currency Exchange</h5>
                <select name="cars" id="cars" onchange="currency_change($(this).val())">
                    @foreach (\App\Model\Currency::where('status', 1)->get() as $key => $currency)
                        <option value="{!! $currency->code !!}" {!! ($currency_code == $currency->code) ? "selected='selected'" : '' !!}>{!! $currency->name !!} {!! $currency->symbol !!}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-2 col-md-12 col-sm-12 ">
                <h4>Quick links</h4>
                <ul class="ftr">
                    <li><a href="{!! route('shipping-and-exchange') !!}">Return & Exchange</a></li>
                    <li><a href="{!! route('how-we-authenticate') !!}">Authentication</a></li>
                    <li><a href="{!! route('shipping-and-exchange') !!}"> Shipping Information</a></li>
                    <li><a href="{!! route('look-books') !!}">Look Books</a></li>
                    {{--                    <li><a href="#!">Contests & Promotions</a></li>--}}
{{--                    <li><a href="#!"> Special Gifts</a></li>--}}
                    <li><a href="{!! route('contact-us') !!}">Contact us</a></li>
                </ul>
            </div>
            <div class="col-xl-2 col-md-12 col-sm-12 ">
                <h4>Company</h4>
                <ul class="ftr">
                    <li><a href="{!! url('about-us') !!}">About us</a></li>
{{--                    <li><a href="#!"> Our Story</a></li>--}}
                    <li><a href="{!! route('terms-and-conditions') !!}"> Terms & Conditions</a></li>
                    <li><a href="{!! route('shipping-and-exchange') !!}"> Return Policy</a></li>
{{--                    <li><a href="#!"> Affiliate program</a></li>--}}
                    <li><a href="{!! route('privacy-policy') !!}"> Privacy Policy</a></li>
                    <li><a href="{!! route('pull') !!}"> Pull</a></li>
                    <li><a href="{!! route('faq') !!}"> FAQ</a></li>
                </ul>
            </div>
            @if(count($socialMedia) > 0)
                <div class="col-xl-2 col-md-12 col-sm-12  ftr-icn">
                    <h4>Stay Connected</h4>
                    @php
                        $socialMediaArray = array_chunk($socialMedia->toArray(), 2);
                    @endphp
                    @foreach($socialMediaArray as $key => $socialLinks)
                        <ul {!! ($key > 1) ? 'class="icn-2"' : '' !!}>
                            @foreach($socialLinks as $socialKey => $socialAccount)
                                    <li><a href="{!! $socialAccount['link'] !!}"><i class="{!! $socialAccount['icon'] !!}" aria-hidden="true"></i></a></li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            @endif
            <div class="col-xl-4 col-md-12 col-sm-12  ">
                <h4>Join Us to get our Monthly Newsletter</h4>
                <form method="GET" action="https://kikk.us6.list-manage.com/subscribe" class="newsletter-form"
                      target="_blank">
                    <input type="hidden" name="u" value="d08fe605a9149dc54a3c13f44">
                    <input type="hidden" name="id" value="96f67efdeb">
                    <input type="email" name="EMAIL" id="email" placeholder="Your Email Address here">
                    <button type="submit" class="button">Subscribe</button>
                </form>
                <img class="img-fluid payment-img" src="{!! frontImage('payment.png') !!}">
            </div>
        </div>
    </div>
    </div>
</section>
<div class="footerx">
    <div class="container">
        <div class="row footerx1">
            <div class="col-sm-12 text-center">
                <h4>© RCHIVE {{date('Y')}} <br/> Toronto </h4>
            </div>
        </div>
    </div>
</div>
<div class="modal bottom-fm fade all-login" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="logine">
            <h3>Login</h3>
            <div class="modal-header">
                <p>Log in to your Grailed account to buy, sell, comment,<br> and more.</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="Button _large _secondary AuthModal-Button _facebook _login social-btn" type="button"><i
                        class="fa fa-facebook-official" aria-hidden="true"></i> Continue with Facebook
                </button>
                <button class="Button _large _secondary AuthModal-Button _facebook _login social-btn-1" type="button"><i
                        class="fa fa-google" aria-hidden="true"></i> Continue with Google
                </button>
                <button class="Button _large _secondary AuthModal-Button _facebook _login social-btn-2" type="button"><i
                        class="fa fa-apple" aria-hidden="true"></i> Continue with Apple
                </button>
            </div>
            <div class="modal-footer">
                <button class="Button _large _secondary AuthModal-Button _facebook _login social-btn-3" type="button"
                        onclick="window.location.href='{!! route('customer.auth.login') !!}'"><i
                        class="fa fa-envelope" aria-hidden="true"></i> Log in with Email
                </button>
                <p class="-message">Don't have an account? <a href="{!! route('customer.auth.register') !!}">Sign Up</a>
                </p>
            </div>
        </div>
    </div>
</div>
