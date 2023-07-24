<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin' => [
                'platform.index' => 1,
                'platform.systems' => 1,
                'platform.systems.index' => 1,
                'platform.systems.roles' => 1,
                'platform.systems.settings' => 1,
                'platform.systems.users' => 1,
                'platform.systems.comment' => 1,
                'platform.systems.attachment' => 1,
                'platform.systems.media' => 1,
                'platform.pasien.list' => 1,
                'platform.pasien.add' => 1,
                'platform.pasien.edit' => 1,
                'platform.pasien.delete' => 1,
                'platform.dokter.list' => 1,
                'platform.dokter.add' => 1,
                'platform.dokter.edit' => 1,
                'platform.dokter.delete' => 1,
                'platform.jadwal.list' => 1,
                'platform.jadwal.add' => 1,
                'platform.jadwal.edit' => 1,
                'platform.jadwal.delete' => 1,
                'platform.obat.list' => 1,
                'platform.obat.add' => 1,
                'platform.obat.edit' => 1,
                'platform.obat.delete' => 1,
                'platform.pemeriksaan.list'  => 1,
                'platform.pemeriksaan.add' => 1,
                'platform.pemeriksaan.edit' => 1,
                'platform.pemeriksaan.delete' => 1,
                'platform.racikan.list' => 1,
                'platform.racikan.add' => 1,
                'platform.racikan.edit' => 1,
                'platform.racikan.delete' => 1,
            ],
            'dokter' => [
                'platform.index' => 1,
                'platform.systems' => 1,
                'platform.systems.index' => 1,
                'platform.systems.roles' => 0,
                'platform.systems.settings' => 1,
                'platform.systems.users' => 0,
                'platform.systems.comment' => 1,
                'platform.systems.attachment' => 1,
                'platform.systems.media' => 1,
                'platform.pasien.list' => 0,
                'platform.pasien.add' => 0,
                'platform.pasien.edit' => 0,
                'platform.pasien.delete' => 0,
                'platform.dokter.list' => 0,
                'platform.dokter.add' => 0,
                'platform.dokter.edit' => 0,
                'platform.dokter.delete' => 0,
                'platform.jadwal.list' => 1,
                'platform.jadwal.add' => 0,
                'platform.jadwal.edit' => 1,
                'platform.jadwal.delete' => 0,
                'platform.obat.list' => 0,
                'platform.obat.add' => 0,
                'platform.obat.edit' => 0,
                'platform.obat.delete' => 0,
                'platform.pemeriksaan.list'  => 1,
                'platform.pemeriksaan.add' => 0,
                'platform.pemeriksaan.edit' => 1,
                'platform.pemeriksaan.delete' => 0,
                'platform.racikan.list' => 1,
                'platform.racikan.add' => 1,
                'platform.racikan.edit' => 1,
                'platform.racikan.delete' => 1,

            ],
            'pasien' => [
                'platform.index' => 1,
                'platform.systems' => 1,
                'platform.systems.index' => 1,
                'platform.systems.roles' => 0,
                'platform.systems.settings' => 1,
                'platform.systems.users' => 0,
                'platform.systems.comment' => 1,
                'platform.systems.attachment' => 1,
                'platform.systems.media' => 1,
                'platform.pasien.list' => 0,
                'platform.pasien.add' => 0,
                'platform.pasien.edit' => 0,
                'platform.pasien.delete' => 0,
                'platform.dokter.list' => 0,
                'platform.dokter.add' => 0,
                'platform.dokter.edit' => 0,
                'platform.dokter.delete' => 0,
                'platform.jadwal.list' => 1,
                'platform.jadwal.add' => 0,
                'platform.jadwal.edit' => 0,
                'platform.jadwal.delete' => 0,
                'platform.obat.list' => 0,
                'platform.obat.add' => 0,
                'platform.obat.edit' => 0,
                'platform.obat.delete' => 0,
                'platform.pemeriksaan.list' => 1,
                'platform.pemeriksaan.add' => 1,
                'platform.pemeriksaan.edit' => 0,
                'platform.pemeriksaan.delete' => 0,
                'platform.racikan.list' => 0,
                'platform.racikan.add' => 0,
                'platform.racikan.edit' => 0,
                'platform.racikan.delete' => 0,
            ],
        ];

        $roleAdmin = Role::first()->id;
        $roleDokter = Role::all()->get(1)->id;
        $rolePasien = Role::all()->last()->id;

        $admin = [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
            'permissions' => $roles['admin'],
        ];

        $dokter = [
            'name' => 'dokter',
            'email' => 'dokter@dokter.com',
            'password' => Hash::make('dokter'),
            'remember_token' => Str::random(10),
            'permissions' => $roles['dokter'],
        ];

        $pasien = [
            'name' => 'pasien',
            'email' => 'pasien@pasien.com',
            'password' => Hash::make('pasien'),
            'remember_token' => Str::random(10),
            'permissions' => $roles['pasien'],
        ];

        $dokters = User::create($dokter);
        $dokters->replaceRoles([$roleDokter]);

        $pasien = User::create($pasien);
        $pasien->replaceRoles([$rolePasien]);

        foreach (range(1,12) as $data){
            $dokter = [
                'name' => 'dokter',
                'email' => fake()->name.'@dokter.com',
                'password' => Hash::make('dokter'),
                'remember_token' => Str::random(10),
                'permissions' => $roles['dokter'],
            ];

            $dokter = User::create($dokter);
            $dokter->replaceRoles([$roleDokter]);
        }

        $admin = User::create($admin);
        $admin->replaceRoles([$roleAdmin]);

    }
}
