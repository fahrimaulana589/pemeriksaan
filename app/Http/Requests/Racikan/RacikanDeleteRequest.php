<?php

namespace App\Http\Requests\Racikan;

use Illuminate\Foundation\Http\FormRequest;

class RacikanDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'racikan' => [
                'required',
                'numeric',
                'exists:racikan,id',
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
