<?php

namespace Http\Requests\Pemeriksaan;

use App\Http\Requests\Pemeriksaan\PemeriksaanDeleteRequest;
use App\Http\Requests\Pemeriksaan\PemeriksaanEditRequest;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Racikan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PemeriksaanDeleteRequestTest extends TestCase
{
    function test_validasi_harus_sukses(){

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create(
            [
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokter->id,
                'keluhan' => 'sakit perut',
                'hari' => Carbon::now()
            ]
        )->first();

        $data = [
            'pemeriksaan' => $pemeriksaan->id
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_tidak_ada_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pemeriksaan field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create(
            [
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokter->id,
                'keluhan' => 'sakit perut',
                'hari' => Carbon::now()
            ]
        )->first();

        $data = [
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_kosong_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pemeriksaan field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create(
            [
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokter->id,
                'keluhan' => 'sakit perut',
                'hari' => Carbon::now()
            ]
        )->first();

        $data = [
            'pemeriksaan' => ''
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_bukan_angka_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pemeriksaan field must be a number.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create(
            [
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokter->id,
                'keluhan' => 'sakit perut',
                'hari' => Carbon::now()
            ]
        )->first();

        $data = [
            'pemeriksaan' => 'asdasd'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_tidak_ada_di_database_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected pemeriksaan is invalid.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create(
            [
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokter->id,
                'keluhan' => 'sakit perut',
                'hari' => Carbon::now()
            ]
        )->first();

        $data = [
            'pemeriksaan' => '12121212'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_memiliki_racikan_harus_gagal(){

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected pemeriksaan is invalid.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $pemeriksaan = Pemeriksaan::factory(1)->create(
            [
                'pasien_id' => $pasien->id,
                'dokter_id' => $dokter->id,
                'keluhan' => 'sakit perut',
                'hari' => Carbon::now()
            ]
        )->first();

        $obat = Obat::factory()->create()->first();

        $racikan = Racikan::factory()->create([
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id
        ])->first();

        $data = [
            'pemeriksaan' => $pemeriksaan->id
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }
}
