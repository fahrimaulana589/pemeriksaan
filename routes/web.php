<?php

use App\Models\Pemeriksaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route('platform.main');
});

Route::get('admin/pemeriksaans/{pemeriksaan}/print',function (Pemeriksaan $pemeriksaan){
    $pdf = Pdf::loadView('pdf.invoice',['pemeriksaan'=>$pemeriksaan]);
    return $pdf->setPaper('a4')->download('invoice.pdf');
})->name('platform.pemeriksaans.print');

Route::get('admin/pelaporan/pemeriksaan/print/harian',function (){
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

    $data = [
        'first' => $first->toDateString(),
        'last' => $last->toDateString(),
        'pemeriksaans' => $pemeriksaans,
        'pasiens' => $pasiens,
        'keluhans' => $keluhans
    ];

    $pdf = Pdf::loadView('pdf.pelaporanharian',['data'=>$data]);
    return $pdf->setPaper('a4')->download('pelaporan.pdf');

})->name('platform.pelaporan.print.harian');
