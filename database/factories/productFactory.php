<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(4),
            'imageUrl' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'quantityInStock' => $this->faker->numberBetween(0, 100),
            'categoryId' => Category::factory(),
        ];
    }
}
