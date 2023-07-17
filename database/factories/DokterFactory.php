<?php

namespace Database\Factories;

use App\Models\Dokter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class   DokterFactory extends Factory
{
    protected $model = Dokter::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numerify('#######'),
            'nama' => $this->faker->name(),
            'icon' => UploadedFile::fake()->image('default.jpg')->store('files'),
            'gender' => $this->faker->randomElement(["pria","wanita"]),
            'harlah' => $this->faker->date,
            'desa' => "Karangmangu",
            'kecamatan' => "Tarub",
            'kabupaten_kota' => "Kabupaten Tegal",
            'pendidikan' => "SMA",
            'keahlian' => 'dokter bedah'
        ];
    }
}
