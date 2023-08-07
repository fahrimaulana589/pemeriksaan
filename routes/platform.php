<?php

declare(strict_types=1);

use App\Orchid\Layouts\Pemeriksaan\PemeriksaanJadwalLa;
use App\Orchid\Screens\Dokter\DokterAddScreen;
use App\Orchid\Screens\Dokter\DokterEditScreen;
use App\Orchid\Screens\Dokter\DokterListScreen;
use App\Orchid\Screens\Jadwal\JadwalAddScreen;
use App\Orchid\Screens\Jadwal\JadwalEditScreen;
use App\Orchid\Screens\Jadwal\JadwalListScreen;
use App\Orchid\Screens\Obat\ObatAddScreen;
use App\Orchid\Screens\Obat\ObatEditScreen;
use App\Orchid\Screens\Obat\ObatListScreen;
use App\Orchid\Screens\Pasien\PasienAddScreen;
use App\Orchid\Screens\Pasien\PasienEditScreen;
use App\Orchid\Screens\Pasien\PasienListScreen;
use App\Orchid\Screens\PelaporanPemeriksaanPerbulanScreen;
use App\Orchid\Screens\PelaporanPemeriksaanPertahunScreen;
use App\Orchid\Screens\PelaporanPemeriksaanScreen;
use App\Orchid\Screens\Pemeriksaan\PemeriksaanAddScreen;
use App\Orchid\Screens\Pemeriksaan\PemeriksaanEditScreen;
use App\Orchid\Screens\Pemeriksaan\PemeriksaanJadwalScreen;
use App\Orchid\Screens\Pemeriksaan\PemeriksaanListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Racikan\RacikanAddScreen;
use App\Orchid\Screens\Racikan\RacikanEditScreen;
use App\Orchid\Screens\Racikan\RacikanListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > RoleSeeder
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Platform > Pasien
Route::screen('pasiens', PasienListScreen::class)
    ->name('platform.pasiens')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Daftar Pasien'), route('platform.pasiens')));

// Platform > Pasien
Route::screen('pasiens/pemeriksaan/{pasien}', PemeriksaanListScreen::class)
    ->name('platform.pasiens.pemeriksaan')
    ->breadcrumbs(fn (Trail $trail,$pasien) => $trail
        ->parent('platform.index')
        ->push(__('Daftar Pasien'), route('platform.pasiens.pemeriksaan',$pasien)));

// Platform > Pasien > Tambah
Route::screen('pasiens/add', PasienAddScreen::class)
    ->name('platform.pasiens.add')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.pasiens')
        ->push(__('Tambah Pasien'), route('platform.pasiens.add')));

// Platform > Pasien > Edit
Route::screen('pasiens/{pasien}/edit', PasienEditScreen::class)
    ->name('platform.pasiens.edit')
    ->breadcrumbs(fn (Trail $trail,$pasien) => $trail
        ->parent('platform.pasiens')
        ->push(__('Edit Pasien'), route('platform.pasiens.edit',$pasien)))
    ->whereNumber('pasien');

// Platform > Dokter
Route::screen('dokters', DokterListScreen::class)
    ->name('platform.dokters')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Daftar Dokter'), route('platform.dokters')));

// Platform > Pasien > Tambah
Route::screen('dokters/add', DokterAddScreen::class)
    ->name('platform.dokters.add')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.dokters')
        ->push(__('Tambah Dokter'), route('platform.dokters.add')));

// Platform > Pasien > Edit
Route::screen('dokters/{dokter}/edit', DokterEditScreen::class)
    ->name('platform.dokters.edit')
    ->breadcrumbs(fn (Trail $trail,$dokter) => $trail
        ->parent('platform.dokters')
        ->push(__('Edit Dokter'), route('platform.dokters.edit',$dokter)))
    ->whereNumber('dokter');

// Platform > Obat
Route::screen('obats', ObatListScreen::class)
    ->name('platform.obats')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Daftar Obat'), route('platform.obats')));

// Platform > Obat > Tambah
Route::screen('obats/add', ObatAddScreen::class)
    ->name('platform.obats.add')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.obats')
        ->push(__('Tambah Obat'), route('platform.obats.add')));

// Platform > Obat > Edit
Route::screen('obats/{obat}/edit', ObatEditScreen::class)
    ->name('platform.obats.edit')
    ->breadcrumbs(fn (Trail $trail,$obat) => $trail
        ->parent('platform.obats')
        ->push(__('Edit Obat'), route('platform.obats.edit',$obat)))
    ->whereNumber('obat');

