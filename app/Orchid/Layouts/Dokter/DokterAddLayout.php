<?php

namespace App\Orchid\Layouts\Dokter;

use App\Models\Obat;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class DokterAddLayout extends Rows
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
                ->applyScope('dokters')
                ->title('Pilih User')
                ->help("Silahkan pilih user"),

            Input::make('nama')
                ->type('text')
                ->max(255)
                ->title(__('Nama'))
                ->placeholder(__('Nama'))
                ->help(__('Masukan nama lengkap dokter')),

            Input::make('pendidikan')
                ->type('text')
                ->max(255)
                ->title(__('Pendidikan Terakhir'))
                ->placeholder(__('Pendidikan Terakhir'))
                ->help(__('Masukan pendidikan terakhir dokter')),

            Input::make('keahlian')
                ->type('text')
                ->max(255)
                ->title(__('Keahlian'))
                ->placeholder(__('Keahlian'))
                ->help(__('Masukan keahlian dokter')),

            Input::make('nama')
                ->type('text')
                ->max(255)
                ->title(__('Nama'))
                ->placeholder(__('Nama'))
                ->help(__('Masukan nama lengkap dokter')),

            Select::make('gender')
                ->title('Gender')
                ->options(['pria' => 'pria','wanita' => 'wanita'])
                ->help('Pilih gender dokter'),

            DateTimer::make('harlah')
                ->title('Hari Lahir')
                ->allowInput()
                ->format('Y-m-d'),

            Input::make('desa')
                ->type('text')
                ->max(255)
                ->title(__('Desa'))
                ->placeholder(__('Desa'))
                ->help(__('Masukan nama desa tempat tinggal dokter')),

            Input::make('kecamatan')
                ->type('text')
                ->max(255)
                ->title(__('Kecamatan'))
                ->placeholder(__('Kecamatan'))
                ->help(__('Masukan nama kecamatan tempat tinggal dokter')),

            Input::make('kabupaten_kota')
                ->type('text')
                ->max(255)
                ->title(__('Kabupaten / Kota'))
                ->placeholder(__('Kabupaten / Kota'))
                ->help(__('Masukan nama kabupaten atau kota tempat tinggal dokter')),

            Input::make('file')
                ->type('file')
                ->max(255)
                ->title(__('Foto'))
                ->placeholder(__('Foto'))
                ->help(__('Masukan foto dokter')),

        ];
    }
}
