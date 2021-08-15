<?php

namespace Database\Factories;

use App\Models\Donasi;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonasiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donasi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
        $date = $this->faker->dateTimeBetween('-2 years', '+7 days');
        $hijri = Hijri::convertToHijri($date)->format('F o');
        return [
            'nama' => $this->faker->name(),
            'no_telp' => $this->faker->phoneNumber(),
            'jumlah' => $this->faker->numberBetween(1000, 1000000),
            'created_at' => $date,
            'bulan' => $hijri,
        ];
    }
}
