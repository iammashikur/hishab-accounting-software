<?php

namespace Database\Seeders;

use App\Models\LoanPayment;
use Illuminate\Database\Seeder;

class LoanPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LoanPayment::factory()
            ->count(5)
            ->create();
    }
}
