@extends('template.layout')

@section('title', 'Just Share Media - Movie-Quality Roofing & Solar Videos')

@section('description', 'Just Share Media offers the largest library of cinematic, movie-quality roofing and solar videos as well as an easy-to-use video customizer all from a low-cost monthly subscription.')

@section('css_additional')
    <link rel="stylesheet" href="{{asset('/assets/css/vidbg.css')}}" />
    <link href="//cdn-images.mailchimp.com/embedcode/naked-10_7.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        #mc_embed_signup{ clear:left; }
        /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
    </style>
@endsection
@section('js_additional')
    <!-- Google Recaptcha -->
    {!! NoCaptcha::renderJs() !!}

    {{--    <script>--}}
    {{--        $(document).ready( function () {--}}

    {{--            --}}
    {{--             @if(is_null(request()->session()->previousUrl()) && !auth()->check())--}}
    {{--                 console.log('test')--}}
    {{--                setTimeout(--}}
    {{--                 function()--}}
    {{--                 {--}}
    {{--                     $('#email-opt-popup').modal('show');--}}
    {{--                 }, 1500);--}}
    {{--            @endif--}}

    {{--            $(document).on('submit', '#mc-embedded-subscribe-form', function () {--}}
    {{--                setTimeout(--}}
    {{--                    function()--}}
    {{--                    {--}}
    {{--                        $('#email-opt-popup-from-body').html(`<p class="email-opt-des px-2" style="font-size: 1rem;">--}}
    {{--                                Thank you for joining our list!<br>--}}
    {{--                                Make sure to saveyour coupon for checkout: <span class="font-weight-bold" style="color: #faf089">x8Ya13b</span>--}}
    {{--                            </p>`);--}}
    {{--                    }, 1000);--}}
    {{--            })--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection

@section('content')

    <div class="content-wrap py-0">
        <!-- New Hero Banner -->
        <div class="section m-0 dark min-vh-75" style='background: url(/assets/images/backgrounds/roof-hammer-dark.jpg);'>
            <div class="vertical-middle">
                <div class="min-vh-75 text-center m-0 d-flex flex-column justify-content-center">
                    <div>
                        <h1 class='jsm-home-title hp-color-white mb-0'>MOVIE QUALITY ROOFING VIDEOS</h1>
                        @if(!Auth::user())
                            <a href="{{route('signup')}}" class="btn hp-btn-primary btn-lg">GET STARTED</a>
                        @endif
                    </div>
                </div>

            </div>
            <div class="video-wrap">
                <div class="yt-bg-player"
                     data-quality="hd1080"
                     data-start="0"
                     data-stop="40"
                     data-video="https://www.youtube.com/watch?v=Z6bohgLZqeU"
                ></div>
            </div>
        </div>

        <div class="section bg-transparent my-sm-0 my-mob-0 pt-lg-5 my-lg-5">
            <div class="clearfix container hp-top-video-sec px-0">
                <div class="text-center">
                    <h1 class="hp-top-video-heading">World-class <span class="hp-color-primary font-weight-bold">roofing videos</span>, without breaking the bank.</h1>

                    <h2 class="hp-top-video-sub-heading">Recently added to our library</h2>
                </div>
                <!-- Portfolio Items -->
                <div id="portfolio" class="portfolio row grid-container gutter-30 mx-5 mt-5" data-layout="fitRows">

                    @if(isset($items))
                        @foreach ($items as $item)
                            <article class="portfolio-item col-md-4 col-sm-6 col-12 pf-video">
                                <div class="grid-inner">
                                    <div class="portfolio-image">
                                        <a href="{{ $item->galleryUrl("title_video") }}">
                                            <img src="{{ $item->galleryUrl('thumbnail') }}" alt="{{ $item->title }}">
                                        </a>
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content dark" data-hover-animate="fadeIn">
                                                <a href="{{ $item->galleryUrl('title_video') }}" class="overlay-trigger-icon bg-light text-dark" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350" data-lightbox="iframe"><i class="icon-line-play"></i></a>
                                            </div>
                                            <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"></div>
                                        </div>
                                    </div>
                                    <div class="portfolio-desc">
                                        <h3><a href="{{ $item->galleryUrl('title_video') }}">{{ $item->title }}</a></h3>
                                        <span>Video</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="section bg-transparent my-sm-0 my-mob-0 pt-mob-0 pt-sm-0 pt-lg-5 my-lg-5">
            <div class="vid-info-sec container px-0 container-sm">
                <div class="row d-lg-flex flex-lg-row d-sm-flex flex-sm-column-reverse flex-mob-column-reverse mx-mob-1">
                    <div class="col-lg-6">
                        <img class="vid-info-sec-img img-fluid" width="700" src="{{asset('assets/images/homepage/choose-video-section.png')}}" alt="Choose your video">
                    </div>
                    <div class="col-lg-6 d-lg-flex float-right flex-column min-vh-lg-50 justify-content-center pl-xl-6">
                        <div class="text-center text-lg-left pl-xl-6">
                            <h1 class="vid-info-sec-heading mb-2">
                                Choose your video
                            </h1>
                            <p class="vid-info-sec-des">
                                Our videos are meant to convert, <span class="hp-color-primary font-weight-bold">period</span>. Choose from cinematic promotional videos to emotional customer testimonials to motivational recruitment videos - <span class="hp-color-primary font-weight-bold">we cover all of your needs</span>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row d-lg-flex flex-lg-row d-sm-flex flex-sm-column mt-6 mx-mob-1">
                    <div class="col-lg-6 d-lg-flex float-left flex-column min-vh-lg-50 justify-content-center pr-xl-6">
                        <div class="text-center text-lg-right pr-xl-6">
                            <h1 class="vid-info-sec-heading mb-2">
                                Customize your video
                            </h1>
                            <p class="vid-info-sec-des mb-mob-0 mb-lg-auto">
                                With our intuitive and easy to use video customizer you can upload your logo, add creative text, or create a captivating message for homeowners, in minutes – <span class="hp-color-primary font-weight-bold"> no experience required. </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img class="vid-info-sec-img img-fluid" width="700" src="{{asset('assets/images/homepage/video-customizer-asset-min.png')}}" alt="Choose your video">
                    </div>
                </div>

                <div class="row d-lg-flex flex-lg-row d-sm-flex flex-sm-column-reverse flex-mob-column-reverse mt-6 mx-mob-1">
                    <div class="col-lg-6">
                        <img class="vid-info-sec-img img-fluid" width="700" src="{{asset('assets/images/homepage/video-export-asset.png')}}" alt="Choose your video">

                    </div>
                    <div class="col-lg-6 d-lg-flex float-right flex-column min-vh-lg-50 justify-content-center pl-xl-6">
                        <div class="text-center text-lg-left pl-xl-6">
                            <h1 class="vid-info-sec-heading mb-2">
                                Export your video
                            </h1>
                            <p class="vid-info-sec-des">
                                Download your video in both <span class="hp-color-primary font-weight-bold">1:1</span> and <span class="hp-color-primary font-weight-bold">16:9</span>, two standard video file sizes needed to start promoting your business. Get automated reminders when it’s time to license a new video each month.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="strategy-call-sec">
            <div class="sec-slope">
                <div class="sec-slope-bg"></div>
                <div class="row">
                    <div class="col-12">
                        <h1 class="hp-color-white sec-slope-heading text-center">Not sure where to start?</h1>
                    </div>
                </div>
            </div>
            <div class="section hp-bg-color-secondary pt-0 my-0">
                <div class="container px-lg-6 ">
                    <div class="row mt-6 mx-mob-1">
                        <div class="col-lg-6 col-sm-12 px-lg-5 px-md-0 d-flex flex-column justify-content-center">
                            <h3 class="mb-0 subsection-heading">
                                Videos for roofers, by roofers
                            </h3>
                            <p class="subsection-description">
                                Not only are we the best at creating highly engaging stock roofing videos - we are roofers by trade.
                                Our team is standing by to help you with choosing the best video for your business and getting started, today!
                            </p>

                        </div>
                        <div class="col-lg-6 col-sm-12 px-md-0">
                            <form id="strategy-call-sec-form" method="POST" action="/">
                                @csrf

                                @if (isset($contactSuccess))
                                    <div class="alert alert-success">
                                        <i class="icon-line-check-circle"></i><strong>Thank you!</strong> We will be in touch to schedule your call.
                                    </div>
                                @endif

                                @if (! $errors->isEmpty())
                                    <div class="alert alert-danger">
                                        <i class="icon-exclamation-circle"></i><strong>Sorry!</strong> An error occurred with your request. Please check your fields and try again.
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <div class="input-group">
                                                <input type='text'
                                                       id="firstName"
                                                       name='firstName'
                                                       maxlength='255'
                                                       class="form-control @error('firstName') is-invalid @enderror"
                                                       placeholder='First Name'
                                                       value="{{ old('firstName') }}"
                                                       style='background-color:#EEE !important;'>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style='background-color:#EEE !important;'>
                                                        <i class="icon-user"></i>
                                                    </span>
                                                </div>
                                                @error('firstName')
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('firstName') }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <div class="input-group">
                                                <input type='text'
                                                       id="lastName"
                                                       name='lastName'
                                                       maxlength='255'
                                                       class="form-control @error('lastName') is-invalid @enderror"
                                                       placeholder='Last Name'
                                                       value="{{ old('lastName') }}"
                                                       style='background-color:#EEE !important;'>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style='background-color:#EEE !important;'>
                                                        <i class="icon-user"></i>
                                                    </span>
                                                </div>
                                                @if ($errors->has('lastName'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('lastName') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="companyName">Company Name</label>
                                            <div class="input-group">
                                                <input type='text'
                                                       id="companyName"
                                                       name='companyName'
                                                       maxlength='255'
                                                       class="form-control @error('companyName') is-invalid @enderror"
                                                       placeholder='Company Name'
                                                       value="{{ old('companyName') }}"
                                                       style='background-color:#EEE !important;'>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style='background-color:#EEE !important;'>
                                                        <i class="icon-house-user"></i>
                                                    </span>
                                                </div>
                                                @if ($errors->has('companyName'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('companyName') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <div class="input-group">
                                                <input type='text'
                                                       id="phone"
                                                       name='phone'
                                                       maxlength='255'
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       placeholder='Phone Number'
                                                       value="{{ old('phone') }}"
                                                       style='background-color:#EEE !important;'>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style='background-color:#EEE !important;'>
                                                        <i class="icon-phone"></i>
                                                    </span>
                                                </div>
                                                @if ($errors->has('phone'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('phone') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 form-group">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <div class="input-group">
                                                <input type='text'
                                                       id="email"
                                                       name='email'
                                                       maxlength='255'
                                                       class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                       placeholder='Email Address'
                                                       value="{{ old('email') }}"
                                                       style='background-color:#EEE !important;'>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style='background-color:#EEE !important;'>
                                                        <i class="icon-email"></i>
                                                    </span>
                                                </div>
                                                @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 form-group text-center">
                                    <div style='display:inline-block;'>
                                        {!! NoCaptcha::display() !!}
                                    </div>

                                    @if ($errors->has('g-recaptcha-response'))
                                        <br/>
                                        <span class="help-block" style='color:red;'>
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <button class="btn hp-btn-light btn-lg w-100" type="submit" id="submit" name="submit" value="submit">Send Message</button>
                                {{--                        <div class="col-12 form-group text-center">--}}
                                {{--                        </div>--}}
                            </form>
                        </div>
                    </div>
                    <h1 class="text-center px-lg-5 mt-6 pb-6">
                        Join the countless roofing companies that are <span class="hp-color-primary font-italic">dominating</span> their digital presence online.
                    </h1>
                    <div class="row mt-6 mx-mob-1">
                        <div class="col-lg-5 col-sm-12 d-flex flex-column justify-content-center px-lg-5">
                            <h3 class="mb-0 subsection-heading">
                                Take control of your brand.
                            </h3>
                            <p class="subsection-description">
                                Ever imaging having to <span class="font-italic font-weight-bold">turn off</span> your lead generation efforts? stop chasing leads and
                                start building a brand that customers know and trust. Through highly engaging and cinematic videos, your roofing company
                                will stand out as the DOMINATE business in your area.
                            </p>
                        </div>
                        <div class="col-lg-7 col-sm-12 w-100 h-100">
                            <iframe height="375" allow="autoplay" allowfullscreen="allowfullscreen"
                                    src="https://www.youtube.com/embed/hjmWOxNBsUQ?autoplay=1&rel=0&controls=1&mute=1">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="more-custom-sec">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h1 class="more-custom-sec-heading mb-6">Looking for something a little more custom?</h1>
                        <p class="px-lg-5 more-custom-sec-des">
                            Our library of <countles></countles>s cinematic roofing videos is great for any sized business, but if you are looking for something to take your business even further, we also offer custom videography packages tailored to the unique needs of your business.
                        </p>
                        <a href="#strategy-call-sec-form" class="btn btn-lg py-3 px-4 rounded-xxxl more-custom-sec-btn hp-btn-primary font-weight-bold">Get a quote now</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="section bg-transparent our-work-section my-0">
            <div class="container text-center">
                <h1 class="our-work-section-heading">Check out some of our work!</h1>
                <div class="row p-5">
                    <div class="col-lg-4 min-vh-25 d-flex flex-column justify-content-between align-content-center mb-mob-1 mb-sm-3">
                        <div class="d-flex flex-row justify-content-center">
                            <img class="img-fluid" src="{{asset('assets/images/logos/roof-repair-squad-logo.png')}}" width="200">
                        </div>
                        <iframe width="350"
                                height="196"
                                src="https://www.youtube.com/embed/i9Bw4iqv9wQ"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                    <div class="col-lg-4 min-vh-25 d-flex flex-column justify-content-between mt-sm-5 mt-md-5 mt-lg-0 mb-mob-1 mb-sm-3">
                        <div class="d-flex flex-row justify-content-center">
                            <img class="img-fluid" src="{{asset('assets/images/logos/cmr-logo.png')}}" width="150">
                        </div>
                        <iframe
                            width="350"
                            height="196"
                            src="https://www.youtube.com/embed/BnNv-wpxj_w"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <div class="col-lg-4 min-vh-25 d-flex flex-column justify-content-between mt-sm-5 mt-md-5 mt-lg-0 mb-mob-1 mb-sm-3">
                        <div class="d-flex flex-row justify-content-center">
                            <img class="img-fluid" src="{{asset('assets/images/logos/blueins-logo.png')}}" width="150">
                        </div>

                        <iframe
                            width="350"
                            height="196"
                            src="https://www.youtube.com/embed/xxWEfltjcYM"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->


        {{--    <div class="modal fade p-0" id="email-opt-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
        {{--        <div class="modal-dialog modal-lg mt-lg-6 " role="document">--}}
        {{--            <div class="modal-content hp-bg-color-primary rounded-xxxl border-0 shadow-lg shadow">--}}
        {{--                <button type="button" class="close opt-popup-btn-close" data-dismiss="modal" aria-label="Close">--}}
        {{--                    <img src="{{asset('assets/images/md-close.png')}}">--}}
        {{--                </button>--}}
        {{--                <div class="modal-body text-center p-5">--}}
        {{--                    <h1 class="email-opt-heading mb-2">Want your first video for only $1?</h1>--}}
        {{--                    <p class="email-opt-des px-2">--}}
        {{--                        Sign-up today and get your first month for only $1! Get access to countless movie-quality roofing and--}}
        {{--                        solar videos to promote your business with, today.--}}
        {{--                    </p>--}}

        {{--                    <div class="row">--}}
        {{--                        <div class="col-12 px-lg-5" id="email-opt-popup-from-body">--}}
        {{--                            <div id="mc_embed_signup">--}}
        {{--                                <form action="https://justsharemedia.us1.list-manage.com/subscribe/post?u=3121674a8058b677851ad5e9c&amp;id=1042c2e3b8"--}}
        {{--                                      method="post"--}}
        {{--                                      id="mc-embedded-subscribe-form"--}}
        {{--                                      name="mc-embedded-subscribe-form"--}}
        {{--                                      class="validate"--}}
        {{--                                      target="_blank"--}}
        {{--                                      -novalidate>--}}
        {{--                                    <div id="mc_embed_signup_scroll">--}}
        {{--                                        <div class="mc-field-group">--}}
        {{--                                            <label for="mce-EMAIL">Email Address </label>--}}
        {{--                                            <input--}}
        {{--                                                    type="email"--}}
        {{--                                                    value=""--}}
        {{--                                                    name="EMAIL"--}}
        {{--                                                    placeholder="😎   Your email goes here...*"--}}
        {{--                                                    class="required form-control p-4 mb-3"--}}
        {{--                                                    id="mce-EMAIL">--}}
        {{--                                        </div>--}}
        {{--                                        <div id="mce-responses" class="clear">--}}
        {{--                                            <div class="response" id="mce-error-response" style="display:none"></div>--}}
        {{--                                            <div class="response" id="mce-success-response" style="display:none"></div>--}}
        {{--                                        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->--}}
        {{--                                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_3121674a8058b677851ad5e9c_1042c2e3b8" tabindex="-1" value=""></div>--}}
        {{--                                        <div class="clear">--}}
        {{--                                            <input type="submit" value="Find out how!" name="subscribe" id="mc-embedded-subscribe" class="btn btn-lg btn-light w-100 hp-color-primary font-weight-bold opt-popup-submit">--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </form>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <!--End mc_embed_signup-->--}}

        {{--                    <p class="mb-0 mt-4 opt-popup-bottom-line">* We Respect Your Privacy - We Will Not Sell, Rent Or Spam Your Email... *</p>--}}


        {{--                </div>--}}

        {{--            </div>--}}
        {{--        </div>--}}
        {{--    </div>--}}

    </div>

@endsection
