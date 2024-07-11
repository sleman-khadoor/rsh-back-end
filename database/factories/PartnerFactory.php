<?php

namespace Database\Factories;
use Faker\Factory as FakerFactory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PartnerFactory extends Factory
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
            'name' => [
                'en' =>  fake()->text(10),
                'ar' =>  $faker->realText(10),
            ],
            'avatar' => fake()->imageUrl(),
            'website_link' => fake()->url(),
        ];
    }
}
