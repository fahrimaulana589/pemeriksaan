<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Obat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PasienSeeder::class);
        $this->call(DokterSeeder::class);
        $this->call(ObatSeeder::class);
        $this->call(PemeriksaanSeeder::class);
    }
}
