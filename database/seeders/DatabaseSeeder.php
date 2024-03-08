<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        $this->call(EarningSeeder::class);
        $this->call(ExpenceSeeder::class);
        $this->call(LoanSeeder::class);
        $this->call(LoanPaymentSeeder::class);
        $this->call(UserSeeder::class);
    }
}
