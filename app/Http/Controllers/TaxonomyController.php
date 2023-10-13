<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Taxonomy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxonomyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Taxonomy/Index', [
            'list_terms' => json_decode(Setting::where('key', 'list_terms')->first()->value, true),
            'taxonomies' => Taxonomy::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $list_term = json_decode(Setting::where('key', 'list_terms')->first()->value, true);

        $term_key = $request->query('term');

        return Inertia::render('Taxonomy/Create', [
            'list_terms' => $list_term,
            'term_key' => $term_key,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'string|unique:taxonomies,slug',
            'description' => 'nullable|string',
        ]);

        Taxonomy::create($validated);

        return redirect(route('taxonomies.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Taxonomy $taxonomy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Taxonomy $taxonomy)
    {
        return Inertia::render('Taxonomy/Edit', [
            'taxonomy' => $taxonomy,
            'list_terms' => json_decode(Setting::where('key', 'list_terms')->first()->value, true),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Taxonomy $taxonomy): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:taxonomies,slug,'.$taxonomy->id,
            'description' => 'nullable|string',
        ]);

        $taxonomy->update($validated);

        return redirect(route('taxonomies.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Taxonomy $taxonomy)
    {
        //
    }
}
