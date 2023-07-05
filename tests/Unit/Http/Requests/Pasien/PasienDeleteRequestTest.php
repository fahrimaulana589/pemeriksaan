<?php

namespace Http\Requests\Pasien;

use App\Http\Requests\Pasien\PasienDeleteRequest;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\services\RacikanService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PasienDeleteRequestTest extends TestCase
{

    public function test_validasi_harus_sukses()
    {
        $pasien = Pasien::factory(1)->create()->first();

        $data = [
            'pasien' => $pasien->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PasienDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected pasien is invalid');

        $data = [
            'pasien' => 12,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PasienDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_id_bukan_angka_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('he pasien field must be a number');

        $data = [
            'pasien' => 'aa',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PasienDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_pasien_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pasien field is required.');

        $data = [
            'pasienss' => '1212',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PasienDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_pasien_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pasien field is required.');

        $data = [
            'pasien' => '',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PasienDeleteRequest();

        $request->validate($validasi->rules());

    }

public function test_validasi_id_terhubung_dengan_pemeriksaan_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected pasien is invalid');

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
            'pasien' => $pasien->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PasienDeleteRequest();

        $request->validate($validasi->rules());

    }

}
