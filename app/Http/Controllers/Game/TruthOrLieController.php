<?php

namespace App\Http\Controllers\Game;
use App\Http\Controllers\Controller;

use App\Models\TruthOrLieQuestion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TruthOrLieController extends Controller
{
    public function show(Request $request)
    {
        $question = TruthOrLieQuestion::random();
        // Get score from session
        $score = $request->session()->get('truth_or_lie_score', [
            'correct' => 0,
            'answered' => 0,
        ]);
        return Inertia::render('Games/TruthOrLie', [
            'question' => $question,
            'score' => $score,
        ]);
    }

    public function check(Request $request)
    {
        $question = TruthOrLieQuestion::findOrFail($request->input('id'));
        $userAnswer = $request->input('answer'); // 'truth' or 'lie'
        $isCorrect = ($userAnswer === 'truth' && $question->is_truth) ||
                     ($userAnswer === 'lie' && !$question->is_truth);

        // Update score in session
        $score = $request->session()->get('truth_or_lie_score', [
            'correct' => 0,
            'answered' => 0,
        ]);
        $score['answered']++;
        if ($isCorrect) {
            $score['correct']++;
        }
        $request->session()->put('truth_or_lie_score', $score);

        return Inertia::render('Games/TruthOrLie', [
            'question' => $question,
            'result' => [
                'correct' => $isCorrect,
                'explanation' => $question->explanation,
                'is_truth' => $question->is_truth,
            ],
            'score' => $score,
        ]);
    }

    // SPA API: Get random question and score
    public function apiRandom(Request $request)
    {
        $question = TruthOrLieQuestion::inRandomOrder()->first();
        $score = $request->session()->get('truth_or_lie_score', [
            'correct' => 0,
            'answered' => 0,
        ]);
        return response()->json([
            'question' => $question,
            'score' => $score,
        ]);
    }

    // SPA API: Check answer and update score
    public function apiCheck(Request $request)
    {
        $question = TruthOrLieQuestion::findOrFail($request->input('id'));
        $userAnswer = $request->input('answer');
        $isCorrect = ($userAnswer === 'truth' && $question->is_truth) ||
                     ($userAnswer === 'lie' && !$question->is_truth);

        $score = $request->session()->get('truth_or_lie_score', [
            'correct' => 0,
            'answered' => 0,
        ]);
        $score['answered']++;
        if ($isCorrect) {
            $score['correct']++;
        }
        $request->session()->put('truth_or_lie_score', $score);

        return response()->json([
            'result' => [
                'correct' => $isCorrect,
                'explanation' => $question->explanation,
                'is_truth' => $question->is_truth,
            ],
            'score' => $score,
        ]);
    }
}
