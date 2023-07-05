<?php

namespace Database\Factories;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class JadwalFactory extends Factory
{
    protected $model = Jadwal::class;

    public function definition(): array
    {
        return [
            'dokter_id' => $this->faker->randomNumber(),
            'senin' => 'off',
            'start_senin' => '00:00:00',
            'end_senin' => '00:00:00',
            'selasa' => 'off',
            'start_selasa' => '00:00:00',
            'end_selasa' => '00:00:00',
            'rabu' => 'off',
            'start_rabu' => '00:00:00',
            'end_rabu' => '00:00:00',
            'kamis' => 'off',
            'start_kamis' => '00:00:00',
            'end_kamis' => '00:00:00',
            'jumat' => 'off',
            'start_jumat' => '00:00:00',
            'end_jumat' => '00:00:00',
            'sabtu' => 'off',
            'start_sabtu' => '00:00:00',
            'end_sabtu' => '00:00:00',
            'minggu' => 'off',
            'start_minggu' => '00:00:00',
            'end_minggu' => '00:00:00',
        ];
    }
}
