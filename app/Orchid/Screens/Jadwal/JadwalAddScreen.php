<?php

namespace App\Orchid\Screens\Jadwal;

use App\Http\Requests\Jadwal\JadwalAddRequest;
use App\Http\Requests\Obat\ObatAddRequest;
use App\Models\User;
use App\Orchid\Layouts\Jadwal\JadwalAddlayout;
use App\Orchid\Layouts\Obat\ObatAddLayout;
use App\services\JadwalService;
use App\services\ObatService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class JadwalAddScreen extends Screen
{
    /**
     * @var User
     */
    public $user;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(User $user): iterable
    {
        $user->load(['roles']);

        return [
            'user' => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.jadwal.add'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tambah Jadwal';
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
            Layout::block(JadwalAddlayout::class)
                ->title(__('Jadwal'))
                ->description(__('Silakan masukan data jadwal dokter dengan benar'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('save')
                ),
        ];
    }

    function save(JadwalAddRequest $request, JadwalService $service)
    {

        $data = $request->all();

        request()->request = $request;

        $service->create($data);

        Toast::info("Jadwal Berhasil Ditambahkan");

        return to_route('platform.jadwals');

    }
}
