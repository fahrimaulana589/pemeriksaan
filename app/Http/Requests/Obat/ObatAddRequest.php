<?php

namespace App\Http\Requests\Obat;

use Illuminate\Foundation\Http\FormRequest;

class ObatAddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'regex:/^[a-zA-Z0-9,. ]*$/'
            ],
            'file' => [
                "file",
                "image",
                "required",
                "max:5000"
            ],
            'deskripsi' => [
                'regex:/^[a-zA-Z0-9,. ]*$/',
                'required'
            ],
            'stok' => [
                'integer',
                'required',
                'min:1'
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
