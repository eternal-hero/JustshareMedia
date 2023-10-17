@extends('template.layout')

@section('title', 'About Us | Just Share Media')
{{--@section('title', 'About Us | Just Share Roofing Media')--}}

@section('description', 'Discover who we are, our mission, and what we can provide to your business.')

@section('content')

    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Payment Error</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment error</li>
            </ol>
        </div>
    </section>

    <div class="content-wrap py-0">

        <div class="section bg-transparent m-0" id='services'>

            <div class="container">

                <div class="heading-block center">
                    <h2>Payment error</h2>
                </div>

                <div class="row col-mb-50">

                    <div class="col topmargin">

                        <p style="text-align: center">Declined</p>
                        <p style="text-align: center"><a href="{{ route('public.gallery') }}">Please try again</a></p>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
