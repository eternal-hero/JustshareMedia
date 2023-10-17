@extends('template.layout')

@section('title', 'Attach Video To Location | ' . config('app.name'))

@section('description', 'Discover who we are, our mission, and what we can provide to your business.')

@section('content')
    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Video</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Video customize</li>
            </ol>
        </div>
    </section>
    <div class="content-wrap py-0">
        <div class="section bg-transparent m-0" id='services'>
            <div class="container">
                <div class="heading-block center">
                    <h2>Select Location</h2>
                </div>
                @if (! $errors->isEmpty())
                    <div class="alert alert-danger">
                        <i class="icon-exclamation-circle"></i><strong>Sorry!</strong> An error occurred with your
                        request.
                        <br/>
                        @foreach ($errors->all() as $error)
                            <br/> {{ $error }}
                        @endforeach
                    </div>
                @endif

                @if(file_exists('storage/video_temp/user_' . $user->id . '/video_' . $video->id . '/big.jpg') && file_exists('storage/video_temp/user_' . $user->id . '/video_' . $video->id . '/small.jpg'))
                    <div id="video-preview" style="text-align: center;">
                        @include('components.video-preview')
                    </div>
                @endif

                <form name="attach_location" action="{{route('save.attached.video', $video->id)}}" method="POST">
                    @csrf
                    <div class="col-12">
                        <span>Select your location</span>
                        @foreach($locations as $location)
                            <div class="row">
                                <div class="col">
                                    <label for="location-{{$location->id}}"><input type="radio"
                                                                                   id="location-{{$location->id}}"
                                                                                   name="attach_video"
                                                                                   value="{{$user->id}},{{$video->id}},{{$location->id}}"/> {{$location->location_name}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input class="btn btn-primary" type="submit" value="Attach">
                </form>
            </div>
        </div>
    </div>
@endsection
