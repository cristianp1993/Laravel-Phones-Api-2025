<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class PhoneFactory extends Factory
{
    public function definition(): array
    {
        // número único de 10 dígitos 
        $number = $this->faker->unique()->numerify('3#########');

        // toma un id de categoría existente; si no hay, crea una
        $categoryId = Category::query()->inRandomOrder()->value('id')
            ?? Category::factory()->create()->id;

        return [
            'number'       => $number,
            'country_code' => '+57',
            'area_code'    => '4',
            'type'         => $this->faker->randomElement(['mobile','home','work','other']),
            'is_primary'   => $this->faker->boolean(20),
            'extension'    => $this->faker->optional(0.3)->numerify('####'),
            'notes'        => $this->faker->optional()->sentence(),

            // nuevos del paso 7 del exmann
            'category_id'  => $categoryId,
            'barcode'      => strtoupper($this->faker->bothify('??#####??##')),
        ];
    }
}
