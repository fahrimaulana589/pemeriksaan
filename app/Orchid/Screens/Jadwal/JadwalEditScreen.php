<?php

namespace App\Orchid\Screens\Jadwal;

use App\Http\Requests\Dokter\DokterEditRequest;
use App\Http\Requests\Jadwal\JadwalEditRequest;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Orchid\Layouts\Dokter\DokterEditLayout;
use App\Orchid\Layouts\Jadwal\JadwalEditlayout;
use App\services\DokterService;
use App\services\JadwalService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class JadwalEditScreen extends Screen
{
    public $jadwal;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Jadwal $jadwal): iterable
    {
        $this->jadwal = $jadwal;
        return $jadwal->toArray();
    }

    public function permission(): ?iterable
    {
        return [
            'platform.jadwal.edit'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->jadwal->dokter->nama;
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
                ->route('platform.jadwals')
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
            Layout::block(JadwalEditlayout::class)
                ->title(__('Jadwal'))
                ->description(__('Silakan masukan data jadwal dengan benar'))
                ->commands(
                    Button::make(__('Update'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('update')
                ),
        ];
    }

    function update(Jadwal $jadwal,JadwalEditRequest $request, JadwalService $jadwalService){
        $data = $request->validated();

        request()->request = $request;

        $jadwalService->update($jadwal->id,$data);

        Toast::info("Update data berhasil");
    }
}
