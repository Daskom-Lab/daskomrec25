<?php
// database/factories/ShiftFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    public function definition(): array
    {
        return [
            'shift_no' => fake()->numberBetween(1, 10),
            'date' => fake()->date(),
            'time_start' => fake()->time(),
            'time_end' => fake()->time(),
            'kuota' => fake()->numberBetween(1, 50),
        ];
    }
}

