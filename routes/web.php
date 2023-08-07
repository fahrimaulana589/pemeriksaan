<?php

use App\Models\Pemeriksaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

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
