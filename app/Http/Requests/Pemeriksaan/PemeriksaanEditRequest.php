<?php

namespace App\Http\Requests\Pemeriksaan;

use Illuminate\Foundation\Http\FormRequest;

class PemeriksaanEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pasien_id' => [
                'int',
                'exists:pasien,id',
                'required'
            ],
            'dokter_id' => [
                'int',
                'exists:dokter,id',
                'required'
            ],
            'keluhan' => [
                'required',
                'string'
            ],
            'hari' =>[
                'required',
                'date',
                'after_or_equal:now'
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
