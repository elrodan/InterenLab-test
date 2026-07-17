<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'required|string|regex:/^[\d\s\+\-\(\)]{10,20}$/',
            'comment' => 'required|string|max:1000',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'    => 'Имя обязательно для заполнения.',
            'email.required'   => 'Email обязателен для заполнения.',
            'email.email'      => 'Некорректный формат email.',
            'phone.required'   => 'Телефон обязателен для заполнения.',
            'phone.regex'      => 'Некорректный формат телефона.',
            'comment.required' => 'Комментарий обязателен для заполнения.',
        ];
    }
}