<?php

namespace Http\Requests\Racikan;

use App\Http\Requests\Pemeriksaan\PemeriksaanDeleteRequest;
use App\Http\Requests\Racikan\RacikanDeleteRequest;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Racikan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RacikanDeleteRequestTest extends TestCase
{

    function test_validasi_harus_sukses(){

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory()->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory()->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ])->first();

        $racikan = Racikan::factory()->create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'obat_id' => $obat->id
        ])->first();

        $data = [
            'racikan' => $racikan->id
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_racikan_tidak_ada_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The racikan field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory()->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory()->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ])->first();

        $racikan = Racikan::factory()->create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'obat_id' => $obat->id
        ])->first();

        $data = [
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_racikan_kosong_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The racikan field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory()->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory()->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ])->first();

        $racikan = Racikan::factory()->create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'obat_id' => $obat->id
        ])->first();

        $data = [
            'racikan' => ''
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_racikan_bukan_angka_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The racikan field must be a number.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory()->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory()->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ])->first();

        $racikan = Racikan::factory()->create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'obat_id' => $obat->id
        ])->first();

        $data = [
            'racikan' => 'aa'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_tidak_ada_di_database_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected racikan is invalid.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();
        $obat = Obat::factory()->create([
            'stok' => 120
        ])->first();

        $pemeriksaan = Pemeriksaan::factory()->create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ])->first();

        $racikan = Racikan::factory()->create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'obat_id' => $obat->id
        ])->first();

        $data = [
            'racikan' => 12121212
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }
}
