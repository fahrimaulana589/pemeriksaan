<?php

namespace App\Http\Requests\Jadwal;

use Illuminate\Foundation\Http\FormRequest;

class JadwalDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'jadwal' => [
                'required',
                'numeric',
                'exists:jadwals,id',
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
