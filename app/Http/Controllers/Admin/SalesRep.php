<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CsvExport;
use App\Exports\SalesRepsExport;
use App\Http\Requests\AddSalesRepRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use net\authorize\util\Log;

class SalesRep extends Controller
{
    public function index() {
        $salesReps = \App\Models\SalesRep::all();
        return view('/admin/sales-rep/index')->with(compact('salesReps'));
    }

    public function add() {
        return view('/admin/sales-rep/add');
    }

    public function store(AddSalesRepRequest $request) {
        $salesRep = new \App\Models\SalesRep();
        $salesRep->name = $request->name;
        $salesRep->save();

        return redirect()->route('admin.sales-rep.index');
    }

    public function destroy(Request $request) {
        $salesRep = \App\Models\SalesRep::find($request->id);
        $salesRep->subscriptions()->detach();
        $salesRep->delete();

        return redirect()->route('admin.sales-rep.index');
    }

    public function manage(Subscription $subscription) {
        $allSalesReps = \App\Models\SalesRep::all();
        $assignedSalesReps = [];
        foreach ($subscription->salesReps as $salesRep) {
            $assignedSalesReps[] = $salesRep->id;
        }

        return view('/admin/sales-rep/manage')->with(compact('allSalesReps', 'subscription', 'assignedSalesReps'));
    }

    public function assign(Subscription $subscription, Request $request) {
        $assignedSalesReps = $request->assigned ? $request->assigned : [];
        $subscription->salesReps()->detach();
        foreach ($assignedSalesReps as $assignedSalesRep) {
            if($request->is_percentage) {
                $isPercentage = isset($request->is_percentage[$assignedSalesRep]);
            } else {
                $isPercentage = false;
            }
            if($request->commission) {
                $commission = isset($request->commission[$assignedSalesRep]) ? $request->commission[$assignedSalesRep] : 0;
            } else {
                $commission = 0;
            }
            $subscription->salesReps()->attach($assignedSalesRep, ['commission' => $commission, 'is_percentage' => $isPercentage]);
        }

        return redirect()->route('admin.orders');
    }

    public function export() {
        return Excel::download(new SalesRepsExport(), 'salesRepsExport.xlsx');
    }

}
