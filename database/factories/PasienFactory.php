<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class PasienFactory extends Factory
{
    protected $model = Pasien::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'user_id' => '2'.$this->faker->numerify('#######'),
            'icon' => UploadedFile::fake()->image('default.jpg')->store('files'),
            'gender' => $this->faker->randomElement(["pria","wanita"]),
            'harlah' => $this->faker->date,
            'desa' => "Karangmangu",
            'kecamatan' => "Tarub",
            'kabupaten_kota' => "Kabupaten Tegal",
        ];
    }
}
