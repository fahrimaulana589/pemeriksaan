<?php

namespace App\Orchid\Screens\Racikan;

use App\Http\Requests\Pemeriksaan\PemeriksaanEditRequest;
use App\Http\Requests\Racikan\RacikanEditRequest;
use App\Models\Pemeriksaan;
use App\Models\Racikan;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanEditlayout;
use App\Orchid\Layouts\Racikan\RacikanEditLayout;
use App\services\PemeriksaanService;
use App\services\RacikanService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class RacikanEditScreen extends Screen
{
    public $pemeriksaan;
    public $racikan;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Pemeriksaan $pemeriksaan,Racikan $racikan): iterable
    {
        $this->pemeriksaan = $pemeriksaan;
        $this->racikan = $racikan;
        return $racikan->toArray();
    }

    public function permission(): ?iterable
    {
        return [
            'platform.racikan.edit'
        ];
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
                ->route('platform.racikans',$this->pemeriksaan->id)
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
            Layout::block(RacikanEditLayout::class)
                ->title(__('Racikan'))
                ->description(__('Silakan masukan data racikan dengan benar'))
                ->commands(
                    Button::make(__('Update'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('update')
                ),
        ];
    }

    function update(Racikan $racikan,RacikanEditRequest $request, RacikanService $service){
        $request->request->add(['variable' => 'value']);

        request()->request = $request;

        $data = $request->validated();

        $service->update($racikan->id,$data);

        Toast::info("Update data berhasil");
    }
}
