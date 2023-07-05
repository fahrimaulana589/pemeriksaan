<?php

namespace App\Orchid\Layouts\Jadwal;

use App\Models\Dokter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TimeZone;
use Orchid\Screen\Layouts\Rows;

class JadwalAddlayout extends Rows
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
            Relation::make('dokter_id')
                ->fromModel(Dokter::class, 'nama','id')
                ->title('Pilih Dokter')
                ->help("Silahkan pilih dokter"),

            Select::make('senin')
                ->options([
                    'off' => "Off",
                    'on' => 'On'
                ])
                ->title('Senin')
                ->placeholder('off/on'),

            Input::make('start_senin')->type('time')
                ->title('Mulai'),

            Input::make('end_senin')->type('time')
                ->title('Berakhir')
                ->help('Kosongkan jika hari tidak aktif'),

            Select::make('selasa')
                ->options([
                    'off' => "Off",
                    'on' => 'On'
                ])
                ->title('Selasa')
                ->placeholder('off/on'),

            Input::make('start_selasa')->type('time')
                ->title('Mulai'),

            Input::make('end_selasa')->type('time')
                ->title('Berakhir')
                ->help('Kosongkan jika hari tidak aktif'),

            Select::make('rabu')
                ->options([
                    'off' => "Off",
                    'on' => 'On'
                ])
                ->title('Rabu')
                ->placeholder('off/on'),

            Input::make('start_rabu')->type('time')
                ->title('Mulai'),

            Input::make('end_rabu')->type('time')
                ->title('Berakhir')
                ->help('Kosongkan jika hari tidak aktif'),

            Select::make('kamis')
                ->options([
                    'off' => "Off",
                    'on' => 'On'
                ])
                ->title('Kamis')
                ->placeholder('off/on'),

            Input::make('start_kamis')->type('time')
                ->title('Mulai'),

            Input::make('end_kamis')->type('time')
                ->title('Berakhir')
                ->help('Kosongkan jika hari tidak aktif'),

            Select::make('jumat')
                ->options([
                    'off' => "Off",
                    'on' => 'On'
                ])
                ->title('Jumat')
                ->placeholder('off/on'),

            Input::make('start_jumat')->type('time')
                ->title('Mulai'),

            Input::make('end_jumat')->type('time')
                ->title('Berakhir')
                ->help('Kosongkan jika hari tidak aktif'),

            Select::make('sabtu')
                ->options([
                    'off' => "Off",
                    'on' => 'On'
                ])
                ->title('Sabtu')
                ->placeholder('off/on'),

            Input::make('start_sabtu')->type('time')
                ->title('Mulai'),

            Input::make('end_sabtu')->type('time')
                ->title('Berakhir')
                ->help('Kosongkan jika hari tidak aktif'),

            Select::make('minggu')
                ->options([
                    'off' => "Off",
                    'on' => 'On'
                ])
                ->title('Minggu')
                ->placeholder('off/on'),

            Input::make('start_minggu')->type('time')
                ->title('Mulai')
                ->placeholder(''),

            Input::make('end_minggu')->type('time')
                ->title('Berakhir')
                ->help('Kosongkan jika hari tidak aktif'),

        ];
    }
}