// Platform > Jadwal
Route::screen('jadwals', JadwalListScreen::class)
    ->name('platform.jadwals')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Daftar Jadwal'), route('platform.jadwals')));

// Platform > Jadwal > Tambah
Route::screen('jadwals/add', JadwalAddScreen::class)
    ->name('platform.jadwals.add')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.jadwals')
        ->push(__('Tambah Jadwal'), route('platform.jadwals.add')));

// Platform > Jadwal > Edit
Route::screen('jadwals/{jadwal}/edit', JadwalEditScreen::class)
    ->name('platform.jadwals.edit')
    ->breadcrumbs(fn (Trail $trail,$jadwal) => $trail
        ->parent('platform.jadwals')
        ->push(__('Edit Jadwal'), route('platform.jadwals.edit',$jadwal)))
    ->whereNumber('jadwal');

// Platform > Pemeriksaan
Route::screen('pemeriksaans', PemeriksaanListScreen::class)
    ->name('platform.pemeriksaans')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Daftar Pemeriksaan'), route('platform.pemeriksaans')));

// Platform > Jadwal Pemeriksaan
Route::screen('pemeriksaans/jadwal', PemeriksaanJadwalScreen::class)
    ->name('platform.pemeriksaans.jadwal')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Daftar Pemeriksaan'), route('platform.pemeriksaans.jadwal')));

// Platform > Pemeriksaan > Tambah
Route::screen('pemeriksaans/add', PemeriksaanAddScreen::class)
    ->name('platform.pemeriksaans.add')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.pemeriksaans')
        ->push(__('Tambah Pemeriksaan'), route('platform.pemeriksaans.add')));

// Platform > Pemeriksaan > Edit
Route::screen('pemeriksaans/{pemeriksaan}/edit', PemeriksaanEditScreen::class)
    ->name('platform.pemeriksaans.edit')
    ->breadcrumbs(fn (Trail $trail,$pemeriksaan) => $trail
        ->parent('platform.pemeriksaans')
        ->push(__('Edit Pemeriksaan'), route('platform.pemeriksaans.edit',$pemeriksaan)))
    ->whereNumber('pemeriksaan');

// Platform > Racikan
Route::screen('pemeriksaans/{pemeriksaan}/racikans', RacikanListScreen::class)
    ->name('platform.racikans')
    ->breadcrumbs(fn (Trail $trail,$pemeriksaan) => $trail
        ->parent('platform.index')
        ->push(__('Daftar Racikan'), route('platform.racikans',$pemeriksaan)))
    ->whereNumber('pemeriksaan');

// Platform > Pemeriksaan > Tambah
Route::screen('pemeriksaans/{pemeriksaan}/racikans/add', RacikanAddScreen::class)
    ->name('platform.racikans.add')
    ->breadcrumbs(fn (Trail $trail,$pemeriksaan) => $trail
        ->parent('platform.racikans',$pemeriksaan)
        ->push(__('Tambah Racikan'), route('platform.racikans.add',$pemeriksaan)));

// Platform > Pemeriksaan > Edit
Route::screen('pemeriksaans/{pemeriksaan}/racikans/{racikan}/edit', RacikanEditScreen::class)
    ->name('platform.racikans.edit')
    ->breadcrumbs(fn (Trail $trail,$pemeriksaan,$racikan) => $trail
        ->parent('platform.racikans',$pemeriksaan)
        ->push(__('Edit Racikan'), route('platform.racikans.edit',[$pemeriksaan,$racikan])));

// Platform > Racikan
Route::screen('pelaporan/pemeriksaan/perhari', PelaporanPemeriksaanScreen::class)
    ->name('platform.pelaporan.pemeriksaan')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Laporan'), route('platform.pelaporan.pemeriksaan')));

// Platform > Racikan
Route::screen('pelaporan/pemeriksaan/perbulan', PelaporanPemeriksaanPerbulanScreen::class)
    ->name('platform.pelaporan.pemeriksaan.perbulan')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Laporan'), route('platform.pelaporan.pemeriksaan.perbulan')));

// Platform > Racikan
Route::screen('pelaporan/pemeriksaan/pertahun', PelaporanPemeriksaanPertahunScreen::class)
    ->name('platform.pelaporan.pemeriksaan.pertahun')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Laporan'), route('platform.pelaporan.pemeriksaan.perbulan')));
