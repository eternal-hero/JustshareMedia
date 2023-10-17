<?php

namespace App\Exports;

use App\Models\PartnerCompany;
use App\Models\SalesRep;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PCExport implements FromView
{

    public function view(): View
    {
        return view('admin.exports.pc', [
            'partnerCompanies' => PartnerCompany::all()
        ]);
    }
}
