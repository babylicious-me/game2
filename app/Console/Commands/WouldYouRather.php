<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\WouldYouRatherQuestion;

class WouldYouRather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-would-you-rather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate funny or interesting Would You Rather questions using OpenAI';

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
            'animals',
            'psychology',
            'language & etymology',
            'body facts',
        ];

        for ($i = 0; $i < 100; $i++) {
            $topic = $topics[array_rand($topics)];
            $prompt = <<<EOT
Give me a funny or interesting "Would You Rather" question about {$topic}. Return JSON like:

{
  "option_a": "Be able to speak to animals",
  "option_b": "Be able to speak every human language"
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

                if (!isset($parsed['option_a'], $parsed['option_b'])) {
                    $this->warn("⚠️ [$i] Bad format: $content");
                    continue;
                }

                // Avoid duplicates
                if (WouldYouRatherQuestion::where('option_a', $parsed['option_a'])->where('option_b', $parsed['option_b'])->exists()) {
                    $this->warn("⚠️ [$i] Duplicate skipped: {$parsed['option_a']} / {$parsed['option_b']}");
                    continue;
                }

                WouldYouRatherQuestion::create([
                    'option_a' => $parsed['option_a'],
                    'option_b' => $parsed['option_b'],
                ]);

                $this->info("✅ [$i] Question saved: {$parsed['option_a']} / {$parsed['option_b']}");

            } catch (\Throwable $e) {
                $this->error("💥 [$i] Exception: " . $e->getMessage());
                continue;
            }
        }

        $this->info("🎉 Done! 100 (or fewer) Would You Rather questions created.");
    }
}
