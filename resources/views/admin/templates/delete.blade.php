@extends('template.layout')

@section('title', 'Deleting Item | Just Share Roofing Media')

@section('description', 'Deleting templates item')

@section('content')

<div class="content-wrap">
    <div class="container clearfix">

        <div class="row clearfix">

            <div class="col-md-9">

                <div class="heading-block border-0">
                    <h3><a href='/admin/templates'>Templates</a> > Deleting: {{ $mainTemplate->title }}</h3>
                    <span>Deleting Gallery Item</span>
                </div>

                <div class="clear"></div>

                <div class="row">
                    <div class="col">
                        <p>You are about to delete this templates item. Are you sure you want to proceed?
                    </div>
                </div>

                <div class='row'>
                    <div class='col'>
                        <h4>Title</h4>
                        <p>{{ $mainTemplate->title }}</p>
                        <h4>Template</h4>
                        <p><img src='{{ Storage::url($mainTemplate->path) }}' width='200px' /></p>
                    </div>
                </div>

                <div class="row clearfix">

                    <div class="col">

                        <h2>Confirmation</h2>

                        <form method="POST" action="/admin/templates/{{ $mainTemplate->id }}/delete">
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
