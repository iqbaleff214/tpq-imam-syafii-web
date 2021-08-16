<?php

namespace Database\Factories;

use App\Models\Pengumuman;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PengumumanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pengumuman::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $judul = $this->faker->sentence();
        $slug = Str::slug($judul);
        return [
            'judul' => $judul,
            'slug' => $slug,
            'konten' => $this->faker->text(5000),
            'admin_id' => 2,
        ];
    }
}
