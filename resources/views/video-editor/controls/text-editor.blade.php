<div class="title">Custom Text</div>
<div class="description">
    Type your custom text in the fields shown to the right.
    <br>
    Use the properties box to stylize your text.
</div>
<div class="newTextElement">Add Text Box</div>
<div class="control-subtitle">Properties</div>
<div class="text-options-tabs">
    <div class="text-options-tab font-tab">
        <img class="text-options-tab-icon white-icon" src="{{url('/images/text-editor/icons/font_icon.svg')}}" alt="Font options">
        Font
    </div>
    <div class="text-options-tab alignment-tab">
        <img class="text-options-tab-icon white-icon" src="{{url('/images/text-editor/icons/alignment_icon.svg')}}" alt="Alignment options">
        Alignment
    </div>
    <div class="text-options-tab colors-tab">
        <img class="text-options-tab-icon white-icon" src="{{url('/images/text-editor/icons/color_icon.svg')}}" alt="Color options">
        Colors
    </div>
</div>
<div class="text-options">
    <div class="font text-option hiddenControl">
        <div class="font-family">
            <label for="">Font</label>
            <select class="font-family-selector"></select>
        </div>
        <div class="font-size">
            <label for="">Size</label>
            <div class="font-size-controls">
                <select name="">
                    <option value="8">8</option>
                    <option value="10">10</option>
                    <option value="12">12</option>
                    <option value="14">14</option>
                    <option value="16">16</option>
                    <option value="18">18</option>
                    <option value="20">20</option>
                    <option value="22">22</option>
                    <option value="24">24</option>
                    <option value="26">26</option>
                    <option value="28">28</option>
                    <option value="30">30</option>
                    <option value="32">32</option>
                    <option value="34">34</option>
                    <option value="36">36</option>
                    <option value="38">38</option>
                    <option value="40">40</option>
                    <option value="42">42</option>
                    <option value="44">44</option>
                    <option value="46">46</option>
                    <option value="48">48</option>
                    <option value="50">50</option>
                    <option value="52">52</option>
                    <option value="54">54</option>
                    <option value="56">56</option>
                    <option value="58">58</option>
                    <option value="60">60</option>
                    <option value="62">62</option>
                    <option value="64">64</option>
                    <option value="66">66</option>
                    <option value="68">68</option>
                    <option value="70">70</option>
                    <option value="72">72</option>
                </select>
                <div class="slider"></div>
            </div>
        </div>
        <div class="font-style">
            <label for="">Style</label>
            <div class="font-style-controls">
                <div class="bold">B</div>
                <div class="italic">I</div>
                <div class="underline">U</div>
            </div>
        </div>
    </div>
    <div class="alignment text-option hiddenControl">
        Style
        <div class="align-wrapper">
            <div class="align left">
                <img class="align-icon white-icon" src="{{url('/images/text-editor/icons/left_icon.svg')}}" alt="Left alignment">
            </div>
            <div class="align center">
                <img class="align-icon white-icon" src="{{url('/images/text-editor/icons/center_icon.svg')}}" alt="Center alignment">
            </div>
            <div class="align right">
                <img class="align-icon white-icon" src="{{url('/images/text-editor/icons/right_icon.svg')}}" alt="Right alignment">
            </div>
            <div class="align justify">
                <img class="align-icon white-icon" src="{{url('/images/text-editor/icons/justify_icon.svg')}}" alt="Justify alignment">
            </div>
        </div>
        <div class="align-wrapper">
            <div class="align-text left">Left</div>
            <div class="align-text center">Center</div>
            <div class="align-text right">Right</div>
            <div class="align-text justify">Justify</div>
        </div>
    </div>
    <div class="colors text-option hiddenControl">
        <div class="text-options-title">
            TEXT COLOR
        </div>
        <input type='text' class='colorPicker' value='blue' />
        <div class="text-options-title">
            BRAND COLORS
        </div>

        <div class="brandColors">
            @if($hasBrandColors)
                @foreach($brandColors as $color)
                    @if($color['value'])
                        <div class="brandColor" style="background-color: {{$color['value']}}"></div>
                    @endif
                @endforeach
            @else
                <a class="text-options-link" target="_blank" href="{{route('dashboard.brand-colors')}}">Set Your brand colors</a>
            @endif
        </div>
    </div>

    <div class="save-template-wrapper">
        <input id="shouldSaveTemplate" type="checkbox" class="shouldSaveTemplate">
        <div class="save-template-text">
            <label for="shouldSaveTemplate">Save as template</label>
        </div>
        <div class="tooltip-wrapper">
            <div class="tooltip-trigger">
                <img src="{{url('/images/text-editor/icons/question_icon.svg')}}"
                     title="The “Save as template” option allows you to save this custom text design as a template. If checked, this design will be available to you in the “Templates” list to use again for future videos!"
                     alt="Question mark">
            </div>
        </div>
    </div>
