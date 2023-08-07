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

class PasienListLayout extends Table
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
            TD::make('harlah', __('Tanggal Lahir')),
            TD::make('gender', __('Jenis Kelamin')),
            TD::make('alamat', 'Alamat')
                ->render(function (Pasien $pasien) {
                    return "Desa {$pasien->desa}, kecamatan {$pasien->kecamatan}, {$pasien->kabupaten_kota}";
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Pasien $pasien) => Link::make(__('Edit'))
                        ->route('platform.pasiens.edit', $pasien->id)
                        ->icon('bs.pencil')
                        ->hidden(permission('platform.pasien.edit')) .

                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'pasien' => $pasien->id,
                        ])
                        ->hidden(permission('platform.pasien.delete')).
                    Link::make(__('Pemeriksaan'))
                        ->route('platform.pasiens.pemeriksaan', $pasien->id)
                        ->icon('bs.list-check')
                        ->hidden(permission('platform.pasien.list'))),
        ];
    }
}
