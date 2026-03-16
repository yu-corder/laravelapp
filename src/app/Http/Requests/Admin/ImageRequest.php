<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('*.upload*')) {
            return [
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
                'upload_token' => 'required|string',
            ];
        }

        if ($this->routeIs('*.delete*')) {
            return [
                'id' => 'required|integer',
            ];
        }

        return [];
    }

    public function messages(): array
    {
        return [
            'image.max'      => '画像サイズは10MB以内にしてください。',
            'upload_token.required' => 'セッションエラーが発生しました。',
        ];
    }
}
