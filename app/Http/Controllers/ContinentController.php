<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContinentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Continent/Index', [
            'continents' => Continent::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Continent/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'string|unique:continents,slug',
            'description' => 'nullable|string',
        ]);

        Continent::create($validated);

        return redirect(route('continents.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Continent $continent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Continent $continent)
    {
        return Inertia::render('Continent/Edit', ['continent' => $continent]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Continent $continent): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:continents,slug,'.$continent->id,
            'description' => 'nullable|string',
        ]);

        $continent->update($validated);

        return redirect(route('continents.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Continent $continent)
    {
        //
    }
}
