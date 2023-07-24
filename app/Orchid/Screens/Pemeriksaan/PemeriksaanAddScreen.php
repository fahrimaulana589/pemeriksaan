<?php

namespace App\Orchid\Screens\Pemeriksaan;

use App\Http\Requests\Pasien\PasienAddRequest;
use App\Http\Requests\Pemeriksaan\PemeriksaanAddRequest;
use App\Models\User;
use App\Orchid\Layouts\Pasien\PasienAddLayout;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanAddlayout;
use App\services\PasienService;
use App\services\PemeriksaanService;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PemeriksaanAddScreen extends Screen
{
    /**
     * @var User
     */
    public $pemeriksaan;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(User $user): iterable
    {
        $user->load(['roles']);

        if(isRole('pasien')){
            $pasien = Auth::user()->pasien;
            return [
                'pasien_id' => $pasien->id,
                'user' => $user,
                'hari' => Carbon::now(),
                'permission' => $user->getStatusPermission(),
            ];
        }

        return [
            'user' => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.pemeriksaan.add'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tambah Pemeriksaan';
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

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(PemeriksaanAddlayout::class)
                ->title(__('Pemeriksaan'))
                ->description(__('Silakan masukan data pemeriksaan dengan benar'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('save')
                ),
        ];
    }

    function save(Request $request,PemeriksaanService $service)
    {
        if(isRole('pasien')){
            $pasien = Auth::user()->pasien;

            $request->merge([
                'pasien_id' => $pasien->id,
                'hari' => Carbon::now(),
                'status' => 'antrian'
            ]);
        }

        $request = app()->make(PemeriksaanAddRequest::class);

        $data = $request->validated();

        $service->create($data);

        Toast::info("Pemeriksaan Berhasil Ditambahkan");

        return to_route('platform.pemeriksaans');
    }
}
