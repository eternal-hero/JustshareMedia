@extends('template.layout')

{{--@section('title', 'Signup | Just Share Media')--}}
@section('title', 'Signup | Just Share Media')

@section('description', 'Sign up for a new subscription.')

@section('css_additional')
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/swiper-bundle.min.css')}}"/>
    <style>
        #planrows {
            justify-content: center;
        }
        .plan-box-area {
            max-width: 500px;
        }
        .plan-box-subtitle {
            padding: 0 90px;
        }
        .plan-color-danger, .plan-btn-danger {
            background-color: rgb(75,129,228);
        }
        .plan-color-success, .plan-btn-success {
            background-color: #4d565c;
        }

        .ribbon {
            position: absolute;
            z-index: 99;
            right: 53px;
            top: -3px;
            width: 100px;
        }
        .plan-box.shadow-lg {
            position: relative;
            overflow: hidden;
        }
        .plan-box.shadow-lg .top-heading {
            margin-bottom: 0;
        }
        .top-heading {
            color: #FDFFFC;
            text-transform: uppercase;
            font-size: 3rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0;
            padding-top: 1.5rem;
            letter-spacing: 0.1rem;
        }
        .plan-color-danger p {
            line-height: 0.5 !important;
            font-weight: bold;
            font-size: 1.2rem;
            letter-spacing: 0.1rem;
            color: white;
        }
        .plan-box-subtitle.h5 {
            margin-bottom: 10px!important;
        }


        @media (max-width: 1439px) {
            .ribbon {
                right: 24px;
            }
        }


        @media (max-width: 1200px) {
            .ribbon {
                right: 8px;
            }
        }

        @media (max-width: 992px) {
            .ribbon {
                right: 34px;
            }
        }

        @media (max-width: 767px) {
            .ribbon {
                right: 2px
            }
            .pricing.row .px-lg-5.plan-box-area {
                padding-left: 10px!important;
                padding-right: 10px!important;
            }
        }


        @media (max-width: 575.98px) {
            .plan-box.shadow-lg {
                max-width: 100%!important;
            }
        }

        @media (max-width: 1439px) and (min-width: 992px){
            .plan-box-area {
                height: 570px;
            }
            .plan-box {
                height: 100%;
            }

        }

        .plan-box-subtitle {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
            height: 50px;
        }

    </style>
@endsection

