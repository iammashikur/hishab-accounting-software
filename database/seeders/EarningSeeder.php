<?php

namespace Database\Seeders;

use App\Models\Earning;
use Illuminate\Database\Seeder;

class EarningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Earning::factory()
            ->count(5)
            ->create();
    }
}
