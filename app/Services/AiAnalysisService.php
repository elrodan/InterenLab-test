<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAnalysisService
{
    public function analyzeAndGenerateReply(string $comment, string $userName): string
    {
        $fallbackReply = "Здравствуйте, {$userName}! Спасибо за ваше обращение. Мы обязательно его рассмотрим и свяжемся с вами в ближайшее время.";

        $apiKey = config('services.openai.api_key');
        if (empty($apiKey)) {
            Log::info('AI skipped: no API key provided');
            return $fallbackReply;
        }

        try {
            $response = Http::timeout(5)->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Кратко определи тональность и напиши вежливый ответ от лица разработчика.'],
                    ['role' => 'user', 'content' => $comment]
                ]
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content') ?: $fallbackReply;
            }

            Log::warning('AI API error', ['status' => $response->status()]);
            return $fallbackReply;

        } catch (\Exception $e) {
            Log::error('AI service failed', ['error' => $e->getMessage()]);
            return $fallbackReply;
        }
    }
}