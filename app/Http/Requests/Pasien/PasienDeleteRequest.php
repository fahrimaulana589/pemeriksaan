<?php

namespace App\Http\Requests\Pasien;

use App\Models\Pemeriksaan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasienDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        $pemeriksaan = Pemeriksaan::all();

        $pemeriksaan_ids = $pemeriksaan->map(function ($data){
            return $data->pasien_id;
        })->flatten();

        return [
            "pasien" => [
                'required',
                'numeric',
                'exists:pasien,id',
                Rule::notIn($pemeriksaan_ids),
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
