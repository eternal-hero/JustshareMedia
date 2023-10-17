@extends('template.layout')

@section('title', 'Products & Services | Just Share Media')
{{--@section('title', 'Products & Services | Just Share Roofing Media')--}}

@section('description', 'Choose from a variety of products and services, and work with us to customize them to your exact needs.')

@section('content')

    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Our Products &amp; Services</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products &amp; Services</li>
            </ol>
        </div>
    </section>

    <div>

        <div class="section bg-transparent m-0" style="" data-bottom-top="background-position:0px 300px;" data-top-bottom="background-position:0px -300px;">
            <div class="container clearfix">

                <div class="heading-block center">
                    <h2>What We Offer</h2>
                    <span>Custom and Royalty-free roofing marketing content and services to fit your needs and your budget</span>
                </div>

                <div class="row pricing col-mb-30 mb-4">

                    <div class="col-md-6 col-lg-6">
                        <div class="pricing-box pricing-simple px-5 py-4 bg-light text-center">
                            <div class="pricing-title">
                                <h3>Stock Videos</h3>
                            </div>
                            <div class="pricing-features">
                                <p>For the roofing company that wants quality content without hiring a custom film team. These are
                                    professionally made 45s - 60s videos tailored for social media advertising. Customized with your
                                    company’s logos and branding and ad language.</p>
                            </div>
                            <div class="pricing-action">
                                <a href="/signup" class="btn btn-primary btn-lg">Sign Up Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="pricing-box pricing-simple px-5 py-4 bg-light text-center">
                            <div class="pricing-title">
                                <h3>Custom Videos</h3>
                            </div>
                            <div class="pricing-features">
                                <p>Talk to our production team about creating a customized video specific to your company! Our expert
                                    film staff will travel to you and produce a video around your needs with your personnel.</p>
                                <br/>
                            </div>
                            <div class="pricing-action">
                                <a href="/contact" class="btn btn-info btn-lg">Schedule Strategy Call</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="pricing-box pricing-simple px-5 py-4 bg-light text-center">
                            <div class="pricing-title">
                                <h3>Photography</h3>
                            </div>
                            <div class="pricing-features">
                                <p>Company Headshots, drone photography, product photography, business content, and more! Our
                                    professional photographers will provide the highest quality images for YOU to use to elevate
                                    your business page and social media content.</p>
                                <p>Best price when bundled with our Custom Video Service.</p>
                            </div>
                            <div class="pricing-action">
                                <a href="/contact" class="btn btn-danger btn-lg">Schedule Strategy Call</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <div class="pricing-box pricing-simple px-5 py-4 bg-light text-center">
                            <div class="pricing-title">
                                <h3>Facebook Marketing</h3>
                            </div>
                            <div class="pricing-features">
                                <p>We will create and manage complex Facebook Ads that will target YOUR desired audience. No
                                    more posting and asking family members to like and share.</p>

                                <p>We create the algorithms and Facebook
                                    puts YOUR video on the customer’s feed, GUARANTEED!</p>
                            </div>
                            <div class="pricing-action">
                                <a href="/contact" class="btn btn-success btn-lg">Schedule Strategy Call</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <x-section-call-to-action/>

@endsection
