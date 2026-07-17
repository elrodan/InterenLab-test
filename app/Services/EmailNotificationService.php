<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class EmailNotificationService
{
    public function sendNotifications(array $data, string $aiReply): void
    {
        $logData = [
            'to_owner' => 'owner@company.com',
            'to_user' => $data['email'],
            'user_name' => $data['name'],
            'comment' => $data['comment'],
            'ai_generated_reply' => $aiReply,
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::channel('single')->info('Email notification simulated', $logData);
    }
}