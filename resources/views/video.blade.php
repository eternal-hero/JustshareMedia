@extends('template.layout')

@section('title', 'About Us | Just Share Roofing Media')

@section('description', 'Discover who we are, our mission, and what we can provide to your business.')

@section('content')

<section id="page-title" class='page-title-mini'>
    <div class="container clearfix">
        <h1>Video</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Video</li>
        </ol>
    </div>
</section>
<div class="content-wrap py-0">
    <div class="section bg-transparent m-0" id='services'>
        <div class="container">
            <div class="heading-block center">
                <h2>Edit video</h2>
            </div>
            {{--@if(!\Illuminate\Support\Facades\Storage::disk('videos')->exists('exportedVideoFrame.jpg'))--}}
            <div class="row">
                <div class="col-12">
                    <img src="{{\Illuminate\Support\Facades\Storage::url('video_temp/exportedVideoFrame.jpg?').\Illuminate\Support\Str::random(10)}}"/>
                </div>
            </div>
            {{--@endif--}}
            <div class="row">
                <div class="col-12">
                    &nbsp;
                </div>
            </div>

            <div class="center">
                <form name="video-form" method="post" action="{{route('video_edit')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="video-text">Logo file</label>
                            <input type="file" id="video-text" name="logo_file">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="float-right" for="logo-text">Logo width</label>
                        </div>
                        <div class="col3">
                            <input class="w-50" type="number" id="logo-width" name="logo_width">
                        </div>
                        <div class="col3">
                            <input class="w-50 float-left" type="number" id="logo-height" name="logo_height">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="logo-height">Position</label>
                        </div>
                        <div class="col-12">
                            <input class="m-1" type="radio" name="position" value="left,top">
                            <input class="m-1" type="radio" name="position" value="center,top">
                            <input class="m-1" type="radio" name="position" value="right,top">
                        </div>
                        <div class="col-12">
                            <input class="m-1" type="radio" name="position" value="left,center">
                            <input class="m-1" type="radio" name="position" value="center,center">
                            <input class="m-1" type="radio" name="position" value="right,center">
                        </div>
                        <div class="col-12">
                            <input class="m-1" type="radio" name="position" value="left,bottom">
                            <input class="m-1" type="radio" name="position" value="center,bottom">
                            <input class="m-1" type="radio" name="position" value="right,bottom">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
