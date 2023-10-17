<div class="col-12">
    <div id="portfolio" class="portfolio row" data-layout="fitRows">
        @foreach ($data as $item)
            <article class="portfolio-item col-md-4 col-sm-6 col-12 pf-video">
                <div class="grid-inner">
                    <div class="portfolio-image">
                            <img src="{{ $item->galleryUrl('thumbnail') }}" alt="{{ $item->title }}">
                        <div class="action-buttons">
                            <div class="mb-2">
                                <a class="preview-link" href="{{ $item->galleryUrl('title_video') }}">
                                    <button class="preview-button">
                                        <span>Preview</span>
                                    </button>
                                </a>
                            </div>
                            <div>
                                @if(\Auth::guest() || \Auth::user()->canEditVideo())
                                    <a href="{{ route('video.customize', ['id' => $item->id, 'type' => 'subscription']) }}">
                                        <button class="preview-button">
                                            <span>Edit video</span>
                                        </button>
                                    </a>
                                @else
                                    @if(!\Auth::user()->canEditVideo())
                                        @php
                                        $subscription = \App\Models\Subscription::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)
                                        ->where('status', \App\Models\Subscription::STATUS_ACTIVE)->first();
                                        @endphp
                                        @if($subscription)
                                        <button class="preview-button additional_video_modal" data-videoid="{{ $item->id }}" data-videotitle="{{ $item->title }}">
                                            Edit video
                                        </button>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="portfolio-desc">
                        <h3>{{ $item->title }}</h3>
                    </div>
                </div>
            </article>
        @endforeach
    </div>


</div>
<script>
    $('.preview-link').magnificPopup({
        type: 'iframe',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
</script>
