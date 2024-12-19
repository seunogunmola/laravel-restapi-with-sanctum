<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id'=>Author::factory(),
            'title'=>fake()->title,
            'price'=>fake()->randomFloat(2,1000,20000),
            'isbn'=>fake()->isbn13(),
            'year'=>fake()->year()
        ];
    }
}
