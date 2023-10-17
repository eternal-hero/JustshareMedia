<input class="btn btn-success" type="button" id="preview-button" value="Preview">
<a href="{{route('public.gallery')}}" class="btn btn-secondary">Back</a>
@if(file_exists(\Storage::path('public/video_temp/user_' . $user->id . '/video_' . $video->id . '/bigPreviewVideo.mp4')))
    <input class="btn btn-primary" type="submit" value="Next">
@endif
