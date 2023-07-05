<?php

namespace App\services;

use App\Models\Jadwal;
use App\Repositories\DashboardRepository;
use App\Repositories\DokterRepository;
use Carbon\Carbon;

class DashboardService
{
    var $repositoery;

    public function __construct()
    {
        $this->repositoery = new DashboardRepository();
    }

    public function pasien()
    {
        $pasiens = $this->repositoery->getAllPasien();
        $total = $pasiens->count();
        $totalPria = $pasiens->filter(fn($item) => $item->gender == 'pria')->count();
        $totalWanita = $pasiens->filter(fn($item) => $item->gender == 'wanita')->count();

        $balita = $pasiens->filter(fn($data) => $this->umur($data->harlah) < 6 && $this->umur($data->harlah) > 0)->count();
        $anak = $pasiens->filter(fn($data) => $this->umur($data->harlah) < 12 && $this->umur($data->harlah) > 5)->count();
        $remaja = $pasiens->filter(fn($data) => $this->umur($data->harlah) < 26 && $this->umur($data->harlah) > 11)->count();
        $dewasa = $pasiens->filter(fn($data) => $this->umur($data->harlah) < 46 && $this->umur($data->harlah) > 25)->count();
        $lansia = $pasiens->filter(fn($data) => $this->umur($data->harlah) < 66 && $this->umur($data->harlah) > 45)->count();
        $manula = $pasiens->filter(fn($data) => $this->umur($data->harlah) > 66 && $this->umur($data->harlah) > 65)->count();

        $desa = $pasiens->countBy(fn($data) => $data->desa);
        $kecamatan = $pasiens->countBy(fn($data) => $data->kecamatan);
        $kabupatenKota = $pasiens->countBy(fn($data) => $data->kabupaten_kota);

        $data = [
            'total' => [
                'total_keseluruhan' => $total,
                'total_wanita' => $totalWanita,
                'total_pria' => $totalPria,
            ],
            'harlah' => [
                'balita' => $balita,
                'anak' => $anak,
                'remaja' => $remaja,
                'dewasa' => $dewasa,
                'lansia' => $lansia,
                'manula' => $manula,
            ],
            'alamat' => [
                'desa' => $desa,
                'kecamatan' => $kecamatan,
                'kabupaten_kota' => $kabupatenKota,
            ]
        ];

        return $data;
    }

    public function dokter()
    {
        $dokter = $this->repositoery->getAllDokter();
        $total = $dokter->count();
        $totalPria = $dokter->filter(fn($item) => $item->gender == 'pria')->count();
        $totalWanita = $dokter->filter(fn($item) => $item->gender == 'wanita')->count();

        $desa = $dokter->countBy(fn($data) => $data->desa);
        $kecamatan = $dokter->countBy(fn($data) => $data->kecamatan);
        $kabupatenKota = $dokter->countBy(fn($data) => $data->kabupaten_kota);

        $jadwals = Jadwal::all();
        $senin = $jadwals->filter(fn($data) => $data->senin == 'on')->map(function ($data) {
            return [
                'dokter' => $data->dokter->toArray(),
                'start' => $data->start_senin,
                'end' => $data->end_senin,
            ];
        })->toArray();

        $selasa = $jadwals->filter(fn($data) => $data->selasa == 'on')->map(function ($data) {
            return [
                'dokter' => $data->dokter->toArray(),
                'start' => $data->start_selasa,
                'end' => $data->end_selasa,
            ];
        })->toArray();
        $rabu = $jadwals->filter(fn($data) => $data->rabu == 'on')->map(function ($data) {
            return [
                'dokter' => $data->dokter->toArray(),
                'start' => $data->start_rabu,
                'end' => $data->end_rabu,
            ];
        })->toArray();
        $kamis = $jadwals->filter(fn($data) => $data->kamis == 'on')->map(function ($data) {
            return [
                'dokter' => $data->dokter->toArray(),
                'start' => $data->start_kamis,
                'end' => $data->end_kamis,
            ];
        })->toArray();
        $jumat = $jadwals->filter(fn($data) => $data->jumat == 'on')->map(function ($data) {
            return [
                'dokter' => $data->dokter->toArray(),
                'start' => $data->start_jumat,
                'end' => $data->end_jumat,
            ];
        })->toArray();
        $sabtu = $jadwals->filter(fn($data) => $data->sabtu == 'on')->map(function ($data) {
            return [
                'dokter' => $data->dokter->toArray(),
                'start' => $data->start_sabtu,
                'end' => $data->end_sabtu,
            ];
        })->toArray();
        $minggu = $jadwals->filter(fn($data) => $data->minggu == 'on')->map(function ($data) {
            return [
                'dokter' => $data->dokter->toArray(),
                'start' => $data->start_minggu,
                'end' => $data->end_minggu,
            ];
        })->toArray();

        $jadwal = [
            'senin' => $senin,
            'selasa' => $selasa,
            'rabu' => $rabu,
            'kamis' => $kamis,
            'jumat' => $jumat,
            'sabtu' => $sabtu,
            'minggu' => $minggu,
        ];

        $now = Carbon::now()->format('N')-1;

        $data = [
            'total' => [
                'total_keseluruhan' => $total,
                'total_wanita' => $totalWanita,
                'total_pria' => $totalPria,
            ],
            'alamat' => [
                'desa' => $desa,
                'kecamatan' => $kecamatan,
                'kabupaten_kota' => $kabupatenKota,
            ],
            'jadwal' => $jadwal,
            'jadwal_hari_ini' => array_values($jadwal)[$now]
        ];

        return $data;
    }

    public function obat()
    {
        $obat = $this->repositoery->getAllObat();
        $total = $obat->count();

        $data = [
            'total' => [
                'total_keseluruhan' => $total,
            ],
        ];

        return $data;
    }

    private function umur($harlah)
    {
        $tanggal_lahir = Carbon::createFromFormat('Y-m-d', $harlah);
        $umur = $tanggal_lahir->diffInYears(Carbon::now());

        return $umur;
    }
}
