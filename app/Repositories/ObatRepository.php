<?php

namespace App\Repositories;

use App\Models\Obat;

class ObatRepository
{
    function create(array $data)
    {
        Obat::create($data);
    }

    function all()
    {
        return Obat::all();
    }

    function find(int $id)
    {
        return Obat::findOrFail($id);
    }

    function update(int $id, array $data)
    {
        $dokter = Obat::find($id);
        $dokter->fill($data);
        $dokter->save();
    }

    function delete(int $id)
    {
        $dokter = Obat::find($id);
        $dokter->delete();
    }


}
