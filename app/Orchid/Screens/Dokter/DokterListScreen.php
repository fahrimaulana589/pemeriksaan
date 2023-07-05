<?php

namespace App\Orchid\Screens\Dokter;

use App\Http\Requests\Dokter\DokterDeleteRequest;
use App\Http\Requests\Pasien\PasienDeleteRequest;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\User;
use App\Orchid\Layouts\Dokter\DokterListLayout;
use App\Orchid\Layouts\Role\RoleListLayout;
use App\services\DokterService;
use App\services\PasienService;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class DokterListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'dokters' => Dokter::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.dokter.list'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Daftar Dokter';
    }

    public function description(): ?string
    {
        return "Berisikan daftar dokter yang ada di apotek";
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
                ->route('platform.dokters.add')
                ->hidden(permission('platform.dokter.add'))
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
            DokterListLayout::class
        ];
    }

    function remove(DokterDeleteRequest $request, DokterService $service)
    {
        $data = $request->validated();
        $service->delete($data['dokter']);
        Toast::info("Hapus Data Berhasil");
    }
}
