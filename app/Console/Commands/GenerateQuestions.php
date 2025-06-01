<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\TruthOrLieQuestion;

class GenerateQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle()
{
    $topics = [
        'space',
        'technology',
        'weird food',
        'historical events',
        'science facts',
        'bizarre inventions',
        'animals (not flamingos)',
        'psychology',
        'language & etymology',
        'body facts (not brains)',
    ];

                for ($i = 0; $i < 100; $i++) {
                $is_truth = $i % 2 === 0; // alternate between true and false
                $topic = $topics[array_rand($topics)];

                $truthText = $is_truth ? 'true' : 'false';
                $prompt = <<<EOT
            Generate a short, lesser-known trivia-style statement about {$topic} (max 12 words). 
            It must be {$truthText}. 
            Do NOT include "True or false:", "Is it true that...", or any question-like phrasing. 
            Just return a clean factual-sounding statement.

            Respond ONLY with valid JSON like this:

            {
            "text": "Statement here.",
            "is_truth": {$truthText},
            "explanation": "Short explanation under 15 words."
            }
            EOT;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.key'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $raw = $response->json();
            $content = $raw['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                $this->error("❌ [$i] Empty response.");
                continue;
            }

            $parsed = json_decode($content, true);

            if (!isset($parsed['text'], $parsed['is_truth'], $parsed['explanation'])) {
                $this->warn("⚠️ [$i] Bad format: $content");
                continue;
            }

            // Avoid duplicates
            if (\App\Models\TruthOrLieQuestion::where('text', $parsed['text'])->exists()) {
                $this->warn("⚠️ [$i] Duplicate skipped: {$parsed['text']}");
                continue;
            }

            \App\Models\TruthOrLieQuestion::create([
                'text' => $parsed['text'],
                'is_truth' => $parsed['is_truth'],
                'explanation' => $parsed['explanation'],
            ]);

            $this->info("✅ [$i] Question saved: {$parsed['text']}");

        } catch (\Throwable $e) {
            $this->error("💥 [$i] Exception: " . $e->getMessage());
            continue;
        }
    }

    $this->info("🎉 Done! 100 (or fewer) trivia questions created with style.");
}


}
