<?php

namespace App\Http\Controllers;

use App\Models\Take;
use App\Rules\Recaptcha;
use Illuminate\Http\RedirectResponse;
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
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'quiz_id' => 'required|integer',
            'status' => 'required|integer',
            'score' => 'nullable|integer',
            'published' => 'nullable|integer',
            'published_at' => 'nullable|date',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'content' => 'nullable|string',
            'takeAnswers' => 'array',
            'captcha_token' => ['required', new Recaptcha],
        ]);
/*
        dd($validated['captcha_token']); */

        $take = $request->user()->takes()->create($validated);

        $takeAnswers = $validated['takeAnswers'];

        foreach($takeAnswers as $takeAnswer) {

            $take->takeAnswers()->create($takeAnswer);

        }

        return redirect(route('quizzes.show', $validated['quiz_id']));
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
