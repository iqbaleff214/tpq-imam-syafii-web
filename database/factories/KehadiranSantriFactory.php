<?php

namespace Database\Factories;

use App\Models\KehadiranSantri;
use Carbon\Carbon;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Translations\Indonesian;
use Illuminate\Database\Eloquent\Factories\Factory;

class KehadiranSantriFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KehadiranSantri::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Hijri::setDefaultAdjustment(-1);
        Date::setTranslation(new Indonesian());
        $status = ['Hadir', 'Sakit', 'Izin', 'Absen'];
        $date = $this->faker->dateTimeBetween('-2 years', 'now');
        $hijri = Hijri::convertToHijri($date)->format('F o');
        return [
            'nilai_adab' => $this->faker->numberBetween(60, 99),
            'keterangan' => $status[$this->faker->numberBetween(0, 3)],
            'created_at' => $date,
            'bulan' => $hijri,
            'santri_id' => 2
        ];
    }
}
