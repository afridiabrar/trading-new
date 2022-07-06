@extends('layouts.front.app')
@section('title', 'FAQ')
@section('content')
    <div class="container text-center glasses-men">
        <h2>FAQ</h2>
        <div class="row">
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="comment">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="Ask a Question" aria-label="Ask a Question"
                               aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">Comment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container faqbx">
        <div class="row faqboxes">
            <div class="col-sm-4">
                <div class=" faq-boxes">
                    <h3>Frequently Asked Questions</h3>
                    <p>Your most popular questions, answered!</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class=" faq-boxes">
                    <h3>Getting Started</h3>
                    <p>Get to know Rchive.ca</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class=" faq-boxes">
                    <h3>Safety & Trust</h3>
                    <p>Money Back Guarantee for Buyers & Sellers.</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class=" faq-boxes">
                    <h3>Buying</h3>
                    <p>Buying is safe thanks to our team of world-class
                        curators and community self-policing.</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class=" faq-boxes">
                    <h3>Selling</h3>
                    <p>Ready to sell your Rchive?
                        We've made it easy with these tips.</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class=" faq-boxes">
                    <h3>Troubleshooting</h3>
                    <p>Experiencing an issue?
                        We've laid out our expert help here.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container glasses-men general">
        <h2>General help topics</h2>
        <div class="row">
            @foreach($help_topics as $key => $help_topic)
                <div class="col-sm-12 topics">
                    <h5> {!! $help_topic->question !!} </h5>
                    <p>{!! $help_topic->answer !!} </p>
                    <hr>
                </div>
            @endforeach
        </div>
    </div>
    </div>
    </div>
    </section>
    <!-- end container-->
@endsection
