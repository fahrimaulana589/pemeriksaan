<?php

namespace App\Repositories;

use App\Models\Dokter;

class DokterRepository
{
    function create(array $data)
    {
        Dokter::create($data);
    }

    function all()
    {
        return Dokter::all();
    }

    function find(int $id)
    {
        return Dokter::findOrFail($id);
    }

    function update(int $id, array $data)
    {
        $dokter = Dokter::find($id);
        $dokter->fill($data);
        $dokter->save();
    }

    function delete(int $id)
    {
        $dokter = Dokter::find($id);
        $dokter->delete();
    }

}
