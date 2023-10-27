<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TermSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if($term = Setting::where('key', 'list_terms')->first()) {
        } else {
            $term = new Setting();
        }

        return Inertia::render('TermSetting/Create', [
            'term' => $term
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
/*     public function create()
    {
        return Inertia::render('Setting/Create');
    } */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'termValue' => 'nullable|string',
        ]);

        dd($validated['termValue']);

        Setting::create($validated);

        return redirect(route('terms.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $term)
    {
        return Inertia::render('Setting/Edit', ['term' => $term]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $term): RedirectResponse
    {
        $validated = $request->validate([
            'value' => 'nullable|string',
        ]);

        $term->update($validated);

        return redirect(route('terms.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $term)
    {
        //
    }
}
