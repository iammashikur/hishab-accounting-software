<?php

namespace Database\Factories;

use App\Models\LoanPayment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanPayment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomNumber(1),
            'loan_id' => \App\Models\Loan::factory(),
        ];
    }
}
