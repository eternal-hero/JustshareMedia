<div class="content-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center" style="text-align: center">
                <img src="{{ public_path() . '/assets/images/just-share-media-logo.png' }}" style="height: 100px;" alt="Just Share Media Logo">
            </div>
            <div class="col-12 text-center" style="text-align: center; margin-top: 10px;">
                <b>PROOF OF LICENSE</b>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-12" style="text-align: justify; padding: 0 50px; font-size: 14pt">
                Just Share Media LLC grants <b>{{ $user->company }}</b> a non-exclusive, limited, non-sub licensable,
                and nontransferable, license to download, reproduce, distribute, perform and display the video
                <b>{{ $licensedVideo->video_title }}</b>, hereby referred to as “the Content”. You shall not (a) resell
                the Content; (b) make any change in the language of the Content; (c) change the Content. The
                temporary license is valid starting <b>{{ date('Y/d/m', strtotime($licensedVideo->created_at)) }}</b>
                and ends when a new license is generated or upon cancelation of services.
            </div>
        </div>
    </div>
</div>
</div>
