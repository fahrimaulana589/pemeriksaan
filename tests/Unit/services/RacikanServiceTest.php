<?php

namespace services;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Racikan;
use App\services\PasienService;
use App\services\PemeriksaanService;
use App\services\RacikanService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Tests\TestCase;

class RacikanServiceTest extends TestCase
{

    function test_create_racikan_harus_sukses()
    {
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory(1)->create([
            'stok' => 12
        ])->first();
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

        $stokobat = Obat::find($obat->id)->stok;

        $this->assertTrue($stokobat == 10);

        $this->assertDatabaseHas('racikan', $data);

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '2'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new RacikanService();

        $service->create($data);

        $stokobat = Obat::find($obat->id)->stok;

        $this->assertTrue($stokobat == 8);

        $this->assertDatabaseHas('racikan', $data);
    }

    function test_create_racikan_jumlah_0_harus_gagal()
    {
        $this->expectException(\Exception::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory(1)->create([
            'stok' => 12
        ])->first();
        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => 0
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new RacikanService();

        $service->create($data);
    }

    function test_create_racikan_jumlah_lebih_dari_stok_harus_gagal()
    {
        $this->expectException(\Exception::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory(1)->create([
            'stok' => 12
        ])->first();
        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => 13
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new RacikanService();

        $service->create($data);
    }

    function test_create_racikan_obat_tidak_ada_harus_gagal()
    {
        $this->expectException(ModelNotFoundException::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $obat = Obat::factory(1)->create([
            'stok' => 12
        ])->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $data = [
            'obat_id' => 1212,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => 1
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new RacikanService();

        $service->create($data);
    }

    function test_create_racikan_pemeriksaan_tidak_ada_harus_gagal()
    {
        $this->expectException(QueryException::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory(1)->create([
            'stok' => 12
        ])->first();
        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => 121,
            'jumlah' => 1
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new RacikanService();

        $service->create($data);
    }

    function test_create_racikan_jumlah_bukan_angka_harus_gagal()
    {
        $this->expectException(\Exception::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory(1)->create([
            'stok' => 12
        ])->first();
        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => 'sss'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service = new RacikanService();

        $service->create($data);
    }

    function test_update_racikan_harus_sukses()
    {
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $obat = Obat::factory(1)->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $service = new RacikanService();

        $racikan = $service->create([
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '10'
        ]);

        $data = [
            'jumlah' => '100'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service->update($racikan->id,$data);

        $stokobat = Obat::find($obat->id)->stok;

        $this->assertTrue($stokobat == 20);

        $this->assertDatabaseHas('racikan', $data);

        $data = [
            'jumlah' => '110'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service->update($racikan->id,$data);

        $stokobat = Obat::find($obat->id)->stok;

        $this->assertTrue($stokobat == 10);

        $this->assertDatabaseHas('racikan', $data);

        $data = [
            'jumlah' => '90'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service->update($racikan->id,$data);

        $stokobat = Obat::find($obat->id)->stok;

        $this->assertTrue($stokobat == 30);

        $this->assertDatabaseHas('racikan', $data);

        $data = [
            'jumlah' => '20'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service->update($racikan->id,$data);

        $stokobat = Obat::find($obat->id)->stok;

        $this->assertTrue($stokobat == 100);

        $this->assertDatabaseHas('racikan', $data);
    }

    function test_update_racikan_jumlah_lebih_besar_dari_stok_harus_gagal()
    {
        $this->expectException(\Exception::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $obat = Obat::factory(1)->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $service = new RacikanService();

        $racikan = $service->create([
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '10'
        ]);

        $data = [
            'jumlah' => '200'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service->update($racikan->id,$data);
    }

    function test_update_racikan_jumlah_bukan_angka_harus_gagal()
    {
        $this->expectException(\Exception::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $obat = Obat::factory(1)->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $service = new RacikanService();

        $racikan = $service->create([
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '10'
        ]);

        $data = [
            'jumlah' => 'ss'
        ];

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service->update($racikan->id,$data);
    }

    function test_delete_racikan_harus_sukses()
    {
        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $obat = Obat::factory(1)->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $service = new RacikanService();

        $racikan = $service->create([
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '10'
        ]);

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service->delete($racikan->id);

        $stokobat = Obat::find($obat->id)->stok;

        $this->assertTrue($stokobat == 120);

        $this->assertDatabaseCount('racikan', 0);

    }

    function test_delete_racikan_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ModelNotFoundException::class);

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $obat = Obat::factory(1)->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
        ])->first();

        $service = new RacikanService();

        $racikan = $service->create([
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '10'
        ]);

        $request = Request::create('/', 'POST');

        request()->request = $request;

        $service->delete(121212);

    }
}
