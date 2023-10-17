@extends('template.layout')

@section('title', 'Support Form ' . ' | Just Share Media')

@section('description', 'Support')

@section('content')

    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>Support Form</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Support Form</li>
            </ol>
        </div>
    </section>
    <div>
        <div class="section bg-transparent m-0" style="" data-bottom-top="background-position:0px 300px;" data-top-bottom="background-position:0px -300px;">
            <div class="container clearfix">
                <iframe src="https://forms.monday.com/forms/embed/81719e49c319061c8ccc92e3507db0de?r=use1" width="650" height="1150" style="border: 0; box-shadow: 5px 5px 56px 0 rgba(0,0,0,0.25);"></iframe>
            </div>
        </div>
    </div>
    <x-section-call-to-action/>
@endsection
