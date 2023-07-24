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

class PasienList2Layout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'pasiens';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('nama', __('Nama')),
            TD::make('photo', __('Foto'))
                ->render(function (Pasien $pasien){
                    $url = asset($pasien->icon);
                    return "<img src='{$url}' style='width:70px;height:70px;border-radius: 50%;object-fit: cover'>";
                }),
            TD::make('harlah', __('Tanggal Lahir')),
            TD::make('gender', __('Jenis Kelamin')),
            TD::make('alamat','Alamat')
                ->render(function (Pasien $pasien){
                    return "Desa {$pasien->desa}, kecamatan {$pasien->kecamatan}, {$pasien->kabupaten_kota}";
                }),
            TD::make('total', __('Total')),
        ];
    }
}
