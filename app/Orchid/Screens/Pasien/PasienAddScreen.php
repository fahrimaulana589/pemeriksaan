<?php

namespace App\Orchid\Screens\Pasien;

use App\Http\Requests\Pasien\PasienAddRequest;
use App\Orchid\Layouts\Dokter\DokterAddLayout;
use App\Orchid\Layouts\Pasien\PasienAddLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\services\PasienService;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PasienAddScreen extends Screen
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
            'platform.pasien.add'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tambah Pasien';
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
            Layout::block(PasienAddLayout::class)
                ->title(__('Pasien'))
                ->description(__('Silakan masukan data pasien dengan benar'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('save')
                ),
        ];
    }

    function save(PasienAddRequest $request, PasienService $service)
    {

        $data = $request->validated();

        request()->request = $request;

        $service->create($data);

        Toast::info("Pasien Berhasil Ditambahkan");

        return to_route('platform.pasiens');
    }
}
