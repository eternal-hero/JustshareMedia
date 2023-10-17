@extends('template.layout')

@section('title', 'Update Subscription | Just Share Roofing Media')

@section('description', 'Update Subscription')

@section('js_additional')
    <script src="/assets/js/components/bs-datatable.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable1').dataTable({
                "bSort" : false
            });
        });
    </script>
@endsection

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    <div class="heading-block border-0">
                        <h3>Update Subscription</h3>
                        <span>Update Subscription</span>
                    </div>

                    <div class="clear"></div>

                    <div class="row clearfix">

                        <div class="col">

                            Subscription will be switched to <b>{{ $type }}</b> on {{ $endAtDate->format('Y-m-d') }}
                            <br>
                            <a href="{{ route('upcoming-transactions') }}">Go back</a>


                        </div>
                    </div>
                </div>
                <div class="w-100 line d-block d-md-none"></div>
                <div class="col-md-3">
                    <x-dashboard-menu/>
                </div>
            </div>

        </div>
    </div>

@endsection
