<?php

namespace App\Orchid\Layouts\Dokter;

use App\Models\Dokter;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DokterListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'dokters';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('nama', __('Nama')),
            TD::make('pendidikan', __('Pendidikan')),
            TD::make('keahlian', __('Keahlian')),
            TD::make('harlah', __('Tanggal Lahir')),
            TD::make('gender', __('Jenis Kelamin')),
            TD::make('alamat', 'Alamat')
                ->render(function (Dokter $dokter) {
                    return "Desa {$dokter->desa}, kecamatan {$dokter->kecamatan}, {$dokter->kabupaten_kota}";
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Dokter $dokter) => Link::make(__('Edit'))
                        ->route('platform.dokters.edit', $dokter->id)
                        ->icon('bs.pencil')
                        ->hidden(permission('platform.dokter.edit')) .

                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'dokter' => $dokter->id,
                        ])->hidden(permission('platform.dokter.delete'))
                ),
        ];
    }
}
