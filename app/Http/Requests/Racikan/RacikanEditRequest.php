<?php

namespace App\Http\Requests\Racikan;

use App\Models\Obat;
use Illuminate\Foundation\Http\FormRequest;

class RacikanEditRequest extends FormRequest
{
    public function rules(): array
    {
        $obat_id = request()->request->get('obat_id');
        $stok = Obat::find($obat_id)->stok;
        dd(request()->route());
//        $jumlah = request()->route()->parameter('racikan')->jumlah;

        return [
            'obat_id' => [
                'int',
                'exists:obats,id',
                'required'
            ],
            'pemeriksaan_id' =>[
                'int',
                'exists:pemeriksaan,id',
                'required'
            ],
            'jumlah' => [
                'int',
                'min:1',
                'required',
                'max:'.$jumlah+$stok
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
