<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'max:255',
            ],
            'description' => [
                'nullable',
                'max:500',
            ],
            'url' => 'url|nullable',
            'receive_email' => [
                'boolean',
            ],
            'notifications_enabled' => [
                'boolean',
            ],
            'telegram_notification_enabled' => [
                'boolean',
            ],
        ];
    }
}
