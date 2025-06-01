<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\NewsHeadline;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FakeNewsController extends Controller
{
    public function show()
    {
        return Inertia::render('Games/FakeNews');
    }

    public function apiRandom(Request $request)
    {
        $question = NewsHeadline::inRandomOrder()->first();
        $score = $request->session()->get('fake_news_score', [
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
        $question = NewsHeadline::findOrFail($request->input('id'));
        $userAnswer = $request->input('answer'); // 'real' or 'fake'
        $isCorrect = ($userAnswer === 'real' && $question->is_real) ||
                     ($userAnswer === 'fake' && !$question->is_real);

        $score = $request->session()->get('fake_news_score', [
            'correct' => 0,
            'answered' => 0,
        ]);
        $score['answered']++;
        if ($isCorrect) {
            $score['correct']++;
        }
        $request->session()->put('fake_news_score', $score);

        return response()->json([
            'result' => [
                'correct' => $isCorrect,
                'source' => $question->source,
                'is_real' => $question->is_real,
            ],
            'score' => $score,
        ]);
    }
}
