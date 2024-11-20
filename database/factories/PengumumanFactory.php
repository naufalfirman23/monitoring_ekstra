<?php

namespace Database\Factories;

use App\Models\Pengumuman;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengumumanFactory extends Factory
{
    protected $model = Pengumuman::class;

    public function definition()
    {
        return [
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'tanggal' => $this->faker->date,
            'status' => $this->faker->randomElement(['aktif', 'non-aktif']),
            'gambar' => 'storage/pengumuman/default.jpg', // Gambar default untuk factory
        ];
    }
}
