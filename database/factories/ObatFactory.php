<?php

namespace Database\Factories;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class ObatFactory extends Factory
{
    protected $model = Obat::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'images' => UploadedFile::fake()->image('default.jpg')->store('files'),
            'deskripsi' => "dsssss shs shssgsshsss",
            'stok' => 12,
            'harga' => 12,
        ];
    }
}
