<?php

namespace App\Http\Requests\Pasien;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasienEditRequest extends FormRequest
{
    public function rules(): array
    {
        $users = User::pasiens()->get();

        $users_ids = $users->map(function ($user){
            return $user->id;
        })->flatten();

        return [
            'user_id' => [
                'numeric',
                'required',
                'unique:dokter,user_id,'.$this->getId(),
                Rule::in($users_ids)
            ],

            'nama' => [
                'required',
                'regex:/^[a-zA-Z ]*$/'
            ],
            'file' => [
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

    public function getId(){
        $pasien = request()->route()->originalParameter('pasien');

        return $pasien;
    }
}
