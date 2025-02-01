<?php
// database/factories/CaasStageFactory.php
namespace Database\Factories;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CaasStage>
 */
class CaasStageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['LOLOS', 'GAGAL']),
            'user_id' => User::factory(),
            'stage_id' => Stage::factory(),
        ];
    }
}
