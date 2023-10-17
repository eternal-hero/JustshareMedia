@extends('template.layout')

{{--@section('title', 'Signup | Just Share Media')--}}
@section('title', 'Signup | Just Share Media')

@section('description', 'Sign up for a new subscription.')

@section('css_additional')
    <link rel="stylesheet" href="{{asset('assets/css/signup.css')}}"/>
@endsection

@section('content')
    <div class="hero-section" style="background-image: url({{ asset('assets/images/signup/roof.png') }});">
        <div class="hero-section-title">
            <h1 class="text"><span class="signup-main-color">roofing and <span class="solar-color">solar</span> videos</span> that help you
                <span>sell more jobs</span></h1>
        </div>
        <div class="hero-section-text">
            <div class="text">seriously, already millions in revenue generated with our videos</div>
        </div>
        <div class="signup-btn create-video-btn">CREATE VIDEO</div>
    </div>
    <div class="explain-section container">
        <div class="explain-section-title">minutes away from your first video</div>
        <div class="explain-section-icons">
            <div class="explain-section-icon">
                <img src="{{  asset('assets/images/signup/icon1.png') }}" width="75px" alt="">
                <span>Choose from hundreds of turn-key videos.</span>
            </div>
            <div class="explain-section-icon">
                <img src="{{  asset('assets/images/signup/icon2.png') }}" width="90px" alt="">
                <span>Customize the video to your brand.</span>
            </div>
            <div class="explain-section-icon">
                <img src="{{  asset('assets/images/signup/icon3.png') }}" width="78px" alt="">
                <span>Export your video and watch your revenue grow.</span>
            </div>
        </div>
    </div>
    <div id="createvideo"></div>
    <div class="signup-section container">
        <div class="packages">
            <div class="go-to-step1">
                <img src="{{  asset('assets/images/signup/edit_details.png') }}" alt="">
                <div>edit details</div>
            </div>
            <div class="packages-choose">
                <img class="annualArrow" src="{{  asset('assets/images/signup/annual_arrow.png') }}" alt="">
                <div class="monthly packages-choose-active">MONTHLY</div>
                <div class="annual">ANNUAL</div>
            </div>
            <div class="monthly-package package active-package">
                <div class="package-title">
                    Inside the package
                </div>
                <div class="package-description">
                    <div>Paid monthly (no commitment)</div>
                    <div>1 video per month</div>
                    <div>Unlimited videos to choose from</div>
                    <div>Buy more video feature included</div>
                    <div style="text-decoration: line-through">Your video posted for you</div>
                </div>
                <div class="package-prices">
                    <div class="package-price"><span>${{ $contractPrice }}</span><span class="price-month">/mo</span>
                    </div>
                </div>
            </div>
            <div class="annual-package package">
                <div class="package-title">
                    Inside the package
                </div>
                <div class="package-description">
                    <div>Paid annually <span class="annual-color">(save $1200!)</span></div>
                    <div>1 video per month <span class="annual-color">(12 total videos!)</span></div>
                    <div>Unlimited videos to choose from</div>
                    <div>Buy more video feature included</div>
                    <div>Your video posted for you</div>
                </div>
                <div class="package-prices">
                    <div class="package-price package-price-old"><span
                            class="lineThrough">${{ $contractPrice }}</span><span class="price-month">/mo</span></div>
                    <div class="package-price package-price-discounted"><span>${{ $annualPrice }}</span><span
                            class="price-month">/mo</span></div>
                </div>
            </div>
        </div>
        <div class="signup-step signup-step1 signup-step-active">
            <div class="step-title">Start making videos today</div>
            <div class="field-wrapper">
                <input type="text" name="" class="step1name">
                <div class="field-placeholder"><span>FULL NAME</span></div>
            </div>
            <div class="error name-error"></div>
            <div class="field-wrapper">
                <input type="email" name="" class="step1email">
                <div class="field-placeholder"><span>EMAIL</span></div>
            </div>
            <div class="error email-error"></div>
            <div class="field-wrapper">
                <input type="password" name="" class="step1password">
                <div class="field-placeholder"><span>PASSWORD</span></div>
            </div>
            <div class="error password-error"></div>
            <div class="field-wrapper">
                <input type="text" name="" class="step1zip">
                <div class="field-placeholder"><span>BILLING ZIP CODE</span></div>
            </div>
            <div class="error zip-error"></div>
            <div class="signup-btn get-started-btn">GET STARTED</div>
        </div>
        <div class="signup-step signup-step2">
            <div class="step-title">Add your payment details</div>
            <div class="field-wrapper">
                <input type="text" name="" class="step2cardholder">
                <div class="field-placeholder"><span>CARDHOLDER NAME</span></div>
            </div>
            <div class="error cardholder-error"></div>
            <div class="field-wrapper">
                <input type="text" name="" class="step2cardnumber">
                <div class="field-placeholder"><span>CARD NUMBER</span></div>
            </div>
            <div class="error cardnumber-error"></div>
            <div class="one-row-field-wrapper">
                <div class="field-wrapper">
                    <input class="expDate" maxlength='5' placeholder="MM/YY" type="text">
                    <input type="hidden" name="SecureCard-expiryMonth" class="step2expMonth">
                    <input type="hidden" name="SecureCard-expiryYear" class="step2expYear">
                </div>
                <div class="field-wrapper">
                    <input type="password" name="" class="step2cvv">
                    <div class="field-placeholder"><span>CVV</span></div>
                </div>
                <div class="field-wrapper">
                    <input type="text" name="" class="step2coupon">
                    <div class="field-placeholder"><span class="step2couponText">COUPON CODE</span></div>
                </div>
            </div>
            <div class="error exp-error"></div>
            <div class="error cvv-error"></div>
            <div class="summary">
                <div class="summary-subtotal summary-item">
                    <div>Sub total:</div>
                    <div class="subtotalVal"></div>
                </div>
                <div class="summary-subtotal summary-item discount-summary">
                    <div>Discount:</div>
                    <div class="discountVal">$0</div>
                </div>
                <div class="summary-subtotal summary-item">
                    <div>Tax(<span class="taxRateVal"></span>):</div>
                    <div class="taxVal"></div>
                </div>
                <div class="summary-subtotal summary-item">
                    <div>Total:</div>
                    <div class="totalVal"></div>
                </div>
            </div>
            <div class="error general-error"></div>
            {!! NoCaptcha::display() !!}
            <div class="signup-btn confirm-btn">CONFIRM ORDER</div>
            <div class="toc">By proceeding you confirm you agree with the <a class="signup-main-color" target="_blank"
                                                                             href="{{ route('terms-conditions') }}">Terms
                    and Conditions.</a></div>
        </div>
    </div>
    <div class="brands-section">
        <div class="brands-section-title">Brands that use our videos</div>
        <div class="brands">
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{  asset('assets/images/signup/brand1.png') }}" alt="">
                </div>
                <div class="brand-video">
                    <iframe src="https://www.youtube.com/embed/i9Bw4iqv9wQ" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen="" id="fitvid0">
                    </iframe>
                </div>
            </div>
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{  asset('assets/images/signup/brand2.png') }}" alt="">
                </div>
                <div class="brand-video">
                    <iframe src="https://www.youtube.com/embed/BnNv-wpxj_w" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen="" id="fitvid0">
                    </iframe>
                </div>
            </div>
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{  asset('assets/images/signup/brand3.png') }}" alt="">
                </div>
                <div class="brand-video">
                    <iframe src="https://www.youtube.com/embed/xxWEfltjcYM" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen="" id="fitvid0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonials-section container">
        <div class="halfstar halfstar1">
            <img src="{{  asset('assets/images/signup/halfstar.png') }}" alt="">
        </div>
        <div class="halfstar halfstar2">
            <img src="{{  asset('assets/images/signup/halfstar.png') }}" alt="">
        </div>
        <div class="halfstar halfstar3">
            <img src="{{  asset('assets/images/signup/halfstar.png') }}" alt="">
        </div>
        <div class="star star1">
            <img src="{{  asset('assets/images/signup/star.png') }}" alt="">
        </div>
        <div class="star star2">
            <img src="{{  asset('assets/images/signup/star.png') }}" alt="">
        </div>
        <div class="star star3">
            <img src="{{  asset('assets/images/signup/star.png') }}" alt="">
        </div>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="upperQuote" src="{{  asset('assets/images/signup/upper_quote.png') }}" alt="">
                    <img class="bottomQuote" src="{{  asset('assets/images/signup/bottom_quote.png') }}" alt="">
                    <img class="testimonial-img" src="{{  asset('assets/images/signup/quote1.jfif') }}" alt="">
                    <div class="testimonial-name">Phillip Waldeck</div>
                    {{--                    <div class="testimonial-company">Company</div>--}}
                    <div class="testimonial-content">Just Share Media has completely improved my company. Within 30
                        days of my first Just Share Media video I saw an additional $700k in sales.
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="upperQuote" src="{{  asset('assets/images/signup/upper_quote.png') }}" alt="">
                    <img class="bottomQuote" src="{{  asset('assets/images/signup/bottom_quote.png') }}" alt="">
                    <img class="testimonial-img" src="{{  asset('assets/images/signup/quote2.jfif') }}" alt="">
                    <div class="testimonial-name">Aaron Schwartz</div>
                    {{--                    <div class="testimonial-company">Company</div>--}}
                    <div class="testimonial-content">This is not just stock videos. These are very high quality and
                        become exclusive to you once you have selected one. So that means your competition isn’t
                        getting the same videos as you. The price is great. Allen has gone above and beyond getting
                        me started out with marketing. He will personally do the work and make sure that you are
                        taken care of 100%. 10/10 recommend Just Share Media for your personal, high quality
                        marketing videos
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="upperQuote" src="{{  asset('assets/images/signup/upper_quote.png') }}" alt="">
                    <img class="bottomQuote" src="{{  asset('assets/images/signup/bottom_quote.png') }}" alt="">
                    <img class="testimonial-img" src="{{  asset('assets/images/signup/quote3.jfif') }}" alt="">
                    <div class="testimonial-name">Nick Peret</div>
                    {{--                        <div class="testimonial-company">Company</div>--}}
                    <div class="testimonial-content">Just Share Media is one of my favorite vendors in the roofing
                        industry. They make extremely high quality videos and are great to work with. We used them
                        to launch our rebrand and it turned out awesome!!
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="upperQuote" src="{{  asset('assets/images/signup/upper_quote.png') }}" alt="">
                    <img class="bottomQuote" src="{{  asset('assets/images/signup/bottom_quote.png') }}" alt="">
                    <img class="testimonial-img" src="{{  asset('assets/images/signup/quote4.jfif') }}" alt="">
                    <div class="testimonial-name">Ryan Blevins</div>
                    {{--                        <div class="testimonial-company">Company</div>--}}
                    <div class="testimonial-content">Best company around for <img
                            src="{{  asset('assets/images/signup/fire.png') }}" alt=""> roofing videos!
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="upperQuote" src="{{  asset('assets/images/signup/upper_quote.png') }}" alt="">
                    <img class="bottomQuote" src="{{  asset('assets/images/signup/bottom_quote.png') }}" alt="">
                    <img class="testimonial-img" src="{{  asset('assets/images/signup/quote5.jfif') }}" alt="">
                    <div class="testimonial-name">Matt Knez</div>
                    {{--                        <div class="testimonial-company">Company</div>--}}
                    <div class="testimonial-content">Just Share Media makes the best videos I have ever seen. I'm not on
                        the annual subscription I am a customer for life!
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="recently-added-section">
        <div class="recently-added-section-title">
            Recently added to our library
        </div>
        @if(isset($recentItems))
            <div class="portfolio">
                @foreach ($recentItems as $item)
                    <article class="portfolio-item pf-video">
                        <div class="grid-inner">
                            <div class="portfolio-image">
                                <a href="{{ $item->galleryUrl("title_video") }}">
                                    <img src="{{ $item->galleryUrl('thumbnail') }}" alt="{{ $item->title }}">
                                </a>
                                <div class="bg-overlay">
                                    <div class="bg-overlay-content dark" data-hover-animate="fadeIn">
                                        <a href="{{ $item->galleryUrl('title_video') }}"
                                           class="overlay-trigger-icon bg-light text-dark"
                                           data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall"
                                           data-hover-speed="350" data-lightbox="iframe"><i class="icon-line-play"></i></a>
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
            </div>
        @endif
    </div>
    <div class="calendly-section">
        <div class="calendly-section-title">
            More questions?
        </div>
        <div class="calendly-section-text">
            Book a call with one of our team members, we'll answer all of your questions.
        </div>
        <div class="calendly-iframes" style="width: 100%">
            <iframe height="1200px" src="https://calendly.com/justshare/30min" frameborder="0"></iframe>
            <iframe height="1200px" src="https://calendly.com/curtisjsm/60min" frameborder="0"></iframe>
        </div>
    </div>
    <div class="confetti" style="justify-content: normal;">
        <img class="animation" src="{{  asset('assets/images/signup/animation.gif') }}" alt="">
{{--        <img class="confetti-img" src="{{  asset('assets/images/signup/confetti.gif') }}" alt="">--}}
        <div class="confetti-title">Welcome to Just Share Media!</div>
        <div class="confetti-text">Let’s finish setting up your account.</div>
        <a class="signup-btn" href="{{ route('dashboard.profile') }}">Go to my profile</a>
    </div>
