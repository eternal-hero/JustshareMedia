@extends('template.layout')

@section('title', 'Tax Rate #' . $taxRate->id . ' | ' . config('app.name'))

@section('description', 'Managing accounts')

@section('content')
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-9">
                    <div class="heading-block border-0">
                        <h3><a href='{{ route('tax-rate.index') }}'>Tax Rates</a> > {{ $taxRate->state_name }}</h3>
                        <span>Tax Rate</span>
                    </div>

                    <div class="clear"></div>
                    <div class="row clearfix">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <h5>State Name</h5>
                                        <div class="input-group">
                                            <p> {{ $taxRate->state_name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <h5>State ISO Code</h5>
                                        <div class="input-group">
                                            <p> {{ $taxRate->state_iso_code }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <h5>Tax Rate (%)</h5>
                                        <div class="input-group">
                                            <p> {{ $taxRate->tax_rate }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col">
                                    <h2>Confirmation</h2>

                                    <form method="POST" action="{{ route('tax-rate.destroy' , $taxRate )}}">
                                        @csrf
                                        @method('DELETE')

                                        <div class="col form-group">
                                            <button class="button button-3d m-0 button-red" type="submit" id="submit"
                                                    name="submit" value="submit">Permanently Delete Item
                                            </button>

                                            <a href='{{ route('tax-rate.index') }}'
                                               class="button button-3d button-dark">
                                                <i class="icon-arrow-left"></i> Go Back
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
