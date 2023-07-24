<?php

namespace App\Orchid\Screens;

use App\Http\Requests\PelaporanFilterBulanRequest;
use App\Http\Requests\PelaporanFilterHariRequest;
use App\Models\Obat;
use App\Models\Pemeriksaan;
use App\Orchid\Layouts\Jadwal\JadwalEditlayout;
use App\Orchid\Layouts\Pasien\PasienList2Layout;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanList2layout;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanListlayout;
use App\Orchid\Layouts\PemeriksaanBulan;
use App\Orchid\Layouts\PemeriksaanChart;
use App\Orchid\Layouts\PemeriksaanTanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PelaporanPemeriksaanPerbulanScreen extends Screen
{
    public $bln;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {

        $validator = Validator::make(request()->all(), [
            'bulan' => [
                'required','numeric',
            ]
        ]);

        if ($validator->fails()) {
            $bulan = Carbon::now()->subMonth()->month;
        } else {
            $bulan = request()->get('bulan');
        }

        $first = Carbon::create(date('Y'), $bulan, 1)->startOfMonth();;
        $last = Carbon::create(date('Y'), $bulan, 1)->endOfMonth();

        $this->bln = $first->monthName;

        $pemeriksaans = Pemeriksaan::whereBetween('hari', [$first, $last])->orderBy('hari')->get();

        $data = $pemeriksaans->groupBy('pasien_id');
        $pasiens = $data->map(function ($item){
            $item[0]->pasien->total = $item->count();
            return $item[0]->pasien;
        });

        $days = [];
        $vals = [];

        $count = 0;
        foreach ($first->daysUntil($last) as $data) {
            $days[] = $data->toDateString();
            $jarak = [Carbon::make($data->subDays()->toDateString()), Carbon::make($data->addDays()->toDateString())];
            $val = $pemeriksaans->whereBetween('hari', $jarak);
            $vals[] = $val->count() != 0 ? $val->count() : 0;
            $count++;
        }
        $dataset = [
            [
                'labels' => $days,
                'name' => 'Some Data',
                'values' => $vals,
            ]
        ];

        return [
            'dataset' => $dataset,
            'first' => $first->toDateString(),
            'last' => $last->toDateString(),
            'pemeriksaans' => $pemeriksaans,
            'bulan' => ''.$bulan,
            'pasiens' => $pasiens
        ];

    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Laporan Perbulan';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(PemeriksaanBulan::class)
                ->title(__('Laporan Pemeriksaan'))
                ->description(__('Silakan masukan rentang bulan'))
                ->commands(
                    Button::make(__('Filter'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('filter')
                ),
            PemeriksaanChart::make('dataset', 'Pemeriksaan Di Bulan ' . $this->bln),
            PemeriksaanList2layout::class,
            PasienList2Layout::class,
        ];
    }

    public function export()
    {
        Toast::message('ok');
    }

    public function filter(PelaporanFilterBulanRequest $request)
    {
        $data = $request->validated();
        return to_route('platform.pelaporan.pemeriksaan.perbulan', $data);
    }
}
