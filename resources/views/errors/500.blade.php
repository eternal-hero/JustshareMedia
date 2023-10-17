@extends('template.layout')

@section('content')

<section id="page-title" class='page-title-mini'>
    <div class="container clearfix">
        <h1>Internal Error</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Error</li>
        </ol>
    </div>
</section>

<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row align-items-center col-mb-80">

                <div class="col-lg-6">
                    <div class="error404 center">!!!</div>
                </div>

                <div class="col-lg-6">

                    <div class="heading-block text-center text-lg-left border-bottom-0">
                        <h4>Oops! We hit an error!</h4>
                        <span>An internal error occurred loading this page.<br/><br/>Visit our <a href='/'>home page</a> to start over.</span>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

@endsection