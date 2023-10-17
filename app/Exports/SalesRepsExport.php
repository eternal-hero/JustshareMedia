<?php

namespace App\Exports;

use App\Models\SalesRep;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesRepsExport implements FromView
{

    public function view(): View
    {
        return view('admin.exports.sales-rep', [
            'salesReps' => SalesRep::all()
        ]);
    }
}
