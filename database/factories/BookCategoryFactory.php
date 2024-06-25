<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Faker\Provider\ar_SA\Text;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookCategory>
 */
class BookCategoryFactory extends Factory
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
                'en' =>  fake()->text(10),
                'ar' =>  $faker->realText(10),
            ]
        ];
    }
}
