@extends('template.layout')

@section('title', 'Licensed Videos | ' . config('app.name'))

@section('description', 'View the list of licensed videos')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatable1').dataTable({
                "order": [[1, "desc"]]
            });
        });
    </script>
@endsection

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-9">
                <span style='float:right'>

                </span>
                    <div class="heading-block border-0">
                        <h3>Licensed Videos</h3>
                        <span>Licensed Videos List</span>
                    </div>
                    <div class="clear"></div>
                    <div class="row clearfix">
                        <div class="col">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <i class="icon-exclamation-triangle"></i> {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    <i class="icon-check-circle"></i> {{ session('success') }}
                                </div>
                            @endif
                            <div>
                                <table id="datatable1" class="table table-striped table-bordered" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Video Title</th>
                                        <th>Date</th>
                                        <th>Location Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Video Title</th>
                                        <th>Date</th>
                                        <th>Location Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach ($licensedVideos as $video)
                                        <tr>
                                            <td>
                                                <a href="{{route('view.licensed.videos', $video->video_id)}}">{{ $video->video_title }}</a>
                                            </td>
                                            <td>{{ $video->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <span>{{$video->location_name}}</span>
{{--                                                @foreach(explode(',', $video->location_name) as $location)--}}
{{--                                                    <br>--}}
{{--                                                @endforeach--}}
                                            </td>
                                            <td>
                                                <a class="button button-3d button-mini button-rounded button-blue"
                                                   href="{{route('view.licensed.videos', $video->video_id)}}">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 line d-block d-md-none"></div>
                <div class="col-md-3">
                    <x-dashboard-menu/>
                </div>
            </div>
        </div>
    </div>
@endsection
