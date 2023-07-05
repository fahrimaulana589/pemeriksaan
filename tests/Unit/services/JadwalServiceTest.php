<?php

namespace services;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\services\JadwalService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;
use Illuminate\Http\Request;

class JadwalServiceTest extends TestCase
{

    function test_create_dokter_harus_sukses()
    {
        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'off',
            "start_senin" => '00:00:00',
            "end_senin" => '00:00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00:00',
            "end_selasa" => '00:00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00:00',
            "end_rabu" => '00:00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00:00',
            "end_kamis" => '00:00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00:00',
            "end_jumat" => '00:00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06:36',
            "end_sabtu" => '14:06:36',
            'minggu' => 'on',
            "start_minggu" => '09:06:36',
            "end_minggu" => '14:06:36'
        ];

        $request = Request::create('/', 'POST', $data);

        request()->request = $request;

        $service = new JadwalService();

        $service->create($data);

        $this->assertDatabaseHas('jadwals', $data);
    }

    function test_create_jadwal_dengan_id_dokter_tidak_ada_harus_gagal()
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Integrity constraint violation');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => 123,
            'senin' => 'off',
            "start_senin" => '00:00:00',
            "end_senin" => '00:00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00:00',
            "end_selasa" => '00:00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00:00',
            "end_rabu" => '00:00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00:00',
            "end_kamis" => '00:00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00:00',
            "end_jumat" => '00:00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06:36',
            "end_sabtu" => '14:06:36',
            'minggu' => 'on',
            "start_minggu" => '09:06:36',
            "end_minggu" => '14:06:36'
        ];

        $request = Request::create('/', 'POST', $data);

        request()->request = $request;

        $service = new JadwalService();

        $service->create($data);

        $this->assertDatabaseHas('jadwals', $data);
    }

    function test_create_jadwal_dengan_hari_selain_off_dan_on_harus_gagal()
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Data truncated for column');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'as',
            "start_senin" => '00:00:00',
            "end_senin" => '00:00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00:00',
            "end_selasa" => '00:00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00:00',
            "end_rabu" => '00:00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00:00',
            "end_kamis" => '00:00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00:00',
            "end_jumat" => '00:00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06:36',
            "end_sabtu" => '14:06:36',
            'minggu' => 'on',
            "start_minggu" => '09:06:36',
            "end_minggu" => '14:06:36'
        ];

        $request = Request::create('/', 'POST', $data);

        request()->request = $request;

        $service = new JadwalService();

        $service->create($data);
    }

    function test_create_jadwal_dengan_start_selain_waktu_harus_gagal()
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Invalid datetime format');

        $dokter = Dokter::factory(1)->create()->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'off',
            "start_senin" => 'asas',
            "end_senin" => '00:00:00',
            'selasa' => 'off',
            "start_selasa" => '00:00:00',
            "end_selasa" => '00:00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00:00',
            "end_rabu" => '00:00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00:00',
            "end_kamis" => '00:00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00:00',
            "end_jumat" => '00:00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06:36',
            "end_sabtu" => '14:06:36',
            'minggu' => 'on',
            "start_minggu" => '09:06:36',
            "end_minggu" => '14:06:36'
        ];

        $request = Request::create('/', 'POST', $data);

        request()->request = $request;

        $service = new JadwalService();

        $service->create($data);
    }

    function test_ambil_semua_data_harus_sukses(){

        $dokter = Dokter::factory(1)->create()->first();

        Jadwal::factory(5)->create([
            'dokter_id' => $dokter->id
        ]);

        $service = new JadwalService();

        $items = $service->all();

        $res = count($items);

        $this->assertTrue($res == 5);

    }

    function test_ambil_data_dengan_id_harus_sukses(){
        $dokter = Dokter::factory(1)->create()->first();

        $jadwal = Jadwal::factory(1)->create([
            'dokter_id' => $dokter->id
        ])->first();

        $service = new JadwalService();

        $item = $service->find($jadwal->id);

        $this->assertDatabaseHas('jadwals',$item->toArray());
    }

    function test_ambil_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $service = new JadwalService();

        $item = $service->find(122);

    }

    function test_update_data_harus_sukses(){
        $dokter = Dokter::factory(1)->create()->first();

        $jadwal = Jadwal::factory(5)->create([
            'dokter_id' => $dokter->id
        ])->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'off',
            "start_senin" => '00:01:00',
            "end_senin" => '00:03:00',
            'selasa' => 'off',
            "start_selasa" => '00:00:00',
            "end_selasa" => '00:00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00:00',
            "end_rabu" => '00:00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00:00',
            "end_kamis" => '00:00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00:00',
            "end_jumat" => '00:00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06:36',
            "end_sabtu" => '14:06:36',
            'minggu' => 'on',
            "start_minggu" => '09:06:36',
            "end_minggu" => '14:06:36'
        ];

        $request = Request::create('/', 'POST', $data);

        request()->request = $request;

        $service = new JadwalService();

        $service->update($jadwal->id,$data);

        $this->assertDatabaseHas('jadwals', $data);
    }

    function test_update_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $dokter = Dokter::factory(1)->create()->first();

        $jadwal = Jadwal::factory(5)->create([
            'dokter_id' => $dokter->id
        ])->first();

        $data = [
            'dokter_id' => $dokter->id,
            'senin' => 'off',
            "start_senin" => '00:01:00',
            "end_senin" => '00:03:00',
            'selasa' => 'off',
            "start_selasa" => '00:00:00',
            "end_selasa" => '00:00:00',
            'rabu' => 'off',
            "start_rabu" => '00:00:00',
            "end_rabu" => '00:00:00',
            'kamis' => 'off',
            "start_kamis" => '00:00:00',
            "end_kamis" => '00:00:00',
            'jumat' => 'off',
            "start_jumat" => '00:00:00',
            "end_jumat" => '00:00:00',
            'sabtu' => 'on',
            "start_sabtu" => '09:06:36',
            "end_sabtu" => '14:06:36',
            'minggu' => 'on',
            "start_minggu" => '09:06:36',
            "end_minggu" => '14:06:36'
        ];

        $request = Request::create('/', 'POST', $data);

        request()->request = $request;

        $service = new JadwalService();

        $service->update(122,$data);

    }

    function test_hapus_data_harus_sukses(){

        $dokter = Dokter::factory(1)->create()->first();

        $jadwal = Jadwal::factory(5)->create([
            'dokter_id' => $dokter->id
        ])->first();

        $service = new JadwalService();

        $service->delete($jadwal->id);

        $this->assertDatabaseMissing('jadwals',$jadwal->toArray());

    }

    function test_hapus_data_dengan_id_tidak_ada_harus_gagal(){
        $this->expectException(ModelNotFoundException::class);

        $dokter = Dokter::factory(1)->create()->first();

        $jadwal = Jadwal::factory(5)->create([
            'dokter_id' => $dokter->id
        ])->first();

        $service = new JadwalService();

        $service->delete(123);
    }

}
