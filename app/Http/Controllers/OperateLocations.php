<?php

namespace App\Http\Controllers;

use App\Models\OperateLocation;
use App\Rules\OperateLocationAddressRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OperateLocations extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operateLocations = OperateLocation::where('user_id', Auth::user()->id)->get();
        return view('dashboard/operate-locations/index', compact('operateLocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard/operate-locations/create');
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
            'user_id' => 'required',
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => [new OperateLocationAddressRule()],
        ]);

        OperateLocation::create($request->all());

        return redirect()->route('operate-locations.index')
            ->with('success', 'Location has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OperateLocation  $operateLocation
     * @return \Illuminate\Http\Response
     */
    public function show(OperateLocation $operateLocation)
    {
        return view('dashboard/operate-locations/show', compact('operateLocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OperateLocation  $operateLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(OperateLocation $operateLocation)
    {
        return view('dashboard/operate-locations/edit', compact('operateLocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OperateLocation  $operateLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OperateLocation $operateLocation)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => [new OperateLocationAddressRule()],
        ]);

        $operateLocation->update($request->all());

        return redirect()->route('operate-locations.index')
            ->with('success', 'Location has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OperateLocation  $operateLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(OperateLocation $operateLocation)
    {
        $operateLocation->delete();

        return redirect()->route('operate-locations.index')
            ->with('success', 'Location has been deleted successfully');
    }


}
