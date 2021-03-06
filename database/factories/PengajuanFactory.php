<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengajuanFactory extends Factory
{
    private static $no_surat = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_pengajuan' => $this->faker->text(rand(20, 50)),
            'user_id' => 1,
            'no_surat' => '552/' . self::$no_surat++ . '/123.4/' . Carbon::now()->format('Y'),
            'perihal' => $this->faker->text(rand(30, 200)),
            'skala_usaha' => $this->faker->randomElement(['kecil', 'menengah']),
            'status' => 'not submitted'
        ];
    }
}
