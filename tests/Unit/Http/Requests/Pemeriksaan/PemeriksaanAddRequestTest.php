<?php

namespace Http\Requests\Pemeriksaan;

use App\Http\Requests\Pasien\PasienAddRequest;
use App\Http\Requests\Pemeriksaan\PemeriksaanAddRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PemeriksaanAddRequestTest extends TestCase
{
    function test_validasi_harus_sukses(){

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_pasien_tidak_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pasien id field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_pasien_ksong_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pasien id field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => '',
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_pasien_bukan_angka_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The pasien id field must be an integer.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => 'as',
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_pasien_tidak_ada_database_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected pasien id is invalid.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => 1212,
            'dokter_id' => $dokter->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_dokter_tidak_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The dokter id field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_dokter_ksong_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The dokter id field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => '',
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_dokter_bukan_angka_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The dokter id field must be an integer.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $dokter->id,
            'dokter_id' => 'ahs',
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_dokter_tidak_ada_database_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected dokter id is invalid.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => '12121212',
            'keluhan' => 'sakit perut',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_keluhan_tidak_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The keluhan field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_keluhan_kosong_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The keluhan field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => '',
            'hari' => Carbon::now()
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_hari_tidak_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The hari field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'asas as as ',
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_hari_kosong_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The hari field is required.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'asdasdasd asd a',
            'hari' => ''
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_hari_bukan_tangal_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The hari field must be a valid date.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'asdasdasd asd a',
            'hari' => 'asasas'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }

    function test_validasi_hari_tangal_masalalu_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The hari field must be a date after or equal to now.');

        $pasien = Pasien::factory(1)->create()->first();
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'keluhan' => 'asdasdasd asd a',
            'hari' => Carbon::now()->subDays(2)
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new PemeriksaanAddRequest();

        $request->validate($validasi->rules());
    }
}
