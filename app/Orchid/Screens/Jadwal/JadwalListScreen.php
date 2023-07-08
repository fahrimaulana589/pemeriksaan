<?php

namespace App\Orchid\Screens\Jadwal;

use App\Http\Requests\Jadwal\JadwalDeleteRequest;
use App\Http\Requests\Obat\ObatDeleteRequest;
use App\Models\Jadwal;
use App\Models\Obat;
use App\Orchid\Layouts\Jadwal\JadwalListlayout;
use App\Orchid\Layouts\Obat\ObatListLayout;
use App\services\JadwalService;
use App\services\ObatService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class JadwalListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $data = [
            'jadwals' => Jadwal::filters()->defaultSort('id', 'desc')->paginate(),
        ];

        if(auth()->user()->inRole('admin')){
            $data = [
                'jadwals' => Jadwal::filters()->defaultSort('id', 'desc')->paginate(),
            ];
        }
        if(auth()->user()->inRole('dokter')){
            $data = [
                'jadwals' => Jadwal::where('id','=',auth()->user()->dokter->id)->filters()->defaultSort('id', 'desc')->paginate(),
            ];
        }
        return $data;
    }

    public function permission(): ?iterable
    {
        return [
            'platform.jadwal.list'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Daftar Jadwal Dokter';
    }

    public function description(): ?string
    {
        return "Berisikan daftar jadwal dokter yang ada di apotek";
    }


    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Tambah')
                ->type(Color::BASIC)
                ->icon('bs.plus')
                ->route('platform.jadwals.add')
                ->hidden(permission('platform.jadwal.add'))
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
            JadwalListlayout::class
        ];
    }

    function remove(JadwalDeleteRequest $request, JadwalService $service)
    {
        $data = $request->validated();
        $service->delete($data['jadwal']);
        Toast::info("Hapus Data Berhasil");
    }
}
