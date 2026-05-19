<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => env('ADMIN_NAME', 'مدير النظام'),
            'phone' => env('ADMIN_PHONE', '0900000000'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
            'is_admin' => true,
        ]);
    }
}
