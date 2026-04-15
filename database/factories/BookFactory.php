<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
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
            'title' => fake()->sentence(rand(2, 5)),
            'author' => fake()->name(),
            'isbn' => fake()->unique()->isbn13(),
            'publication_year' => fake()->numberBetween(1950, (int) now()->year),
            'description' => fake()->optional(0.9)->paragraphs(2, true),
        ];
    }
}
