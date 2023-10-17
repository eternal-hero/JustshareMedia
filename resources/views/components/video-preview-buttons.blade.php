<div class="row text-center">
    <div class="col-6">
        <a href="{{ \Storage::url('public/video_temp/user_' . $user->id . '/video_' . $video->id . '/bigPreviewVideo.mp4') }}"
           style="display: @if(file_exists(\Storage::path('public/video_temp/user_' . $user->id . '/video_' . $video->id . '/bigPreviewVideo.mp4'))) block @else none @endif"
           class="btn btn-file"
           data-lightbox="iframe"><button class="btn btn-outline-primary">Preview 16x9</button></a>

    </div>
    <div class="col-6">
        <a href="{{ \Storage::url('public/video_temp/user_' . $user->id . '/video_' . $video->id . '/smallPreviewVideo.mp4') }}"
           style="display: @if(file_exists(\Storage::path('public/video_temp/user_' . $user->id . '/video_' . $video->id . '/smallPreviewVideo.mp4'))) block @else none @endif"
           class="btn btn-file"
           data-lightbox="iframe"><button class="btn btn-outline-primary">Preview 1x1</button></a>
    </div>
</div>
