<?php

namespace App\Repositories;

use App\Models\Pasien;

class PasienRepository
{
    function create(array $data)
    {
        Pasien::create($data);
    }

    function all()
    {
        return Pasien::all();
    }

    function find(int $id)
    {
        return Pasien::findOrFail($id);
    }

    function update(int $id, array $data)
    {
        $pasien = Pasien::find($id);
        $pasien->fill($data);
        $pasien->save();
    }

    function delete(int $id)
    {
        $pasien = Pasien::find($id);
        $pasien->delete();
    }

}
