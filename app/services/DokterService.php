<?php

namespace App\services;

use App\Repositories\DokterRepository;
use App\Repositories\PasienRepository;
use App\Traits\UploadFile;

class DokterService
{

    use UploadFile;

    var $repositoery;

    public function __construct()
    {
        $this->repositoery = new DokterRepository();
    }


    function create(array $data)
    {
        $data['icon'] = $this->getPhoto();
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
        $item = $this->repositoery->find($id);
        $file = $this->updatePhoto($item->icon);

        $data['icon'] = $file;

        $this->repositoery->update($id,$data);
    }

    function delete(int $id)
    {
        $item = $this->repositoery->find($id);
        $this->repositoery->delete($id);
        $this->deletePhoto($item->icon);
    }
}
