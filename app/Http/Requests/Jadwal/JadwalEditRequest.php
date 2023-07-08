<?php

namespace App\Http\Requests\Jadwal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JadwalEditRequest extends FormRequest
{
    public function rules(): array
    {
        $senin = request()->request->get('senin');
        $selasa = request()->request->get('selasa');
        $rabu = request()->request->get('rabu');
        $kamis = request()->request->get('kamis');
        $jumat = request()->request->get('jumat');
        $sabtu = request()->request->get('sabtu');
        $minggu = request()->request->get('minggu');

        $jadwal = request()->route('jadwal');

        return [
            'dokter_id' => [
                'required',
                'exists:dokter,id',
                'unique:jadwals,dokter_id,'.$jadwal->dokter_id,
                'int',
            ],
            'senin' => [
                'required',
                Rule::in(['off','on']),
                'alpha',
            ],
            "start_senin" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $senin == "on")
            ],
            "end_senin" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $senin == "on")
            ],
            'selasa' => [
                'required',
                Rule::in(['off','on']),
                'alpha',
            ],
            "start_selasa" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $selasa == "on")
            ],
            "end_selasa" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $selasa == "on")
            ],
            'rabu' => [
                'required',
                Rule::in(['off','on']),
                'alpha',
            ],
            "start_rabu" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $rabu == "on")
            ],
            "end_rabu" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $rabu == "on")
            ],
            'kamis' => [
                'required',
                Rule::in(['off','on']),
                'alpha',
            ],
            "start_kamis" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $kamis == "on")
            ],
            "end_kamis" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $kamis == "on")
            ],
            'jumat' => [
                'required',
                Rule::in(['off','on']),
                'alpha',
            ],
            "start_jumat" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $jumat == "on")
            ],
            "end_jumat" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $jumat == "on")
            ],
            'sabtu' => [
                'required',
                Rule::in(['off','on']),
                'alpha',
            ],
            "start_sabtu" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $sabtu == "on")
            ],
            "end_sabtu" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $sabtu == "on")
            ],
            'minggu' => [
                'required',
                Rule::in(['off','on']),
                'alpha',
            ],
            "start_minggu" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $minggu == "on")
            ],
            "end_minggu" => [
                'date_format:H:i',
                'nullable',
                Rule::requiredIf(fn()=> $minggu == "on")
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
