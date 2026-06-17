<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
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
        $name = fake()->unique()->words(3, true);
        $descriptions = [
            'Современный товар для повседневного использования.',
            'Практичная модель с удобными функциями и приятным дизайном.',
            'Надёжный вариант для дома, работы и ежедневных задач.',
            'Компактное решение с хорошим соотношением цены и качества.',
            'Удобный товар, который подходит для регулярного использования.',
        ];

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'description' => fake()->randomElement($descriptions),
            'price' => fake()->randomFloat(2, 10, 1000),
            'image' => null,
            'stock_quantity' => fake()->numberBetween(0, 100),
            'is_available' => fake()->boolean(80),
        ];
    }
}
