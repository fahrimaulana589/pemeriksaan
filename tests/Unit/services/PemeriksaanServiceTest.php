<?php

namespace services;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\services\DokterService;
use App\services\PasienService;
use App\services\PemeriksaanService;
use App\services\RacikanService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PemeriksaanServiceTest extends TestCase
{
    function test_create_pemeriksaan_harus_sukses()
    {
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => "mual",
            'hari' => fake()->date
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new PemeriksaanService();

        $service->create($data);

        $this->assertDatabaseHas('pemeriksaan', $data);
    }

    function test_create_pemeriksaan_dengan_pasien_tidak_ada_harus_gagal()
    {

        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Integrity constraint violation');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => 1212,
            'dokter_id' => $dokter->id,
            'keluhan' => "mual",
            'hari' => fake()->date
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new PemeriksaanService();

        $service->create($data);
    }

    function test_create_pemeriksaan_dengan_dokter_tidak_ada_harus_gagal()
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Integrity constraint violation');

        $pasien = Pasien::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => 121,
            'keluhan' => "mual",
            'hari' => fake()->date
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new PemeriksaanService();

        $service->create($data);

    }

    function test_create_pemeriksaan_dengan_hari_bukan_tanggal_harus_gagal(){

        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Invalid datetime format');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => "mual",
            'hari' => 'asa'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new PemeriksaanService();

        $service->create($data);

    }

    function test_ambil_semua_data_harus_sukses(){
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        Pemeriksaan::factory(5)->create($data);

        $service = new PemeriksaanService();

        $item = $service->all();

        $this->assertDatabaseCount('pemeriksaan',count($item));
    }

    function test_ambil_semua_data_berdasarkan_dokter_harus_sukses(){
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        Pemeriksaan::factory(5)->create($data);

        $dokter2 = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter2->id,
        ];

        Pemeriksaan::factory(3)->create($data);

        $service = new PemeriksaanService();

        $item = $service->allByDokter($dokter->id);
        $this->assertTrue(5 ==count($item));

        $item = $service->allByDokter($dokter2->id);
        $this->assertTrue(3 ==count($item));
    }

    function test_ambil_semua_data_berdasarkan_pasien_harus_sukses(){
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        Pemeriksaan::factory(5)->create($data);

        $dokter2 = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter2->id,
        ];

        Pemeriksaan::factory(3)->create($data);

        $service = new PemeriksaanService();

        $item = $service->allByPasien($pasien->id);
        $this->assertTrue(8 ==count($item));
    }

    function test_ambil_data_dengan_id_harus_suskes(){
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        Pemeriksaan::factory(5)->create($data);

        $dokter2 = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter2->id,
        ];

        $pemeriksaan = Pemeriksaan::factory(3)->create($data)->first();

        $service = new PemeriksaanService();

        $item = $service->find($pemeriksaan->id);

        $this->assertDatabaseHas('pemeriksaan',$data);

    }

    function test_ambil_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        Pemeriksaan::factory(5)->create($data);

        $dokter2 = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter2->id,
        ];

        $pemeriksaan = Pemeriksaan::factory(3)->create($data)->first();

        $service = new PemeriksaanService();

        $item = $service->find(1212);

        $this->assertDatabaseHas('pemeriksaan',$item->toArray());

    }

    function test_update_data_harus_sukses(){
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        $pemeriksaan = Pemeriksaan::factory(5)->create($data)->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => "mual2",
            'hari' => fake()->date
        ];

        $service = new PemeriksaanService();

        $item = $service->update($pemeriksaan->id,$data);

        $this->assertDatabaseHas('pemeriksaan',$data);
    }

    function test_update_data_dengan_id_tidak_ada_harus_sukses(){
        $this->expectException(ModelNotFoundException::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        $pemeriksaan = Pemeriksaan::factory(5)->create($data)->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => "mual2",
            'hari' => fake()->date
        ];

        $service = new PemeriksaanService();

        $service->update(1212,$data);

        $this->assertDatabaseHas('pemeriksaan',$data);
    }

    function test_update_data_pasien_tidak_ada_harus_gagal(){
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Integrity constraint violation');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        $pemeriksaan = Pemeriksaan::factory(5)->create($data)->first();

        $data = [
            'pasien_id' => 1212,
            'dokter_id' => $dokter->id,
            'keluhan' => "mual2",
            'hari' => fake()->date
        ];

        $service = new PemeriksaanService();

        $service->update($pemeriksaan->id,$data);

        $this->assertDatabaseHas('pemeriksaan',$data);
    }

    function test_update_data_dokter_tidak_ada_harus_gagal(){
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Integrity constraint violation');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        $pemeriksaan = Pemeriksaan::factory(5)->create($data)->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => 21121,
            'keluhan' => "mual2",
            'hari' => fake()->date
        ];

        $service = new PemeriksaanService();

        $item = $service->update($pemeriksaan->id,$data);

        $this->assertDatabaseHas('pemeriksaan',$data);
    }

    function test_update_data_hari_bukan_tanggal_harus_gagal(){
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Invalid datetime format');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        $pemeriksaan = Pemeriksaan::factory(5)->create($data)->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => "mual2",
            'hari' => 'aaa'
        ];

        $service = new PemeriksaanService();

        $service->update($pemeriksaan->id,$data);

        $this->assertDatabaseHas('pemeriksaan',$data);
    }

    function test_hapus_data_harus_sukses(){
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        $pemeriksaan = Pemeriksaan::factory(5)->create($data)->first();

        $service = new PemeriksaanService();

        $service->delete($pemeriksaan->id);

        $this->assertDatabaseMissing('pemeriksaan',$pemeriksaan->toArray());

    }

    function test_hapus_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ];

        Pemeriksaan::factory(5)->create($data)->first();

        $service = new PemeriksaanService();

        $service->delete(12);

    }

    function test_hapus_data_dengan_id_memiliki_obat_ada_harus_gagal(){
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

        $service = new PemeriksaanService();

        $service->delete($pemeriksaan->id);
    }
}
