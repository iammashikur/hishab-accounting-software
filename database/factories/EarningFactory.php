<?php

namespace Database\Factories;

use App\Models\Earning;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EarningFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Earning::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source' => 'বেতন',
            'description' => $this->faker->text(),
            'amount' => $this->faker->randomNumber(1),
        ];
    }
}
