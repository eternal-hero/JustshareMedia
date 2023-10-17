<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportPage;
use Illuminate\Http\Request;

class SupportPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supportPages = SupportPage::all();

        return view('admin.supportPages.index', compact('supportPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supportPages.create');
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
            'title' => 'required|string',
            'url' => 'required|unique:support_pages,url|string',
            'content' => 'required|string'
        ]);

        SupportPage::create($request->only(['title', 'url', 'content']));

        return redirect()->route('support-pages.index')
            ->with('success', 'Support Page was created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupportPage  $supportPage
     * @return \Illuminate\Http\Response
     */
    public function show(SupportPage $supportPage)
    {
        return view('admin.supportPages.show', compact('supportPage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupportPage  $supportPage
     * @return \Illuminate\Http\Response
     */
    public function edit(SupportPage $supportPage)
    {
        return view('admin.supportPages.edit', compact('supportPage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupportPage  $supportPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupportPage $supportPage)
    {
        $request->validate([
            'title' => 'required|string',
            'url' => 'required|string',
            'content' => 'required|string'
        ]);

        $supportPage->update($request->only(['title', 'url', 'content']));

        return redirect()->route('support-pages.index')
            ->with('success', 'Tax Rate updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupportPage  $supportPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupportPage $supportPage)
    {
        $supportPage->delete();

        return redirect()->route('support-pages.index')
            ->with('success', 'Support Page was deleted successfully');
    }
}
