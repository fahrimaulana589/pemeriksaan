<?php

namespace App\Orchid\Layouts\Pasien;

use App\Models\Pasien;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PasienList3Layout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'keluhans';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('keluhan', __('Nama'))
            ->render(function ($data){
                return $data['keluhan'];
            }),
            TD::make('jumlah', __('Total'))
            ->render(function ($data){
                return $data['jumlah'];
            }),
            TD::make('jumlah', __('Pasien'))
                ->render(function ($data){
                    return implode(',',$data['pasiens']);
                }),
        ];
    }
}
