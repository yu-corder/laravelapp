<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TotonoiHistoryRequest extends FormRequest
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
        return [
            'sauna_id'   => 'required|exists:saunas,id',
            'visit_date' => 'required|date',
            'comment'    => 'nullable|string|max:500',
            'price'      => 'nullable|integer|min:0',
        ];
    }
}
