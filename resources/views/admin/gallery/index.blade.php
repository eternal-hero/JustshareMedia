@extends('template.layout')

@section('title', 'Manage Gallery | Just Share Roofing Media')

@section('description', 'Managing gallery items')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
		$(document).ready(function() {
			$('#datatable1').dataTable();
		});
	</script>
@endsection

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                <div class="heading-block border-0">
                    <h3>Gallery</h3>
                    <span>Public Gallery Items</span>
                </div>

                <div class="clear"></div>

                @if (session('itemAdded'))
                    <div class="alert alert-success">
                        <i class="icon-exclamation-circle"></i>The new gallery item has been added.
                    </div>
                @endif

                <div class='row'>
                    <div class='col'>
                        <p><a class='button button-3d' href="{{route('admin.gallery.add')}}">Add New</a></p>
                    </div>
                </div>

                <div class="row clearfix">

                    <div class="col">

                        <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Shingle Type</th>
                                    <th>Thumbnail</th>
                                    <th>Public</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Shingle Type</th>
                                    <th>Thumbnail</th>
                                    <th>Public</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data['items'] as $gallery_item)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.gallery.edit', $gallery_item)}}">{{ $gallery_item->title }}</a>
                                        </td>

                                        <td>
                                            <a href="{{route('admin.gallery.edit', $gallery_item)}}">{{ $gallery_item->shingle_type }}</a>
                                        </td>
                                        <td>
                                            <img src='{{ $gallery_item->galleryUrl('thumbnail') }}' width='100px' />
                                        </td>
                                        <td>
                                            <a href="{{route('admin.gallery.edit', $gallery_item)}}">{{ $gallery_item->drawPublicColumn() }}</a>
                                        </td>
                                        <td>{{ $gallery_item->updated_at ? $gallery_item->updated_at : $gallery_item->created_at }}</td>
                                        <td class='text-center'>
                                            <a class="button button-3d button-mini button-rounded" href='/admin/gallery/{{ $gallery_item->id }}'>View</a><br/>
                                            <a class="button button-3d button-mini button-rounded button-red" href='/admin/gallery/{{ $gallery_item->id }}/delete'>Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
