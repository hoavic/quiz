<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Taxonomy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Country/Index', [
            'countries' => Country::with('continent')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $taxonomies = Taxonomy::whereIn('taxonomy', [
            'diem', 'tai-chinh', 'ngon-ngu', 'thoi-tiet', 'an-toan', 'giai-tri', 'tinh-cach', 'dia-hinh', 'thanh-pho'
        ])->get();
/*         dd($taxonomies); */
        return Inertia::render('Country/Create', [
            'continents' => Continent::orderBy('name', 'asc')->get(),
            'taxonomies' => $taxonomies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'string|unique:continents,slug',
            'continent_id' => 'integer|required',
            'description' => 'nullable|string',
        ]);

        if($continent = Continent::find($validated['continent_id'])) {
            $continent->countries()->create($validated);
        }

        /* Country::create($validated); */

        return redirect(route('countries.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return Inertia::render('Country/Edit', [
            'country' => $country,
            'continents' => Continent::orderBy('name', 'asc')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:continents,slug,'.$country->id,
            'continent_id' => 'integer|required',
            'description' => 'nullable|string',
        ]);

        $country->update($validated);

        return redirect(route('countries.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