@section('content')

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalTitle">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You appear to have an existing account. Please login to place an order.</p>
                    <div class="col-12 form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" id="emailModal" name="emailModal" value="" class="sm-form-control" />
                    </div>

                    <div class="col-12 form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="passwordModal" name="passwordModal" value="" class="sm-form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <p id='modalLoginFailed' style='display:none;color:red;font-weight:bold;text-align:center;'>Login failed, please try again&nbsp;</p>
                    <button id='btnLoginModal' class='btn btn-primary' onclick="getProfile()">Login</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Title -->
    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Signup</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Signup</li>
            </ol>
        </div>
    </section>

    <div class="content-wrap font-primary py-0">
        <div class="section bg-transparent m-0">
            <div class="container">

                <div id='loading' style='text-align:center;'>
                    <img src='/assets/images/loading.gif' />
                </div>

                <!-- Step 1 -->
                <div id='step1' style='display:none;' class="text-center step1">

                    <h1 class="step1-heading">Choose a plan</h1>
{{--                    <h4 class="step1-subheading">Multiple Options = Better Savings</h4>--}}
                    <p class="step1-des px-xl-6 mx-xl-6">
                        With each plan, you get one video license per month. You can save some money by paying for the year up front with the Annual plan, or stick to the month-to-month plan with no commitment.
                    </p>
                    <div id='planrows' class="row pricing col-mb-30 mb-4" ></div>
                </div>

                <!-- Step 2 -->
                <div id='step2' style='display:none;'>
                    <div class='row'>
                        <div class='col'>
                            <h3>Your Plan</h3>
                            <p>You are ordering our <span id='step2-plan-name' style='font-weight:bold;'></span> plan,
                                billed $<span id='step2-plan-price' style='font-weight:bold;'></span> <span id='step2-plan-term' style='font-weight:bold;'></span>.</p>
                            <p><a href='#' onclick="step1()">Go back and select a different plan.</a></p>
                            <p>Company information can be changed at any time through your online profile. A valid email address is required to receive our notifications.</p>
                            <p>Your payment information will be handled at the bottom of the page.</p>
                        </div>

                        <div class='col'>
                            <h3>Billing Profile</h3>

							<p>This information will be used for your company profile.</p>

                            <p id='logout' style='display:none;font-weight:bold;font-size:1.2em;'><a href='#' onclick='logout()'><i class='icon-line-log-out'></i> Logout</a></p>

							<form id="billing-form" name="billing-form" class="row mb-0" action="#" method="post">
                                <input type="hidden" name="lat"/>
                                <input type="hidden" name="lng"/>

                                <div class="col-12 form-group">
									<label for="email">Email Address:</label>
									<input type="email" id="email" name="email" onfocusout="checkEmail()" value="" class="sm-form-control" />
								</div>

                                <div class="col-12 form-group">
									<label for="password">Password:</label>
									<input type="password" id="password" name="password" value="" class="sm-form-control" />
								</div>

                                <div class="col-12 form-group">
									<label for="password_confirmation">Confirm Password:</label>
									<input type="password" id="password_confirmation" name="password_confirmation" value="" class="sm-form-control" />
								</div>

								<div class="col-md-6 form-group">
									<label for="first_name">First Name:</label>
									<input type="text" id="first_name" name="first_name" value="" class="sm-form-control" />
								</div>

								<div class="col-md-6 form-group">
									<label for="last_name">Last Name:</label>
									<input type="text" id="last_name" name="last_name" value="" class="sm-form-control" />
								</div>

								<div class="w-100"></div>

								<div class="col-12 form-group">
									<label for="company">Company Name:</label>
									<input type="text" id="company" name="company" value="" class="sm-form-control" />
								</div>

								<div class="col-12 form-group">
									<label for="address" style="display: flex">
                                        <div class="tooltip-wrapper" style="margin-right: 5px">
                                            <div class="tooltip-trigger">
                                                <img src="{{url('/images/text-editor/icons/question_icon.svg')}}"
                                                     title="Credit card billing address."
                                                     alt="Question mark">
                                            </div>
                                        </div>
                                        <div>Billing Address:</div>
                                    </label>
									<input type="text" id="address" name="address" value="" class="sm-form-control" />
								</div>

                                <div class="col-12 form-group">
									<label for="address2">Address Line 2:</label>
									<input type="text" id="address2" name="address2" value="" class="sm-form-control" />
								</div>

								<div class="col-lg-6 col-xs-12 form-group">
									<label for="city">City</label>
									<input type="text" id="city" name="city" value="" class="sm-form-control" />
								</div>

                                <div class="col-lg-6 col-xs-12 form-group">
									<label for="state">State</label>
									{{-- <input type="text" id="state" name="state" value="" class="sm-form-control" /> --}}
                                    <select id="state" name="state" class="sm-form-control">
                                        <option value=''>---</option>
                                    </select>
								</div>

                                <div class="col-6 form-group">
									<label for="zip">Zip</label>
									<input type="text" id="zip" name="zip" value="" class="sm-form-control" />
								</div>

								<div class="col-md-6 form-group">
									<label for="phone">Phone:</label>
									<input type="text" id="phone" name="phone" value="" class="sm-form-control" />
								</div>

							</form>
                        </div>
                    </div>

                    <br/>
                    <hr/>
                    <br/>

                    <div class='row'>
                        <div class='col'>
                            <h3>Social Media (optional)</h3>
                            <p>If you have social media accounts for your business, enter your page URLs here.</p>
                            <div class='row'>
                                <div class="col-4 form-group">
                                    <label for="social_facebook">Facebook</label>
                                    <input type="text" id="social_facebook" name="social_facebook" value="" class="sm-form-control" />
                                </div>
                                <div class="col-4 form-group">
                                    <label for="social_twitter">Twitter</label>
                                    <input type="text" id="social_twitter" name="social_twitter" value="" class="sm-form-control" />
                                </div>
                                <div class="col-4 form-group">
                                    <label for="social_instagram">Instagram</label>
                                    <input type="text" id="social_instagram" name="social_instagram" value="" class="sm-form-control" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <br/>
                    <hr/>
                    <br/>

                    <div class='row'>

                        <div class='col'>
                            <h3>Payment Information</h3>
                            <p>Enter the card details for the billing information you used above.</p>
                            <p><img src='/assets/images/credit-card-logos.png' /></p>
                        </div>

                        <div class='col'>
                            <div class='row mb-0'>
                                <div class="col-12 form-group">
                                    <label for="cardnumber">Card Number:</label>
                                    <input type="text" id="cardnumber" name="cardnumber" value="" class="sm-form-control" maxlength="16" />
                                </div>
                                <div class="col-lg-4 col-xs-12 form-group">
                                    <label for="cvv">CVV Code:</label>
                                    <input type="number" id="cvv" name="cvv" value="" class="sm-form-control" />
                                </div>
                                <div class="col-lg-4 col-xs-12 creditcard-expiry-month-group">
                                    <label for="expmonth">Expiry Month:</label>
                                    <select id="expmonth" name="expmonth" class="sm-form-control">
                                        <option value=''>---</option>
                                        <option value='01'>01 - January</option>
                                        <option value='02'>02 - February</option>
                                        <option value='03'>03 - March</option>
                                        <option value='04'>04 - April</option>
                                        <option value='05'>05 - May</option>
                                        <option value='06'>06 - June</option>
                                        <option value='07'>07 - July</option>
                                        <option value='08'>08 - August</option>
                                        <option value='09'>09 - September</option>
                                        <option value='10'>10 - October</option>
                                        <option value='11'>11 - November</option>
                                        <option value='12'>12 - December</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-xs-12 form-group">
                                    <label for="expyear">Expiry Year:</label>
                                    <select id="expyear" name="expyear" class="sm-form-control">
                                        <option value=''>---</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <br/>
                    <hr/>
                    <br/>

                    <div class='row'>
                        <div class='col'>
                            <h3>Order Summary</h3>
                            <h4 id='step2-summary-plan-name'></h4>

                            <p>Recurring payments billed <span style='font-weight:bold' id='step2-summary-plan-term'></span>.</p>

                            <p id='step2-summary-contract-notice' style='display:none;'>
                                <span style='color:red;font-weight:bold;'>NOTE:</span> You are signing up for a payment contract for a term of <b>12 months</b>. Early cancellation is subject to additional fees as outlined in our <a href='/terms-of-service'>Terms of Service</a>.<br/><br/>
                            </p>

                            <p>
                                <input type='checkbox' id='agreement' name='agreement' /> I agree to the <a href="{{route('terms-conditions')}}" target="_blank">Terms and Conditions</a> and <a href="{{route('privacy-policy')}}" target="_blank">Privacy Policy</a>.
                            </p>

                            <p>
                                <b>Discount Code:</b>
                                <input type='text' name='coupon' id='coupon' />
                                <button id='validateCoupon' name='validateCoupon' onclick="validateCoupon()" class='btn btn-xs btn-primary'>Validate</button>
                            </p>

                            <p style='font-weight:bold;font-size:1.2em;'>Plan Price: $<span id='step2-summary-original'></span></p>
                            <p style='font-weight:bold;font-size:1.2em;'>Tax: $<span id='step2-summary-tax'></span></p>

                            <p id='couponDescription' style='font-weight:bold;display:none;'><p>

                            <p style='font-weight:bold;font-size:1.5em;'>Total Today: $<span id='step2-summary-plan-price'></span></p>

                            <p><button id='btnorder' class='btn btn-primary' onclick="step3()" style='font-weight:bold;font-size:1.2em;'>Place Order</button></p>

                            <p id='ordererror' style='display:none;color:red;font-weight:bold;margin-bottom:10px;'></p>
                        </div>

                        <div class='col' style='font-size:.8em;'>
                            <p>
                                You can shop at www.justsharemedia.com with confidence. We have partnered
                                with <a href='https://www.authorize.net'>Authorize.Net</a>, a leading payment gateway since 1996, to accept
                                credit cards and electronic check payments safely and securely for our customers.
                            </p>
                            <p>
                                The Authorize.Net Payment Gateway manages the complex routing of sensitive customer information through
                                the electronic check and credit card processing networks. See an
                                <a href='https://www.authorize.net/resources/how-payments-work.html'>online payments diagram</a> to see how it works.
                            </p>
                            <p>
                                The company adheres to strict industry standards for payment processing, including:
                                <ul>
                                    <li>128-bit Secure Sockets Layer (SSL) technology for secure Internet Protocol (IP) transactions.</li>
                                    <li>Industry leading encryption hardware and software methods and security protocols to protect customer information.</li>
                                    <li>Compliance with the Payment Card Industry Data Security Standard (PCI DSS).</li>
                                </ul>
                            </p>
                            <p>
                                For additional information regarding the privacy of your sensitive cardholder data, please read the <a href='https://www.authorize.net/company/privacy/'>Authorize.Net Privacy Policy</a>.
                                www.justsharemedia.com is registered with the Authorize.Net Verified Merchant Seal program.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div id='step3' style='display:none'>
                    <div class="heading-block center">
                        <h2>Order Confirmed</h2>
                    </div>
                    <div>
                        <p>Thank you for your business! Your order has been received.</p>
                        <p style='font-weight:bold;font-size:1.2em;'>Order #<span id='orderID'></span></p>
                        @if(\Auth::guest())
                        <p>You may now <a href='{{route('login')}}'>login to your account</a> to monitor your order status.</p>
                        @endif
                    </div>
                </div>

                <!-- Error -->
                <div id='errorPage' class='text-center' style='display:none'>
                    <div class="heading-block center">
                        <h2>Error</h2>
                    </div>
                    <div>
                        <p id='errorMessage'></p>
                    </div>
                </div>


            </div>


            <div class="logo-banner mt-3">

                <div class="container text-center">
                    <h1 class="logo-banner-heading mb-6">
                        World-class <span class="hp-color-primary font-weight-bold">roofing videos</span>, without breaking the bank.
                    </h1>

                    <iframe width="1280" height="720" src="https://www.youtube.com/embed/ytuJpONPb6w?autoplay=0" title="Just share media Plans tutorial" frameborder="0" allow="autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>

                    <h2 class="logo-banner-subheading mb-0 mt-5">
                        Brands that use our videos
                    </h2>
                </div>


                <!-- Slider main container -->
                <div class="swiper swiper-logo-banner">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->

                        <div class="swiper-slide">
                            <div class="d-flex flex-column justify-content-center text-center min-vh-50 min-vm-sm-25 min-vm-mob-25">
                                <img class="img-fluid mx-auto" src="{{asset('assets/images/logos/bluebird-logo.png')}}" alt="BlueBird" width="250">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column justify-content-center text-center min-vh-50 min-vm-sm-25 min-vm-mob-25">
                                <img class="img-fluid mx-auto" src="{{asset('assets/images/logos/cmr-logo.png')}}" alt="cmr" width="250">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column justify-content-center text-center min-vh-50 min-vm-sm-25 min-vm-mob-25">
                                <img class="img-fluid mx-auto" src="{{asset('assets/images/logos/colonial-contracting-logo.png')}}" alt="colonial contracting" width="250">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column justify-content-center text-center min-vh-50 min-vm-sm-25 min-vm-mob-25">
                                <img class="img-fluid mx-auto" src="{{asset('assets/images/logos/colossal-roofing-logo.svg')}}" alt="colossal roofing" width="250">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column justify-content-center text-center min-vh-50 min-vm-sm-25 min-vm-mob-25">
                                <img class="img-fluid mx-auto" src="{{asset('assets/images/logos/hammerhead-roof-logo.png')}}" alt="hammerhead roof" width="250">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column justify-content-center text-center min-vh-50 min-vm-sm-25 min-vm-mob-25">
                                <img class="img-fluid mx-auto" src="{{asset('assets/images/logos/roof-repair-squad-logo.png')}}" alt="roof repair squad" width="250">
                            </div>
                        </div>
                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                </div>
            </div>

            <div class="container signup-vid-sec text-center">
                <h2 class="signup-vid-heading hp-color-secondary mb-lg-0 mb-mob-1">
                    Cinematic doesn’t have to be difficult
                </h2>

                <div class="row">
                    <div class="col-lg-4 p-xl-4 mb-md-4 mb-lg-0">
                        <img class="img-fluid p-3" width="700" src="{{asset('assets/images/homepage/choose-video-section.png')}}" alt="Choose your video">
                        <div class="text-center text-justify mt-4">
                            <h2 class="mb-2 vid-sec-heading hp-color-secondary">
                                Choose your video
                            </h2>
                            <p class="vid-sec-des hp-color-secondary px-4">
                                Our videos are meant to convert, <span class="hp-color-primary font-weight-bold">period</span>. Choose from cinematic promotional videos to emotional customer testimonials to motivational recruitment videos - <span class="hp-color-primary font-weight-bold">we cover all of your needs</span>.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 p-xl-4 mb-md-4 mb-lg-0">
                        <img class="img-fluid" width="700" src="{{asset('assets/images/homepage/video-customizer-asset-min.png')}}" alt="Customize your video">
                        <div class="text-center text-justify mt-4">
                            <h2 class="mb-2 vid-sec-heading hp-color-secondary">
                                Customize your video
                            </h2>
                            <p class="vid-sec-des hp-color-secondary px-4">
                                With our intuitive and easy to use video customizer you can upload your logo, add creative text, or create a captivating message for homeowners, in minutes – <span class="hp-color-primary font-weight-bold"> no experience required. </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 p-xl-4 mb-md-4 mb-lg-0">
                        <img class="img-fluid p-4" width="700" src="{{asset('assets/images/homepage/video-export-asset.png')}}" alt="Export your video">
                        <div class="text-center text-justify mt-4">
                            <h2 class="mb-2 vid-sec-heading hp-color-secondary">
                                Export your video
                            </h2>
                            <p class="vid-sec-des hp-color-secondary px-4">
                                Download your video in both <span class="hp-color-primary font-weight-bold">1:1</span> and <span class="hp-color-primary font-weight-bold">16:9</span>, two standard video file sizes needed to start promoting your business. Get automated reminders when it’s time to license a new video each month.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="hp-bg-color-primary faq-section">
                <div class="container">
                    <h1 class="text-center hp-color-white faq-sec-heading py-6"> Frequently Asked Questions </h1>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 pr-lg-5">
                            <div class="faq-question-sec mb-6">
                                <h3 class="hp-color-white mb-2 font-weight-bold font-italic">Why should I choose a stock video over a custom video?</h3>
                                <p>
                                    Custom videos can be expensive and time consuming to have produced. Generally, a custom video will cost you upwards of $10,000 and after using it for a while, can go stale with your audience. With Just Share Media, you get a new video every 30-days. This allows your business to keep homeowners engaged with new content each month.
                                </p>
                            </div>
                            <div class="faq-question-sec mb-6">
                                <h3 class="hp-color-white mb-2 font-weight-bold font-italic">Why should I use video to promote my company?</h3>
                                <p>
                                    Video content is on the rise, especially across social media. By 2022, online videos will make up more than 82% of all consumer internet traffic — 15 times higher than it was in 2017. This means that if you are not using video to promote your business, you are significantly behind the market and homeowners will pass you by.
                                </p>
                            </div>
                            <div class="faq-question-sec mb-6">
                                <h3 class="hp-color-white mb-2 font-weight-bold font-italic">What are the differences in your plans?</h3>
                                <p>
                                    Both of our plans include the same features, videos, customization, etc. We just believe in options for our customers so dip your toe in the water with just a monthly plan or go all-in with a year of video content (and save money too).
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 pl-lg-5">
                            <div class="faq-question-sec mb-6">
                                <h3 class="hp-color-white mb-2 font-weight-bold font-italic">Can I change videos at any time?</h3>
                                <p>
                                    Each video is licensed for 30-days, at which you can then license a new video for your company’s use.
                                </p>
                            </div>
                            <div class="faq-question-sec mb-6">
                                <h3 class="hp-color-white mb-2 font-weight-bold font-italic">What if I want to use the video in more than one location?</h3>
                                <p>
                                    Our plans offer video ‘add-ons’ which allow you to add a second, third, or fourth location to your account, which then allows you to use your video in each location without worry. Plus it will lock down your video for each location selected, meaning it’s exclusive to you and no one else!
                                </p>
                            </div>
                            <div class="faq-question-sec mb-6">
                                <h3 class="hp-color-white mb-2 font-weight-bold font-italic">What happens when my video license expires?</h3>
                                <p>
                                    When you subscribe to Just Share Media, you are receiving a 30-day license to our video library. Each month, a new 30-day license is generated that allows you to then unlock and customize a new video. If you do not go in and choose a new video, your license will be automatically generated and applied to the same video you already have licensed. Just go into your Account and choose a new video each month and you’ll be all set!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js_additional')
