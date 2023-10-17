<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PCExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPartnerCompanyRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class PartnerCompanyController extends Controller
{
    public function index() {
        $partnerCompanies = \App\Models\PartnerCompany::all();
        return view('/admin/partner-company/index')->with(compact('partnerCompanies'));
    }

    public function add() {
        return view('/admin/partner-company/add');
    }

    public function store(AddPartnerCompanyRequest $request) {
        $partnerCompany = new \App\Models\PartnerCompany();
        $partnerCompany->name = $request->name;
        $partnerCompany->save();

        return redirect()->route('admin.partner-company.index');
    }

    public function destroy(Request $request) {
        $partnerCompany = \App\Models\PartnerCompany::find($request->id);
        $partnerCompany->subscriptions()->detach();
        $partnerCompany->delete();

        return redirect()->route('admin.partner-company.index');
    }

    public function manage(Subscription $subscription) {
        $allPartnerCompanies = \App\Models\PartnerCompany::all();
        $assignedPartnerCompanies = [];
        foreach ($subscription->partnerCompanies as $partnerCompany) {
            $assignedPartnerCompanies[] = $partnerCompany->id;
        }

        return view('/admin/partner-company/manage')->with(compact('allPartnerCompanies', 'subscription', 'assignedPartnerCompanies'));
    }

    public function assign(Subscription $subscription, Request $request) {
        $assignedPartnerCompanies = $request->assigned ? $request->assigned : [];
        $subscription->partnerCompanies()->detach();
        foreach ($assignedPartnerCompanies as $partnerCompany) {
            if($request->is_percentage) {
                $isPercentage = isset($request->is_percentage[$partnerCompany]);
            } else {
                $isPercentage = false;
            }
            if($request->commission) {
                $commission = isset($request->commission[$partnerCompany]) ? $request->commission[$partnerCompany] : 0;
            } else {
                $commission = 0;
            }
            $subscription->partnerCompanies()->attach($partnerCompany, ['commission' => $commission, 'is_percentage' => $isPercentage]);
        }

        return redirect()->route('admin.orders');
    }

    public function export() {
        return \Maatwebsite\Excel\Facades\Excel::download(new PCExport(), 'partnerCompaniesExport.xlsx');
    }
}
