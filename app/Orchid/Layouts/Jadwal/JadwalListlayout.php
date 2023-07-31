<?php

namespace App\Orchid\Layouts\Jadwal;

use App\Models\Dokter;
use App\Models\Jadwal;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class JadwalListlayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'jadwals';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('nama', __('Nama'))->render(fn(Jadwal $jadwal) => $jadwal->dokter->nama),
            TD::make('hari', __('Jadwal'))->render(function (Jadwal $jadwal) {
                return view('components.list_jadwal', compact('jadwal'));
            }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Jadwal $jadwal) => Link::make(__('Edit'))
                        ->route('platform.jadwals.edit', $jadwal->id)
                        ->icon('bs.pencil')
                        ->hidden(permission('platform.jadwal.edit')) .
                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'jadwal' => $jadwal->id,
                        ])
                        ->hidden(permission('platform.jadwal.delete'))),
        ];
    }
}
