<?php

namespace services;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\services\DokterService;
use App\services\ObatService;
use App\services\RacikanService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ObatServiceTest extends TestCase
{

    function test_create_dokter_harus_sukses()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'nama' => 'fahri',
            'deskripsi' => 'pria k k k k',
            'stok' => 10
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file
        ]);

        request()->request = $request;

        $service = new ObatService();

        $service->create($data);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);

        $this->assertDatabaseHas('obats', $data);

    }

    function test_create_dokter_dengan_stok_bukan_angka_harus_gagal()
    {
        $this->expectException(QueryException::class);

        $this->expectExceptionMessage('Incorrect integer value');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'nama' => 'fahri',
            'deskripsi' => 'pria k k k k',
            'stok' => "uiu"
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file
        ]);

        request()->request = $request;

        $service = new ObatService();

        $service->create($data);

    }

    function test_ambil_semua_data_harus_sukses()
    {

        Obat::factory(5)->create();

        $service = new ObatService();

        $items = $service->all();

        $res = count($items);

        $this->assertTrue($res == 5);

    }

    function test_ambil_data_dengan_id_harus_sukses()
    {
        $id = Obat::factory(5)->create()->first()->id;

        $service = new ObatService();

        $item = $service->find($id);

        $this->assertDatabaseHas('obats', $item->toArray());
    }

    function test_ambil_data_dengan_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ModelNotFoundException::class);

        $id = Obat::factory(5)->create()->first()->id;

        $service = new ObatService();

        $item = $service->find(122);
    }

    function test_update_data_harus_sukses()
    {
        $item_1 = Obat::factory(1)->create()->first();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'nama' => 'fahri',
            'deskripsi' => 'pria k k k k',
            'stok' => 12
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new ObatService();

        $service->update($item_1->id, $data);

        $item_2 = $service->find($item_1->id);

        $this->assertTrue($item_1->images != $item_2->images);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);

        $this->assertDatabaseHas('obats', $data);

    }

    function test_update_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'nama' => 'fahri',
            'deskripsi' => 'pria k k k k',
            'stok' => "uiu"
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'files' => $file,
        ]);

        request()->request = $request;

        $service = new DokterService();

        $service->update(1333,$data);
    }

    function test_hapus_data_harus_sukses(){

        $item_1 = Obat::factory(1)->create()->first();

        $service = new ObatService();

        $service->delete($item_1->id);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 0);

        $this->assertDatabaseMissing('obats',$item_1->toArray());

    }

    function test_hapus_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $item_1 = Obat::factory(1)->create()->first();

        $service = new ObatService();

        $service->delete(1212);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);
    }

    function test_hapus_data_dengan_id_memiliki_racikan_harus_gagal(){
        $this->expectException(QueryException::class);

        $obat = Obat::factory(1)->create()->first();

        $pasien = Pasien::factory(1)->create()->first();

        $dokter = Dokter::factory(1)->create()->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '2'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new RacikanService();

        $service->create($data);

        $service = new ObatService();

        $service->delete($obat->id);

    }
}
