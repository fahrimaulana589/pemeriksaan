<?php

namespace App\Orchid\Screens\Obat;

use App\Http\Requests\Obat\ObatEditRequest;
use App\Models\Obat;
use App\Orchid\Layouts\Obat\ObatEditLayout;
use App\services\ObatService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ObatEditScreen extends Screen
{
    public $obat;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Obat $obat): iterable
    {
        $this->obat = $obat;
        return $obat->toArray();
    }

    public function permission(): ?iterable
    {
        return [
            'platform.obat.edit'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->obat->nama;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Kembali')
                ->icon('bs.arrow-left')
                ->type(Color::BASIC)
                ->route('platform.obats')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(ObatEditLayout::class)
                ->title(__('Obat'))
                ->description(__('Silakan masukan data obat dengan benar'))
                ->commands(
                    Button::make(__('Update'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('update')
                ),
        ];
    }

    function update(Obat $obat,ObatEditRequest $request, ObatService $obatService){
        $data = $request->validated();
        request()->request = $request;
        $obatService->update($obat->id,$data);
        Toast::info("Update data berhasil");
    }
}
