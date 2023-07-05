<?php

namespace App\Http\Requests\Dokter;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Pemeriksaan;
use App\Models\Racikan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DokterDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        $pemeriksaan = Pemeriksaan::all();

        $pemeriksaan_ids = $pemeriksaan->map(function ($data){
            return $data->dokter_id;
        })->flatten();

        $jadwals = Jadwal::all();

        $jadwal_ids = $jadwals->map(function ($jadwal){
            return $jadwal->dokter_id;
        })->flatten();

        return [
            "dokter" => [
                'required',
                'numeric',
                'exists:dokter,id',
                Rule::notIn($jadwal_ids),
                Rule::notIn($pemeriksaan_ids),
            ]
        ];
    }
    public function authorize(): bool
    {
        return true;
    }

}
