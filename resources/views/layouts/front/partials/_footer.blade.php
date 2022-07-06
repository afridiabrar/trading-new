<div class="container newsletter-back">
    <div class="row">
        <div class="col-md-6">
            <div>
                <h2 class="fw-700 text-white">Newsletter</h2>
                <p class="text-white">Subscribe to our Newsletter to get <br>
                    our Latest Updates.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <form class="newsletter" method="post" action="{{ route('newsletter') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" required name="email" class="form-control" id="inputEmail" placeholder="Your Email Here*">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<footer class="footer pb-5 cover-banner" style="background-image: url('{{ frontImage('footer-back.jpg') }}');">
    <div class="container">
        <div class="row pb-3">
            <div class="col-md-3 logo-m widgets2">
                <img src="{{ frontImage('logo-home-1.png') }}" class="img-fluid pb-3" alt="">
                <p class="text-white">
                    Many businesses, large and small, have a
                    huge source of great ideas that can help
                    them improve, innovate, and grow, and yet
                    so many of these companies.
                </p>
                <p class="text-white"><i class="fa fa-map-marker"></i> London, UK 441</p>
                <p class="text-white"><i class="fa fa-phone"></i> Phone: +7 526 255 25 26</p>
                <p class="text-white"><i class="fa fa-envelope"></i> Email: info@example.com</p>

                <ul class="social-media-list">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa fa-twitter"></i></a></a></li>
                    <li><a href="#"><i class="fa fa fa-pinterest-p"></i></a></li>
                    <li><a href="#"><i class="fa fa fa-behance"></i></a></li>
                </ul>

            </div>
            <div class="col-md-3 widgets2">
                <h4 class="pb-3 text-white border-bottom">recent news</h4>

                <p class="pt-4">
                    <a href="#" class="text-white"> <b> Narrow Your Focus to Prevent Overanalysis </b><br>
                        <i class="fa fa-clock-o yellow"></i> <span class="font-12 text-gry">March 18, 2015</span>
                    </a>
                </p>
                <p class="pt-2">
                    <a href="#" class="text-white"> <b> Narrow Your Focus to Prevent Overanalysis </b> <br>
                        <i class="fa fa-clock-o yellow"></i> <span class="font-12 text-gry">March 18, 2015</span>
                    </a>
                </p>
                <p class="pt-2">
                    <a href="#" class="text-white"> <b> Narrow Your Focus to Prevent Overanalysis </b><br>
                        <i class="fa fa-clock-o yellow"></i> <span class="font-12 text-gry">March 18, 2015</span>
                    </a>
                </p>

            </div>
            <div class="col-md-3 widgets2">
                <h4 class="pb-3 text-white border-bottom">extra links</h4>
                <div class="d-flex">
                    <ul class="mt-4">
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                    </ul>
                    <ul class="mt-4 pl-5">
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3 widgets2">
                <h4 class="pb-3 text-white border-bottom">extra links</h4>
                <div class="d-flex">
                    <ul class="mt-4">
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                    </ul>
                    <ul class="mt-4 pl-5">
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>
                        <li> <a href="#"> Lorem Ipsum </a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row border-top justify-content-center">
            <div class="col-md-8 pt-5">
                <img src="{{ frontImage('items-101.png') }}" width="150" class="pl-2 img-fluid" alt="">
                <img src="{{ frontImage('items-102.png') }}" width="150" class="pl-2 img-fluid" alt="">
                <img src="{{ frontImage('items-103.png') }}" width="150" class="pl-2 img-fluid" alt="">
                <img src="{{ frontImage('items-104.png') }}" width="150" class="pl-2 img-fluid" alt="">
            </div>
            <div class="col-md-4 pt-5">
                <p class="text-white ">On Sale 70% DisCount <br>Best Products of the Month</p>

            </div>
        </div>
    </div>

</footer>

<div class="container-fluid footer-copyright ">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-12">
                <p class="copyright">© 2020 Trading Centre LTD. All Right Reserved
                <p>
            </div>
        </div>
    </div>
</div>
