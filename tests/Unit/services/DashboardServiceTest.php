<?php

namespace services;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\services\DashboardService;
use Carbon\Carbon;
use Tests\TestCase;

class DashboardServiceTest extends TestCase
{

    public function test_jumlah_pasien_harus_sukses()
    {
        Pasien::factory(12)->create();

        $service = new DashboardService();

        $data = $service->pasien();

        $this->assertTrue($data['total']['total_keseluruhan'] == 12);
    }

    public function test_jumlah_pasien_berdasarkan_gender_harus_sukses()
    {
        Pasien::factory(12)->create([
            'gender' => 'pria'
        ]);

        Pasien::factory(12)->create([
            'gender' => 'wanita'
        ]);

        $service = new DashboardService();

        $data = $service->pasien();

        $this->assertTrue($data['total']['total_pria'] == 12);
        $this->assertTrue($data['total']['total_wanita'] == 12);
    }

    public function test_jumlah_pasien_berdasarkan_umur_harus_sukses()
    {
        Pasien::factory(12)->create([
            'harlah' => Carbon::now()->subYears(5)
        ]);
        Pasien::factory(12)->create([
            'harlah' => Carbon::now()->subYears(11)
        ]);
        Pasien::factory(12)->create([
            'harlah' => Carbon::now()->subYears(23)
        ]);
        Pasien::factory(12)->create([
            'harlah' => Carbon::now()->subYears(34)
        ]);
        Pasien::factory(12)->create([
            'harlah' => Carbon::now()->subYears(60)
        ]);
        Pasien::factory(12)->create([
            'harlah' => Carbon::now()->subYears(90)
        ]);

        $service = new DashboardService();

        $data = $service->pasien();

        $this->assertTrue($data['harlah']['balita'] == 12);
        $this->assertTrue($data['harlah']['anak'] == 12);
        $this->assertTrue($data['harlah']['remaja'] == 12);
        $this->assertTrue($data['harlah']['dewasa'] == 12);
        $this->assertTrue($data['harlah']['lansia'] == 12);
        $this->assertTrue($data['harlah']['manula'] == 12);
    }

    public function test_jumlah_pasien_berdasarkan_alamat_desa_harus_sukses()
    {
        Pasien::factory(3)->create([
            'desa' => 'karangmangu'
        ]);
        Pasien::factory(12)->create([
            'desa' => 'kalikangkung'
        ]);
        Pasien::factory(2)->create([
            'kecamatan' => 'lebaksiu'
        ]);
        Pasien::factory(121)->create([
            'kecamatan' => 'tarub'
        ]);
        Pasien::factory(12)->create([
            'kabupaten_kota' => 'tegal'
        ]);
        Pasien::factory(13)->create([
            'kabupaten_kota' => 'brebes'
        ]);

        $service = new DashboardService();

        $data = $service->pasien();

        $this->assertTrue($data['alamat']['desa']['karangmangu'] == 3);
        $this->assertTrue($data['alamat']['desa']['kalikangkung'] == 12);
        $this->assertTrue($data['alamat']['kecamatan']['tarub'] == 121);
        $this->assertTrue($data['alamat']['kecamatan']['lebaksiu'] == 2);
        $this->assertTrue($data['alamat']['kabupaten_kota']['tegal'] == 12);
        $this->assertTrue($data['alamat']['kabupaten_kota']['brebes'] == 13);
    }

    public function test_jumlah_dokter_berdasarkan_gender_harus_sukses()
    {
        Dokter::factory(12)->create([
            'gender' => 'pria'
        ]);

        Dokter::factory(12)->create([
            'gender' => 'wanita'
        ]);

        $service = new DashboardService();

        $data = $service->dokter();

        $this->assertTrue($data['total']['total_pria'] == 12);
        $this->assertTrue($data['total']['total_wanita'] == 12);
    }

    public function test_jumlah_dokter_berdasarkan_alamat_desa_harus_sukses()
    {
        Dokter::factory(3)->create([
            'desa' => 'karangmangu'
        ]);
        Dokter::factory(12)->create([
            'desa' => 'kalikangkung'
        ]);
        Dokter::factory(2)->create([
            'kecamatan' => 'lebaksiu'
        ]);
        Dokter::factory(121)->create([
            'kecamatan' => 'tarub'
        ]);
        Dokter::factory(12)->create([
            'kabupaten_kota' => 'tegal'
        ]);
        Dokter::factory(13)->create([
            'kabupaten_kota' => 'brebes'
        ]);

        $service = new DashboardService();

        $data = $service->dokter();

        $this->assertTrue($data['alamat']['desa']['karangmangu'] == 3);
        $this->assertTrue($data['alamat']['desa']['kalikangkung'] == 12);
        $this->assertTrue($data['alamat']['kecamatan']['tarub'] == 121);
        $this->assertTrue($data['alamat']['kecamatan']['lebaksiu'] == 2);
        $this->assertTrue($data['alamat']['kabupaten_kota']['tegal'] == 12);
        $this->assertTrue($data['alamat']['kabupaten_kota']['brebes'] == 13);
    }

    public function test_jumlah_dokter_berdasarkan_jadwal_harus_sukses()
    {
        $dokter1 = Dokter::factory(1)->create([
            'gender' => 'pria'
        ])->first();

        Jadwal::factory(1)->create([
            'dokter_id' => $dokter1->id,
            'senin' => 'on',
            'start_senin' => '12:12:12',
            'end_senin' => '13:12:12',
        ]);

        $dokter2 = Dokter::factory(1)->create([
            'gender' => 'wanita'
        ])->first();

        Jadwal::factory(1)->create([
            'dokter_id' => $dokter2->id,  'senin' => 'on',
            'selasa' => 'on',
            'start_selasa' => '12:12:12',
            'end_selasa' => '13:12:12',
        ]);

        $service = new DashboardService();

        $data = $service->dokter();

        dump(count($data['jadwal']['senin']));

        $this->assertTrue(count($data['jadwal']['senin']) == 2);
        $this->assertTrue(count($data['jadwal']['selasa']) == 1);
    }
}
