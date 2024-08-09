<?php

namespace Database\Factories;
use Faker\Factory as FakerFactory;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
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
                'ar' =>  $faker->title,
            ],
            'content' => [
                'en' =>  fake()->text(100),
                'ar' =>  $faker->realText(100),
            ],
            'cover_image' => fake()->imageUrl()
        ];
    }
}
