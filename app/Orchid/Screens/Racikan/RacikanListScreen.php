<?php

namespace App\Orchid\Screens\Racikan;

use App\Http\Requests\Pemeriksaan\PemeriksaanDeleteRequest;
use App\Http\Requests\Racikan\RacikanDeleteRequest;
use App\Models\Pemeriksaan;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanListlayout;
use App\Orchid\Layouts\Racikan\RacikanListLayout;
use App\services\PemeriksaanService;
use App\services\RacikanService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class RacikanListScreen extends Screen
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
        return [
            'racikans' => $pemeriksaan->racikan()->filters()->defaultSort('id', 'desc')->paginate(),
            'pemeriksaan' => $pemeriksaan
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.racikan.list'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Daftar Racikan';
    }

    public function description(): ?string
    {
        return "Berisikan daftar Daftar pemeriksaan yang ada di apotek";
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
                ->route('platform.pemeriksaans'),
            Link::make('Tambah')
                ->type(Color::BASIC)
                ->icon('bs.plus')
                ->route('platform.racikans.add', $this->pemeriksaan->id)
                ->hidden(permission('platform.racikan.add')),
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
            RacikanListLayout::class
        ];
    }

    function remove(RacikanDeleteRequest $request, RacikanService $service)
    {
        $data = $request->validated();
        $service->delete($data['racikan']);
        Toast::info("Hapus Data Berhasil");
    }
}
