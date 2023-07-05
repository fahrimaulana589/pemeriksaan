<?php

namespace Http\Requests\Jadwal;

use App\Http\Requests\Jadwal\JadwalAddRequest;
use App\Http\Requests\Jadwal\JadwalEditRequest;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class JadwalEditRequestTest extends TestCase
{
    function test_validasi_harus_sukses(){
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'off',
            "start_senin" => '00:00',
            "end_senin" => '00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00',
            "end_selasa" => '00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00',
            "end_rabu" => '00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00',
            "end_kamis" => '00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00',
            "end_jumat" => '00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06',
            "end_sabtu" => '14:06',
            'minggu' => 'on',
            "start_minggu" => '09:06',
            "end_minggu" => '14:06'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_dekter_tidak_ada_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected dokter id is invalid');

        $data = [
            'dokter_id' => 121,
            'senin' => 'off',
            "start_senin" => '00:00',
            "end_senin" => '00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00',
            "end_selasa" => '00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00',
            "end_rabu" => '00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00',
            "end_kamis" => '00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00',
            "end_jumat" => '00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06',
            "end_sabtu" => '14:06',
            'minggu' => 'on',
            "start_minggu" => '09:06',
            "end_minggu" => '14:06'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_hari_ditak_ada_validasi_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The senin field is required');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            "start_senin" => '00:00',
            "end_senin" => '00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00',
            "end_selasa" => '00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00',
            "end_rabu" => '00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00',
            "end_kamis" => '00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00',
            "end_jumat" => '00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06',
            "end_sabtu" => '14:06',
            'minggu' => 'on',
            "start_minggu" => '09:06',
            "end_minggu" => '14:06'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_hari_kosong_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The senin field is required');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => '',
            "start_senin" => '00:00',
            "end_senin" => '00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00',
            "end_selasa" => '00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00',
            "end_rabu" => '00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00',
            "end_kamis" => '00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00',
            "end_jumat" => '00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06',
            "end_sabtu" => '14:06',
            'minggu' => 'on',
            "start_minggu" => '09:06',
            "end_minggu" => '14:06'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_hari_selain_on_dan_off_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected senin is invalid');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'asa',
            "start_senin" => '00:00',
            "end_senin" => '00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00',
            "end_selasa" => '00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00',
            "end_rabu" => '00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00',
            "end_kamis" => '00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00',
            "end_jumat" => '00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06',
            "end_sabtu" => '14:06',
            'minggu' => 'on',
            "start_minggu" => '09:06',
            "end_minggu" => '14:06'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_waktu_format_salah_harus_gagal(){
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The start senin field must match the format H:i');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'off',
            "start_senin" => 's0:00:00',
            "end_senin" => '00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00',
            "end_selasa" => '00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00',
            "end_rabu" => '00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00',
            "end_kamis" => '00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00',
            "end_jumat" => '00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06',
            "end_sabtu" => '14:06',
            'minggu' => 'on',
            "start_minggu" => '09:06',
            "end_minggu" => '14:06'
        ];

        $request = Request::create('/', 'POST', $data);

        $validasi = new JadwalEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

    function test_validasi_waktu_kosong_tapi_hari_on_harus_gagal()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The start senin field is required');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'on',
            'selasa' => 'off',
            "start_selasa" => '00:00',
            "end_selasa" => '00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00',
            "end_rabu" => '00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00',
            "end_kamis" => '00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00',
            "end_jumat" => '00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06',
            "end_sabtu" => '14:06',
            'minggu' => 'on',
            "start_minggu" => '09:06',
            "end_minggu" => '14:06'
        ];

        $request = Request::create('/', 'POST', $data);

        request()->request = $request;

        $validasi = new JadwalEditRequest();

        $request->validate($validasi->rules());

        $this->assertTrue(true);
    }

}
