<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make(__('Dashboard'))
                ->icon('bs.list')
                ->route('platform.main')
                ->permission('platform.index'),

            Menu::make(__(''))
                ->title(__('Master'))
                ->permission(['platform.pasien.list','platform.dokter.list','platform.obat.list']),

            Menu::make(__('Pasien'))
                ->icon('bs.people')
                ->route('platform.pasiens')
                ->permission('platform.pasien.list'),

            Menu::make(__('Dokter'))
                ->icon('bs.people')
                ->route('platform.dokters')
                ->permission('platform.dokter.list'),

            Menu::make(__('Obat'))
                ->icon('bs.clipboard2-data')
                ->route('platform.obats')
                ->permission('platform.obat.list'),

            Menu::make(__(''))
                ->title(__('Pelayanan')),

            Menu::make(__('Jadwal dokter'))
                ->icon('bs.list-check')
                ->route('platform.jadwals')
                ->permission('platform.jadwal.list'),

            Menu::make(__('Pemeriksaan'))
                ->icon('bs.list-check')
                ->route('platform.pemeriksaans')
                ->permission('platform.pemeriksaan.list'),

            Menu::make(__(''))
                ->title(__('Access Controls'))
                ->permission(['platform.systems.users','platform.systems.roles']),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users'),

            Menu::make(__('Roles'))
                ->icon('bs.lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group(__('Pasien'))
                ->addPermission('platform.pasien.list', __('List'))
                ->addPermission('platform.pasien.add', __('Add'))
                ->addPermission('platform.pasien.edit', __('Edit'))
                ->addPermission('platform.pasien.delete', __('Delete')),
            ItemPermission::group(__('Dokter'))
                ->addPermission('platform.dokter.list', __('List'))
                ->addPermission('platform.dokter.add', __('Add'))
                ->addPermission('platform.dokter.edit', __('Edit'))
                ->addPermission('platform.dokter.delete', __('Delete')),
            ItemPermission::group(__('Jadwal'))
                ->addPermission('platform.jadwal.list', __('List'))
                ->addPermission('platform.jadwal.add', __('Add'))
                ->addPermission('platform.jadwal.edit', __('Edit'))
                ->addPermission('platform.jadwal.delete', __('Delete')),
            ItemPermission::group(__('Obat'))
                ->addPermission('platform.obat.list', __('List'))
                ->addPermission('platform.obat.add', __('Add'))
                ->addPermission('platform.obat.edit', __('Edit'))
                ->addPermission('platform.obat.delete', __('Delete')),
            ItemPermission::group(__('Pemeriksaan'))
                ->addPermission('platform.pemeriksaan.list', __('List'))
                ->addPermission('platform.pemeriksaan.add', __('Add'))
                ->addPermission('platform.pemeriksaan.edit', __('Edit'))
                ->addPermission('platform.pemeriksaan.delete', __('Delete')),
            ItemPermission::group(__('Racikan'))
                ->addPermission('platform.racikan.list', __('List'))
                ->addPermission('platform.racikan.add', __('Add'))
                ->addPermission('platform.racikan.edit', __('Edit'))
                ->addPermission('platform.racikan.delete', __('Delete')),
        ];
    }
}
