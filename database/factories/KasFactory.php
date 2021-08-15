<?php

namespace Database\Factories;

use App\Models\Kas;
use Illuminate\Database\Eloquent\Factories\Factory;

class KasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uraian' => $this->faker->sentence(3),
            $this->faker->boolean(60) ? 'pemasukan' : 'pengeluaran' => $this->faker->randomNumber(7),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
