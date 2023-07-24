<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Layouts\Rows;

class PemeriksaanTanggal extends Rows
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

            DateTimer::make('first')
                ->title('Awal')
                ->allowInput()
                ->format('Y-m-d')
                ->required(),
            DateTimer::make('last')
                ->title('Akhir')
                ->allowInput()
                ->format('Y-m-d')
                ->required(),
        ];
    }
}
