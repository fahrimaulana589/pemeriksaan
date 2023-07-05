<?php

namespace App\Orchid\Screens\Dokter;

use App\Http\Requests\Dokter\DokterAddRequest;
use App\Http\Requests\Pasien\PasienAddRequest;
use App\Orchid\Layouts\Dokter\DokterAddLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\services\DokterService;
use App\services\PasienService;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DokterAddScreen extends Screen
{
    /**
     * @var User
     */
    public $user;

    public function permission(): ?iterable
    {
        return [
            'platform.dokter.add'
        ];
    }


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

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tambah Dokter';
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
                ->route('platform.dokters')
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
            Layout::block(DokterAddLayout::class)
                ->title(__('Dokter'))
                ->description(__('Silakan masukan data dokter dengan benar'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('save')
                ),
        ];
    }

    function save(DokterAddRequest $request, DokterService $service)
    {

        $data = $request->validated();

        request()->request = $request;

        $service->create($data);

        Toast::info("Dokter Berhasil Ditambahkan");

        return to_route('platform.dokters');

    }
}
