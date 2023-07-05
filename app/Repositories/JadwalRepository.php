<?php

namespace App\Repositories;

use App\Models\Jadwal;

class JadwalRepository
{

    function create(array $data)
    {
        Jadwal::create($data);
    }

    function all()
    {
        return Jadwal::all();
    }

    function find(int $id)
    {
        return Jadwal::findOrFail($id);
    }

    function update(int $id, array $data)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->fill($data);
        $jadwal->save();
    }

    function delete(int $id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->delete();
    }

}
