<?php

namespace App\Orchid\Layouts\Pemeriksaan;

use App\Models\Dokter;
use App\Models\Pasien;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class PemeriksaanEditlayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Relation::make('pasien_id')
                ->fromModel(Pasien::class, 'nama','id')
                ->title('Pilih Pasien')
                ->help("Silahkan pilih pasien")
                ->disabled(auth()->user()->inRole('dokter')),

            Relation::make('dokter_id')
                ->fromModel(Dokter::class, 'nama','id')
                ->title('Pilih Dokter')
                ->help("Silahkan pilih dokter")
                ->disabled(auth()->user()->inRole('dokter')),

            Select::make('status')
                ->title('Pilih Status')
                ->options([
                    'antrian'   => 'Antrian',
                    'proses' => 'Proses',
                    'selesai' => 'Selesai',
                    'batal' => 'Batal',
                ]),

            Input::make('keluhan')
                ->type('text')
                ->max(255)
                ->title(__('Keluhan'))
                ->placeholder(__('keluhan'))
                ->help(__('Masukan keluhan pasien')),

            DateTimer::make('hari')
                ->title('Hari')
                ->allowInput()
                ->format('Y-m-d'),

        ];
    }
}
