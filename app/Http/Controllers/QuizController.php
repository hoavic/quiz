<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Take;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user() === 1) {
            $quizzes = Quiz::all();
        } else {
            $quizzes = Auth::user()->quizzes()->get();
        }

        return Inertia::render('Quiz/Index', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        switch($request->query('type')) {
            case 'basic':
                $path = 'Type/Basic';
                break;

            default:
                $path = 'Choose';
                break;
        }

        return Inertia::render('Quiz/'.$path, [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:quizzes,slug',
            'summary' => 'nullable|string',
            'type' => 'required|string',
            'published' => 'nullable|integer',
            'published_at' => 'nullable|date',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'content' => 'nullable|string',
            'questions' => 'array',
        ]);

        $quiz = $request->user()->quizzes()->create($validated);

        $questions = $validated['questions'];

        foreach($questions as $question) {

            $question['quiz_id'] = $quiz->id;

            $newQuestion = $quiz->questions()->create($question);

            foreach($question['answers'] as $answer) {
                $answer['quiz_id'] = $quiz->id;
                $answer['question_id'] = $newQuestion->id;
                $newQuestion->answers()->create($answer);
            }
        }

        return redirect(route('quizzes.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        return Inertia::render('Quiz/Show', [
            'quiz' => $quiz->load('questions.answers'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Quiz $quiz)
    {
        switch($quiz->type) {
            case 'basic':
                $path = 'Type/Basic';
                break;

            default:
                $path = 'Choose';
                break;
        }

        return Inertia::render('Quiz/'.$path, [
            'quiz' => $quiz->load('questions.answers')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        $this->authorize('update', $quiz);

        $validated = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:quizzes,slug,'.$quiz->id,
            'summary' => 'nullable|string',
            'type' => 'required|string',
            'published' => 'nullable|integer',
            'published_at' => 'nullable|date',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'content' => 'nullable|string',
            'questions' => 'array',
        ]);

        $quiz->update($validated);

        $questions = $validated['questions'];

/*         $quiz
            ->questions()
            ->whereNotIn('id', collect($questions)->pluck('id'))
            ->delete(); */

        $old_question_ids = $quiz->questions->pluck('id');
        $new_question_ids = collect($questions)->pluck('id');
/*         dd($new_question_ids->toArray()); */
        foreach($old_question_ids as $old_question_id) {
            if(!in_array($old_question_id, $new_question_ids->toArray())) {
                $deleted_question = Question::find($old_question_id)->delete();
            }
        }

        foreach($questions as $question) {

            $newQuestion = $quiz->questions()->updateOrCreate([
                'id' => $question['id'] ?? null,
            ], $question);

/*             $newQuestion
                ->answers()
                ->whereNotIn('id', collect($question['answers'])->pluck('id'))
                ->delete(); */

            $quiz
                ->questions()
                ->where('id', $newQuestion->id)
                ->first()
                ->answers()
                ->whereNotIn('id', collect($question['answers'])->pluck('id'))
                ->delete();

            foreach($question['answers'] as $answer) {
                if(empty($answer['quiz_id'])) {$answer['quiz_id'] = $quiz->id;}
                    $quiz
                        ->questions()
                        ->where('id', $newQuestion->id)
                        ->first()
                        ->answers()->updateOrCreate([
                        'id' => $answer['id'] ?? null,
                    ], $answer);
            }

        }

        return redirect(route('quizzes.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
