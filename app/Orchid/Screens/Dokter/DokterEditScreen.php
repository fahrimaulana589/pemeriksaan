<?php

namespace App\Orchid\Screens\Dokter;

use App\Http\Requests\Dokter\DokterEditRequest;
use App\Http\Requests\Pasien\PasienEditRequest;
use App\Models\Dokter;
use App\Orchid\Layouts\Dokter\DokterEditLayout;
use App\services\DokterService;
use App\services\PasienService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DokterEditScreen extends Screen
{
    public $dokter;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Dokter $dokter): iterable
    {
        $this->dokter = $dokter;
        return $dokter->toArray();
    }

    public function permission(): ?iterable
    {
        return ['platform.dokter.edit'];
    }


    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->dokter->nama;
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
                ->route('platform.dokters')
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
            Layout::block(DokterEditLayout::class)
                ->title(__('Dokter'))
                ->description(__('Silakan masukan data dokter dengan benar'))
                ->commands(
                    Button::make(__('Update'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('update')
                ),
        ];
    }

    function update(Dokter $dokter,DokterEditRequest $request, DokterService $dokterService){
        $data = $request->validated();

        request()->request = $request;

        $dokterService->update($dokter->id,$data);

        Toast::info("Update data berhasil");
    }
}
