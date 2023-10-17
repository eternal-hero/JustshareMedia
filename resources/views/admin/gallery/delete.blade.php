@extends('template.layout')

@section('title', 'Deleting Item | Just Share Roofing Media')

@section('description', 'Deleting gallery item')

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                <div class="heading-block border-0">
                    <h3><a href='/admin/gallery'>Gallery</a> > Deleting: {{ $item->title }}</h3>
                    <span>Deleting Gallery Item</span>
                </div>

                <div class="clear"></div>

                <div class="row">
                    <div class="col">
                        <p>You are about to delete this gallery item. Are you sure you want to proceed?
                    </div>
                </div>

                <div class='row'>
                    <div class='col'>
                        <h4>Title</h4>
                        <p>{{ $item->title }}</p>
                        <h4>URL</h4>
                        <p><a href='{{ $item->url }}'>{{ $item->url }}</a></p>
                        @if ($item->thumbnail)
                            <h4>Thumbnail</h4>
                            <p><img src='{{ $item->galleryUrl('thumbnail') }}' width='200px' /></p>
                        @endif
                    </div>
                </div>

                <div class="row clearfix">

                    <div class="col">

                        <h2>Confirmation</h2>

                        <form method="POST" action="/admin/gallery/{{ $item->id }}/delete">
                            @csrf
                            @method('DELETE')

                            <div class="col form-group">
                                <button class="button button-3d m-0 button-red" type="submit" id="submit" name="submit" value="submit">Permanently Delete Item</button>
                            </div>
                        </form>

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
