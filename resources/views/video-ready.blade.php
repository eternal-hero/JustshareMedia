@extends('template.layout')

@section('title', 'Video customization | ' . config('app.name'))

@section('description', 'Discover who we are, our mission, and what we can provide to your business.')

@section('content')
    <section id="page-title" class='page-title-mini make-padding-smaller'>

    </section>
    <div class="section bg-transparent m-0" id='services'>
        <div class="container video-ready-wrapper-helper">
            <div class="heading-block center">
                <img class="location-label-image" src="{{ asset('images/location-label-green.svg') }}" alt="">
                <h2>You are all set!</h2>
            </div>
            <div class="row d-flex flex-column align-items-center">
                <p class="video-ready-re-download-text">Your downloads are complete, click below if you do not see them in your downloads folder.</p>
                <a href="{{route('licensed.videos')}}"><button class="btn btn-primary video-ready-re-download-button">Go to downloads</button></a>
            </div>

            {{-- Info block --}}
            <div class="row d-flex flex-column align-items-center video-ready-info-block">
                <h4 class="video-ready-info-block-title">In each download you will receive 2 files:</h4>
                <div class="col d-flex flex-row justify-content-center">
                        <div class="col text-center d-flex flex-column align-items-center video-ready-info-block-mini-block margin-right">
                            <h5 class="video-ready-info-block-mini-block-title">File 1</h5>
                            <p class="video-ready-info-block-mini-block-text">
                                This is a 1080px by 1080px video file as you designed and is the preferred file size for social media.
                            </p>
                        </div>
                        <div class="col text-center d-flex flex-column align-items-center video-ready-info-block-mini-block">
                            <h5 class="video-ready-info-block-mini-block-title">File 2</h5>
                            <p class="video-ready-info-block-mini-block-text">
                                This is a 16:9 resolution video with your logo attached and is also used on a variety ads.
                            </p>
                        </div>
                </div>
{{--                <p class="video-ready-faq">--}}
{{--                    <a href="#" class="video-ready-faq-link">Click here</a>--}}
{{--                    to learn more about file sizes and what is best to use.--}}
{{--                </p>--}}
            </div>
        </div>
    </div>
    <style>
        .video-ready-wrapper-helper .video-ready-info-block {
            padding-bottom: 56px
        }
    </style>
@endsection

