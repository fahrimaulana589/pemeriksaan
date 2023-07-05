<?php

namespace App\services;

use App\Models\Obat;
use App\Repositories\JadwalRepository;
use App\Repositories\ObatRepository;
use App\Repositories\RacikanRepository;
use http\Exception\BadConversionException;
use http\Exception\BadQueryStringException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

class RacikanService
{

    var $repositoery;
    var $repositoeryObat;

    public function __construct()
    {
        $this->repositoery = new RacikanRepository();
        $this->repositoeryObat = new ObatRepository();
    }

    function create(array $data)
    {
        $obat = $this->repositoeryObat->find($data['obat_id']);

        if (!is_int($data['jumlah']) && !ctype_digit($data['jumlah'])) {
            throw new \Exception('Data salah bukan integer');
        }

        if ($data['jumlah'] > 0 && $data['jumlah'] <= $obat->stok) {

            $obat->stok = $obat['stok'] - $data['jumlah'];

            $obat->save();

        } else {
            throw new \Exception('Data salah');
        }

        return $this->repositoery->create($data);
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
        $racikan = $this->repositoery->find($id);
        $obat = $this->repositoeryObat->find($racikan['obat_id']);

        $number1 = $racikan->jumlah;
        $number2 = $data['jumlah'];

        if (!is_int($number2) && !ctype_digit($number2)) {
            throw new \Exception('Data salah bukan integer');
        }

        if ($number1 < $number2) {
            $lebih = $number2 - $number1;
            if ($lebih >= 0 && $lebih <= $obat->stok) {

                $obat->stok = $obat['stok'] - $lebih;

                $obat->save();

            } else {
                throw new \Exception('Data salah');
            }
        } elseif ($number1 > $number2) {
            $lebih = $number1 - $number2;
            if ($lebih >= 0 && $lebih >= $obat->stok) {

                $obat->stok = $obat['stok'] + $lebih;

                $obat->save();

            } else {
                throw new \Exception('Data salah');
            }
        }

        $this->repositoery->update($id, $data);
    }

    function delete(int $id)
    {
        $racikan = $this->repositoery->find($id);

        $obat = $this->repositoeryObat->find($racikan['obat_id']);

        $obat->stok = $obat['stok'] + $racikan->jumlah;

        $obat->save();

        $this->repositoery->delete($id);
    }

}
