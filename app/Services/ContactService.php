<?php

namespace App\Services;

class ContactService
{
    protected AiAnalysisService $aiService;
    protected EmailNotificationService $emailService;

    public function __construct(
        AiAnalysisService $aiService,
        EmailNotificationService $emailService
    ) {
        $this->aiService = $aiService;
        $this->emailService = $emailService;
    }

    public function processContactForm(array $validatedData): void
    {
        $aiReply = $this->aiService->analyzeAndGenerateReply(
            $validatedData['comment'],
            $validatedData['name']
        );

        $this->emailService->sendNotifications($validatedData, $aiReply);
    }
}