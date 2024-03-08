<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source' => $this->faker->text(),
            'description' => $this->faker->sentence(15),
            'amount' => $this->faker->randomNumber(1),
        ];
    }
}
