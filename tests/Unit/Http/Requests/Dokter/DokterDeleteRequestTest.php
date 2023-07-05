<?php

namespace Http\Requests\Dokter;

use App\Http\Requests\Dokter\DokterAddRequest;
use App\Http\Requests\Dokter\DokterDeleteRequest;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\services\RacikanService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DokterDeleteRequestTest extends TestCase
{

    public function test_validasi_harus_sukses()
    {
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter' => $dokter->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new DokterDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected dokter is invalid');

        $data = [
            'dokter' => 12,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new DokterDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_id_bukan_angka_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('he dokter field must be a number');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter' => 'aa',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new DokterDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_dokter_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The dokter field is required.');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokters' => 'aa',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new DokterDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_dokter_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The dokter field is required.');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter' => '',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new DokterDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_id_terhubung_dengan_jadwal_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected dokter is invalid');

        $dokter = Dokter::factory(1)->create()->first();

        Jadwal::factory(1)->create([
            'dokter_id' => $dokter->id
        ]);

        $data = [
            'dokter' => $dokter->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new DokterDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_id_terhubung_dengan_pemeriksaan_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected dokter is invalid');

        $dokter = Dokter::factory(1)->create()->first();

        $obat = Obat::factory(1)->create()->first();

        $pasien = Pasien::factory(1)->create()->first();

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

        $data = [
            'dokter' => $dokter->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new DokterDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }
}
