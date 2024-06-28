<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;


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
        $faker = FakerFactory::create('ar_SA');

        return [
            'title' => [
                'en' =>  fake()->text(30),
                'ar' =>  $faker->realText(30),
            ],
            'abstract' => [
                'en' => fake()->text(1000),
                'ar' => $faker->realText(1000)
            ],
            'printing_year' => fake()->year(),
            'ISBN' => fake()->isbn10(),
            'EISBN' => fake()->isbn13(),
            'cover_image' => fake()->imageUrl(),
            'author_id' => fake()->numberBetween(1, 20)
        ];
    }
}
