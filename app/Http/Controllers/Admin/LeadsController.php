<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leads;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function index() {
        $leads = Leads::all();

        return view('admin.leads.index')->with(compact('leads'));
    }

    public function add() {
        return view('admin.leads.add');
    }

    public function store(Request $request) {
        $lead = new Leads();
        $lead->name = $request->name;
        $lead->save();

        return redirect()->route('admin.leads.index');
    }
}
