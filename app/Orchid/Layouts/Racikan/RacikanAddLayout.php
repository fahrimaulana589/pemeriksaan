<?php

namespace App\Orchid\Layouts\Racikan;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class RacikanAddLayout extends Rows
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
            Input::make('pemeriksaan_id')
                ->type('hidden')
                ->value($this->query['pemeriksaan']->id)
                ->max(255),

            Relation::make('obat_id')
                ->fromModel(Obat::class, 'nama','id')
                ->title('Pilih Obat')
                ->help("Silahkan pilih obat"),

            Input::make('jumlah')
                ->type('number')
                ->max(255)
                ->title(__('Jumlah'))
                ->placeholder(__('jumlah'))
                ->help(__('Masukan jumlah obat')),
        ];
    }
}
