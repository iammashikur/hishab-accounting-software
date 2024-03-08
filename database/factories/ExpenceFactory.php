<?php

namespace Database\Factories;

use App\Models\Expence;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expence::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'ঘর ভাড়া',
            'description' => $this->faker->sentence(15),
            'amount' => $this->faker->randomNumber(1),
        ];
    }
}
