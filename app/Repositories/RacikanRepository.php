<?php

namespace App\Repositories;

use App\Models\Racikan;

class RacikanRepository
{

    function create(array $data)
    {
        return Racikan::create($data);
    }

    function all()
    {
        return Racikan::all();
    }

    function find(int $id)
    {
        return Racikan::findOrFail($id);
    }

    function update(int $id, array $data)
    {
        $dokter = Racikan::find($id);
        $dokter->fill($data);
        $dokter->save();
    }

    function delete(int $id)
    {
        $dokter = Racikan::find($id);
        $dokter->delete();
    }

}
