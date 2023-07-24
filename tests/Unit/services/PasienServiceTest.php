<?php

namespace services;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\services\DokterService;
use App\services\PasienService;
use App\services\RacikanService;
use Database\Factories\PasienFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PasienServiceTest extends TestCase
{

    function test_create_pasien_harus_sukses()
    {
        $data = Pasien::factory()->make()->makeHidden('icon')->toArray();

        Storage::deleteDirectory('');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new PasienService();

        $service->create($data);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);

        $this->assertDatabaseHas('pasien', $data);
    }

    function test_create_pasien_dengan_gender_selain_pria_dan_wanita_harus_gagal()
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Data truncated');

        $data = Pasien::factory()->make([
            'gender' => 'lala'
        ])->makeHidden('icon')->toArray();

        Storage::deleteDirectory('');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new PasienService();
        $service->create($data);

    }

    function test_create_pasien_dengan_harlah_selain_tanggal_harus_gagal()
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Invalid datetime format');

        $data = Pasien::factory()->make([
            'harlah' => 'asas'
        ])->makeHidden('icon')->toArray();

        Storage::deleteDirectory('');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new PasienService();
        $service->create($data);

    }

    function test_ambil_semua_data_harus_sukses(){

        Pasien::factory(5)->create();

        $service = new PasienService();

        $items = $service->all();

        $res = count($items);

        $this->assertTrue($res == 5);

    }

    function test_ambil_data_dengan_id_harus_sukses(){
        $id = Pasien::factory(5)->create()->first()->id;

        $service = new PasienService();

        $item = $service->find($id);

        $this->assertDatabaseHas('pasien',$item->toArray());
    }

    function test_ambil_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $id = Pasien::factory(5)->create()->first()->id;

        $service = new PasienService();

        $item = $service->find(122);

    }

    function test_update_data_harus_sukses(){
        $item_1 = Pasien::factory(1)->create()->first();

        $data = Pasien::factory()->make()->makeHidden('icon')->toArray();
        Storage::deleteDirectory('');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new PasienService();

        $service->update($item_1->id,$data);

        $item_2 = $service->find($item_1->id);

        $this->assertTrue($item_1->icon != $item_2->icon);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);

        $this->assertDatabaseHas('pasien',$data);

    }

    function test_update_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $data = Pasien::factory()->make()->makeHidden('icon')->toArray();
        Storage::deleteDirectory('');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new PasienService();

        $service->update(1333,$data);

    }

    function test_hapus_data_harus_sukses(){

        $item_1 = Pasien::factory(1)->create()->first();

        $service = new PasienService();

        $service->delete($item_1->id);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 0);

        $this->assertDatabaseMissing('pasien',$item_1->toArray());

    }

    function test_hapus_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $item_1 = Pasien::factory(1)->create()->first();

        $service = new PasienService();

        $service->delete(1212);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);
    }

    function test_hapus_data_dengan_id_memiliki_pemeriksaan_ada_harus_gagal(){
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

        $service = new PasienService();

        $service->delete($pasien->id);
    }
}
