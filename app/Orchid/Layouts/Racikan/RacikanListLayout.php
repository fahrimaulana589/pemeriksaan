<?php

namespace App\Orchid\Layouts\Racikan;

use App\Models\Pemeriksaan;
use App\Models\Racikan;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RacikanListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'racikans';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('obat_id', __('Obat'))
                ->render(function (Racikan $racikan) {
                    return $racikan->obat->nama;
                }),

            TD::make('jumlah', __('Jumlah')),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Racikan $racikan) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.racikans.edit',[$this->query['pemeriksaan']->id,$racikan->id])
                            ->icon('bs.pencil')
                            ->hidden(permission('platform.racikan.edit')),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'racikan' => $racikan->id,
                            ])
                            ->hidden(permission('platform.racikan.delete')),
                    ])),
        ];
    }
}