</div>

@section('text_editor_controls_js')
<script>
    const setEditorControlState = element => {
        $('.font-size-controls select').val(element.css('font-size').replace('px', '')).change();
        $('.font-family-selector').val(element.css('font-family').replace(/"/g,"")).change();
        if(element.css('font-weight') == 700) {
            $('.font-style-controls .bold').addClass('active')
        } else {
            $('.font-style-controls .bold').removeClass('active')
        }
        if(element.css('font-style') === 'italic') {
            $('.font-style-controls .italic').addClass('active')
        } else {
            $('.font-style-controls .italic').removeClass('active')
        }
        if(element.css('text-decoration').startsWith('underline')) {
            $('.font-style-controls .underline').addClass('active')
        } else {
            $('.font-style-controls .underline').removeClass('active')
        }
        $('.align').removeClass('active')
        if(element.css('text-align') === 'left') {
            $('.align.left').addClass('active')
        }
        if(element.css('text-align') === 'center') {
            $('.align.center').addClass('active')
        }
        if(element.css('text-align') === 'right') {
            $('.align.right').addClass('active')
        }
        if(element.css('text-align') === 'justify') {
            $('.align.justify').addClass('active')
        }
        // console.log(element.css('color'))
        $(".colorPicker").spectrum("set", element.css('color'));
    }

    $(document).ready(function () {
        $('.tooltip-trigger').tooltip({
            position: {
                my: "center bottom-20",
                at: "center top",
                using: function( position, feedback ) {
                    $( this ).css( position );
                    $( "<div>" )
                        .addClass( "arrow" )
                        .addClass( feedback.vertical )
                        .addClass( feedback.horizontal )
                        .appendTo( this );
                }
            }
        });

        /*
        * get all google fonts
        * */
        const googleAPIKey = '{{ env('FONT_SERVICE_KEY') }}';
        let allGoogleFonts = []
        $.get('https://www.googleapis.com/webfonts/v1/webfonts?key=' + googleAPIKey).then(function(resp) {
            allGoogleFonts = resp.items
            for(let i = 0; i < allGoogleFonts.length; i++) {
                $('.font-family-selector').append(`<option value="${allGoogleFonts[i].family}">${allGoogleFonts[i].family}</option>`)
            }
        })

        $('.text-option.font').removeClass('hiddenControl')
        $('.font-tab').addClass('active')

        $(".colorPicker").spectrum({
            showInput: true,
            change: function(color) {
                selectedElement().color.set(color.toHexString())
                if($('.textElement.selected .text').css('text-decoration').startsWith('underline')) {
                    $('.textElement.selected .text').css({ 'text-decoration': 'underline' })
                }
            }
        });

        $('.brandColor').click(function() {
            const color = $(this).css('background-color');
            $(".colorPicker").spectrum("set", color);
            selectedElement().color.set($(".colorPicker").spectrum('get').toHexString())
            if($('.textElement.selected .text').css('text-decoration').startsWith('underline')) {
                $('.textElement.selected .text').css({ 'text-decoration': 'underline' })
            }
        })

        $('.slider').slider({
            slide: function( event, ui ) {
                $('.font-size-controls select option[value="'+ui.value+'"]').prop('selected', true)
                selectedElement().font.size(ui.value)
            },
            change: function(e, ui) {
                selectedElement().font.size(ui.value)
            },
            step: 2,
            min: 8,
            max: 72
        })

        $('.font-size-controls select').change(function() {
            $('.slider').slider('value', $(this).val());
            selectedElement().font.size($(this).val())
        })

        $('.font-tab').click(function() {
            $('.text-option').addClass('hiddenControl')
            $('.text-option.font').removeClass('hiddenControl')
            $('.text-options-tab').removeClass('active')
            $(this).addClass('active')
        })

        $('.alignment-tab').click(function() {
            $('.text-option').addClass('hiddenControl')
            $('.text-option.alignment').removeClass('hiddenControl')
            $('.text-options-tab').removeClass('active')
            $(this).addClass('active')
        })

        $('.colors-tab').click(function() {
            $('.text-option').addClass('hiddenControl')
            $('.text-option.colors').removeClass('hiddenControl')
            $('.text-options-tab').removeClass('active')
            $(this).addClass('active')
        })

        $('.font-family-selector').change(function() {
            const fontFamily = $('option:selected', this).val()
            WebFont.load({
                google: {
                    families: [fontFamily]
                },
                fontactive: function(familyName, fvd) {
                    selectedElement().font.family(familyName)
                },
            });
        })

        $('.align.left').click(function() {
            selectedElement().alignment.left()
            $('.align').removeClass('active')
            $(this).addClass('active')
        })

        $('.align.center').click(function() {
            selectedElement().alignment.center()
            $('.align').removeClass('active')
            $(this).addClass('active')
        })

        $('.align.right').click(function() {
            selectedElement().alignment.right()
            $('.align').removeClass('active')
            $(this).addClass('active')
        })

        $('.align.justify').click(function() {
            selectedElement().alignment.justify()
            $('.align').removeClass('active')
            $(this).addClass('active')
        })

        $('.bold').click(function() {
            selectedElement().font.bold(!$(this).hasClass('active'))
            $(this).toggleClass('active')
        })

        $('.italic').click(function() {
            selectedElement().font.italic(!$(this).hasClass('active'))
            $(this).toggleClass('active')
        })

        $('.underline').click(function() {
            selectedElement().font.underline(!$(this).hasClass('active'))
            $(this).toggleClass('active')
        })
    })
</script>
@endsection


@section('css_additional')
@parent
<style>
    .ui-tooltip, .arrow:after {
        background: white;
        width: 483px;
    }
    .ui-tooltip {
        padding: 8px 10px;
        border-radius: 6px;
        /*box-shadow: 0px 2px 0px 3px rgba(0, 0, 0, 0.25);*/
        color: #444444;
        font-size: 13px;
    }
    .arrow {
        width: 70px;
        height: 16px;
        overflow: hidden;
        position: absolute;
        left: 50%;
        margin-left: -35px;
        bottom: -16px;
    }
    .arrow.top {
        top: -16px;
        bottom: auto;
    }
    .arrow.left {
        left: 20%;
    }
    .arrow:after {
        content: "";
        position: absolute;
        left: 20px;
        top: -20px;
        width: 25px;
        height: 25px;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .arrow.top:after {
        bottom: -20px;
        top: auto;
    }

    .text-options {

    }
    .text-options-tab.active {
        padding: 0 10px;
        background: #1477FB;
        border-radius: 4px;
    }

    .text-options-tab-icon {
        width: 22px;
        height: 22px;
        margin-right: 8px;
    }

    .align-icon {
        width: 22px;
        height: 22px;
    }

    .newTextElement {
        height: 38px;
        background: #1477FB;
        color: white;
        font-size: 17px;
        align-items: center;
        justify-content: center;
        display: flex;
        border-radius: 4px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .text-options-tabs {
        display: flex;
        justify-content: flex-start;
        height: 62px;
        margin-bottom: 5px;
        align-items: center;
        background: black;
        border-radius: 4px;
        color: white;
        cursor: pointer;
    }

    .text-options-tab {
        margin-left: 10px;
        height: 32px;
        display: flex;
        align-items: center;
        font-size: 13px;
    }

    .text-option {
        background: #2F2F2F;
        border-radius: 4px;
        padding: 10px 20px;
    }

    .text-options-title {
        margin-top: 10px;
        margin-bottom: 5px;
        color: white;
        font-family: 'Poppins';
        font-size: 12px;
    }

    .text-option label {
        font-size: 12px;
        font-family: 'Poppins';
        font-weight: 400;
        text-transform: uppercase;
        color: white;
    }

    .text-option select {
        border: 1px solid #6C757C;
        background: #2F2F2F;
        border-radius: 4px;
        height: 32px;
        color: white;
    }

    .text-option .font-family {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }

    .text-option .font-size {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }

    .text-option .font-size .font-size-controls {
        display: flex;
        align-items: center;
    }

    .text-option .font-size .font-size-controls select {
        width: 25%;
        margin-right: 5%;
    }

    .text-option .font-size .font-size-controls .slider {
        width: 70%;
        height: 3px;
    }

    .ui-slider-handle {
        top: -4.5px!important;
        width: 10px!important;
        height: 10px!important;
        border-radius: 100%;
    }

    .font-style-controls {
        display: flex;
        justify-content: space-between;
    }

    .font-style-controls div {
        display: flex;
        width: 32%;
        height: 55px;
        align-items: center;
        justify-content: center;
        border: 1px solid #6C757C;
        border-radius: 4px;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }

    .font-style-controls div.active {
        background: rgba(20, 119, 251, 0.1);
        border: 1px solid #1477FB;
    }

    .alignment {
        color: white;
    }

    .align-wrapper {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 5px
    }

    .align-wrapper .align {
        display: flex;
        width: 80px;
        height: 55px;
        align-items: center;
        justify-content: center;
        border: 1px solid #6C757C;
        border-radius: 4px;
        cursor: pointer;
    }

    .align-wrapper .align.active {
        background: rgba(20, 119, 251, 0.1);
        border: 1px solid #1477FB;
    }

    .align-wrapper .align-text {
        display: flex;
        width: 80px;
        justify-content: center;
        font-size: 15px;

    }

    .brandColors {
        display: flex;
        justify-content: flex-start;
    }

    .brandColor {
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border-radius: 4px;
        cursor: pointer;
    }

    .text-options-link {
        color: white;
        font-size: 12px;
    }
    .text-options-link:hover {
        color: #e2e2e2;
    }

    .save-template-wrapper {
        position: absolute;
        bottom: 20px;
        display: flex;
        align-items: center;
    }

    .shouldSaveTemplate {
        width: 18px;
        height: 18px;
    }

    .save-template-text label{
        margin: 0 5px;
        font-size: 16px;
        font-family: "Lato", sans-serif;
        font-weight: 400;
    }

    .tooltip-trigger {
        /*position: relative;*/
    }
    .tooltip-content {
        display: none;
    }

    .sp-colorize-container {
        width: 32px;
        height: 32px;
        border-radius: 4px!important;
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }

    .input.spectrum.with-add-on, .sp-colorize-container sp-add-on, .sp-original-input-container .sp-add-on {
        border-radius: 4px!important;
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }

    input.colorPicker {
        cursor: pointer;
        position: absolute;
        top: 0;
        left: 0;
        width: 32px;
        height: 32px;
        border-radius: 4px!important;
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
        border: 1px solid #6C757C;
        opacity: 0;
    }
</style>
@endsection
