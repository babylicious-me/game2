<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\TwoTruthsOneLieQuestion;

class TwoTruthsOneLie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-two-truths-one-lie';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Two Truths and One Lie questions using OpenAI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $topics = [
            'travel',
            'food',
            'technology',
            'history',
            'science',
            'sports',
            'music',
            'movies',
            'nature',
            'fun facts',
        ];

        for ($i = 0; $i < 100; $i++) {
            $topic = $topics[array_rand($topics)];
            $prompt = <<<EOT
Give me a Two Truths and One Lie set about {$topic}. Return JSON like this:

{
  "statement_1": "I’ve been skydiving twice.",
  "is_truth_1": true,
  "statement_2": "I can speak six languages fluently.",
  "is_truth_2": false,
  "statement_3": "I once met a president by accident.",
  "is_truth_3": true
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

                if (
                    !isset($parsed['statement_1'], $parsed['is_truth_1'], $parsed['statement_2'], $parsed['is_truth_2'], $parsed['statement_3'], $parsed['is_truth_3'])
                ) {
                    $this->warn("⚠️ [$i] Bad format: $content");
                    continue;
                }

                // Avoid duplicates
                if (TwoTruthsOneLieQuestion::where('statement_1', $parsed['statement_1'])
                    ->where('statement_2', $parsed['statement_2'])
                    ->where('statement_3', $parsed['statement_3'])
                    ->exists()) {
                    $this->warn("⚠️ [$i] Duplicate skipped: {$parsed['statement_1']} / {$parsed['statement_2']} / {$parsed['statement_3']}");
                    continue;
                }

                TwoTruthsOneLieQuestion::create([
                    'statement_1' => $parsed['statement_1'],
                    'is_truth_1' => $parsed['is_truth_1'],
                    'statement_2' => $parsed['statement_2'],
                    'is_truth_2' => $parsed['is_truth_2'],
                    'statement_3' => $parsed['statement_3'],
                    'is_truth_3' => $parsed['is_truth_3'],
                ]);

                $this->info("✅ [$i] Question saved: {$parsed['statement_1']} / {$parsed['statement_2']} / {$parsed['statement_3']}");

            } catch (\Throwable $e) {
                $this->error("💥 [$i] Exception: " . $e->getMessage());
                continue;
            }
        }

        $this->info("🎉 Done! 100 (or fewer) Two Truths and One Lie questions created.");
    }
}
