<?php

namespace App\Http\Controllers;

use App\Models\Take;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user() === 1) {
            $takes = Take::all();
        } else {
            $takes = Auth::user()->takes();
        }
        return Inertia::render('Take/Index', [
            'takes' => $takes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Take/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Take $take)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Take $take)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Take $take)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Take $take)
    {
        //
    }
}
