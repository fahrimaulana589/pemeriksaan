<?php

namespace App\services;

use App\Repositories\JadwalRepository;
use App\Repositories\PemeriksaanRepository;

class PemeriksaanService
{

    var $repositoery;

    public function __construct()
    {
        $this->repositoery = new PemeriksaanRepository();
    }

    function create(array $data)
    {
        $this->repositoery->create($data);
    }

    function all()
    {
        return $this->repositoery->all();
    }

    function find(int $id)
    {
        return $this->repositoery->find($id);
    }

    function update(int $id, array $data)
    {
        $this->repositoery->find($id);
        $this->repositoery->update($id,$data);
    }

    function delete(int $id)
    {
        $this->repositoery->find($id);
        $this->repositoery->delete($id);
    }

    public function allByDokter(int $id)
    {
        return $this->repositoery->allByDokter($id);
    }

    public function allByPasien(int $id)
    {
        return $this->repositoery->allByPasien($id);
    }

}
