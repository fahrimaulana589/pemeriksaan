<?php

namespace App\Http\Requests\Pasien;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasienAddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'regex:/^[a-zA-Z ]*$/'
            ],
            'file' => [
                'required',
                'file',
                'image',
                'max:5000'
            ],
            'gender'=>[
                'required',
                Rule::in(['pria','wanita'])
            ],
            'harlah'=> [
                'required',
                'date',
                'before_or_equal:now'
            ],
            'desa' => [
                'required',
                'regex:/^[a-zA-Z ]*$/'
            ],
            'kecamatan' => [
                'required',
                'regex:/^[a-zA-Z ]*$/'
            ],
            'kabupaten_kota' => [
                'required',
                'regex:/^[a-zA-Z ]*$/'
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
