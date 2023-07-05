<?php

namespace App\Orchid\Screens\Pemeriksaan;

use App\Http\Requests\Jadwal\JadwalEditRequest;
use App\Http\Requests\Pemeriksaan\PemeriksaanEditRequest;
use App\Models\Jadwal;
use App\Models\Pemeriksaan;
use App\Orchid\Layouts\Jadwal\JadwalEditlayout;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanEditlayout;
use App\services\JadwalService;
use App\services\PemeriksaanService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PemeriksaanEditScreen extends Screen
{
    public $pemeriksaan;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Pemeriksaan $pemeriksaan): iterable
    {
        $this->pemeriksaan = $pemeriksaan;
        return $pemeriksaan->toArray();
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->pemeriksaan->pasien->nama;
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
                ->route('platform.pemeriksaans')
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.pemeriksaan.edit'
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
            Layout::block(PemeriksaanEditlayout::class)
                ->title(__('Pemeriksaan'))
                ->description(__('Silakan masukan data pemeriksaan dengan benar'))
                ->commands(
                    Button::make(__('Update'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('update')
                ),
        ];
    }

    function update(Pemeriksaan $pemeriksaan,PemeriksaanEditRequest $request, PemeriksaanService $jadwalService){
        $data = $request->validated();

        request()->request = $request;

        $jadwalService->update($pemeriksaan->id,$data);

        Toast::info("Update data berhasil");
    }
}
