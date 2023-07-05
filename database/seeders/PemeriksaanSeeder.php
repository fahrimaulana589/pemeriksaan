<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Racikan;
use App\services\PemeriksaanService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class PemeriksaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasiens = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $dokters = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $obats = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        $jumlahIterasi = 5; // Jumlah iterasi yang diinginkan

        for ($i = 0; $i < $jumlahIterasi; $i++) {

            $pemeriksaan = Pemeriksaan::factory()->create([
                'pasien_id' => fake()->randomElement($pasiens),
                'dokter_id' => fake()->randomElement($dokters),
            ])->first();

            $jumlahIterasi2 = 3;

            for ($b = 0; $b < $jumlahIterasi2; $b++) {
                Racikan::factory()->create([
                    'pemeriksaan_id' => $i+1,
                    'jumlah' => 1,
                    'obat_id' => fake()->randomElement($obats),
                ]);
            }
        }

    }
}
