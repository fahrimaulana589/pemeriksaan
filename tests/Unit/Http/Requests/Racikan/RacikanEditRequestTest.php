<?php

namespace Http\Requests\Racikan;

use App\Http\Requests\Racikan\RacikanAddRequest;
use App\Http\Requests\Racikan\RacikanEditRequest;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RacikanEditRequestTest extends TestCase
{

    function test_validasi_harus_sukses()
    {
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

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $dokter->id,
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_obat_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The obat id field is required.');

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

        $data = [
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_obat_ksong_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The obat id field is required.');

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

        $data = [
            'obat_id' => '',
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_obat_bukan_angka_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The obat id field must be an integer.');

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

        $data = [
            'obat_id' => 'as',
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_obat_tidak_ada_database_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected obat id is invalid.');

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

        $data = [
            'obat_id' => 1212,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pemeriksaan id field is required.');

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

        $data = [
            'obat_id' => $obat->id,
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_ksong_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pemeriksaan id field is required.');

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

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => '',
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_bukan_angka_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pemeriksaan id field must be an integer.');

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

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => 'as',
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pemeriksaan_tidak_ada_database_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected pemeriksaan id is invalid.');

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

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => 1212,
            'jumlah' => '12',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_jumlah_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The jumlah field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

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

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_jumlah_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The jumlah field is required.');

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

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_jumlah_bukan_angka_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The jumlah field must be an integer');

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

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => 'asas',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_jumlah_lebih_besar_dari_stok_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The jumlah field must not be greater than');

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

        $data = [
            'obat_id' => $obat->id,
            'pemeriksaan_id' => $pemeriksaan->id,
            'jumlah' => '1212',
        ];

        $request = Request::create('/', 'POST', $data);

        request()->request = $request;

        $validasi = new RacikanEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }
}
