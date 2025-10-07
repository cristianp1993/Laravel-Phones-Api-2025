<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => $this->faker->optional()->sentence(10),
            'estado'      => $this->faker->boolean(),      
            'position'    => $this->faker->numberBetween(0, 100),
        ];
    }
}
