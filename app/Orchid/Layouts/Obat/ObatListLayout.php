<?php

namespace App\Orchid\Layouts\Obat;

use App\Models\Obat;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ObatListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'obats';

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
                ->render(function (Obat $obat){
                    $url = asset($obat->images);
                    return "<img src='{$url}' style='width:70px;height:70px;border-radius: 50%;object-fit: cover'>";
                }),
            TD::make('deskripsi', __('Deskripsi')),
            TD::make('stok', __('Stok')),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Obat $obat) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.obats.edit', $obat->id)
                            ->icon('bs.pencil')
                            ->hidden(permission('platform.obat.edit')),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'obat' => $obat->id,
                            ])
                            ->hidden(permission('platform.obat.delete')),
                    ])),
        ];
    }
}
