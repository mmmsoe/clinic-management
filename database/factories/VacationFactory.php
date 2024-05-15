<?php

namespace Database\Factories;

use App\Models\Vacation;
use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacation>
 */
class VacationFactory extends Factory
{
    protected $model = Vacation::class;

    public function definition()
    {
        $fromDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $toDate = $this->faker->dateTimeBetween($fromDate, $fromDate->format('Y-m-d H:i:s') . ' +30 days');

        return [
            'clinic_id' => Clinic::factory(),
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'reason' => $this->faker->sentence(),
        ];
    }
}
