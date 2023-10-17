@extends('template.layout')

@section('title', 'Support Pages Management | ' . config('app.name'))

@section('description', 'Managing accounts')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
		$(document).ready(function() {
			$('#datatable1').dataTable( {
                "order": [[ 0, "asc" ]]
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
                    <a href='{{ route('support-pages.create') }}' class='btn btn-primary'>Add</a>
                </span>
                <div class="heading-block border-0">
                    <h3>Support Pages</h3>
                    <span>Support Pages List</span>
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
                                        <th>Title</th>
                                        <th>Url</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Url</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($supportPages as $page)
                                        <tr>
                                            <td><a href='{{route('support-pages.edit', $page)}}'>{{ $page->title }}</a></td>
                                            <td><a href='{{route('support-pages.edit', $page)}}'>{{ $page->url }}</a></td>
                                            <td><a class="button button-3d button-mini button-rounded button-red" href='{{route('support-pages.show', $page )}}'>Delete</a></td>
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
