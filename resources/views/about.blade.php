@extends('template.layout')

@section('title', 'About Us | Just Share Media')
{{--@section('title', 'About Us | Just Share Roofing Media')--}}

@section('description', 'Discover who we are, our mission, and what we can provide to your business.')

@section('content')

    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>About Us</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About</li>
            </ol>
        </div>
    </section>

    <div class="content-wrap py-0">

        <div class="mission">
            <div class="container mission-container">
                <div class="mission-info">
                    <div class="mission-title">
                        OUR MISSION
                    </div>
                    <div class="mission-text">
                        <p>Our mission is to give roofing and solar professionals premium video content through an
                            easy-to-use platform at a low cost.</p>
                        <p>Access hundreds of professionally filmed roofing and solar videos, pick your favorites,
                            customize them with your branding and logos, and download! It’s that easy.</p>
                    </div>
                </div>
                <div class="mission-media">
                    <img class="main_img" src="{{ asset('assets/images/about/mission_media.png') }}" alt="">
                    <img class="logo" src="{{ asset('assets/images/about/logo.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="mission-bottom">
            <img src="{{ asset('assets/images/about/mission_bottom.png') }}" alt="">
        </div>

        <div class="teams">
            <div class="container team-container">
                <div class="teams-title"><span class="teams-color_main">OUR</span> <span class="teams-color_sec">TEAM</span></div>
                <div class="teams-members">
                    <div class="member member-left">
                        <div class="member-media">
                            <img src="{{ asset('assets/images/about/alen.png') }}" alt="Allen Mick">
                        </div>
                        <div class="member-info">
                            <div class="member-name teams-color_main">Allen Mick</div>
                            <div class="member-title teams-color_sec">Founder / Heads of Sales</div>
                            <div class="member-bio">
                                A true blue-collar entrepreneur Allen is a 3rd generation roofer. He has held key positions at multiple of the Top 100 roofing companies, and before Just Share Media, Allen was running a national roofing company of his own. His extensive industry knowledge mixed with a mastery of sales is leading Just Share Media's explosive growth.
                            </div>
                        </div>
                    </div>

                    <div class="member member-right">
                        <div class="member-info">
                            <div class="member-name teams-color_main">Ryan Landis</div>
                            <div class="member-title teams-color_sec">Founder / CEO </div>
                            <div class="member-bio">
                                Creating visual masterpieces in the form of video has been Ryan's passion for over 15 years. With a background in electrical engineering, he is creatively experienced and has a mind for numbers and mathematics as well. Ryan founded the idea of Just Share Media in 2020.
                            </div>
                        </div>
                        <div class="member-media">
                            <img src="{{ asset('assets/images/about/ryan.png') }}" alt="Ryan Landis">
                        </div>
                    </div>

                    <div class="member member-left">
                        <div class="member-media">
                            <img src="{{ asset('assets/images/about/justin.png') }}" alt="Justin Wells">
                        </div>
                        <div class="member-info">
                            <div class="member-name teams-color_main">Justin Wells</div>
                            <div class="member-title teams-color_sec">Co-Founder</div>
                            <div class="member-bio">
                                With an extensive background in strategy & business development across a variety of high-growth tech startups, Justin leads Just Share Media's marketing & strategy efforts. A serial entrepreneur with multiple exits, Justin has helped shape Just Share Media's foundation and trajectory from day 1.
                            </div>
                        </div>
                    </div>

                    <div class="member member-right">
                        <div class="member-info">
                            <div class="member-name teams-color_main">Hector Gutierrez</div>
                            <div class="member-title teams-color_sec">Co-Founder</div>
                            <div class="member-bio">
                                Hector has worked in public accounting for 8+ years with a broad clientele base across various industries in the assurance, attest, and consulting space. He is a licensed CPA and works as an audit manager at a large local firm in Plano, TX while providing guidance and establishing Just Share Media's financial and accounting policies.
                            </div>
                        </div>
                        <div class="member-media">
                            <img src="{{ asset('assets/images/about/hector.png') }}" alt="Hector Gutierrez">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="testimonials-top">
            <img class="desktop" src="{{ asset('assets/images/about/footer_bg_top.png') }}" alt="">
            <img class="mobile" src="{{ asset('assets/images/about/footer_bg_top_mobile.png') }}" alt="">
        </div>
        <div class="testimonials">
            <div class="container testimonials-container">
                <div class="testimonials-icon">
                    <img src="{{ asset('assets/images/about/qm.png') }}" alt="">
                    <img src="{{ asset('assets/images/about/qm.png') }}" alt="">
                </div>
                <div class="testimonials-text">
                    <p>High quality marketing content, generally in the form of professionally filmed and edited videos, is what many roofing companies are lacking. This content, paired with someone who understands Facebook’s algorithms, can reach thousands of potential direct clients through social media, guaranteed!</p>
                    <p class="ttpnmb">This is different from boosting posts. The distribution algorithm is tweaked perfectly so your video will go to exactly your target demographic. This ensures that only people who need your service are seeing your ad on Facebook. It’s what separates the best and most profitable roofing companies from their competition.</p>
                </div>
                <div class="testimonials-sign">
                    <div class="teams-color_sec">Ryan Landis</div>
                    <div class="cw">Just Share Roofing Media</div>
                </div>
            </div>
        </div>



        <x-section-call-to-action/>

    </div>