<!-- Google Recaptcha -->
{!! NoCaptcha::renderJs() !!}
<script>
    let _token = '{{ csrf_token() }}';
    let plan = 0; // Selected plan ID
    let term = 'monthly'; // Selected term
    let originalTerm = 'monthly';
    let coupon = false; // Current coupon
    let couponRecurring = false;
    let total = 0;
    let originalTotal = 0;
    let originalPrice = 0;
    let originalTax = 0;
    let plans = [];
    let fieldErrors = []; // Array used to clear field errors
    let loggedin = false;
    let state_code = '';
    let _taxRate;

    let key = '{{config('services.google.key')}}';
    let addressField;
    let geocoder;

    $(document).ready( function () {

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

        var swiper = new Swiper(".swiper-logo-banner", {
            slidesPerView: 3.5,
            spaceBetween: 30,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            }
        });
    });

    window.onload = function() {
        // Generate form field years
        generateYears();
        generateStates();

        // Load page data
        $.post('/step1', {_token: _token }, function(response) {
            // Check for bad response
            if (! response) return errorPage();

            // Load plan data
            let json = JSON.parse(response);
            let tmp = '';
            console.log("plans:", json.plans)
            json.plans.forEach(function(obj) {

                if(obj.term !== 'monthly') {
                    // Add to plans data array
                    plans.push(obj);
                    console.log(obj);
                    let label = '';
                    let subLabel = '';
                    let subTitle = ''
                    switch (obj.term) {
                        case 'monthly':
                            label = 'Single';
                            subLabel = 'license';
                            subTitle = 'A single 1-month license'
                            break;
                        case 'yearly':
                            label = 'Annual';
                            subLabel = 'plan';
                            subTitle = '12 months, paid up front'
                            break;
                        case 'contract':
                            label = 'Monthly';
                            subLabel = 'plan';
                            subTitle = 'Month-to-month, no commitment'
                            break;
                    }

                    // Set available terms
                    tmp += '<div class="plan-box-area col-lg-6 col-md-12 col-sm-12 px-md-0 px-lg-5 px-sm-5">'
                    if(obj.term === 'yearly'){
                        tmp += '<img class="ribbon" src="{{ asset('assets/images/ribbon.png') }}"/>'
                    }
                    tmp += '<div class="plan-box shadow-lg">';
                    tmp += '<div class="d-flex flex-column text-center plan-color-' + obj.color + ' justify-content-center pt-3">';
                    tmp +=      '<h1 class="top-heading">' + label + '</h1>' +
                        '<p>' + subLabel +'</p> '+
                        '</div>' +
                        '<div class="d-flex flex-column">' +
                        '<div class="d-flex flex-column text-center justify-content-between mb-5 plan-box-detail-sec">' +
                        '<p class="mt-5 mb-4 plan-box-subtitle h5">' + subTitle + '</p>' +
                        '<div class="d-flex flex-column plan-box-pricing-sec mb-6">';
                    switch (obj.term) {
                        case 'monthly':
                            tmp += '<h1 id="plan-' + obj.term + '-price">$'+ obj.monthly +'</h1>';
                            break;
                        case 'yearly':
                            tmp += '<h1 id="plan-' + obj.term + '-price">$' + (obj.yearly) + '</h1>';
                            break;
                        case 'contract':
                            tmp += '<h1 id="plan-' + obj.term + '-price">$' + obj.contract + '</h1>';
                            break;
                    }
                    tmp += '<p id="plan-' + obj.term + '-term">per month</p>' +
                        '</div>' +


                        '<div>' +
                        '<button onclick="step2(\'' + obj.term + '\')" class="btn rounded-xxxl px-6 btn-lg plan-box-btn plan-btn-' + obj.color + '">Select</button>' +
                        '</div>';

                    tmp += '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }

            });

            // Set HTML
            document.getElementById('planrows').innerHTML = tmp;

            // Update feature lists
            // json.plans.forEach(function(obj) {
            //     obj.features.forEach(function(feature) {
            //         document.getElementById('featurelist-' + obj.term).innerHTML += '<li><span class="fa-li"><i class="icon-checkmark"></i></span>' + feature + '</li>';
            //     });
            // });

            // Display signup form
            $('#loading').css('display', 'none');
            $('#step1').css('display', 'inline');

            //step2(1); // dev @todo remove this
        }).fail(function(response) {
            errorPage();
        });

    }

    function errorPage(message = false)
    {
        $('#step1').css('display', 'none');
        $('#step2').css('display', 'none');
        $('#step3').css('display', 'none');
        $('#loading').css('display', 'none');
        $('#errorPage').css('display', 'inline');

        // Handle error message
        if (message) {
            $('#errorMessage').html(message);
        } else {
            $('#errorMessage').html('A fatal error occurred. Please try again later.');
        }
    }

    // Load a new csrf token
    function refreshToken()
    {
        $.get('/refresh-token').done(function(data) {
            _token = data;
        })
    }

    // Steps
    function step1()
    {
        this.term = this.originalTerm;
        $('#step1').css('display', 'inline');
        $('#step2').css('display', 'none');
        $('#step3').css('display', 'none');
    }

    function step2(argTerm)
    {
        // Update UI
        // $('#step1').css('display', 'none');
        $('#loading').css('display', 'block');

        // Clear coupon fields and totals
        $('#couponDescription').css('display', 'none');
        $('#couponDescription').val('');
        $('#coupon').val('');
        $('#paymonthly').prop('checked', false);
        $('#step2-summary-paymonthly-description').css('display', 'none');
        coupon = false;
        total = 0;
        originalTotal = 0;

        // Perform step 2 actions
        term = argTerm;
        plan = 1; // Hard code plan #1
        //console.log('Selected plan: ' + plan);
        //console.log('Selected term: ' + argTerm);
        //console.log('Current coupon: ' + coupon);
        // Load pricing
        step2Calculation();

        @if(\Auth::check())

        let email = document.getElementById('emailModal').value;
        $.post('/get-profile-loggedin', {_token: _token }, function(response) {
            // Auth success, set profile fields
            loggedin = true;
            document.getElementById('email').value = response.profile.email;
            $('#password').hide();
            $('label[for="password"]').hide();
            $('label[for="password_confirmation"]').hide();
            $('#password_confirmation').hide();
            document.getElementById('first_name').value = response.profile.first_name;
            document.getElementById('last_name').value = response.profile.last_name;
            document.getElementById('company').value = response.profile.company;
            document.getElementById('address').value = response.profile.address;
            document.getElementById('address2').value = response.profile.address2;
            document.getElementById('city').value = response.profile.city;
            document.getElementById('state').value = response.profile.state;
            document.getElementById('zip').value = response.profile.zip;
            document.getElementById('phone').value = response.profile.phone;
            // Set elements to read only
            document.getElementById('email').readOnly = true;
            document.getElementById('password').readOnly = true;
            document.getElementById('password_confirmation').readOnly = true;
        });
        @endif
    }

    function setTax(amount, taxRate) {
        _taxRate = taxRate
        $('#step2-summary-tax').html(amount + ' (tax rate: ' + taxRate + ' %)');
    }

    function setStep2PlanName(name) {
        $('#step2-plan-name').html(plans[plan-1].name);
        $('#step2-summary-plan-name').html(plans[plan-1].name);
    }

    function setStep2PlanPrice(price) {
        $('#step2-plan-price').html(price);
        $('#step2-summary-plan-price').html(price);
    }

    function step3()
    {
        // Disable submit button
        document.getElementById("btnorder").disabled = true;
        document.getElementById('btnorder').innerHTML = "<img src='/assets/images/loading.gif' width='25px' /> &nbsp; Submitting...";

        // Helpers
        codeAddress();
        clearFieldErrors();
        refreshToken();

        // POST variable handling
       let agreement = 0;
        if ($('#agreement').is(":checked")) {
            agreement = 1;
        }

        // Attempt order submit
        $.ajax({
            type: "POST",
            url: "/step3",
            data: {
                _token: _token,
                plan: plan,
                term: term,
                email: $('#email').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val(),
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                company: $('#company').val(),
                address: $('#address').val(),
                address2: $('#address2').val(),
                city: $('#city').val(),
                state: $('#state').val(),
                zip: $('#zip').val(),
                phone: $('#phone').val(),
                social_facebook: $('#social_facebook').val(),
                social_twitter: $('#social_twitter').val(),
                social_instagram: $('#social_instagram').val(),
                cardnumber: $('#cardnumber').val(),
                cvv: $('#cvv').val(),
                expmonth: $('#expmonth').val(),
                expyear: $('#expyear').val(),
                agreement: agreement,
                coupon: coupon,
                lat: $('input[name="lat"]').val(),
                lng: $('input[name="lng"]').val(),
            },
            dataType: 'json',
            success: function(data) {
                // Check for error response
                if (data.result != 'success') {
                   let msg = data.message;
                    if (! msg) msg = 'Unknown error, please contact us for assistance';
                    orderError(msg);
                    return;
                }

                // Success
                //console.log('step3 Order Success!');
                //console.log(data);

                // Update order id
                $('#orderID').html(data.orderID);

                // Update display
                $('#step1').css('display', 'none');
                $('#step2').css('display', 'none');
                $('#step3').css('display', 'inline');
                scrollTop();
            },
            error: function(err) {
                if (err.status == 422) {
                    //console.log('Validation error');
                    orderError('There was an issue with your information. Please check your fields and try again.');
                    //console.warn(err.responseJSON.errors);
                    $.each(err.responseJSON.errors, function (i, error) {
                        $('#ordererror').css('display', 'inline');
                        fieldErrors.push('errorlabel-' + i);
                       let el = $(document).find('[name="'+i+'"]');
                        el.after($('<span id="errorlabel-' + i + '" style="color: red;font-weight:bold;">&nbsp;'+error[0]+'&nbsp;</span>'));
                    });
                } else if (err.status >= 400) {
                    errorPage();
                }

                // Re-enable order button
                document.getElementById("btnorder").disabled = false;
                document.getElementById('btnorder').innerHTML = "Place Order";
                scrollTop();
            }
        })
    }

    // Show the order error message under Place Order button
    function orderError(message) {
        document.getElementById("ordererror").innerHTML = message;
        $('#ordererror').css('display', 'inline');
        document.getElementById("btnorder").disabled = false;
        document.getElementById('btnorder').innerHTML = "Place Order";
    }

    // Login modal close event
    $('#loginModal').on('hide.bs.modal', function() {
        if (! loggedin) {
            clearFields();
        }
    });

    // Functions
    function checkEmail()
    {
       let email = document.getElementById('email').value;
        if (! email) return;
        if (loggedin) return;
        $.post('/check-email', {_token: _token, email: email }, function(response) {
            if (response.exists) {
                document.getElementById('emailModal').value = email;
                $('#loginModal').modal('show');
            }
        });
    }

    // Validate the user's coupon
    function validateCoupon()
    {
        couponRecurring = false;
        $('#couponDescription').html('');
        $('#couponDescription').css('display', 'none');
        coupon = document.getElementById('coupon').value;
        $.post('/validate-coupon', {_token: _token, coupon: coupon, plan: plan, term: term, state_code: state_code }, function(response) {
            let coupon = $('#coupon').val();
            console.log(response);
            total = response.total;
            originalTotal = response.originalTotal;
            originalTax = response.tax;
            _taxRate = response.tax_rate;
            setTax(originalTax, _taxRate);
            setTotalUI();
            if (! response.coupon && coupon != '' ) {

                    $('#couponDescription').html('Your code is invalid');
                    $('#couponDescription').css('color', 'red');
                    $('#couponDescription').css('display', 'inline');
                    console.log('Invalid coupon');
                return false;
            }

            if (response.couponRecurring) {
                couponRecurring = true;
            }

            //console.log('Total with Coupon: ' + total);
            //console.log('Original Total: ' + originalTotal);
            $('#couponDescription').html(response.description);
            $('#couponDescription').css('color', 'green');
            $('#couponDescription').css('display', 'inline');
        });
    }

    // Sets the displayed total in the UI
    function setTotalUI() {
        //console.log('Total' + total);
        //console.log('OriginalTotal' + originalTotal);
        if (couponRecurring) {
            $('#step2-plan-price').html(total);
            $('#step2-summary-plan-price').html(total);
        } else {
            if (total != originalTotal) {
                $('#step2-plan-price').html(total + ' today, then $' + originalTotal + ' ');
            } else {
                $('#step2-plan-price').html(total);
            }
            $('#step2-summary-plan-price').html(total);
        }

        // Set original total
        $('#step2-summary-original').html(originalTotal);
    }

    // Resets UI coupon fields
    function resetCoupon()
    {
        total = originalTotal;
        coupon = false;
        couponRecurring = false;
        setTotalUI(originalTotal);
        $('#couponDescription').html('');
        $('#couponDescription').css('display', 'none');
        $('#coupon').val('');
    }

    // Attempt obtaining a profile
    function getProfile()
    {
        $('#modalLoginFailed').css('display', 'none');
       let email = document.getElementById('emailModal').value;
       let password = document.getElementById('passwordModal').value;
        $.post('/get-profile', {_token: _token, email: email, password: password }, function(response) {
            if (! response.profile) {
                // auth failed
                loggedin = false;
                $('#modalLoginFailed').css('display', 'inline');
                $('#modalLoginFailed').html(response.message);
                $('#passwordModal').val('');
                return false;
            }

            // Auth success, set profile fields
            loggedin = true;
            document.getElementById('email').value = response.profile.email;
            document.getElementById('password').value = document.getElementById('passwordModal').value;
            document.getElementById('password_confirmation').value = document.getElementById('passwordModal').value;
            document.getElementById('first_name').value = response.profile.first_name;
            document.getElementById('last_name').value = response.profile.last_name;
            document.getElementById('company').value = response.profile.company;
            document.getElementById('address').value = response.profile.address;
            document.getElementById('address2').value = response.profile.address2;
            document.getElementById('city').value = response.profile.city;
            document.getElementById('state').value = response.profile.state;
            document.getElementById('zip').value = response.profile.zip;
            document.getElementById('phone').value = response.profile.phone;

            // Set elements to read only
            document.getElementById('email').readOnly = true;
            document.getElementById('password').readOnly = true;
            document.getElementById('password_confirmation').readOnly = true;

            // Handle saved credit card details
            // document.getElementById('creditcardnumber').value = '';
            // document.getElementById('creditcardcode').value = '';
            // document.getElementById('creditcardexpirymonth').value = '';
            // document.getElementById('creditcardexpiryyear').value = '';

            // Show signout button
            $('#logout').css('display', 'inline');

            // Completed, hide login modal
            $('#loginModal').modal('hide');
            $('#passwordModal').val('');
        });
    }

    // Log out of the form
    function logout() {
        loggedin = false;
        clearFields();
        document.getElementById('email').readOnly = false;
        document.getElementById('password').readOnly = false;
        document.getElementById('password_confirmation').readOnly = false;
        $('#logout').css('display', 'none');
    }

    // Clear all formn fields
    function clearFields() {
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
        document.getElementById('first_name').value = '';
        document.getElementById('last_name').value = '';
        document.getElementById('company').value = '';
        document.getElementById('address').value = '';
        document.getElementById('address2').value = '';
        document.getElementById('city').value = '';
        document.getElementById('state').value = '';
        document.getElementById('zip').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('cardnumber').value = '';
        document.getElementById('cvv').value = '';
        document.getElementById('expmonth').value = '';
        document.getElementById('expyear').value = '';
        document.getElementById("ordererror").innerHTML = '';
        $('#ordererror').css('display', 'none');
    }

    // Clears form field errors for next submission attempt
    function clearFieldErrors()
    {
        // Clear generic error
        $('#ordererror').css('display', 'none');

        // Clear field errors
        $.each(fieldErrors, function(i, label) {
            document.getElementById(label).remove();
        });
        fieldErrors = []; // Clears errors
    }

    // Generate credit card year selections
    function generateYears()
    {
       let year = new Date().getFullYear();
        for (var i = 0; i <= 15; i++) {
            document.getElementById('expyear').innerHTML += "<option value='" + year + "'>" + year + "</option>";
            year++;
        }
    }
    // Generate state input fields
    function generateStates()
    {
       $.get('/get-states').done(function (response){
           let select = document.getElementById('state');
           for (let i = 0; i < response.length; i++) {
               let option = document.createElement("option");
               option.text = response[i].iso + ' - ' + response[i].name;
               option.value = response[i].iso;
               select.add(option);
           }
       });
    }

    // Create our number formatter.
   let formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });

    $(document).ready(function (){
        $('#state').on('change', function (){
            let stateCode = $(this).val();
            setTaxRateFromState(stateCode);

        });
    });

    function setTaxRateFromState(stateCode){
        $.post('/get-state-tax-rate', {_token: _token, state_code: stateCode }, function(response) {
            state_code = stateCode;
            //$('#couponDescription').html('');
            //$('#coupon').val('');
            //step2Calculation();

           originalTax = response.tax;
            _taxRate = response.tax_rate;
            setTax(originalTax, _taxRate);
            setTotalUI();
            validateCoupon();
        });
    }

    function step2Calculation()
    {
        $.post('/step2', {_token: _token, plan: plan, term:term, state_code:state_code }, function(response) {
            if (! response.price) errorPage();
            total = response.price;
            originalTotal = response.original;
            originalPrice = response.price;
            originalTax = response.tax;
            setTax(response.tax, response.tax_rate);
            setTotalUI();
            setStep2PlanPrice(total);
            //console.log('Calculated Step 2 Total: ' + total);

            // Set plan name UI
            setStep2PlanName(plans[plan-1].term);

            // Show contact notice UI
            $('#step2-summary-contract-notice').css('display', 'none');
            if (term == 'contract') $('#step2-summary-contract-notice').css('display', 'inline');

            // Set term UI
            $('#step2-plan-term').html((term == 'contract' ? 'monthly on a 12 month contract' : term));
            $('#step2-summary-plan-term').html((term == 'contract' ? 'monthly on a 12 month contract' : term));

            // Set display UI
            $('#loading').css('display', 'none');
            $('#step1').css('display', 'none');
            $('#step2').css('display', 'inline');
            $('#step3').css('display', 'none');

            scrollTop();
        });
    }
    function scrollTop()
    {
        $('html, body').animate({
            scrollTop: $("#page-title").offset().top
        }, 400);
    }

    function setLatLng(data) {
        $('input[name="lat"]').val(JSON.parse(data.lat()));
        $('input[name="lng"]').val(JSON.parse(data.lng()));
    }

    function codeAddress() {

        //In this case it gets the address from an element on the page, but obviously you  could just pass it to the method instead
        //let address = document.getElementById( 'address' ).value;

        geocoder.geocode({'address': addressField.value}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $('#state option:first').prop('selected', true)
                $('#city').val('')
                $('#zip').val('')
                for(let i=0; i < results[0].address_components.length; i++) {
                    if(results[0].address_components[i].types.includes('administrative_area_level_1')) {
                        $('#state option[value="' + results[0].address_components[i].short_name + '"]').prop('selected', true)
                    }
                    if(results[0].address_components[i].types.includes('locality')) {
                        $('#city').val(results[0].address_components[i].long_name)
                    }
                    if(results[0].address_components[i].types.includes('postal_code')) {
                        $('#zip').val(results[0].address_components[i].long_name)
                    }
                }

                setLatLng(results[0].geometry.location);
                let stateCode = $('#state').val();
                setTaxRateFromState(stateCode);
            } else {
                console.log('Geocode was not successful for the following reason: ' + status)
            }
        });
    }



    function initGeocode(){
        addressField = document.getElementById("address");

        addressField.onkeyup = function() {
            $('input[name="lat"]').val('')
            $('input[name="lng"]').val('')
        };

        geocoder = new google.maps.Geocoder();
        // Create the autocomplete object, restricting the search predictions to
        // addresses in the US.
        autocomplete = new google.maps.places.Autocomplete(addressField, {
            componentRestrictions: {country: ["us", "ua"]},
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        //addressField.focus();
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();
        let address = "";

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        // place.address_components are google.maps.GeocoderAddressComponent objects
        // which are documented at http://goo.gle/3l5i5Mr

        for (const component of place.address_components) {
            const componentType = component.types[0];
            console.log(componentType);
            switch (componentType) {
                case "street_number": {
                    address = `${component.long_name} ${address}`;
                    break;
                }

                case "route": {
                    address += component.short_name;
                    break;
                }
            }
        }
        //addressField.value = address;
        codeAddress();
    }

</script>
<script async
        src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&libraries=places&callback=initGeocode">
</script>
@endsection
