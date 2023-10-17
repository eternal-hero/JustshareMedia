@extends('template.layout')

@section('title', 'Video customization | ' . config('app.name'))

@section('description', 'Discover who we are, our mission, and what we can provide to your business.')

@section('content')
    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Video</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Video customize</li>
            </ol>
        </div>
    </section>
{{--    < class="content-wrap py-0">--}}
        <div class="section bg-transparent m-0" id='services'>
            <div class="container">
                <div class="heading-block center">
                    <h2>Edit your video</h2>
                </div>

                <div class="row d-flex justify-content-center align-items-center mb-5 container-wrapper-help-part">
                    <div class="col-7 d-flex justify-content-end">
                        <span data-toggle="modal"
                              data-target="#how-to-get-started-modal" class="mr-4 container-wrapper-help-part helper-starting-link">How to get started</span>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button
                            class="btn btn-primary d-flex justify-content-between container-wrapper-help-part need-help-button">
                            <i class="far fa-play-circle"></i>
                            <a href="https://www.youtube.com/watch?v=c7yDCc5pqLU" target="_blank"><span class="container-wrapper-help-part need-help-button-text">Need Help</span></a>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col mx-auto content-wrapper-helper product-edit">
                        <div id="tabs" class="row d-flex flex-row">
                            <div class="col-3">
                                <ul class="list-group">
                                    <li class="list-group-item m-auto bg-transparent border-0">
                                        <a href="#tabs-1">
                                            <div class="content-wrapper-helper product-edit-action">
                                                <div class="row d-flex flex-column">
                                                    <span
                                                        class="content-wrapper-helper template-image action-image"></span>
                                                    <span
                                                        class="d-flex justify-content-center content-wrapper-helper product-edit-action-title">Templates</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item m-auto bg-transparent border-0">
                                        <a href="#tabs-2">
                                            <div class="content-wrapper-helper product-edit-action">
                                                <div class="row d-flex flex-column">
                                                    <span
                                                        class="content-wrapper-helper upload-image action-image"></span>
                                                    <span
                                                        class="d-flex justify-content-center content-wrapper-helper product-edit-action-title">Uploads</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div id="tabs-1" class="col-9">
                                <div class="row d-flex flex-row flex-nowrap">
                                    <div class="col-4 content-wrapper-helper product-edit-second-column">
                                        <h2 class="my-4 text-uppercase content-wrapper-helper product-edit-second-column-title">
                                            Choose a
                                            template</h2>
                                        <hr class="content-wrapper-helper product-edit-second-column-line">
                                        <div class="row d-flex flex-row">
                                            <div class="col">
                                                <div class="owl-carousel owl-carousel-custom-styles">
                                                    @foreach($templates as $template)
                                                    <div
                                                        class="item m-0 content-wrapper-helper product-edit-second-column-template-option transform" data-template-id="{{$template->id}}" data-image="{{$template->title}}">
                                                        <div class="row h-100">
                                                            <div
                                                                class="col d-flex flex-column justify-content-around align-items-center">
                                                                <img
                                                                    src="{{\Illuminate\Support\Facades\Storage::url($template->path)}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @include('video-editor.preview.blade.php')


{{--                                    <div--}}
{{--                                        class="col-8 content-wrapper-helper content-wrapper-helper templates-third-column">--}}
{{--                                        <div class="content-wrapper-helper templates-third-column-image"--}}
{{--                                             style="background-image: url({{\Illuminate\Support\Facades\Storage::url($video->title_image . '?').\Illuminate\Support\Str::random(10)}})">--}}
{{--                                            <div--}}
{{--                                                class="d-flex justify-content-center align-items-center content-wrapper-helper upload-logo-third-column-title-logo">--}}

