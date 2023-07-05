<?php

namespace App\Orchid\Screens\Pasien;

use App\Http\Requests\Pasien\PasienEditRequest;
use App\Models\Pasien;
use App\Orchid\Layouts\Pasien\DokterAddLayout;
use App\Orchid\Layouts\Pasien\DokterEditLayout;
use App\Orchid\Layouts\Pasien\PasienEditLayout;
use App\services\PasienService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PasienEditScreen extends Screen
{
    public $pasien;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Pasien $pasien): iterable
    {
        $this->pasien = $pasien;
        return $pasien->toArray();
    }

    public function permission(): ?iterable
    {
        return [
            'platform.pasien.edit'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->pasien->nama;
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
                ->route('platform.pasiens')
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
            Layout::block(PasienEditLayout::class)
                ->title(__('Pasien'))
                ->description(__('Silakan masukan data pasien dengan benar'))
                ->commands(
                    Button::make(__('Update'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('update')
                ),
        ];
    }

    function update(Pasien $pasien,PasienEditRequest $request, PasienService $pasienService){
        $data = $request->validated();

        request()->request = $request;

        $pasienService->update($pasien->id,$data);

        Toast::info("Update data berhasil");
    }
}
