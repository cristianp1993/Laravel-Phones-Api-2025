<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // generamos un número “limpio” de 10 dígitos
        $ten = $this->faker->numerify('##########');

        return [
            'number'       => $ten,
            'country_code' => '57',
            'area_code'    => $this->faker->optional()->numerify('###'),
            'type'         => $this->faker->randomElement(['mobile','home','work','other']),
            'is_primary'   => $this->faker->boolean(20),
            'extension'    => $this->faker->optional(0.3)->numerify('####'),
            'notes'        => $this->faker->optional()->sentence(),
        ];
    }
}
