<?php

namespace App\Repositories;

use App\Models\Pemeriksaan;

class PemeriksaanRepository
{

    function create(array $data)
    {
        Pemeriksaan::create($data);
    }

    function all()
    {
        return Pemeriksaan::all();
    }

    function find(int $id)
    {
        return Pemeriksaan::findOrFail($id);
    }

    function update(int $id, array $data)
    {
        $pemeriksaan = Pemeriksaan::find($id);
        $pemeriksaan->fill($data);
        $pemeriksaan->save();
    }

    function delete(int $id)
    {
        $pemeriksaan = Pemeriksaan::find($id);
        $pemeriksaan->delete();
    }

    public function allByDokter(int $id)
    {
        return Pemeriksaan::where('dokter_id','=',$id)->get();
    }

    public function allByPasien(int $id)
    {
        return Pemeriksaan::where('pasien_id','=',$id)->get();
    }

}
