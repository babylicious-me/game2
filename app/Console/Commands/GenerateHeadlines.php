<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\NewsHeadline;

class GenerateHeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-headlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate real or fake news headlines using OpenAI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        for ($i = 0; $i < 100; $i++) {
            $prompt = <<<EOT
Give me a news headline that is either fake or real.
Return ONLY valid JSON:
{
  "headline": "Example Headline",
  "is_real": true,
  "source": "BBC"
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

                if (!isset($parsed['headline'], $parsed['is_real'])) {
                    $this->warn("⚠️ [$i] Bad format: $content");
                    continue;
                }

                // Avoid duplicates
                if (NewsHeadline::where('headline', $parsed['headline'])->exists()) {
                    $this->warn("⚠️ [$i] Duplicate skipped: {$parsed['headline']}");
                    continue;
                }

                NewsHeadline::create([
                    'headline' => $parsed['headline'],
                    'is_real' => $parsed['is_real'],
                    'source' => $parsed['source'] ?? null,
                ]);

                $this->info("✅ [$i] Headline saved: {$parsed['headline']}");

            } catch (\Throwable $e) {
                $this->error("💥 [$i] Exception: " . $e->getMessage());
                continue;
            }
        }

        $this->info("🎉 Done! 100 (or fewer) news headlines created.");
    }
}
