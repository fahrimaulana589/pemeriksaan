<?php

namespace App\Orchid\Screens\Pasien;

use App\Http\Requests\Pasien\PasienDeleteRequest;
use App\Models\Pasien;
use App\Orchid\Layouts\Pasien\PasienListLayout;
use App\Orchid\Layouts\Role\RoleListLayout;
use App\services\PasienService;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class PasienListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'pasiens' => Pasien::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.pasien.list'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Daftar Pasien';
    }

    public function description(): ?string
    {
        return "Berisikan daftar pasien yang ada di apotek";
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
                ->route('platform.pasiens.add')
                ->hidden(permission('platform.pasien.add'))

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
            PasienListLayout::class
        ];
    }

    function remove(PasienDeleteRequest $request, PasienService $service)
    {
        $data = $request->validated();
        $service->delete($data['pasien']);
        Toast::info("Hapus Data Berhasil");
    }
}
