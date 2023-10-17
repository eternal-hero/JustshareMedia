@extends('template.layout')

@section('title', 'Manage Templates | Just Share Roofing Media')

@section('description', 'Managing template items')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
		$(document).ready(function() {
			$('#datatable1').dataTable();

            $('.showUsers').click(function () {
                const id = $(this).data('id');
                $('.users').css('display', 'flex')
                $('.users-content').html('Please wait')
                $.get('/admin/templates/getUserList/' + id, function(resp) {
                    $('.users-content').html('')
                    if(resp.length === 0) {
                        $('.users-content').append(`<div>All users are assigned to this template</div>`)
                    } else {
                        resp.forEach(function(user) {
                            $('.users-content').append(`<div>${user}</div>`)
                        })
                    }
                })
            })

            $('.users').click(function() {
                $('.users').css('display', 'none')
                $('.users-content').html('')
            })
		});
	</script>
@endsection

@section('content')

<style>
    .users {
        width: 100%;
        height: 100%;
        background: #0000001a;
        position: fixed;
        left: 0;
        top: 0;
        display: block;
        z-index: 999999;
        align-items: center;
    }
    .users-content {
        margin: 0 auto;
        background: black;
        padding: 10px;
        color: white;
    }
</style>

<div class="users" style="display: none">
    <div class="users-content">

    </div>
</div>

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                <div class="heading-block border-0">
                    <h3>Templates</h3>
                    <span>Templates from admin area</span>
                </div>

                <div class="clear"></div>

                @if (session('itemAdded'))
                    <div class="alert alert-success">
                        <i class="icon-exclamation-circle"></i>The new template item has been added.
                    </div>
                @endif

                <div class='row'>
                    <div class='col'>
                        <p><a class='button button-3d' href="{{route('admin.templates.add')}}">Add New</a></p>
                    </div>
                </div>

                <div class="row clearfix">

                    <div class="col">

                        <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Thumbnail</th>
                                    <th>Updated</th>
                                    <th>Users</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Thumbnail</th>
                                    <th>Updated</th>
                                    <th>Users</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data['items'] as $template)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.templates.edit', $template)}}">{{ $template->title }}</a>
                                        </td>
                                        <td>
                                            <img src='{{ Storage::url($template->path) }}' width='100px' />
                                        </td>
                                        <td>{{ $template->updated_at ? $template->updated_at : $template->created_at }}</td>
                                        <td><div style="color: #4b81e4; cursor: pointer" class="showUsers" data-id="{{$template->id}}">Show</div></td>
                                        <td class='text-center'>
                                            <a class="button button-3d button-mini button-rounded" href='/admin/templates/{{ $template->id }}'>View</a><br/>
                                            <a class="button button-3d button-mini button-rounded button-red" href='/admin/templates/{{ $template->id }}/delete'>Delete</a>
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
