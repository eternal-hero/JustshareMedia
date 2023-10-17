@extends('template.layout')

{{--@section('title', 'Contact Us | Just Share Roofing Media')--}}
@section('title', 'Contact Us | Just Share Media')

@section('description', 'Contact us via email or social media. We look forward to speaking with you!')

@section('js_additional')
    <!-- Facebook scripts -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v8.0" nonce="Uqtudd8l"></script>

    {{--<!-- Google Recaptcha -->
    {!! NoCaptcha::renderJs() !!}--}}
@endsection

@section('content')

    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Contact Us</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact</li>
            </ol>
        </div>
    </section>

    <div class="content-wrap">

        <div class="container">

            <div class="row gutter-40 col-mb-80">
                <!-- Postcontent
                ============================================= -->
                <div class="postcontent col-lg-8">

                    <h3>Send us an Email</h3>


                    <div class="container clearfix">
                        <iframe src="https://forms.monday.com/forms/embed/81719e49c319061c8ccc92e3507db0de?r=use1" width="650" height="1150" style="border: 0; box-shadow: 5px 5px 56px 0 rgba(0,0,0,0.25);"></iframe>
                    </div>

                </div>

                <!-- Social Media -->
                <div class="postcontent col-lg-4">
                    <h3>Social Media</h3>
                    <p>We are also available on Facebook.</p>
                    <div class="fb-page"
                        data-href="https://www.facebook.com/justsharemedia"
                        data-tabs=""
                        data-width=""
                        data-height=""
                        data-small-header="false"
                        data-adapt-container-width="true"
                        data-hide-cover="false"
                        data-show-facepile="true"
                    >
                        <blockquote
                            cite="https://www.facebook.com/justsharemedia"
                            class="fb-xfbml-parse-ignore"
                        >
                            <a href="https://www.facebook.com/justsharemedia">Just Share Roofing Media</a>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>

        <x-section-services/>

    </div>

@endsection