{{--                                                     @if($logo)--}}
{{--                                                    <img class="logo-preview" src="{{asset(\Illuminate\Support\Facades\Storage::url($logo)) . '?' . \Illuminate\Support\Str::random(10)}}"/>--}}
{{--                                                     @else--}}
{{--                                                    <img class="logo-preview" src="{{asset('/images/dummy_logo.png')}}"/>--}}
{{--                                                     @endif--}}
{{--                                            </div>--}}
{{--                                                @if($selectedTemplate)--}}
{{--                                                <img src="{{asset(\Illuminate\Support\Facades\Storage::url($selectedTemplate->path)) . '?' . \Illuminate\Support\Str::random(10)}}" class="chosen-template"/>--}}
{{--                                                @else--}}
{{--                                                <img src="{{asset('/images/dummy.png')}}" class="chosen-template"/>--}}
{{--                                                @endif--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                            <div id="tabs-2" class="col-9">
                                <div class="row d-flex flex-row flex-nowrap">
                                    <div class="col-4 content-wrapper-helper product-edit-second-column">
                                        <h2 class="my-4 text-uppercase content-wrapper-helper product-edit-second-column-title">
                                            Upload
                                            your logo</h2>
                                        <hr class="content-wrapper-helper product-edit-second-column-line ">
                                        <div class="upload-section">
                                            @if($logo)
                                                <img class="logo-preview" src="{{asset(\Illuminate\Support\Facades\Storage::url($logo)) . '?' . \Illuminate\Support\Str::random(10)}}"/>
                                            @else
                                                <img class="logo-preview" src="{{asset('/images/dummy.png')}}"/>
                                            @endif
                                        </div>
                                        <div
                                            class="row d-flex text-center flex-column align-items-center content-wrapper-helper upload-logo-second-column-button-part">
                                            <div class="file-loader-wrapper">
                                                <form id="process-logo" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" accept=".png" name="logo_file" id="logo-file"
                                                           class="d-flex btn btn-primary content-wrapper-helper upload-logo-second-column-button-part-button"/>
                                                </form>
                                                <label for="logo-file" class="upload-button-text">Upload Logo</label>
                                            </div>
                                            <span
                                                class="content-wrapper-helper upload-logo-second-column-button-part-text">
                                Make sure to upload a .png or transparent version of your logo.
                            </span>
                                        </div>
                                        <span class="content-wrapper-helper upload-logo-second-column-bottom-text">
                            <a href="#"
                               class="content-wrapper-helper upload-logo-second-column-bottom-link">Learn more</a> why .png is the preferred logo type
                        </span>
                                    </div>
{{--                                    <div--}}
{{--                                        class="col-8 content-wrapper-helper content-wrapper-helper templates-third-column">--}}
{{--                                        <div class="content-wrapper-helper templates-third-column-image"--}}
{{--                                             style="background-image: url({{\Illuminate\Support\Facades\Storage::url($video->title_image . '?').\Illuminate\Support\Str::random(10)}})">--}}
{{--                                            <div--}}
{{--                                                class="d-flex justify-content-center align-items-center content-wrapper-helper upload-logo-third-column-title-logo">--}}
{{--                                                @if($logo)--}}
{{--                                                    <img class="logo-preview" src="{{asset(\Illuminate\Support\Facades\Storage::url($logo)) . '?' . \Illuminate\Support\Str::random(10)}}"/>--}}
{{--                                                @else--}}
{{--                                                    <img class="logo-preview" src="{{asset('/images/dummy_logo.png')}}"/>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                            @if($selectedTemplate)--}}
{{--                                                <img src="{{asset(\Illuminate\Support\Facades\Storage::url($selectedTemplate->path)) . '?' . \Illuminate\Support\Str::random(10)}}" class="chosen-template"/>--}}
{{--                                            @else--}}
{{--                                                <img src="{{asset('/images/dummy.png')}}" class="chosen-template"/>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="final-video-settings">
                    @csrf
                    <input type="hidden" name="logo" value="{{$logo}}"/>
                    <input type="hidden" name="template" value="{{$template->id}}"/>
                    <input type="hidden" name="video_id" value="{{$video->id}}"/>
                    <textarea style="display: none" id="editorData" name="editorData"></textarea>
                    <textarea style="display: none" id="editorImage" name="editorImage"></textarea>
                </form>
                <div class="row">
                    <div class="col-12 center">
                        <button class="export-video disabled"><span>Export video</span></button>
                    </div>
                </div>
            </div>
            <div id="loader">
                <div class="spinner-border" style="" role="status"><span class="sr-only">Loading...</span></div>
            </div>

            <div id="how-to-get-started-modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-wrapper-helper modal-position">
                    <div class="modal-content">
                        <div
                            class="modal-header text-center border-bottom-0 pb-0 modal-wrapper-helper modal-header-container">
                            <h2 class="modal-title mx-auto text-uppercase modal-wrapper-helper modal-title">How to get
                                started</h2>
                            <button type="button" class="close ml-0 modal-wrapper-helper close-button"
                                    data-dismiss="modal">
                            </button>
                        </div>
                        <hr class="mx-auto my-0 modal-wrapper-helper line-under-title">
                        <div class="modal-body">
                            <div class="row d-flex justify-content-center px-6 modal-wrapper-helper main-info-section">
                                <div class="col d-flex flex-column align-items-center">
                                    <img class="modal-wrapper-helper modal-window-point-image"
                                         src="{{ asset('images/uploads/black.svg') }}" alt="">
                                    <div class="row d-flex flex-column text-center">
                                        <span
                                            class="modal-wrapper-helper modal-window-point-title">1. Upload logo</span>
                                        <p class="modal-wrapper-helper modal-window-point-description">Upload your
                                            logo</p>
                                    </div>
                                </div>
                                <div class="col d-flex flex-column align-items-center">
                                    <img class="modal-wrapper-helper modal-window-point-image"
                                         src="{{ asset('images/templates/black.svg') }}" alt="">
                                    <div class="row d-flex flex-column text-center">
                                        <span
                                            class="modal-wrapper-helper modal-window-point-title">2. Choose template</span>
                                        <p class="modal-wrapper-helper modal-window-point-description">Choose from one
                                            of our predesigned templates.</p>
                                    </div>
                                </div>
                                <div class="col d-flex flex-column align-items-center">
                                    <img class="modal-wrapper-helper modal-window-point-image"
                                         src="{{ asset('images/customize/black.svg') }}" alt="">
                                    <div class="row d-flex flex-column text-center">
                                        <span class="modal-wrapper-helper modal-window-point-title">3. Customize</span>
                                        <p class="modal-wrapper-helper modal-window-point-description">Choose your
                                            colors and customize your font to match your company’s brand.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
                @endsection
                @section('js_additional')
                    <script src="{{ asset('assets/js/jquery-ui.min.js') }}" type="text/javascript"></script>
                    <script src="{{ asset('assets/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            checkToProceed();
                            $(".owl-carousel").owlCarousel({
                                items: 2,
                                dots: false,
                                loop: false,
                                mouseDrag: false,
                                touchDrag: false,
                                pullDrag: false,
                                rewind: true,
                                autoplay: false,
                                margin: 20,
                                nav: true,
                                navContainerClass: 'owl-custom-navigation',
                                navClass: ['btn btn-primary-outline','btn btn-primary-outline'],
                                navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>']
                            });

                            $(document).on('click', '.product-edit-second-column-template-option', function () {
                                $('.chosen-template').attr('src', '/storage/video_templates/' + $(this).data('image') + '.png?' + new Date().getTime());
                                $('input[name="template"]').val($(this).data('template-id'));
                                checkToProceed();
                            });

                            $("#tabs").tabs();

                            $(document).on('click', '.export-video', function (){
                                // return;

                                appImg(function(image) {
                                    appData(function(appData) {

                                        $.ajaxSetup({
                                            headers: {
                                                "X-CSRF-TOKEN": '{{ csrf_token() }}'
                                            }
                                        });

                                        console.log(appData)

                                        $('#editorImage').val(image)
                                        let formData = new FormData(document.getElementById('final-video-settings'));
                                        $.ajax({
                                            url: '{{route('submit.template')}}',
                                            data: JSON.stringify(
                                                {
                                                    appData: appData,
                                                    preview: image,
                                                    video: '{{$video->id}}',
                                                    logo: $('.logo-preview').attr('src')
                                                }
                                            ),
                                            contentType: "application/json",
                                            type: 'POST',
                                            success: function (response){
                                                console.log(response);
                                                {{--window.location.href ='{{route('attach.locations')}}';--}}
                                            },
                                            error: function (error) {
                                                console.log(error);
                                            },
                                            cache: false,
                                            contentType: false,
                                            processData: false
                                        });
                                    })



                                    })
                            });

                            $('#big-text-color, #small-text-color').colorpicker(
                                {
                                    extensions: [
                                        {
                                            name: 'swatches', // extension name to load
                                            options: { // extension options
                                                colors: {!! $user->getBrandColorsForJs() !!},
                                                namesAsValues: true
                                            }
                                        }
                                    ]
                                });

                            $(document).on('click', 'input[type="submit"]', function () {
                                $('#loader').show();
                            });

                            {{--$('#logo-file').change(function () {--}}
                            {{--    if ($(this).val() !== '') {--}}
                            {{--        let logoFormData = new FormData(document.getElementById('process-logo'));--}}
                            {{--        $.ajax({--}}
                            {{--            url: '{{route('process.logo', $video->id)}}',--}}
                            {{--            type: 'POST',--}}
                            {{--            data: logoFormData,--}}
                            {{--            success: function (response) {--}}
                            {{--                $('#loader').hide();--}}
                            {{--                if (response.status) {--}}
                            {{--                    $('.logo-preview').attr('src', response.logoUrl + '?' + new Date().getTime());--}}
                            {{--                    $('input[name="logo"]').val(response.path);--}}
                            {{--                    checkToProceed();--}}
                            {{--                }--}}
                            {{--            },--}}
                            {{--            error: function (error) {--}}

                            {{--                $('#loader').hide();--}}
                            {{--            },--}}
                            {{--            beforeSend: function () {--}}
                            {{--                $('#loader').show();--}}
                            {{--            },--}}

                            {{--            cache: false,--}}
                            {{--            contentType: false,--}}
                            {{--            processData: false--}}
                            {{--        });--}}
                            {{--    }--}}
                            {{--});--}}
                        });

                        function checkToProceed() {
                            let logo = $('input[name="logo"]').val();
                            let template = $('input[name="template"]').val();

                            if (logo !== '' && template !== '') {
                                $('button.export-video').removeClass('disabled');
                            }
                        }


                        function entityAdded(entity) {
                            $('#video-' + entity).change(function () {
                                if ($(this).val() !== '') {
                                    $('#' + entity + '-added').show();
                                } else {
                                    $('#' + entity + '-added').hide();
                                }
                            });
                        }

                        function scale(block) {
                            let step = 1,
                                minFontSize = 7,
                                scrollHeight = block.scrollHeight,
                                height = block.offsetHeight;
                            console.log(block.scrollTop)

                            if (scrollHeight > height - 2) {
                                let fontsize = parseInt($(block).css('font-size'), 10) - step;
                                if (fontsize >= minFontSize) {
                                    $(block).css('font-size', fontsize)
                                    scale(block);
                                }
                            }
                        }
                    </script>
                    @yield('editorjs')
@endsection