@endsection

@section('js_additional')
    {!! NoCaptcha::renderJs() !!}
    {{--    <script async--}}
    {{--            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&libraries=places&callback=initGeocode">--}}
    {{--    </script>--}}
    <script>

        let term = 'contract'
        let currentStep = 1

        let state = null
        let taxRate = null
        let taxValue = null
        let subTotal = null
        let total = null
        let couponValue = null
        let couponLoadingInterval = null

        let getStartedBtnLoading = false
        let confirmBtnLoading = false

        $('.create-video-btn').click(function () {
            document.getElementById('createvideo').scrollIntoView();
        })

        $('.go-to-step1').click(function () {
            couponValue = null;
            $('.step2coupon').val('')
            $('.go-to-step1').removeClass('go-to-step1-visible')
            $('.signup-step2').removeClass('signup-step-active')
            $('.signup-step1').addClass('signup-step-active')
            $('.packages').removeClass('packages-step2')
        })

        const checkStep1 = function () {
            const name = $('.step1name').val()
            const email = $('.step1email').val()
            const password = $('.step1password').val()
            const zip = $('.step1zip').val()
            if (getState(zip) !== 'none') {
                state = getState(zip)
            }
            $.ajax({
                type: "POST",
                url: "/check-step1",
                data: {
                    _token: '{{ csrf_token() }}',
                    term: term,
                    name: name,
                    email: email,
                    password: password,
                    state: getState(zip)
                },
                dataType: 'json',
                success: function (data) {
                    getStartedBtnLoading = false
                    $('.get-started-btn').html('GET STARTED')
                    confirmBtnLoading = false
                    $('.confirm-btn').html('CONFIRM ORDER')
                    taxRate = data.price.tax_rate
                    taxValue = data.price.tax
                    subTotal = data.price.original_price
                    total = data.price.price
                    state = data.state

                    $('.subtotalVal').html('$' + subTotal)
                    $('.taxRateVal').html(taxRate + '%')
                    $('.taxVal').html('$' + taxValue)
                    $('.totalVal').html('$' + total)
                    if(couponValue>0) {
                        $('.discountVal').parent().addClass('applied')
                        $('.step2coupon').addClass('applied')
                        $('.step2couponText').addClass('applied')
                    } else {
                        $('.discountVal').parent().removeClass('applied')
                        $('.step2coupon').removeClass('applied')
                        $('.step2couponText').removeClass('applied')
                    }
                    $('.discountVal').html(couponValue ? '$' + couponValue : '$0')

                    currentStep = 2

                    $('.signup-step1').removeClass('signup-step-active')
                    $('.signup-step2').addClass('signup-step-active')
                    $('.go-to-step1').addClass('go-to-step1-visible')
                    $('.packages').addClass('packages-step2')
                },
                error: function (err) {
                    getStartedBtnLoading = false
                    $('.get-started-btn').html('GET STARTED')
                    confirmBtnLoading = false
                    $('.confirm-btn').html('CONFIRM ORDER')
                    const errors = err.responseJSON.errors
                    console.log(errors.name)
                    if (errors.name !== undefined) {
                        console.log(errors.name[0])
                        $('.name-error').html(errors.name[0])
                    }
                    if (errors.email !== undefined) {
                        console.log(errors.email[0])
                        $('.email-error').html(errors.email[0])
                    }
                    if (errors.password !== undefined) {
                        console.log(errors.password[0])
                        $('.password-error').html(errors.password[0])
                    }
                    if (errors.zip !== undefined) {
                        console.log(errors.zip[0])
                        $('.zip-error').html(errors.zip[0])
                    }
                    if (errors.state !== undefined) {
                        // console.log(errors.zip[0])
                        $('.zip-error').html('Please enter valid zip code.')
                    }
                }
            })
        }

        $('.step2coupon').keyup(function () {
            if (couponLoadingInterval) {
                clearTimeout(couponLoadingInterval)
            }
            couponLoadingInterval = setTimeout(function () {
                confirmBtnLoading = true
                $('.confirm-btn').html('LOADING...')
                couponValue = null
                $.ajax({
                    type: "POST",
                    url: "/validate-coupon",
                    data: {
                        _token: '{{ csrf_token() }}',
                        term: term,
                        state_code: state,
                        coupon: $('.step2coupon').val(),
                        plan: 1,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.couponValue) {

                            couponValue = data.couponValue
                        }
                        taxRate = data.tax_rate
                        taxValue = data.tax
                        subTotal = data.origSubTotal
                        total = data.total

                        $('.subtotalVal').html('$' + subTotal)
                        $('.taxRateVal').html(taxRate + '%')
                        $('.taxVal').html('$' + taxValue)
                        $('.totalVal').html('$' + total)

                        console.log(parseFloat(couponValue))

                        if(parseFloat(couponValue)>0) {
                            $('.discountVal').parent().addClass('applied')
                            $('.step2coupon').addClass('applied')
                            $('.step2couponText').addClass('applied')
                        } else {
                            $('.discountVal').parent().removeClass('applied')
                            $('.step2coupon').removeClass('applied')
                            $('.step2couponText').removeClass('applied')
                        }
                        $('.discountVal').html(couponValue ? '$' + couponValue : '$0')
                        confirmBtnLoading = false
                        $('.confirm-btn').html('CONFIRM ORDER')
                    },
                    error: function (err) {
                        confirmBtnLoading = false
                        $('.confirm-btn').html('CONFIRM ORDER')
                        console.log(err)
                    }
                })
            }, 500)
        })


        $('.monthly').click(function () {
            term = 'contract'
            if (currentStep === 2) {
                clearTimeout(couponLoadingInterval)
                $('.step2coupon').val('')
                $('.discountVal').html('0$')
                $('.discountVal').parent().removeClass('applied')
                $('.step2coupon').removeClass('applied')
                $('.step2couponText').removeClass('applied')
                confirmBtnLoading = true
                $('.confirm-btn').html('LOADING...')
                couponValue = null
                checkStep1()
            }
            $('.monthly').addClass('packages-choose-active')
            $('.annual').removeClass('packages-choose-active')
            $('.monthly-package').addClass('active-package')
            $('.annual-package').removeClass('active-package')
        })

        $('.annual').click(function () {
            term = 'yearly'
            if (currentStep === 2) {
                clearTimeout(couponLoadingInterval)
                $('.step2coupon').val('')
                $('.discountVal').html('0$')
                $('.discountVal').parent().removeClass('applied')
                $('.step2coupon').removeClass('applied')
                $('.step2couponText').removeClass('applied')
                confirmBtnLoading = true
                $('.confirm-btn').html('LOADING...')
                couponValue = null
                checkStep1()
            }
            $('.monthly').removeClass('packages-choose-active')
            $('.annual').addClass('packages-choose-active')
            $('.monthly-package').removeClass('active-package')
            $('.annual-package').addClass('active-package')
        })

        $('.get-started-btn').click(function () {
            if (!getStartedBtnLoading) {
                $('.error').html('')
                getStartedBtnLoading = true
                $(this).html('LOADING...')
                checkStep1()
            }

        })

        $('.confirm-btn').click(function () {
            if (!confirmBtnLoading) {
                $('.error').html('')
                confirmBtnLoading = true
                $('.confirm-btn').html('LOADING...')
                const registrationData = {
                    _token: '{{ csrf_token() }}',
                    term: term,
                    email: $('.step1email').val(),
                    password: $('.step1password').val(),
                    password_confirmation: $('.step1password').val(),
                    name: $('.step1name').val(),
                    zip: $('.step1zip').val(),
                    cardnumber: $('.step2cardnumber').val(),
                    cardholder: $('.step2cardholder').val(),
                    cvv: $('.step2cvv').val(),
                    expmonth: $('.step2expMonth').val(),
                    expyear: $('.step2expYear').val(),
                    coupon: $('.step2coupon').val(),
                    state: state,
                    g_recaptcha_response: grecaptcha.getResponse(),
                }

                $.ajax({
                    type: "POST",
                    url: "/register",
                    data: registrationData,
                    dataType: 'json',
                    success: function (data) {
                        grecaptcha.reset();
                        confirmBtnLoading = false
                        $('.confirm-btn').html('CONFIRM ORDER')
                        console.log(data)
                        if (data.result === 'error') {
                            if (data.message === 'DeclinedPayment') {
                                $('.general-error').html('Payment failed to process, please check your card details and balance and try again.')
                            } else if (data.message === 'DeclinedProfile') {
                                $('.general-error').html('Creating payment account failed, please check your card details and balance and try again.')
                            } else {
                                $('.general-error').html('Signup failed, pleas contact us.')
                            }
                        }
                        if (data.result === 'success') {
                            $('.confetti').addClass('confetti-visible')
                        }
                    },
                    error: function (err) {
                        grecaptcha.reset();
                        confirmBtnLoading = false
                        $('.confirm-btn').html('CONFIRM ORDER')
                        const errors = err.responseJSON.errors
                        console.log(errors.name)
                        if (errors.cardholder !== undefined) {
                            console.log(errors.cardholder[0])
                            $('.cardholder-error').html(errors.cardholder[0])
                        }
                        if (errors.cardnumber !== undefined) {
                            console.log(errors.cardnumber[0])
                            $('.cardnumber-error').html(errors.cardnumber[0])
                        }
                        if (errors.cvv !== undefined) {
                            console.log(errors.cvv[0])
                            $('.cvv-error').html(errors.cvv[0])
                        }
                        if (errors.expmonth !== undefined) {
                            console.log(errors.expmonth[0])
                            $('.exp-error').html(errors.expmonth[0])
                        }
                        if (errors.expyear !== undefined) {
                            console.log(errors.expyear[0])
                            $('.exp-error').html(errors.expyear[0])
                        }
                    }
                })
            }


        })

        var expiryMask = function () {
            var inputChar = String.fromCharCode(event.keyCode);
            var code = event.keyCode;
            var allowedKeys = [8];
            if (allowedKeys.indexOf(code) !== -1) {
                return;
            }

            event.target.value = event.target.value.replace(
                /^([1-9]\/|[2-9])$/g, '0$1/'
            ).replace(
                /^(0[1-9]|1[0-2])$/g, '$1/'
            ).replace(
                /^([0-1])([3-9])$/g, '0$1/$2'
            ).replace(
                /^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2'
            ).replace(
                /^([0]+)\/|[0]+$/g, '0'
            ).replace(
                /[^\d\/]|^[\/]*$/g, ''
            ).replace(
                /\/\//g, '/'
            );
        }

        var splitDate = function ($domobj, value) {
            var regExp = /(1[0-2]|0[1-9]|\d)\/(20\d{2}|19\d{2}|0(?!0)\d|[1-9]\d)/;
            var matches = regExp.exec(value);
            $domobj.siblings('input[name$="expiryMonth"]').val(matches[1]);
            $domobj.siblings('input[name$="expiryYear"]').val(matches[2]);
        }

        $('.expDate').on('keyup', function () {
            expiryMask();
        });

        $('.expDate').on('focusout', function () {
            splitDate($(this), $(this).val());
        });


        $(".field-wrapper .field-placeholder").on("click", function () {
            $(this).closest(".field-wrapper").find("input").focus();
        });
        $(".field-wrapper input").on("keyup", function () {
            var value = $.trim($(this).val());
            if (value) {
                $(this).closest(".field-wrapper").addClass("hasValue");
            } else {
                $(this).closest(".field-wrapper").removeClass("hasValue");
            }
        });

        function getState(zipString) {

            /* Ensure param is a string to prevent unpredictable parsing results */
            if (typeof zipString !== 'string') {
                console.log('Must pass the zipcode as a string.');
                return;
            }

            /* Ensure we have exactly 5 characters to parse */
            if (zipString.length !== 5) {
                console.log('Must pass a 5-digit zipcode.');
                return;
            }

            /* Ensure we don't parse strings starting with 0 as octal values */
            const zipcode = parseInt(zipString, 10);

            let st;
            let state;

            /* Code cases alphabetized by state */
            if (zipcode >= 35000 && zipcode <= 36999) {
                st = 'AL';
                state = 'Alabama';
            } else if (zipcode >= 99500 && zipcode <= 99999) {
                st = 'AK';
                state = 'Alaska';
            } else if (zipcode >= 85000 && zipcode <= 86999) {
                st = 'AZ';
                state = 'Arizona';
            } else if (zipcode >= 71600 && zipcode <= 72999) {
                st = 'AR';
                state = 'Arkansas';
            } else if (zipcode >= 90000 && zipcode <= 96699) {
                st = 'CA';
                state = 'California';
            } else if (zipcode >= 80000 && zipcode <= 81999) {
                st = 'CO';
                state = 'Colorado';
            } else if ((zipcode >= 6000 && zipcode <= 6389) || (zipcode >= 6391 && zipcode <= 6999)) {
                st = 'CT';
                state = 'Connecticut';
            } else if (zipcode >= 19700 && zipcode <= 19999) {
                st = 'DE';
                state = 'Delaware';
            } else if (zipcode >= 32000 && zipcode <= 34999) {
                st = 'FL';
                state = 'Florida';
            } else if ((zipcode >= 30000 && zipcode <= 31999) || (zipcode >= 39800 && zipcode <= 39999)) {
                st = 'GA';
                state = 'Georgia';
            } else if (zipcode >= 96700 && zipcode <= 96999) {
                st = 'HI';
                state = 'Hawaii';
            } else if (zipcode >= 83200 && zipcode <= 83999) {
                st = 'ID';
                state = 'Idaho';
            } else if (zipcode >= 60000 && zipcode <= 62999) {
                st = 'IL';
                state = 'Illinois';
            } else if (zipcode >= 46000 && zipcode <= 47999) {
                st = 'IN';
                state = 'Indiana';
            } else if (zipcode >= 50000 && zipcode <= 52999) {
                st = 'IA';
                state = 'Iowa';
            } else if (zipcode >= 66000 && zipcode <= 67999) {
                st = 'KS';
                state = 'Kansas';
            } else if (zipcode >= 40000 && zipcode <= 42999) {
                st = 'KY';
                state = 'Kentucky';
            } else if (zipcode >= 70000 && zipcode <= 71599) {
                st = 'LA';
                state = 'Louisiana';
            } else if (zipcode >= 3900 && zipcode <= 4999) {
                st = 'ME';
                state = 'Maine';
            } else if (zipcode >= 20600 && zipcode <= 21999) {
                st = 'MD';
                state = 'Maryland';
            } else if ((zipcode >= 1000 && zipcode <= 2799) || (zipcode === 5501) || (zipcode === 5544)) {
                st = 'MA';
                state = 'Massachusetts';
            } else if (zipcode >= 48000 && zipcode <= 49999) {
                st = 'MI';
                state = 'Michigan';
            } else if (zipcode >= 55000 && zipcode <= 56899) {
                st = 'MN';
                state = 'Minnesota';
            } else if (zipcode >= 38600 && zipcode <= 39999) {
                st = 'MS';
                state = 'Mississippi';
            } else if (zipcode >= 63000 && zipcode <= 65999) {
                st = 'MO';
                state = 'Missouri';
            } else if (zipcode >= 59000 && zipcode <= 59999) {
                st = 'MT';
                state = 'Montana';
            } else if (zipcode >= 27000 && zipcode <= 28999) {
                st = 'NC';
                state = 'North Carolina';
            } else if (zipcode >= 58000 && zipcode <= 58999) {
                st = 'ND';
                state = 'North Dakota';
            } else if (zipcode >= 68000 && zipcode <= 69999) {
                st = 'NE';
                state = 'Nebraska';
            } else if (zipcode >= 88900 && zipcode <= 89999) {
                st = 'NV';
                state = 'Nevada';
            } else if (zipcode >= 3000 && zipcode <= 3899) {
                st = 'NH';
                state = 'New Hampshire';
            } else if (zipcode >= 7000 && zipcode <= 8999) {
                st = 'NJ';
                state = 'New Jersey';
            } else if (zipcode >= 87000 && zipcode <= 88499) {
                st = 'NM';
                state = 'New Mexico';
            } else if ((zipcode >= 10000 && zipcode <= 14999) || (zipcode === 6390) || (zipcode === 501) || (zipcode === 544)) {
                st = 'NY';
                state = 'New York';
            } else if (zipcode >= 43000 && zipcode <= 45999) {
                st = 'OH';
                state = 'Ohio';
            } else if ((zipcode >= 73000 && zipcode <= 73199) || (zipcode >= 73400 && zipcode <= 74999)) {
                st = 'OK';
                state = 'Oklahoma';
            } else if (zipcode >= 97000 && zipcode <= 97999) {
                st = 'OR';
                state = 'Oregon';
            } else if (zipcode >= 15000 && zipcode <= 19699) {
                st = 'PA';
                state = 'Pennsylvania';
            } else if (zipcode >= 300 && zipcode <= 999) {
                st = 'PR';
                state = 'Puerto Rico';
            } else if (zipcode >= 2800 && zipcode <= 2999) {
                st = 'RI';
                state = 'Rhode Island';
            } else if (zipcode >= 29000 && zipcode <= 29999) {
                st = 'SC';
                state = 'South Carolina';
            } else if (zipcode >= 57000 && zipcode <= 57999) {
                st = 'SD';
                state = 'South Dakota';
            } else if (zipcode >= 37000 && zipcode <= 38599) {
                st = 'TN';
                state = 'Tennessee';
            } else if ((zipcode >= 75000 && zipcode <= 79999) || (zipcode >= 73301 && zipcode <= 73399) || (zipcode >= 88500 && zipcode <= 88599)) {
                st = 'TX';
                state = 'Texas';
            } else if (zipcode >= 84000 && zipcode <= 84999) {
                st = 'UT';
                state = 'Utah';
            } else if (zipcode >= 5000 && zipcode <= 5999) {
                st = 'VT';
                state = 'Vermont';
            } else if ((zipcode >= 20100 && zipcode <= 20199) || (zipcode >= 22000 && zipcode <= 24699) || (zipcode === 20598)) {
                st = 'VA';
                state = 'Virginia';
            } else if ((zipcode >= 20000 && zipcode <= 20099) || (zipcode >= 20200 && zipcode <= 20599) || (zipcode >= 56900 && zipcode <= 56999)) {
                st = 'DC';
                state = 'Washington DC';
            } else if (zipcode >= 98000 && zipcode <= 99499) {
                st = 'WA';
                state = 'Washington';
            } else if (zipcode >= 24700 && zipcode <= 26999) {
                st = 'WV';
                state = 'West Virginia';
            } else if (zipcode >= 53000 && zipcode <= 54999) {
                st = 'WI';
                state = 'Wisconsin';
            } else if (zipcode >= 82000 && zipcode <= 83199) {
                st = 'WY';
                state = 'Wyoming';
            } else {
                st = 'none';
                state = 'none';
                console.log('No state found matching', zipcode);
            }

            return st;
        }

        $(document).ready(function () {

        });
    </script>
@endsection
