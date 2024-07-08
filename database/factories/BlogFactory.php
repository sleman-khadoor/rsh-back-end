<?php

namespace Database\Factories;

use App\Enums\LanguageEnum;
use Faker\Factory as FakerFactory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
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
            'title' => fake()->text(30),
            'content' => fake()->text(1000),
            'date' => fake()->date(),
            'writer' => fake()->text(10),
            'lang' => $this->faker->randomElement([LanguageEnum::AR->value, LanguageEnum::EN->value]),
            'cover_image' => fake()->imageUrl(),
        ];
    }
}
