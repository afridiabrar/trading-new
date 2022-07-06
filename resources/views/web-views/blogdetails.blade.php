@extends('layouts.front.app')
@section('title', 'Blog Details')
@section('content')

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-9">
                    <div class="pb-4 text-center">
                        <img src="{!! asset('storage/app/public/blog/'.$blog->image) !!}"
                             height="500" class="img-fluid" alt="">
                    </div>
                    <span> {!! 'Created On: ' . date('d-m-Y', strtotime($blog->created_at)) !!} </span>
                    <h4 class="py-2">{!! $blog->title !!}</h4>

                    <p class="py-2">
                        {!! $blog->content !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end container-->
@endsection
