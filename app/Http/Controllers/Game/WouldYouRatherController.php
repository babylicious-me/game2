<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\WouldYouRatherQuestion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WouldYouRatherController extends Controller
{
    // Show the SPA view for the game
    public function show()
    {
        return Inertia::render('Games/WouldYouRather');
    }

    public function apiRandom(Request $request)
    {
        $question = WouldYouRatherQuestion::inRandomOrder()->first();
        $score = $request->session()->get('would_you_rather_score', [
            'a' => 0,
            'b' => 0,
            'answered' => 0,
        ]);
        return response()->json([
            'question' => $question,
            'score' => $score,
        ]);
    }

    public function apiAnswer(Request $request)
    {
        $question = WouldYouRatherQuestion::findOrFail($request->input('id'));
        $choice = $request->input('answer');
        if ($choice === 'a') {
            $question->increment('votes_a');
        } else {
            $question->increment('votes_b');
        }
        $total = $question->votes_a + $question->votes_b;
        $percent_a = $total ? round($question->votes_a / $total * 100) : 0;
        $percent_b = $total ? round($question->votes_b / $total * 100) : 0;

        $score = $request->session()->get('would_you_rather_score', [
            'a' => 0,
            'b' => 0,
            'answered' => 0,
        ]);
        $score[$choice]++;
        $score['answered']++;
        $request->session()->put('would_you_rather_score', $score);

        return response()->json([
            'result' => [
                'percent_a' => $percent_a,
                'percent_b' => $percent_b,
            ],
            'score' => $score,
        ]);
    }
}
