<?php

namespace Http\Requests\Jadwal;

use App\Http\Requests\Jadwal\JadwalDeleteRequest;
use App\Models\Dokter;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class JadwalDeleteRequestTest extends TestCase
{

    public function test_validasi_harus_sukses()
    {
        $dokter = Dokter::factory(1)->create()->first();

        $jadwal = Jadwal::factory(1)->create([
            'dokter_id' => $dokter->id,
        ])->first();

        $data = [
            'jadwal' => $jadwal->id,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalDeleteRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    public function test_validasi_id_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected jadwal is invalid');

        $data = [
            'jadwal' => 12,
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_id_bukan_angka_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('he jadwal field must be a number');

        $data = [
            'jadwal' => 'aa',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_jadwal_tidak_ada_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The jadwal field is required.');

        $data = [
            'pasienss' => 'aa',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalDeleteRequest();

        $request->validate($validasi->rules());
    }

    public function test_validasi_jadwal_kosong_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The jadwal field is required.');

        $data = [
            'jadwal' => '',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalDeleteRequest();

        $request->validate($validasi->rules());

    }}
