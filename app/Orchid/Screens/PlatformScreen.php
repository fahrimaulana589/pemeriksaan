<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Orchid\Layouts\Pasien\ChartsPasienAlamatLayout;
use App\Orchid\Layouts\Pasien\ChartsPasienUmurLayout;
use App\Orchid\Layouts\Pasien\ChartsPasienGenderLayout;
use App\services\DashboardService;
use App\services\DokterService;
use Illuminate\Support\Carbon;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    private $dokter;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(DashboardService $dashboardService): iterable
    {
        $pasien = $dashboardService->pasien();
        $dokter = $dashboardService->dokter();
        $this->dokter = $dokter;
        $obat = $dashboardService->obat();

        return [
            'pasien_gender' => [
                [
                    'name' => 'Some Data',
                    'values' => [$pasien['total']['total_pria'], $pasien['total']['total_wanita']],
                    'labels' => ['Pria', 'Wanita'],
                ]
            ],
            'pasien_umur' => [
                [
                    'name' => 'Some Data',
                    'values' => [$pasien['harlah']['balita'], $pasien['harlah']['anak'], $pasien['harlah']['remaja'], $pasien['harlah']['dewasa'], $pasien['harlah']['lansia'], $pasien['harlah']['manula'],],
                    'labels' => ['Balita', 'Anak', 'Remaja', 'Dewasa', 'Lansia', 'Manula'],
                ]
            ],
            'pasien_alamat_desa' => [
                [
                    'name' => 'Some Data',
                    'values' => array_values($pasien['alamat']['desa']->toArray()),
                    'labels' => array_keys($pasien['alamat']['desa']->toArray()),
                ]
            ],
            'metrics' => [
                'pasien' => ['value' => number_format($pasien['total']['total_keseluruhan']), 'diff' => 0],
                'obat' => ['value' => number_format($obat['total']['total_keseluruhan']), 'diff' => 0],
                'dokter' => ['value' => number_format($dokter['total']['total_keseluruhan']), 'diff' => 0],
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Dashboard';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive guide to creating and customizing various types of charts, including bar, line, and pie charts.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     * @throws \Throwable
     *
     */
    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Pasien' => 'metrics.pasien',
                'Dokter' => 'metrics.dokter',
                'Obat' => 'metrics.obat',
            ]),
            ChartsPasienAlamatLayout::make('pasien_alamat_desa', 'Pasien Berdasarkan Lokasi Desa')
                ->description('Perbandingan pasien berdasarkan alamat desa'),
            Layout::split([
                ChartsPasienGenderLayout::make('pasien_gender', 'Pasien Berdasarkan Gender')
                    ->description('Perbandingan pasien berdasarkan gender'),
                ChartsPasienUmurLayout::make('pasien_umur', 'Pasien Berdasarkan Umur')
                    ->description('Perbandingan pasien berdasarkan umur'),
            ]),
            Layout::split([
                Layout::view('components.list_jadwal_dokter', ['dokter' => $this->dokter]),
                Layout::view('components.list_dokter', ['dokters' => $this->dokter]),
            ])->ratio('60/40'),
        ];
    }
}
