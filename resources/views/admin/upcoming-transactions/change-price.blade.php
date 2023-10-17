@extends('template.layout')

@section('title', 'Update Subscription Price | Just Share Roofing Media')

@section('description', 'Update Subscription Price')

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
                        <h3>Update Subscription Price</h3>
                        <span>Update Subscription Price for <b>{{ $subscription->user->company }}</b></span>
                    </div>

                    <div class="clear"></div>

                    <div class="row clearfix">

                        <div class="col">

                            Type custom price <small>(leave blank to fallback to default price)</small>
                            <br>
                            <form method="post" action="{{ route('upcoming-transactions.do-change-price') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="subscription" value="{{ $subscription->id }}">
                                <input type="hidden" name="redirect" value="{{ url()->previous() }}">
                                <input type="number" step="0.01" name="price">
                                <input type="submit" value="Save">
                            </form>


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
