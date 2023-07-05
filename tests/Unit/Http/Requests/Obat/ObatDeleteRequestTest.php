<?php

namespace Http\Requests\Obat;

use App\Http\Requests\Obat\ObatDeleteRequest;
use App\Http\Requests\Pasien\PasienDeleteRequest;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\services\RacikanService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ObatDeleteRequestTest extends TestCase
{
    public function test_validasi_harus_sukses()
    {
        $pasien = Obat::factory(1)->create()->first();

        $data = [
            'obat' => $pasien->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new ObatDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected obat is invalid');

        $data = [
            'obat' => 12,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new ObatDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_id_bukan_angka_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('he obat field must be a number');

        $data = [
            'obat' => 'aa',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new ObatDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_obat_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The obat field is required.');

        $data = [
            'pasienss' => 'aa',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new ObatDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_obat_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The obat field is required.');

        $data = [
            'obat' => '',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new ObatDeleteRequest();

        $request->validate($validasi->rules());

    }

    public function test_validasi_obat_punya_racikan_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected obat is invalid.');

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

        $data = [
            'obat' => $pasien->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new ObatDeleteRequest();

        $request->validate($validasi->rules());

    }
}