@endsection

@section('css_additional')
    <style>
        #footer {
            margin-top: 0 !important;
        }

        .cw {
            color: white;
        }

        .mission {
            background: #0C1018;
        }

        .mission-container {
            display: flex;
        }

        .mission-info, .mission-media {
            display: flex;
            flex: 1;
        }

        .mission-info {
            flex-direction: column;
            padding: 90px 0px;
        }

        .mission-title {
            font-family: 'Poppins', serif;
            font-size: 60px;
            font-weight: 700;
            color: #5880DD;
            margin-bottom: 30px;
        }

        .mission-text {
            font-family: 'Poppins', serif;
            font-size: 22px;
            font-weight: 400;
            color: #FFFFFF;
            opacity: 0.6;
        }

        .mission-text p {
            line-height: 33px;
        }

        .mission-bottom img {
            width: 100%;
            vertical-align: top;
        }

        .mission-media {
            position: relative;
            padding: 90px 0 90px 190px;
        }

        .mission-media .main_img {
            width: 100%;
            border-radius: 10px;
        }

        .mission-media .logo {
            position: absolute;
            right: calc(50% - 67px - 90px);
            top: calc(50% - 62px);
        }
        .teams-color_main {
            color: #0C1018;
        }
        .teams-color_sec {
            color: #5880DD
        }
        .teams {
            margin-top: 120px;
        }
        .teams-title {
            margin-bottom: 104px;
        }
        .teams-title span {
            font-family: 'Poppins', serif;
            font-style: normal;
            font-weight: 700;
            font-size: 60px;
            line-height: 90px;
        }
        .teams-members {
            display: flex;
            flex-direction: column;
        }
        .member {
            display: flex;
            margin-bottom: 120px;
        }
        .member-media, .member-info {
            display: flex;
            flex: 1;
        }
        .member-info {
            flex-direction: column;
            padding: 0px 60px;
        }
        .member-name {
            font-family: 'Poppins', serif;
            font-style: normal;
            font-weight: 700;
            font-size: 42px;
            line-height: 63px;
            margin-bottom: 10px;
        }
        .member-title {
            font-family: 'Poppins', serif;
            font-style: normal;
            font-weight: 700;
            font-size: 16px;
            line-height: 24px;
            margin-bottom: 40px;
        }
        .member-bio {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 21px;
            line-height: 32px;
            color: #0F0F0F;
        }
        .member-right .member-media {
            justify-content: end;
        }
        .member-left .member-info {
            padding: 0 0 0 120px;
        }
        .member-right .member-info {
            padding: 0 120px 0 0;
        }
        .testimonials {
            background-size: cover!important;
            background: url("{{ asset('assets/images/about/footer_bg_bottom.png') }}");
        }
        .testimonials-top img{
            width: 100%;
        }

        .testimonials .testimonials-text p {
            font-family: 'Poppins', serif;
            font-style: normal;
            font-weight: 400;
            font-size: 21px;
            line-height: 32px!important;
            text-align: center;
            color: #FFFFFF;
            opacity: 0.6;
        }

        .ttpnmb {
            margin-bottom: 0;
        }

        .testimonials-icon {
            text-align: center;
            padding-top: 100px;
            padding-bottom: 50px;
        }

        .testimonials-sign {
            padding: 40px 0 100px 0;
        }

        .testimonials-sign div {
            font-family: Poppins;
            font-weight: 400;
            font-size: 21px;
            text-align: center;
        }

        .testimonials-top img.mobile {
            display: none;
        }

        @media only screen and (max-width: 1439px) {
            .testimonials-top img.mobile {
                display: block;
            }
            .testimonials-top img.desktop {
                display: none;
            }
            .testimonials {
                background: #0C1018;
            }
        }

        @media only screen and (max-width: 1199px) {


            .mission-media {
                justify-content: center;
                align-items: center;
            }
            .mission-title, .teams-title span {
                font-size: 40px;
            }
            .member-media {
                align-items: center;
            }
        }
        @media only screen and (max-width: 991px) {

            .mission-media .logo {
                position: absolute;
                right: calc(50% - 67px);
                top: calc(50% - 62px);
            }

            .mission-media {
                justify-content: center;
                align-items: center;
                padding: 0;
            }
            .mission-text, .member-bio {
                font-size: 18px;
                line-height: 27px;
            }
            .member {
                flex-direction: column;
            }
            .member-left .member-info {
                padding: 0;
            }
            .member-right .member-info {
                padding: 0;
            }
            .member-media img {
                width: 80%;
                margin: 0 auto;
                order: 1;
            }
            .member-info {
                order: 2;
            }
            .member-name {
                margin-top: 40px;
            }
        }
        @media only screen and (max-width: 767px) {
            .mission-container {
                flex-direction: column;
            }
            .mission-media {
                padding: 0;
                margin-bottom: 90px;
            }
        }



    </style>
@endsection
