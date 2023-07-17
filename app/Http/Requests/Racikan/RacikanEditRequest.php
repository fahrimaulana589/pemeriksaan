<?php

namespace App\Http\Requests\Racikan;

use App\Models\Obat;
use App\Models\Racikan;
use Illuminate\Foundation\Http\FormRequest;

class RacikanEditRequest extends FormRequest
{
    public function rules(): array
    {
        $obat_id = request()->request->get('obat_id');
        $stok = Obat::find($obat_id) != null ? Obat::find($obat_id)->stok : 0;

        $jumlah = request()->route()->parameter('racikan');
        $jumlah = Racikan::find($jumlah) != null ? Racikan::find($jumlah)->jumlah : 0;

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
