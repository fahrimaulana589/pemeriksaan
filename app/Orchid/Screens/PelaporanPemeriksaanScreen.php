<?php

namespace App\Orchid\Screens;

use App\Http\Requests\PelaporanFilterHariRequest;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Orchid\Layouts\Jadwal\JadwalEditlayout;
use App\Orchid\Layouts\Pasien\PasienList2Layout;
use App\Orchid\Layouts\Pasien\PasienList3Layout;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanList2layout;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanListlayout;
use App\Orchid\Layouts\PemeriksaanChart;
use App\Orchid\Layouts\PemeriksaanTanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PelaporanPemeriksaanScreen extends Screen
{
    var $day;
    var $first;
    var $last;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {

        $validator = Validator::make(request()->all(), [
            'first' => [
                'required',
                'date',
                'before:last'
            ], // Aturan validasi "date" akan memeriksa format tanggal
            'last' => [
                'required',
                'date',
                'before_or_equal:today',
                'after:first'
            ], // Aturan validasi "date" akan memeriksa format tanggal
        ]);

        if ($validator->fails()) {
            $first = Carbon::now()->subDays(13);
            $last = Carbon::now();
        } else {
            $first = Carbon::make(request()->get('first'));
            $last = Carbon::make(request()->get('last'));
        }

        $pemeriksaans = Pemeriksaan::whereBetween('hari', [$first, $last])->orderBy('hari')->get();

        $data = $pemeriksaans->groupBy('pasien_id');
        $datakeluhan = $pemeriksaans->groupBy('keluhan');

        $pasiens = $data->map(function ($item) {
            $item[0]->pasien->total = $item->count();
            return $item[0]->pasien;
        });

        $keluhans = $datakeluhan->map(function (Collection $item, $key) {
            $pasiens = $item->map(function ($item) {
                return $item->pasien->nama;
            })->toArray();
            return [
                'keluhan' => $key,
                'jumlah' => $item->count(),
                'pasiens' => $pasiens
            ];
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

        $this->day = $count;

        $this->first = $first->toDateString();
        $this->last = $last->toDateString();

        return [
            'dataset' => $dataset,
            'first' => $first->toDateString(),
            'last' => $last->toDateString(),
            'pemeriksaans' => $pemeriksaans,
            'pasiens' => $pasiens,
            'keluhans' => $keluhans
        ];

    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Laporan Perhari';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('print')
                ->route('platform.pelaporan.print.harian',['first'=>$this->first,'last'=>$this->last])
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
            Layout::block(PemeriksaanTanggal::class)
                ->title(__('Laporan Pemeriksaan'))
                ->description(__('Silakan masukan rentang tanggal'))
                ->commands(
                    Button::make(__('Filter'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('filter')
                ),
            PemeriksaanChart::make('dataset', 'Pemeriksaan Dalam ' . $this->day . ' hari terakhir'),
            PemeriksaanList2layout::class,
            PasienList2Layout::class,
            PasienList3Layout::class,
        ];
    }

    public function export()
    {
        Toast::message('ok');
    }

    public function filter(PelaporanFilterHariRequest $request)
    {
        $data = $request->validated();
        return to_route('platform.pelaporan.pemeriksaan', $data);
    }
}
