@extends('template.layout')

@section('title', 'Manual Payment for the subscription')

@section('description', 'Manual Payment for the subscription')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    @if($status == true)
                        You subscription is now active!<br>
                        Go to <a href="{{ route('public.gallery') }}">Gallery page</a> in order to license new video.
                    @else
                        There was issue with payment, please go to <a href="{{ route('dashboard.billing.update') }}">Billing page</a> in order to check your payment method.
                        <br>
                        Error: {{ $message }}
                    @endif

                </div>

                <div class="w-100 line d-block d-md-none"></div>

                <div class="col-md-3">

                    <x-dashboard-menu/>

                </div>

            </div>

        </div>
    </div>

@endsection
