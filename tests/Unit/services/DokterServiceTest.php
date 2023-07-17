<?php

namespace services;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\services\DokterService;
use App\services\JadwalService;
use App\services\PasienService;
use App\services\RacikanService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DokterServiceTest extends TestCase
{
    function test_create_dokter_harus_sukses()
    {

        $file = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'user_id' => 1,
            'nama' => 'fahri',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new DokterService();

        $service->create($data);

        $files = count(Storage::allFiles('files'));
        $this->assertTrue($files == 1);

        $this->assertDatabaseHas('dokter', $data);
    }

    function test_create_dokter_dengan_gender_selain_pria_dan_wanita_harus_gagal()
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Data truncated');

        $data = [
            'user_id' => 1,
            'nama' => 'fahri',
            'gender' => 'bencong',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new DokterService();
        $service->create($data);

    }

    function test_create_dokter_dengan_harlah_selain_tanggal_harus_gagal()
    {
        $this->expectException(QueryException::class);

        $this->expectExceptionMessage('Invalid datetime format');

        $data = [
            'user_id' => 1,
            'nama' => 'fahri',
            'gender' => 'pria',
            'harlah' => 's',
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new DokterService();
        $service->create($data);

    }

    function test_create_dokter_dengan_user_id_sudah_ada_harus_gagal()
    {
        $this->expectException(QueryException::class);

        $this->expectExceptionMessage('Duplicate entry');

        Dokter::factory()->create([
            'user_id' => 1
        ]);

        $data = [
            'user_id' => 1,
            'nama' => 'fahri',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $file = UploadedFile::fake()->image('avatar.jpg');

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new DokterService();
        $service->create($data);

    }

    function test_ambil_semua_data_harus_sukses()
    {

        Dokter::factory(5)->create();

        $service = new DokterService();

        $items = $service->all();

        $res = count($items);

        $this->assertTrue($res == 5);

    }

    function test_ambil_data_dengan_id_harus_sukses()
    {
        $data = Dokter::factory(5)->create()->first();

        $id = $data->id;

        $service = new DokterService();

        $item = $service->find($id);

        $this->assertDatabaseHas('dokter', $item->toArray());
    }

    function test_ambil_data_dengan_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ModelNotFoundException::class);

        $id = Dokter::factory(5)->create()->first()->id;

        $service = new DokterService();

        $item = $service->find(122);

    }

    function test_update_data_harus_sukses()
    {
        $item_1 = Dokter::factory(1)->create()->first();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'user_id' => 1,
            'nama' => 'fahri',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'file' => $file,
        ]);

        request()->request = $request;

        $service = new DokterService();

        $service->update($item_1->id, $data);

        $item_2 = $service->find($item_1->id);

        $this->assertTrue($item_1->icon != $item_2->icon);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);

        $this->assertDatabaseHas('dokter', $data);

    }

    function test_update_data_dengan_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ModelNotFoundException::class);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'user_id' => 1,
            'nama' => 'fahri',
            'gender' => 'pria',
            'harlah' => fake()->date,
            'desa' => 'Karangmangu',
            'kecamatan' => 'Tarub',
            'kabupaten_kota' => 'Kabupaten Tegal',
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];

        $request = Request::create('/', 'POST', $data, files: [
            'files' => $file,
        ]);

        request()->request = $request;

        $service = new DokterService();

        $service->update(1333, $data);

    }

    function test_hapus_data_harus_sukses()
    {

        $item_1 = Dokter::factory(1)->create()->first();

        $service = new DokterService();

        $service->delete($item_1->id);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 0);

        $this->assertDatabaseMissing('dokter', $item_1->toArray());

    }

    function test_hapus_data_dengan_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ModelNotFoundException::class);

        $item_1 = Dokter::factory(1)->create()->first();

        $service = new DokterService();

        $service->delete(1212);

        $files = count(Storage::allFiles('files'));

        $this->assertTrue($files == 1);
    }

    function test_hapus_data_dengan_id_memiliki_jadwal_ada_harus_gagal()
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Cannot delete or update a parent');

        $item_1 = Dokter::factory(1)->create()->first();

        Jadwal::factory(1)->create([
            'dokter_id' => $item_1->id,
        ]);

        $service = new DokterService();

        $service->delete($item_1->id);
    }

    function test_hapus_data_dengan_id_memiliki_pemeriksaan_ada_harus_gagal()
    {
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

        $service = new DokterService();

        $service->delete($dokter->id);
    }
}
