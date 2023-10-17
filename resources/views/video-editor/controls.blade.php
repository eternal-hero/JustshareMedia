<div class="controls">
    <div class="controls-tabs">
        <div class="tab tab-templates">
            <img class="tab-icon black-icon" src="{{url('/images/text-editor/icons/templates_black.svg')}}" alt="Templates">
            <img class="tab-icon white-icon" src="{{url('/images/text-editor/icons/templates_white.svg')}}" alt="Templates">
            Templates
        </div>
        <div class="tab tab-logo">
            <img class="tab-icon black-icon" src="{{url('/images/text-editor/icons/uploads_black.svg')}}" alt="Uploads">
            <img class="tab-icon white-icon" src="{{url('/images/text-editor/icons/uploads_white.svg')}}" alt="Uploads">
            Uploads
        </div>
        <div class="tab tab-text_editor">
            <img class="tab-icon black-icon" src="{{url('/images/text-editor/icons/text_black.svg')}}" alt="Text Editor">
            <img class="tab-icon white-icon" src="{{url('/images/text-editor/icons/text_white.svg')}}" alt="Text Editor">
            Text Editor
        </div>
    </div>
    <div class="controls-active_tab">
        <div class="templates-tab tab-controls hiddenControl">
            @include('video-editor.controls.templates')
        </div>
        <div class="logo-tab tab-controls hiddenControl">
            @include('video-editor.controls.logo')
        </div>
        <div class="text_editor-tab tab-controls hiddenControl">
            @include('video-editor.controls.text-editor')
        </div>
    </div>
</div>

@section('controls_dep')
    <script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
@endsection

@section('controls_js')
<script>
    $(document).ready(function() {
        $('.templates-tab').removeClass('hiddenControl')
        $('.tab-templates').addClass('active')
        $('.tab-templates').click(function() {
            $('.tab-controls').addClass('hiddenControl')
            $('.templates-tab').removeClass('hiddenControl')
            $('.tab').removeClass('active')
            $(this).addClass('active')
        })

        $('.tab-logo').click(function() {
            $('.tab-controls').addClass('hiddenControl')
            $('.logo-tab').removeClass('hiddenControl')
            $('.tab').removeClass('active')
            $(this).addClass('active')
        })

        $('.tab-text_editor').click(function() {
            templateType = 'custom'
            $('.tab-controls').addClass('hiddenControl')
            $('.text_editor-tab').removeClass('hiddenControl')
            $('.tab').removeClass('active')
            $(this).addClass('active')
            $('.existingTemplate').html('')
        })
    })
</script>
@yield('templates_controls_js')
@yield('text_editor_controls_js')
@yield('logo_controls_js')
@endsection

@section('css_additional')
@parent
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">
<style>
    .hiddenControl {
        display: none!important;
    }
    .controls {
        height: 100%;
    }
    .controls-tabs {
        display: flex;
        height: 50px;
        margin: 30px 0;
        justify-content: space-around;
    }
    .tab {
        display: flex;
        align-items: center;
        color: black;
        cursor: pointer;
    }
    .tab.active {
        padding: 0 10px;
        background: black;
        border-radius: 10px;
        color: white;
    }

    .tab-icon {
        width: 28px;
        height: 28px;
        margin-right: 10px;
    }

    .tab .white-icon {
        display: none;
    }
    .tab .black-icon {
        display: block;
    }

    .tab.active .white-icon {
        display: block;
    }
    .tab.active .black-icon{
        display: none;
    }

    .controls-active_tab {
        position: relative;
        height: calc(100% - 140px);
        padding: 0 20px;
        background: #EEEEEE;
    }

    .controls-active_tab .title {
        padding-top: 17px;
        padding-bottom: 17px;
        margin-bottom: 10px;
        font-family: 'Poppins', serif;
        font-weight: 700;
        font-size: 21px;
        color: black;
        text-align: center;
        border-bottom: solid 1px #DFDFDF;
    }

    .controls-active_tab .description {
        font-size: 15px;
        text-align: center;
        line-height: 21px;
        margin: 10px 40px;
        color: #444444;
    }

    .templates-tab {
        height: 100%;
    }

    .control-subtitle {
        margin-bottom: 10px;
        margin-top: 20px;
        font-size: 16px;
        font-weight: 500;
        font-family: 'Poppins';
        color: black;
    }

    .editor-icon {
        width: 30px;
        height: 30px;
    }

    .editor-icon path {
        fill: white;
        stroke: white;
    }


</style>
@endsection
