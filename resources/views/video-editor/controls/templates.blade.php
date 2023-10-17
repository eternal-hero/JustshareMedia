<div class="title">CHOOSE A TEMPLATE</div>
<div class="description">Choose a suitable template from our library or a custom one that you saved earlier.</div>
<div class="scroll">
    <div class="scroll-title control-subtitle">Custom Templates</div>
    <div class="scroll-section">
        <div class="empty">
            <img class="empty-template-icon" src="{{url('/images/text-editor/icons/empty_template_icon.svg')}}" alt="Delete Template">
            <div>EMPTY</div>
        </div>
        <script>
            let customTemplatesEditorData = []
        </script>
        @foreach($customTemplates as $template)
        <div id="template-{{$template->id}}" class="template-preview custom-template-preview">
            <div id="delete-id-{{$template->id}}" class="delete-template">
                <img class="delete-template-icon black-icon" src="{{url('/images/text-editor/icons/trash_black.svg')}}" alt="Delete Template">
                <img class="delete-template-icon white-icon" src="{{url('/images/text-editor/icons/trash_white.svg')}}" alt="Delete Template">
            </div>
            <img style="z-index: 1" src="{{\Illuminate\Support\Facades\Storage::url($template->preview_path)}}" alt="">
            <img style="z-index: 0" src="{{\Illuminate\Support\Facades\Storage::url($video->title_image . '?')}}" alt="">
            <img class="checked-template-icon" src="{{url('/images/text-editor/icons/checked_icon.svg')}}" alt="Template Checked">
        </div>
        <script>
            customTemplatesEditorData['{{ $template->id }}'] = {!! $template->editorData !!}
        </script>
        @endforeach
    </div>
    <div class="scroll-title control-subtitle">Predefined Templates</div>
    <div class="scroll-section">
        @foreach($defaultTemplates as $template)
            <div id="template-{{$template->id}}" class="template-preview existing-template" data-template-id="{{$template->id}}" data-image="{{$template->title}}">
                <img class="templateUrl" style="z-index: 1" src="{{\Illuminate\Support\Facades\Storage::url($template->path)}}" alt="">
                <img style="z-index: 0" src="{{\Illuminate\Support\Facades\Storage::url($video->title_image . '?')}}" alt="">
                <img class="checked-template-icon" src="{{url('/images/text-editor/icons/checked_icon.svg')}}" alt="Template Checked">
            </div>
        @endforeach
    </div>
</div>
<div class="custom-template-delete-confirmation hiddenControl">
    <div class="ctdc-wrapper">
        <div class="ctdc-title">Are you sure you want to delete this custom template?</div>
        <div class="ctdc-description">Once you delete the template, any custom formatting connected with it will be deleted too.</div>
        <div class="ctdc-delete-btn">Yes, Delete</div>
        <div class="ctdc-cancel-btn">Cancel</div>
        <div class="ctdc-close">X</div>
    </div>
</div>

