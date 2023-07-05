<?php

namespace Database\Factories;

use App\Models\Racikan;
use Illuminate\Database\Eloquent\Factories\Factory;

class RacikanFactory extends Factory
{
    protected $model = Racikan::class;

    public function definition(): array
    {
        return [
            'obat_id' => 1,
            'pemeriksaan_id' => 1,
            'jumlah' => 12
        ];
    }
}
