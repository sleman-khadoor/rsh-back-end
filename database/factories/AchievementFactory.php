<?php

namespace Database\Factories;
use Faker\Factory as FakerFactory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AchievementFactory extends Factory
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
            'content' => [
                'en' =>  fake()->text(200),
                'ar' =>  $faker->realText(200),
            ]
        ];
    }
}