@section('templates_controls_js')
<script>
    $('document').ready(function() {
        let deleteTemplateID = false
        $('.empty').click(function() {
            $('.checked-template-icon').hide()
            templateType = 'custom'
            $('.tab-controls').addClass('hiddenControl')
            $('.text_editor-tab').removeClass('hiddenControl')
            $('.tab').removeClass('active')
            $('.tab-text_editor').addClass('active')
            $('.existingTemplate').html('')
            $('.textElements').html('')
        })

        $('.delete-template').click(function() {
            deleteTemplateID = $(this).attr('id').replace('delete-id-', '')
            $('.custom-template-delete-confirmation').removeClass('hiddenControl')
        })

        $('.ctdc-close').click(function() {
            $('.custom-template-delete-confirmation').addClass('hiddenControl')
        })

        $('.ctdc-cancel-btn').click(function() {
            $('.custom-template-delete-confirmation').addClass('hiddenControl')
        })

        $('.template-preview').click(function () {
            $('.checked-template-icon').hide()
            $('.checked-template-icon', this).show();
        })

        $('.existing-template').click(function() {
            templateType = 'existing'
            selectedTemplate = $(this).data('template-id')
            const templateUrl = $('.templateUrl', this).attr('src');
            $('.existingTemplate').html(`<img src="${templateUrl}" />`)
            // $('.existingTemplate img').attr('src', templateUrl  + '?' + new Date().getTime())
            $('.textElements').html('')
        })
        $('.custom-template-preview').click(function() {
            templateType = 'custom'
            const id = $(this).attr('id').replace('template-', '')
            let editorData = customTemplatesEditorData[id]
            $('.existingTemplate').html('')
            $('.textElements').html('')
            initFromEditorData(editorData)
        })
        $('.ctdc-delete-btn').click(function () {
            $('#loader').show();
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
                }
            });
            $.ajax({
                url: '{{route('delete.template')}}',
                data: JSON.stringify({
                    id: deleteTemplateID
                }),
                contentType: "application/json",
                type: 'DELETE',
                success: function (response){
                    $('#template-' + deleteTemplateID).remove()
                    $('.custom-template-delete-confirmation').addClass('hiddenControl')
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    $('#loader').hide();
                },
                cache: false,
                processData: false
            });
        })

    })
</script>
@endsection

@section('css_additional')
    @parent
<style>
    .template-preview {
        position: relative;
        height: 140px;
        width: 140px;
        cursor: pointer;
    }
    .template-preview img {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .checked-template-icon {
        display: none;
        bottom: 5px;
        right: 5px;
        width: 21px!important;
        height: 21px!important;
        z-index: 3;
    }

    .empty {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 2.5px solid #DFDFDF;
        border-radius: 4px;
        cursor: pointer;
        font-family: 'Poppins';
        font-size: 12px;
        color: #6C757C;
    }

    .empty-template-icon {
        left: 0;
        top: 0;
        width: 22px;
        height: 22px;
    }

    .delete-template-icon {
        width: 28px;
        height: 28px;
        margin-right: 10px;
    }

    .delete-template-icon.white-icon {
        display: none;
    }
    .delete-template-icon.black-icon {
        display: block;
    }

    .delete-template:hover .white-icon {
        display: block;
    }

    .custom-template-preview .delete-template {
        position: absolute;
        z-index: 9;
        right: 5px;
        top: 5px;
        width: 21px;
        height: 21px;
    }

    .scroll {
        height: 470px;
        padding-right: 10px;
        overflow-y: scroll;
    }

    .scroll::-webkit-scrollbar {
        width: 6px;
    }

    /* Track */
    .scroll::-webkit-scrollbar-track {
        background: #EEEEEE;

    }

    /* Handle */
    .scroll::-webkit-scrollbar-thumb {
        background: #6C757C;
        border-radius: 3px;
    }

    /* Handle on hover */
    .scroll::-webkit-scrollbar-thumb:hover {
        background: #6C757C;
    }

    .scroll-section {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 15px;
    }

    .custom-template-delete-confirmation {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(1,1,1,0.6);
        /*opacity: 0.6;*/
        z-index: 200;
    }

    .ctdc-wrapper {
        position: relative;
        width: 630px;
        padding: 40px 80px;
        background: white;
        border-radius: 4px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .ctdc-title {
        font-family: 'Poppins';
        font-weight: 600;
        font-size: 20px;
        margin-bottom: 15px;
    }

    .ctdc-description {
        font-family: 'Lato';
        font-weight: 400;
        font-size: 16px;
        margin-bottom: 25px;
    }

    .ctdc-delete-btn {
        height: 50px;
        background: #F74848;
        border-radius: 4px;
        color: white;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
        cursor: pointer;
    }

    .ctdc-cancel-btn {
        height: 50px;
        border: 1px solid #D3D3D3;
        border-radius: 4px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .ctdc-close {
        position: absolute;
        right: 20px;
        top: 15px;
        cursor: pointer;
    }

</style>
@endsection
