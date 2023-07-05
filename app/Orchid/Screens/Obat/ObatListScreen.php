<?php

namespace App\Orchid\Screens\Obat;

use App\Http\Requests\Obat\ObatDeleteRequest;
use App\Models\Obat;
use App\Orchid\Layouts\Obat\ObatListLayout;
use App\services\ObatService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class ObatListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'obats' => Obat::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.obat.list'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Daftar Obat';
    }

    public function description(): ?string
    {
        return "Berisikan daftar obat yang ada di apotek";
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
                ->route('platform.obats.add')
                ->hidden(permission('platform.obat.add'))
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
            ObatListLayout::class
        ];
    }

    function remove(ObatDeleteRequest $request, ObatService $service)
    {
        $data = $request->validated();
        $service->delete($data['obat']);
        Toast::info("Hapus Data Berhasil");
    }
}
