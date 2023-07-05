<?php

namespace App\Orchid\Screens\Racikan;

use App\Http\Requests\Pemeriksaan\PemeriksaanAddRequest;
use App\Http\Requests\Racikan\RacikanAddRequest;
use App\Models\Pemeriksaan;
use App\Orchid\Layouts\Pemeriksaan\PemeriksaanAddlayout;
use App\Orchid\Layouts\Racikan\RacikanAddLayout;
use App\services\PemeriksaanService;
use App\services\RacikanService;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use PHPUnit\Exception;

class RacikanAddScreen extends Screen
{
    /**
     * @var User
     */
    public $pemeriksaan;
    public $racikan;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(User $user, Pemeriksaan $pemeriksaan): iterable
    {
        $user->load(['roles']);
        $this->pemeriksaan = $pemeriksaan;

        return [
            'user' => $user,
            'permission' => $user->getStatusPermission(),
            'pemeriksaan' => $pemeriksaan
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.racikan.add'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tambah Racikan';
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
                ->route('platform.racikans', $this->pemeriksaan->id)
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
            Layout::block(RacikanAddLayout::class)
                ->title(__('Racikan'))
                ->description(__('Silakan masukan data racikan dengan benar'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->method('save')
                ),
        ];
    }

    function save(RacikanAddRequest $request, RacikanService $service)
    {

        $data = $request->validated();

        $service->create($data);

        Toast::info("Racikan Berhasil Ditambahkan");

        return to_route('platform.racikans', $this->pemeriksaan->id);
    }
}
