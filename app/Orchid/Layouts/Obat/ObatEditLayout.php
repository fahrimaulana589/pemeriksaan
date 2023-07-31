<?php

namespace App\Orchid\Layouts\Obat;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ObatEditLayout extends Rows
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
            Input::make('nama')
                ->type('text')
                ->max(255)
                ->title(__('Nama'))
                ->placeholder(__('Nama'))
                ->help(__('Masukan nama lengkap obat')),

            Input::make('deskripsi')
                ->max(255)
                ->title(__('Deskripsi'))
                ->placeholder(__('Deskripsi'))
                ->help(__('Masukan Deskripsi obat')),

            Input::make('stok')
                ->type('number')
                ->max(255)
                ->title(__('Stok'))
                ->placeholder(__('Stok'))
                ->help(__('Masukan stok obat')),

        ];
    }
}
