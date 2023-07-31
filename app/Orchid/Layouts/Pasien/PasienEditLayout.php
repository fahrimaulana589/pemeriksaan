<?php

namespace App\Orchid\Layouts\Pasien;

use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class PasienEditLayout extends Rows
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
            Relation::make('user_id')
                ->fromModel(User::class, 'name','id')
                ->applyScope('pasiens')
                ->title('Pilih User')
                ->help("Silahkan pilih user"),

            Input::make('nama')
                ->type('text')
                ->max(255)
                ->title(__('Nama'))
                ->placeholder(__('Nama'))
                ->help(__('Masukan nama lengkap pasien')),

            Select::make('gender')
                ->title('Gender')
                ->options(['pria' => 'pria','wanita' => 'wanita'])
                ->help('Pilih gender pasien'),

            DateTimer::make('harlah')
                ->title('Hari Lahir')
                ->allowInput()
                ->format('Y-m-d'),

            Input::make('desa')
                ->type('text')
                ->max(255)
                ->title(__('Desa'))
                ->placeholder(__('Desa'))
                ->help(__('Masukan nama desa tempat tinggal pasien')),

            Input::make('kecamatan')
                ->type('text')
                ->max(255)
                ->title(__('Kecamatan'))
                ->placeholder(__('Kecamatan'))
                ->help(__('Masukan nama kecamatan tempat tinggal pasien')),

            Input::make('kabupaten_kota')
                ->type('text')
                ->max(255)
                ->title(__('Kabupaten / Kota'))
                ->placeholder(__('Kabupaten / Kota'))
                ->help(__('Masukan nama kabupaten atau kota tempat tinggal pasien')),

        ];
    }
}
