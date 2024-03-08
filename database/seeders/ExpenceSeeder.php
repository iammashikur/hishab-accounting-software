<?php

namespace Database\Seeders;

use App\Models\Expence;
use Illuminate\Database\Seeder;

class ExpenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expence::factory()
            ->count(5)
            ->create();
    }
}
