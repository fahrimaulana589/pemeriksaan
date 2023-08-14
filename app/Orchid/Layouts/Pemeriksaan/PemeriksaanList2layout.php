<?php

namespace App\Orchid\Layouts\Pemeriksaan;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PemeriksaanList2layout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'pemeriksaans';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('dokter_id', __('Dokter'))
                ->render(function (Pemeriksaan $pemeriksaan) {
                    return $pemeriksaan->dokter->nama;
                }),

            TD::make('pasien_id', __('Pasien'))
                ->render(function (Pemeriksaan $pemeriksaan) {
                    return $pemeriksaan->pasien->nama;
                }),

            TD::make('keluhan', __('Keluhan')),

            TD::make('status', __('Status')),

            TD::make('hari', __('Hari Pemeriksaan')),
        ];
    }
}
