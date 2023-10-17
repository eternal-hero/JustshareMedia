@extends('template.layout')

@section('title', $page->title . ' | ' . config('app.name'))

@section('description', 'Support')

@section('content')

    <section id="page-title" class='page-title-mini'>
        <div class="container clearfix">
            <h1>{{$page->title}}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$page->title}}</li>
            </ol>
        </div>
    </section>
    <div>
        <div class="section bg-transparent m-0" style="" data-bottom-top="background-position:0px 300px;" data-top-bottom="background-position:0px -300px;">
            <div class="container clearfix">
                {!! $page->content !!}
            </div>
        </div>
    </div>
    <x-section-call-to-action/>
@endsection
