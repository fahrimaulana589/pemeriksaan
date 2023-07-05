<?php

namespace Database\Factories;

use App\Models\Pemeriksaan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PemeriksaanFactory extends Factory
{
    protected $model = Pemeriksaan::class;

    public function definition(): array
    {
        return [
            'pasien_id' => 1,
            'dokter_id' => 1,
            'keluhan' => "mual",
            'hari' => Carbon::now()->subDays(rand(1,9))
        ];
    }
}
