<?php

namespace App\Orchid\Screens\Pemeriksaan;

use App\Http\Requests\Pemeriksaan\PemeriksaanDeleteRequest;
use App\Models\Pemeriksaan;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanListlayout;
use App\services\PemeriksaanService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class PemeriksaanJadwalScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $data = [
            'pemeriksaans' => Pemeriksaan::filters()->defaultSort('id', 'desc')->paginate(),
        ];

        if(auth()->user()->inRole('admin')){
            $data = [
                'pemeriksaans' => Pemeriksaan::filters()->defaultSort('id', 'desc')->paginate(),
            ];
        }

        if(auth()->user()->inRole('dokter')){
            $data = [
                'pemeriksaans' => Pemeriksaan::where('dokter_id','=',auth()->user()->dokter->id)->filters()->defaultSort('id', 'desc')->paginate(),
            ];
        }

        if(auth()->user()->inRole('pasien')){
            $data = [
                'pemeriksaans' => Pemeriksaan::where('pasien_id','=',auth()->user()->pasien->id)->where('status','proses')->filters()->defaultSort('id', 'desc')->paginate(),
            ];
        }

        return $data;
    }

    public function permission(): ?iterable
    {
        return [
            'platform.pemeriksaan.list'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Daftar Pemeriksaan';
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
            Link::make('Tambah')
                ->type(Color::BASIC)
                ->icon('bs.plus')
                ->route('platform.pemeriksaans.add')
                ->hidden(permission('platform.pemeriksaan.add'))

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
            PemeriksaanListlayout::class
        ];
    }

    function remove(PemeriksaanDeleteRequest $request, PemeriksaanService $service)
    {
        $data = $request->validated();
        $service->delete($data['pemeriksaan']);
        Toast::info("Hapus Data Berhasil");
    }
}
