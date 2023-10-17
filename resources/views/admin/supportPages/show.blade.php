@extends('template.layout')

@section('title', 'Support Page #' . $supportPage->id . ' | ' . config('app.name'))

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

                    <div class="heading-block border-0">
                        <h3><a href='{{ route('support-pages.index') }}'>Support Pages</a> > {{ $supportPage->title }}</h3>
                        <span>Tax Rate</span>
                    </div>

                    <div class="clear"></div>
                    <div class="row clearfix">
                        <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <h5>Title</h5>
                                            <div class="input-group">
                                                <p>{{ $supportPage->title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <h5>URL</h5>
                                            <div class="input-group">
                                                <p> {{ $supportPage->url }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <h5>Content</h5>
                                            <div class="container clearfix">
                                                {!! $supportPage->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="row clearfix">
                                <div class="col">
                                    <h2>Confirmation</h2>

                                    <form method="POST" action="{{ route('support-pages.destroy' , $supportPage )}}">
                                        @csrf
                                        @method('DELETE')

                                        <div class="col form-group">
                                            <button class="button button-3d m-0 button-red" type="submit" id="submit" name="submit" value="submit">Permanently Delete Item</button>

                                            <a href='{{ route('support-pages.index') }}' class="button button-3d button-dark">
                                                <i class="icon-arrow-left"></i> Go Back
                                            </a>
                                        </div>
                                    </form>
                                </div>
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
