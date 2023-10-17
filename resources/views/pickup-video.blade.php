@extends('template.layout')

@section('title', 'Gallery | ' . config('app.name'))

@section('description', 'Browse through some of our creations and experience what we can provide for you.')

@section('js_additional')
    <script>
        $(document).ready(function () {
            // Handler for .ready() called.
            $('html, body').animate({
                scrollTop: $('#galleryitems').offset().top
            }, 'slow');
        });
    </script>
@endsection

@section('content')

    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Gallery</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gallery</li>
            </ol>
        </div>
    </section>
    <div id='galleryitems' class="section m-0 bg-transparent">
        <div class="container clearfix">
            <div class="heading-block center">
                <h2>Pickup the video</h2>
            </div>
        <!-- Portfolio Items -->
            <div class="row">
                <div class="col-9">
                    <div id="portfolio" class="portfolio row" data-layout="fitRows">
                            <article class="portfolio-item col-md-4 col-sm-6 col-12 pf-video">
                                    <div class="portfolio-image">
                                        <a href="{{ $video->galleryUrl('thumbnail') }}">
                                            <img src="{{ $video->galleryUrl('thumbnail') }}" alt="{{ $video->title }}">
                                        </a>
                                        <div class="bg-overlay">

                                            <div class="bg-overlay-content dark" data-hover-animate="fadeIn">
                                                <a href="{{ $video->galleryUrl('title_video') }}"
                                                   class="overlay-trigger-icon bg-light text-dark"
                                                   data-hover-animate="fadeInDownSmall"
                                                   data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350"
                                                   data-lightbox="iframe"><i class="icon-line-play"></i></a>
                                            </div>
                                            <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"></div>
                                        </div>
                                    </div>
                                    <div class="portfolio-desc">
                                        <h3><a href="{{ $video->galleryUrl('title_video') }}">{{ $video->title }}</a></h3>
                                    </div>
                            </article>
                        <article class="portfolio-item col-md-4 col-sm-6 col-12 pf-video">
                            <button class="button button-3d b-0" type="submit" id="submit" name="submit"
                                    value="submit">PickUp Video
                            </button>
                        </article>
                    </div>
                </div>

                <div class="col-3">
                    <span>Select your location</span>
                    @foreach($locations as $location)
                        <div class="row">
                            <div class="col">
                                <label for="location-{{$location->id}}"><input type="radio"
                                                                               id="location-{{$location->id}}"
                                                                               name="location"
                                                                               value="{{$location->id}}"/> {{$location->name}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <x-section-call-to-action/>

@endsection
