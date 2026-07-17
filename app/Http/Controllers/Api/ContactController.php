<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ContactController extends Controller
{
    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    #[OA\Post(
        path: "/api/contact",
        summary: "Отправка формы обратной связи",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "phone", "comment"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Иван Иванов"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "ivan@example.com"),
                    new OA\Property(property: "phone", type: "string", example: "+79991234567"),
                    new OA\Property(property: "comment", type: "string", example: "Интересует сотрудничество"),
                ]
            )
        ),
        tags: ["Contact"],
        responses: [
            new OA\Response(response: 200, description: "Успешно отправлено"),
            new OA\Response(response: 422, description: "Ошибка валидации"),
            new OA\Response(response: 429, description: "Превышен лимит запросов"),
            new OA\Response(response: 500, description: "Внутренняя ошибка сервера"),
        ]
    )]
    public function store(ContactFormRequest $request): JsonResponse
    {
        try {
            $this->contactService->processContactForm($request->validated());

            return response()->json([
                'message' => 'Ваше сообщение успешно отправлено. Мы свяжемся с Вами в ближайшее время.'
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Contact form processing failed', [
                'error' => $e->getMessage(),
                'data' => $request->validated()
            ]);

            return response()->json([
                'message' => 'Произошла ошибка при обработке Вашего сообщения. Пожалуйста, попробуйте позже.'
            ], 500);
        }
    }
}