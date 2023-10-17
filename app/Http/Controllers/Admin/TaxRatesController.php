<?php

namespace App\Http\Controllers\Admin;

use App\Models\TaxRate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaxRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxRates = TaxRate::all();

        return view('admin/taxRate/index', compact('taxRates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/taxRate/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'state_name' => 'required',
            'state_iso_code' => 'required|unique:tax_rates,state_iso_code',
            'tax_rate' => 'numeric'
        ]);

        TaxRate::create($request->only(['state_name', 'state_iso_code', 'tax_rate']));

        return redirect()->route('tax-rate.index')
            ->with('success', 'Tax Rate created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaxRate  $taxRate
     * @return \Illuminate\Http\Response
     */
    public function show(TaxRate $taxRate)
    {
        return view('admin/taxRate/show', compact('taxRate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaxRate  $taxRate
     * @return \Illuminate\Http\Response
     */
    public function edit(TaxRate $taxRate)
    {
        return view('admin/taxRate/edit', compact('taxRate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxRate  $taxRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaxRate $taxRate)
    {
        $request->validate([
            'state_name' => 'required',
            'state_iso_code' => 'required',
            'tax_rate' => 'numeric'
        ]);

        $taxRate->update($request->only(['state_name', 'state_iso_code', 'tax_rate']));

        return redirect()->route('tax-rate.index')
            ->with('success', 'Tax Rate updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaxRate  $taxRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxRate $taxRate)
    {
        $taxRate->delete();

        return redirect()->route('tax-rate.index')
            ->with('success', 'Tax Rate was deleted successfully');
    }

    public function getStateTaxRate(Request $request)
    {
        return response()->json(['taxRate' => (TaxRate::where(['state_iso_code' => $request->post('state_code')])->first())->tax_rate / 100 ]);
    }
}
