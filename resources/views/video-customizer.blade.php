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
        <div class="container ve-container">
            <div class="heading-block center">
                <h2>Edit your video</h2>
            </div>

            <div class="row d-flex justify-content-center align-items-center mb-5 container-wrapper-help-part">
{{--                <div class="col-7 d-flex justify-content-end">--}}
{{--                        <span data-toggle="modal"--}}
{{--                              data-target="#how-to-get-started-modal" class="mr-4 container-wrapper-help-part helper-starting-link">How to get started</span>--}}
{{--                </div>--}}
                <div class="col d-flex justify-content-center">
                    <button
                        class="btn btn-primary d-flex justify-content-between container-wrapper-help-part need-help-button">
                        <i class="far fa-play-circle"></i>
                        <a href="https://www.youtube.com/watch?v=cyS5xQqXsSo" target="_blank"><span class="container-wrapper-help-part need-help-button-text">Need Help</span></a>
                    </button>
                </div>
            </div>

        </div>

        <div id="videoEditor" class="row" style="height: auto">
            <div class="video_editor-controls">
                @include('video-editor.controls')
            </div>
            <div class="video_editor-preview-scroll">
                <div class="video_editor-preview" style="min-width: 740px">
                    @include('video-editor.preview')
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12 center">
                    <button class="export-video disabled"><span>Export video</span></button>
                </div>
                <img src="" alt="" id="imgprev">
            </div>
        </div>

        <div id="loader">
            <div class="spinner-border" style="" role="status"><span class="sr-only">Loading...</span></div>
        </div>
        @include('video-editor.how-to-start-modal')
    </div>
@endsection

@section('js_additional')
{{--DEPS--}}
@yield('controls_dep')
@yield('preview_dep')
<script type="text/javascript">
        let templateType = 'custom'
        let logoPath = null
        let selectedTemplate = null
        $(document).ready(function() {
            // load default font for editor
            // ABeeZee
            WebFont.load({
                google: {
                    families: ['ABeeZee']
                },
            });
            $(document).on('click', '.export-video', function () {
                if(!logoPath) {
                    return;
                }
                $('#loader').show()
                appImg(function(imageWLogo, imageWOLogo) {
                    // console.log('imageWLogo')
                    // console.log(imageWLogo)
                    // console.log('imageWOLogo')
                    // console.log(imageWOLogo)
                    // $('#videoEditor').append(`<img style="position: absolute; left: 0: top: 0: z-index: 999999" src='${imageWLogo}' />`)
                    // $('#loader').hide()
                    // return;
                    appData(function(appData) {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": '{{ csrf_token() }}'
                            }
                        });
                        const shouldSaveTemplate = $('.shouldSaveTemplate').is(':checked')
                        $.ajax({
                            url: '{{route('submit.template')}}',
                            data: JSON.stringify(
                                {
                                    templateType: templateType,
                                    appData: appData,
                                    preview: imageWOLogo,
                                    template: imageWLogo,
                                    video: '{{$video->id}}',
                                    logo: logoPath,
                                    shouldSaveTemplate: shouldSaveTemplate,
                                    selectedTemplate: selectedTemplate,
                                }
                            ),
                            contentType: "application/json",
                            type: 'POST',
                            success: function (response){
                                window.location.href ='{{route('attach.locations', ['licenseType' => $type])}}';
                            },
                            error: function (error) {
                                console.log(error);
                                $('#loader').hide()
                            },
                            cache: false,
                            processData: false
                        });
                    })
                })
            });
        })
</script>
@yield('controls_js')
@yield('preview_js')
@endsection

@section('css_additional')
    <style>
        #videoEditor {

            max-width: 1320px;
            margin: 0 auto;
            padding: 0 15px;

            position: relative;
            top: 0;
            right: 0;
            height: 740px;
            height: auto;
            justify-content: space-between;
            background: #F9F9F9;
        }

        .video_editor-controls, .video_editor-preview {
            position: relative;
            height: 740px;
        }

        .video_editor-controls {
            width: 530px;
            margin: 0 auto;
        }


        @media only screen and (max-width: 1440px) {
            #videoEditor {
                max-width: 100%;
                padding: 0;
                margin: 0;
                justify-content: space-around;
            }

            .ve-container {
                margin: 0;
                max-width: 100%;
            }
            .video_editor-controls {
                margin: 0;
            }
        }

        @media only screen and (max-width: 1380px) {
            #videoEditor {
                padding: 0;
            }
            .video_editor-controls {
                width: 500px;
                margin: 0;
            }
            .controls-active_tab {
                padding: 0 10px;
            }
        }

        @media only screen and (max-width: 800px) {

            .video_editor-preview-scroll {
                overflow-x: scroll;
            }
        }

    </style>
@endsection
