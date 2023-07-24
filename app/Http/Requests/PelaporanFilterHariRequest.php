<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelaporanFilterHariRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first' => [
                'required',
                'date',
                'before:last'
            ], // Aturan validasi "date" akan memeriksa format tanggal
            'last' => [
                'required',
                'date',
                'before_or_equal:today',
                'after:first'
            ], // Aturan validasi "date" akan memeriksa format tanggal
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
