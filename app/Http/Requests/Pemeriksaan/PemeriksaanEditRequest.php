<?php

namespace App\Http\Requests\Pemeriksaan;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'after_or_equal:'.Carbon::now()->toDateString()
            ],
            'status' => [
                'required',
                'alpha',
                Rule::in(['antrian','proses','selesai','batal'])
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
