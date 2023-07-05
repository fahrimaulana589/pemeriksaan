<?php

namespace App\Orchid\Layouts\Pemeriksaan;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PemeriksaanListlayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'pemeriksaans';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('dokter_id', __('Dokter'))
                ->render(function (Pemeriksaan $pemeriksaan) {
                    return $pemeriksaan->dokter->nama;
                }),

            TD::make('pasien_id', __('Pasien'))
                ->render(function (Pemeriksaan $pemeriksaan) {
                    return $pemeriksaan->pasien->nama;
                }),

            TD::make('keluhan', __('Keluhan')),

            TD::make('pasien_id', __('Pasien'))
                ->render(function (Pemeriksaan $pemeriksaan) {
                    return $pemeriksaan->pasien->nama;
                }),

            TD::make('hari', __('Hari PemeriksaanSeeder')),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Pemeriksaan $pemeriksaan) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.pemeriksaans.edit', $pemeriksaan->id)
                            ->icon('bs.pencil')
                            ->hidden(permission('platform.pemeriksaan.edit')),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'pemeriksaan' => $pemeriksaan->id,
                            ])
                            ->hidden(permission('platform.pemeriksaan.delete')),

                        Link::make(__('Racikan'))
                            ->route('platform.racikans', $pemeriksaan->id)
                            ->icon('bs.plus')
                            ->hidden(permission('platform.racikan.list')),

                    ])),
        ];
    }
}
