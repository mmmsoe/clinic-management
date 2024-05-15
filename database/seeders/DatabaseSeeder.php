<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clinic;
use App\Models\ClinicDay;
use App\Models\OperationHour;
use App\Models\Vacation;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        Clinic::factory()
            ->count(10)
            ->has(
                ClinicDay::factory()
                    ->count(5)
                    ->state(function (array $attributes, Clinic $clinic) {
                        $faker = Faker::create(); // Instantiate Faker
                        return ['day' => $faker->randomElement(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])];
                    })
                    ->has(OperationHour::factory()->count(8))
            )
            ->has(Vacation::factory()->count(3))
            ->create();
    }
}
