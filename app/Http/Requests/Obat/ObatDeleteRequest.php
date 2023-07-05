<?php

namespace App\Http\Requests\Obat;

use App\Models\Obat;
use App\Models\Racikan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ObatDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        $racikans = Racikan::all();

        $racikan_ids = $racikans->map(function ($racikan){
            return $racikan->obat_id;
        })->flatten();

        return [
            "obat" => [
                'required',
                'numeric',
                'exists:obats,id',
                Rule::notIn($racikan_ids)
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
