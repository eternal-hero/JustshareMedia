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

                        <form class="js-validation-signin" method="POST" action="{{ route('support-pages.update' , $supportPage )}}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Title</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                name="title"
                                                value="{{ old('title') ? old('title') : $supportPage->title }}"
                                                class="form-control @error('title') is-invalid @enderror"
                                            >
                                            @error ('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <h5>URL</h5>
                                        <div class="input-group">
                                            <input type="text"
                                                   name="url"
                                                   value="{{ old('url') ? old('url') : $supportPage->url }}"
                                                   class="form-control @error('url') is-invalid @enderror"
                                                   readonly
                                            >
                                            @error('url')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>Content</h5>
                                        <div class="input-group">
                                            <textarea
                                                name="content"
                                                class="form-control @error('content') is-invalid @enderror">
                                                {{ old('content') ? old('content') : $supportPage->content }}
                                            </textarea>
                                            @error('content')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr/>

                            <div class="form-group text-center">
                                <button type="submit" class="button button-3d">
                                    <i class="icon-check"></i> Save Support Page
                                </button>
                                &nbsp;
                                <a href='{{ route('support-pages.index') }}' class="button button-3d button-dark">
                                    <i class="icon-arrow-left"></i> Go Back
                                </a>
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
<script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
<script>
    let editor_config = {
        path_absolute : "/",
        selector: 'textarea',
        relative_urls: false,
        width: '100%',
        height: '500',
        use_lfm: true,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback : function(callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            let cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url : cmsURL,
                title : 'Filemanager',
                width : x * 0.8,
                height : y * 0.8,
                resizable : "yes",
                close_previous : "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    };

    /*tinymce.init({
        selector: 'textarea',
        plugins: 'lists preview hr anchor pagebreak image wordcount fullscreen directionality paste textpattern code link ',
        toolbar: 'undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | image | bullist numlist outdent indent | link | code',
        width: '100%',
        height: '500',
        use_lfm: true,
    });*/
    tinymce.init(editor_config);
</script>
@endsection

