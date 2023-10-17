<div class="logo-control-wrapper">
    @if($logo)
        <img class="logo-preview-control" src="{{asset(\Illuminate\Support\Facades\Storage::url($logo)) . '?' . \Illuminate\Support\Str::random(10)}}"/>
    @else
        <img class="logo-preview-control" src="{{asset('/images/dummy_logo.png')}}"/>
    @endif
    <div class="uploadLogoControl">
        <form id="process-logo-control" enctype="multipart/form-data">
            @csrf
            <input id="logoInputControlInput" class="logoInputControl" accept="image/png" name="logo_file" type="file">
        </form>
        <div class="process-logo-control-trigger">Upload Logo</div>
    </div>
</div>

@section('logo_controls_js')
<script>
    $('.logoInputControl').change(function() {

        var fileName = document.getElementById("logoInputControlInput").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile !=="png"){
            return;
        }

        let logoFormData = new FormData(document.getElementById('process-logo-control'));
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
</script>
@endsection

@section('css_additional')
@parent
<style>
    .logo-control-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding-top: 40px;

    }
    .uploadLogoControl {
        position: relative;
        width: 300px;
        margin-top: 40px;
        height: 50px;
    }

    #process-logo-control, .process-logo-control-trigger {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }

    .logoInputControl {
        height: 100%;
        cursor: pointer;
    }

    #process-logo-control {
        opacity: 0;
        z-index: 2;
    }
    .process-logo-control-trigger {
        z-index: 1;
        text-align: center;
        line-height: 50px;
        background: #3F95FF;
        border: 1px solid #3F95FF;
        border-radius: 30px;
        color: white;
        font-size: 24px;
    }

</style>
@endsection
