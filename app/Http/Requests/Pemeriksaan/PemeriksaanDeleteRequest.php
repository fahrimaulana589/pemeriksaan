<?php

namespace App\Http\Requests\Pemeriksaan;

use App\Models\Jadwal;
use App\Models\Racikan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        $racikans = Racikan::all();

        $racikan_ids = $racikans->map(function ($racikan){
            return $racikan->pemeriksaan_id;
        })->flatten();

        return [
            'pemeriksaan' => [
                'required',
                'numeric',
                'exists:pemeriksaan,id',
                Rule::notIn($racikan_ids)
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
