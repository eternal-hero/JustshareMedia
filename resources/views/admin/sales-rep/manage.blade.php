@extends('template.layout')

@section('title', 'Add Sales Rep | Just Share Roofing Media')

@section('description', 'Adding Sales Rep')

@section('content')

    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-9">

                    <div class="heading-block border-0">
                        <h3>Managing Sales Rep for {{ $subscription->user->company }}</h3>
                    </div>

                    <div class="clear"></div>

                    <div class="row clearfix">

                        <div class="col">

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <i class="icon-exclamation-triangle"></i> {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    <i class="icon-check-circle"></i> {{ session('success') }}
                                </div>
                            @endif

                            <form class="js-validation-signin" method="POST" action="{{ route('admin.sales-rep-assign', ['subscription' => $subscription->id]) }}">
                                @csrf
                                @foreach($allSalesReps as $salesRep)
                                @php
                                    if(in_array($salesRep->id, $assignedSalesReps)) {
                                        $pivot = $subscription->salesReps()->find($salesRep->id)->pivot;
                                    } else {
                                        unset($pivot);
                                    }
                                @endphp
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="input-group" style="display: flex; align-items: center; justify-content: space-between;">
                                                <div>
                                                    <span class="mr-1">Assigned:</span>
                                                    <input type="checkbox" {!! in_array($salesRep->id, $assignedSalesReps) ? 'checked' : '' !!} name="assigned[{{$salesRep->id}}]" value="{{ $salesRep->id }}" class="mr-2">
                                                    <span class="mr-1">{{ $salesRep->name }}</span>
                                                </div>
                                                <div>
                                                    <span class="mr-1">Commission</span>
                                                    <input type="text" name="commission[{{$salesRep->id}}]" value="{!! isset($pivot) ? $pivot->commission : 0 !!}" class="mr-1">
                                                    <span class="mr-1">Is percentage?</span>
                                                    <input type="checkbox" {!! isset($pivot) && $pivot->is_percentage ? 'checked' : '' !!} name="is_percentage[{{$salesRep->id}}]" value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="form-group text-center">
                                    <button type="submit" class="button button-3d">
                                        <i class="icon-check"></i> Save
                                    </button>
                                </div>
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
