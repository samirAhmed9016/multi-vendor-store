<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(5, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(10),
            'image' => $this->faker->imageUrl(300, 300),
            'price' => $this->faker->randomFloat(1, 1, 499),

            'compare_price' => $this->faker->randomFloat(1, 500, 999),
            'featured' => rand(0, 1),

            'category_id' => $this->faker->numberBetween(1, 20),
            'store_id' => $this->faker->numberBetween(1, 5),

        ];
    }
}
