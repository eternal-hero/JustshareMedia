<div class="previewOverlay"></div>
<div id="editor-app">
    <div class="relative">
        <div class="layer layer0 videoPreview"></div>
        <div class="layer layer1 logoPreview">
            <div class="uploadLogoInner">
                <form id="process-logo-inner" enctype="multipart/form-data">
                    @csrf
                    <input id="logoInputInternalInput" class="logoInput" accept="image/png" name="logo_file" type="file">
                </form>
            </div>
            @if($logo)
                <img class="logo-preview-inner"
{{--                     {!! $logoWidth && $logoHeight ? 'style="width:'. $logoWidth .'px; height:'. $logoHeight .'px"' : '' !!}--}}
                     src="{{asset(\Illuminate\Support\Facades\Storage::url($logo)) . '?' . \Illuminate\Support\Str::random(10)}}"/>
            @else
                <img class="logo-preview-inner" src="{{asset('/images/dummy_logo.png')}}"/>
            @endif
        </div>
        <div class="layer2 textElements"></div>
        <div class="layer3 existingTemplate">
{{--            <img src="" alt="">--}}
        </div>
    </div>
</div>

@section('preview_dep')
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js" crossorigin="anonymous"></script>
@endsection

@section('preview_js')
<script>
    // $(document).on('keydown', '.text', function(e) {
    //     const previewHeight = 740
    //     const textHeight = $(this).css('height').replace('px', '')
    //     const holderTopPosition = $(this).parent('.textElement').css('top').replace('px', '')
    //     const appendedHeight = parseInt($(this).css('font-size').replace('px', ''))
    //
    //     console.log('textHeight')
    //     console.log(textHeight)
    //
    //     console.log('holderTopPosition')
    //     console.log(holderTopPosition)
    //
    //     if((parseInt(holderTopPosition) +  parseInt(textHeight) + appendedHeight) > previewHeight) {
    //         e.preventDefault()
    //         return false;
    //     }
    //
    //     return true;
    //
    // });
    @if($logo)
        logoPath = '{{$logo}}'
        $('button.export-video').removeClass('disabled');
    @endif
    $('.logoInput').change(function() {

        var fileName = document.getElementById("logoInputInternalInput").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile !=="png"){
            return;
        }

        let logoFormData = new FormData(document.getElementById('process-logo-inner'));
        $.ajax({
            url: '{{route('process.logo', $video->id)}}',
            type: 'POST',
            data: logoFormData,
            success: function (response) {
                $('#loader').hide();
                logoPath = response.path
                $('.logo-preview-inner').attr('src', response.logoUrl + '?' + new Date().getTime());
                // $('.logo-preview-inner').css('width', response.width * 0.65)
                // $('.logo-preview-inner').css('height', response.height * 0.65)
                // $('#process-logo-inner').css('width', response.width * 0.65)
                // $('#process-logo-inner').css('height', response.height * 0.65)



                $('.logo-preview-control').attr('src', response.logoUrl + '?' + new Date().getTime());
                $('button.export-video').removeClass('disabled');
            },
            error: function (error) {
                $('#loader').hide();
            },
            beforeSend: function () {
                $('#loader').show();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    })

    const size = (width, height) => {
        return {
            width: width,
            height: height
        }
    }

    const elementSize = (rootSize, width, height) => {
        const scale = 1;
        const elementWidth =  width * scale;
        const elementHeight = height * scale;
        return size(elementWidth, elementHeight);
    }

    const position = (x, y, z) => {
        return {
            left: x,
            top: y,
            index: z
        }
    }

    const domReload = app => {
        // in this f dom is::[id]
        const elements = app.preview.dom;
        elements.root.dom.width(elements.root.size.width)
        elements.root.dom.height(elements.root.size.height)
        elements.logo.dom.width(elements.logo.size.width);
        elements.logo.dom.height(elements.logo.size.height);
    }

    const app = selector => {
        // initial settings
        const rootDom = $(selector);
        const logoDom = $('.logoPreview');
        const elements = $('.textElements .textElement')
        const rootSize = size(rootDom.css('width').replace('px', ''), rootDom.css('height').replace('px', ''));

        return {
            preview: {
                size: rootSize,
                dom: {
                    root: {
                        dom: rootDom,
                        position: position(0, 0, 0),
                        size: elementSize(rootSize, $('.videoeditor-preview').width(), $('.videoeditor-preview').width())
                    },
                    logo: {
                        dom: logoDom,
                        position: position(0, 0, 0),
                        size: elementSize(rootSize, 200, 130),
                        style: {}
                    },
                    elements: elements
                }
            },
        }
    }

    const createElementOnPreview = (data, content) => {
        const el = newTextElement(content)
        WebFont.load({
            google: {
                families: [data.fontFamily]
            },
            fontactive: function(familyName, fvd) {
                $('.text', el).css('font-family', familyName)
            },
        });

        $('.text', el).css('font-size', data.fontSize)
        $('.text', el).css('font-weight', data.fontWeight)
        $('.text', el).css('font-style', data.fontStyle)
        $('.text', el).css('text-decoration', data.textDecoration)
        $('.text', el).css('text-align', data.alignment)
        $('.text', el).css('color', data.color)
        $('.text', el).html(data.html)
        $('.textElement', el).css('top', data.top)
        $('.textElement', el).css('left', data.left)
        $('.textElement', el).css('width', data.width)
        $('.textElement', el).css('height', data.height)

        configureMovement(el)
    }

    const initFromEditorData = (data, content) => {
        for(let i =0; i< data.length; i++) {
            createElementOnPreview(data[i], content)
        }
    }

    const editorApp = app('#editor-app');
    domReload(editorApp)

    appData = callback => {
        const storeState = []
        editorApp.preview.dom.elements = $('.textElements .textElement')
        $(editorApp.preview.dom.elements).each(function (i, e) {
            // console.log($('.text', e).css('font-family').replace(/"/g,""))
            const obj = {
                top: $(e).css('top'),
                left: $(e).css('left'),
                width: $(e).css('width'),
                height: $(e).css('height'),
                alignment: $('.text', e).css('text-align'),
                fontFamily: $('.text', e).css('font-family').replace(/"/g,""),
                fontSize: $('.text', e).css('font-size'),
                fontWeight: $('.text', e).css('font-weight'),
                fontStyle: $('.text', e).css('font-style'),
                textDecoration: $('.text', e).css('text-decoration'),
                color: $('.text', e).css('color'),
                html: $('.text', e).html()
            }
            storeState.push(obj)

        });
        callback(JSON.stringify(storeState))
    }
    const appImg = callback => {
        html2canvas(document.getElementById('editor-app')).then(function (canvas) {
            const overlayImg = canvas.toDataURL()
            $('.previewOverlay').append(`<img src="${overlayImg}" />`)
            $('#editor-app').css('background', 'none')
            $('.removeTextElement').remove()
            html2canvas(document.getElementById('editor-app'), {backgroundColor: null, scale: 2}).then(function (canvas) {
                const templateImgWLogo = canvas.toDataURL()
                $('.logoPreview').remove()
                html2canvas(document.getElementById('editor-app'), {backgroundColor: null, scale: 2}).then(function (canvas2) {
                    const templateImgWOLogo = canvas2.toDataURL()
                    callback(templateImgWLogo, templateImgWOLogo)
                });
            });
        });
    }

    const element = (el) => {
        return {
            alignment: {
                left: () => {
                    el.css({ 'text-align': 'left' })
                    // el.children().css({ 'text-align': 'left' })
                },
                center: () => {
                    el.css({ 'text-align': 'center' })
                    // el.children().css({ 'text-align': 'center' })
                },
                right: () => {
                    el.css({ 'text-align': 'right' })
                    // el.children().css({ 'text-align': 'right' })
                },
                justify: () => {
                    el.css({ 'text-align': 'justify' })
                    // el.children().css({ 'text-align': 'justify' })
                },
            },
            font: {
                family: f => {
                    el.css({ 'font-family': f })
                    // el.children().css({ 'font-family': f })
                },
                size: s => {
                    el.css({ 'font-size': s })
                    // el.children().css({ 'font-size': s })
                },
                bold: toggleState => {
                    if(toggleState) {
                        el.css({ 'font-weight': 700 })
                        // el.children().css({ 'font-weight': 700 })
                    } else {
                        el.css({ 'font-weight': 400 })
                        // el.children().css({ 'font-weight': 400 })
                    }
                },
                italic: toggleState => {
                    if(toggleState) {
                        el.css({ 'font-style': 'italic' })
                        // el.children().css({ 'font-style': 'italic' })
                    } else {
                        el.css({ 'font-style': 'normal' })
                        // el.children().css({ 'font-style': 'normal' })
                    }
                },
                underline: toggleState => {
                    if(toggleState) {
                        el.css({ 'text-decoration': 'underline' })
                        el.children().css({ 'text-decoration': 'underline' })
                    } else {
                        el.css({ 'text-decoration': 'none' })
                        el.children().css({ 'text-decoration': 'none' })
                    }
                }
            },
            color: {
                set: color => {
                    el.css({ 'color': color })
                    // el.children().css({ 'color': color })
                }
            }
        }
    }

    // const isTextElementSelected = () => {
    //     console.log($('.textElement.selected .text'))
    // }

    const selectedElement = () => {
        return element($('.textElement.selected .text'))
    }

    // EVENTS
    $('.relative').click(function (e) {
        if(e.target !== e.currentTarget) return;
        $('.textElement', this).removeClass('selected')
    })

    jQuery.fn.selectText = function(){
        var doc = document;
        var element = this[0];
        if (doc.body.createTextRange) {
            var range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            var selection = window.getSelection();
            var range = document.createRange();
            range.selectNodeContents(element);
            selection.removeAllRanges();
            selection.addRange(range);
        }
    };

    $('body').on('dblclick', '.textElement', function() {
        $(this).draggable('destroy')
        $(this).resizable('destroy')
        $(this).css('height', 'auto')
        $('.text', this).attr('contentEditable', true)
        $(this).addClass('active');
        const el = $('.text', this);
        $('.text', this).selectText()

    })
    $('body').on('focusout', '.textElement', function () {
        $('.text', this).attr('contentEditable', false)
        const textHeight = $('.text', this).css('height').replace('px', '')
        const elementHeight = $(this).css('height').replace('px', '')
        $(this).css('height', elementHeight)

        $(this).removeClass('active');
        $(this).removeClass('selected');
        $(this).draggable({
            preventCollision: true,
            grid: [5, 5],
            containment: '#editor-app',
            drag: function(event, ui) {
                const elementWidth = $(this).css('width').replace('px', '')
                $(this).siblings('.removeTextElement').css({
                    top: ui.position.top - 10,
                    left: parseInt(ui.position.left) + parseFloat(elementWidth) - 10
                })
            }
        });
        $(this).resizable({
            grid: [5, 5],
            handles: 'e, se',
            // handles: 'e',
            containment: '#editor-app',
            resize: function( event, ui ) {
                $(this).siblings('.removeTextElement').css({
                    top: ui.position.top - 10,
                    left: parseInt(ui.position.left) + parseFloat(ui.size.width) - 10
                })
            }
        });
    })

    $('body').on('mouseup', '.textElement', function() {
        $('.tab-controls').addClass('hiddenControl')
        $('.text_editor-tab').removeClass('hiddenControl')
        $('.tab').removeClass('active')
        $('.tab-text_editor').addClass('active')
        if($(this).hasClass('selected')) {
            return;
        }
        $('.textElement').removeClass('selected')
        $(this).addClass('selected')
        setEditorControlState($('.text', this))
    })

    // $('body').on('resize', '.textElement', function(e, ui) {
        // const widthWithPadding = ui.size.width - 4
        // $('.text', this).width(widthWithPadding)
        // $('.text', this).height(ui.size.height)
    // })

    $(document).on('click', '.removeTextElement', function() {
        $(this).parent('.textElementWrapper').remove()
    })

    /*
    * text options
    * */

    const configureMovement = el => {
        const removeLeftPosition = parseInt($('.textElement', el).css('width').replace('px', '')) + parseInt($('.textElement', el).css('left').replace('px', '')) - 10
        const removeTopPosition = parseInt($('.textElement', el).css('top').replace('px', '')) - 10
        $('.removeTextElement', el).css('left', removeLeftPosition)
        $('.removeTextElement', el).css('top', removeTopPosition)
        $( ".draggable", el).draggable({
            preventCollision: true,
            grid: [5, 5],
            containment: '#editor-app',
            drag: function(event, ui) {
                const elementWidth = $(this).css('width').replace('px', '')
                $(this).siblings('.removeTextElement').css({
                    top: ui.position.top - 10,
                    left: parseInt(ui.position.left) + parseFloat(elementWidth) - 10
                })
            }
        });
        $( ".resizable", el).resizable({
            grid: [5, 5],
            handles: 'e, se',
            // handles: 'e',
            containment: '#editor-app',
            resize: function( event, ui ) {
                $(this).siblings('.removeTextElement').css({
                    top: ui.position.top - 10,
                    left: parseInt(ui.position.left) + parseFloat(ui.size.width) - 10
                })
            }
        });
    }

    const newTextElement = content => {
        const el = $(`
            <div class="textElementWrapper">
                <div class="removeTextElement">X</div>
                <div class="draggable resizable textElement">
                    <div class="text">${content}</div>
                </div>
            </div>
        `).appendTo('.textElements')

        $('.textElement', el).css({left: editorApp.preview.size.width/2 - 300/2})
        $('.textElement', el).css({top: editorApp.preview.size.height/2 - 16/2})
        editorApp.preview.dom.elements = $('.textElements .textElement')
        $('.text', el).css('font-family', 'ABeeZee')
        $('.text', el).css('color', '#FFF')

        return el
    }

    $('.newTextElement').click(function() {
        templateType = 'custom'
        const el = newTextElement('Double click to edit')
        configureMovement(el)
    })
</script>
@endsection

@section('css_additional')
@parent
<style>
    #editor-app {
        background: url({{\Illuminate\Support\Facades\Storage::url($video->title_image . '?').\Illuminate\Support\Str::random(10)}});
        background-size: contain;
        height: 740px;
        width: 740px;
        float: right;
    }
    .previewOverlay {
        position: absolute;
        top: 0;
        right: 0;
        width: 740px;
        height: 740px;
    }
    .relative {
        position: relative;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }
    .layer {
        position: absolute;
        z-index: 101;
    }
    .layer1 {
        /*visibility: hidden;*/
    }

    .existingTemplate {
        position: absolute;
        top: 0;
        left: 0;
    }

    .textElements {
        width: 100%;
        height: 100%;
    }

    #process-logo-inner {
        width: 100%;
        height: 100%;
        margin: 0;
        cursor: pointer;
    }

    .logoInput {
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .logoPreview {
        position: absolute;
        left: 20px;
        top: 0;
        width: auto!important;
        max-width: 300px!important;
        height: 161px!important;
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .logoPreview .logo-preview {
        margin-left: 20px;
    }

    .logo-preview-inner {
        max-width: 100%;
        max-height: calc(100% - 40px);
    }

    .logoPreview .uploadLogoInner {
        position: absolute;
        width: 100%;
        height: 100%;
        display: flex;
        vertical-align: middle;
        align-items: center;
        z-index: 111;
        overflow: hidden;
    }

    .logoPreview .logo-preview {
        height: 100%;
        width: auto;
    }

    .draggable {
        width: auto;
        height: auto;
        margin: 0;
        padding: 0;
    }
    .resizable {
        background: transparent;
    }
    .textElement {
        position: absolute;
        width: 300px;
        height: 32px;
        overflow: hidden;
        font-size: 32px;
        font-weight: 400;
        font-style: normal;
        text-align: left;
        color: #000000;
    }
    .removeTextElement {
        position: absolute;
        z-index: 2;
        display: flex;
        text-align: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background: #2F2F2F;
        color: white;
        cursor: pointer;
        border-radius: 50%;
        font-size: 14px;
    }
    .ui-icon-gripsmall-diagonal-se {
        z-index: 2!important;
    }

    .textElement {
        cursor: grab;
    }

    .textElement.selected, .ui-draggable-dragging, .ui-resizable-resizing {
        outline: dotted 1px white!important;
    }

    .textElement.active {
        outline: dotted 1px #1477FB !important;
        cursor: text;
    }

    .textElement textarea {
        display: none;
    }
    .textElement .text {
        /*white-space: pre-wrap;*/
        line-height: 1;
        padding: 0px 2px;
        word-break: break-all;
        /*display:inline-block;*/
    }
    .textElement.active {
        /*outline: dotted 1px;*/
    }
    /*.textElement.active textarea {*/
    /*    display: block;*/
    /*    padding: 0;*/
    /*    margin: 0;*/
    /*}*/

    /*.textElement.active .text{*/
    /*    display: none;*/
    /*}*/

    textarea {
        overflow: hidden;
        resize: none;
        line-height: 1;
        border: 0;
        outline: 0;
        background: transparent;
    }
</style>
@endsection
