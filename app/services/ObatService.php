<?php

namespace App\services;

use App\Repositories\DokterRepository;
use App\Repositories\ObatRepository;
use App\Traits\UploadFile;

class ObatService
{

    use UploadFile;

    var $repositoery;

    public function __construct()
    {
        $this->repositoery = new ObatRepository();
    }

    function create(array $data)
    {
        $data['images'] = $this->getPhoto();
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
        $data['images'] = $this->updatePhoto($item->images);
        $this->repositoery->update($id, $data);
    }

    function delete(int $id)
    {
        $item = $this->repositoery->find($id);
        $this->repositoery->delete($id);
        $this->deletePhoto($item->images);
    }

}
