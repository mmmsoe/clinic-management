<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClinicDay;
use App\Models\OperationHour;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OperationHour>
 */
class OperationHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->time($format = 'H:i:s', $max = 'now');
        $endTime = date('H:i:s', strtotime($startTime) + 3600); // Adds one hour
        return [
            'clinic_day_id' => ClinicDay::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_booked' => $this->faker->boolean($chanceOfGettingTrue = 50),
        ];
    }
}
