<?php

namespace App\Orchid\Screens;

use App\Http\Requests\PelaporanFilterHariRequest;
use App\Http\Requests\PelaporanFilterTahunRequest;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Orchid\Layouts\Jadwal\JadwalEditlayout;
use App\Orchid\Layouts\Pasien\PasienList2Layout;
use App\Orchid\Layouts\Pasien\PasienListLayout;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanList2layout;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanListlayout;
use App\Orchid\Layouts\PemeriksaanChart;
use App\Orchid\Layouts\PemeriksaanTahun;
use App\Orchid\Layouts\PemeriksaanTanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PelaporanPemeriksaanPertahunScreen extends Screen
{
    var $day;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {

        $validator = Validator::make(request()->all(), [
            'tahun' => [
                'required', 'numeric',
            ]
        ]);

        if ($validator->fails()) {
            $tahun = Carbon::now()->year;
        } else {
            $tahun = request()->get('tahun');
        }

        $first = Carbon::create($tahun, 1, 1);
        $last = Carbon::create($tahun, 12, 31);;

        $pemeriksaans = Pemeriksaan::whereBetween('hari', [$first, $last])->orderBy('hari')->get();

        $data = $pemeriksaans->groupBy('pasien_id');
        $pasiens = $data->map(function ($item){
            $item[0]->pasien->total = $item->count();
            return $item[0]->pasien;
        });

        $days = [];
        $vals = [];

        $count = 0;
        foreach (range(1, 12) as $data) {
            $first = Carbon::create(date('Y'), $data, 1)->startOfMonth();
            $last = Carbon::create(date('Y'), $data, 1)->endOfMonth();
            $days[] = $first->toDateString() . ' | ' . $last->toDateString();
            $jarak = [$first, $last];
            $val = $pemeriksaans->whereBetween('hari', $jarak);
            $vals[] = $val->count() != 0 ? $val->count() : 0;
            $count++;
        }
//        dd('op');
        $dataset = [
            [
                'labels' => $days,
                'name' => 'Some Data',
                'values' => $vals,
            ]
        ];

        $this->day = $count;

        return [
            'dataset' => $dataset,
            'pemeriksaans' => $pemeriksaans,
            'tahun' => $tahun,
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
        return 'Laporan Tahunan';
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
            Layout::block(PemeriksaanTahun::class)
                ->title(__('Laporan Pemeriksaan'))
                ->description(__('Silakan masukan rentang tahun'))
                ->commands(
                    Button::make(__('Filter'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('filter')
                ),
            PemeriksaanChart::make('dataset', 'Pemeriksaan Dalam ' . $this->day . ' hari terakhir'),
            PemeriksaanList2layout::class,
            PasienList2Layout::class,
        ];
    }

    public function export()
    {
        Toast::message('ok');
    }

    public function filter(PelaporanFilterTahunRequest $request)
    {
        $data = $request->validated();
        return to_route('platform.pelaporan.pemeriksaan.pertahun', $data);
    }
}
