@extends('template.layout')

@section('title', 'Video Order Management | Just Share Roofing Media')

@section('description', 'Managing video orders')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable1').dataTable( {
                "order": [[ 0, "desc" ]]
            });
        });
    </script>
@endsection

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-9">
                    <div class="heading-block border-0">
                        <h3>Video Orders</h3>
                        <span>All video orders</span>
                        <div><a href="{{ route('admin.video-orders.export') }}">Export</a></div>
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
                                <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date Licensed</th>
                                        <th>User</th>
                                        <th>Company</th>
                                        <th>Video</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date Licensed</th>
                                        <th>User</th>
                                        <th>Company</th>
                                        <th>Video</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach ($licenses as $license)
                                        <tr>
                                            <td>{{ $license->id }}</td>
                                            <td>{{ $license->created_at }}</td>
                                            <td>{{ $license->user->email }}</td>
                                            <td>{{ $license->user->company }}</td>
                                            <td>{{ $license->video->title }}</td>
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
