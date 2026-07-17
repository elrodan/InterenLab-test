<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

class SystemController extends Controller
{
    #[OA\Get(
        path: "/api/health",
        summary: "Проверка статуса сервиса",
        tags: ["System"],
        responses: [
            new OA\Response(response: 200, description: "Сервис работает")
        ]
    )]
    public function health(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toDateTimeString(),
            'service' => 'Landing API'
        ]);
    }

    #[OA\Get(
        path: "/api/metrics",
        summary: "Статистика обращений",
        tags: ["System"],
        responses: [
            new OA\Response(response: 200, description: "Статистика получена")
        ]
    )]
    public function metrics(): \Illuminate\Http\JsonResponse
    {
        $logPath = storage_path('logs/laravel.log');
        $successCount = 0;

        if (file_exists($logPath)) {
            $logs = file_get_contents($logPath);
            $successCount = substr_count($logs, 'Email notification simulated');
        }

        return response()->json([
            'total_successful_submissions' => $successCount,
            'uptime' => 'N/A (local env)'
        ]);
    }
}