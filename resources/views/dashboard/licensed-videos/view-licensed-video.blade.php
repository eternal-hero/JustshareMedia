@extends('template.layout')

@section('title', 'Licensed Video | ' . config('app.name'))

@section('description', '')

@section('content')
    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Video</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$video->title}}</li>
            </ol>
        </div>
    </section>
    <div class="content-wrap py-0">
        <div class="section bg-transparent m-0" id='services'>
            <div class="container">
                <div class="heading-block center">
                    <h2>{{$video->title}}</h2>
                </div>
                        @include('components.video-preview-buttons')
                        <div class="row mt-5 mb-5">
                            <div class="col-3">
                                <p>Licensed locations for this video:</p>
                            </div>
                            <div class="col-9 text-right">
                                @if($user->getNotAttachedOperationalLocations($video->id))
                                <a href="{{ route('attach.locations', $video->id)}}"
                                   class="btn btn-file">
                                    <button class="btn btn-primary">Add More Locations</button></a>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th>Location name</th>
                                        <th>Download licensed video</th>
                                        <th>Download license file</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($licensedVideos as $location)
                                        <tr>
                                            <td>{{$location->location->address}}</td>
                                            <td>
                                                @if(file_exists(\Storage::path('public/rendered_video/user_' . $user->id . '/video_' . $video->id . '/bigFinalVideo.mp4')))
                                                    <a href="{{ route('download.licensed.videos',['video_id' => $video->id ,'location_id'=> $location->location_id, 'size' => 'big']) }}"
                                                       class="btn btn-file">
                                                        <button class="btn btn-primary">Download 16x9</button>
                                                    </a>
                                                @endif
                                                @if(file_exists(\Storage::path('public/rendered_video/user_' . $user->id . '/video_' . $video->id . '/smallFinalVideo.mp4')))
                                                    <a href="{{ route('download.licensed.videos',['video_id' => $video->id , 'location_id'=> $location->location_id,'size' => 'small']) }}"
                                                       class="btn btn-file">
                                                        <button class="btn btn-primary">Download 1x1</button>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('download.license.file',['video_id' => $video->id , 'location_id'=> $location->location_id ]) }}"
                                                   class="btn btn-file">
                                                    <button class="btn btn-primary">Download License PDF</button>
                                                </a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
