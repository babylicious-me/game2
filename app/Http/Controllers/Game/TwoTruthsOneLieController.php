<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\TwoTruthsOneLieQuestion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TwoTruthsOneLieController extends Controller
{
    public function show()
    {
        return Inertia::render('Games/TwoTruthsOneLie');
    }

    public function apiRandom(Request $request)
    {
        $question = TwoTruthsOneLieQuestion::inRandomOrder()->first();
        $score = $request->session()->get('two_truths_one_lie_score', [
            'correct' => 0,
            'answered' => 0,
        ]);
        return response()->json([
            'question' => $question,
            'score' => $score,
        ]);
    }

    public function apiAnswer(Request $request)
    {
        $question = TwoTruthsOneLieQuestion::findOrFail($request->input('id'));
        $answer = $request->input('answer'); // 1, 2, or 3
        $isLie = [
            1 => !$question->is_truth_1,
            2 => !$question->is_truth_2,
            3 => !$question->is_truth_3,
        ];
        $isCorrect = $isLie[$answer] ?? false;
        $lieStatement = '';
        if (!$question->is_truth_1) $lieStatement = $question->statement_1;
        if (!$question->is_truth_2) $lieStatement = $question->statement_2;
        if (!$question->is_truth_3) $lieStatement = $question->statement_3;

        $score = $request->session()->get('two_truths_one_lie_score', [
            'correct' => 0,
            'answered' => 0,
        ]);
        $score['answered']++;
        if ($isCorrect) {
            $score['correct']++;
        }
        $request->session()->put('two_truths_one_lie_score', $score);

        return response()->json([
            'result' => [
                'correct' => $isCorrect,
                'lie' => $lieStatement,
            ],
            'score' => $score,
        ]);
    }
}
