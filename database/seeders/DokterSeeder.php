<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::dokters()->get();

        $users_ids = $users->map(function ($user){
            return $user->id;
        })->flatten();

        foreach (range(1,13) as $item) {
            Dokter::factory(1)->create([
                'user_id' => $users_ids[$item-1]
            ]);
        }

        $dokters = Dokter::all();

        $dokters->each(function ($dokter) {
            $data = [
                'dokter_id' => $dokter->id,
            ];

            $this->dayRand('senin', $data);
            $this->dayRand('selasa', $data);
            $this->dayRand('rabu', $data);
            $this->dayRand('kamis', $data);
            $this->dayRand('jumat', $data);
            $this->dayRand('sabtu', $data);
            $this->dayRand('minggu', $data);

            Jadwal::factory()->create($data);
        });
    }

    private function dayRand($day, &$data)
    {
        $data[$day] = fake()->randomElement(['on', 'off']);

        if ($data[$day] == 'on') {
            $data['start_' . $day] = '08:00';
            $data['end_' . $day] = '17:00';
        } else {
            $data['start_' . $day] = '00:00';
            $data['end_' . $day] = '00:00';
        }
    }
}
