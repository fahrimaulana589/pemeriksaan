<?php

namespace App\Repositories;

class DashboardRepository
{
    public $pasienRepository;
    public $dokterRepository;
    public $obatRepository;

    public function __construct()
    {
        $this->pasienRepository = new PasienRepository();
        $this->dokterRepository = new DokterRepository();
        $this->obatRepository = new ObatRepository();
    }

    public function getAllPasien()
    {
        return $this->pasienRepository->all();
    }

    public function getAllDokter()
    {
        return $this->dokterRepository->all();
    }

    public function getAllObat()
    {
        return $this->obatRepository->all();
    }
}
