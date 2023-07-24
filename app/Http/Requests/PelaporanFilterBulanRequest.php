<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelaporanFilterBulanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bulan' => [
                'required',
                'numeric',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
