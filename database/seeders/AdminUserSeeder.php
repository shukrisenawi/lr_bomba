<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bomba.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create regular user for testing
        User::create([
            'name' => 'Regular User',
            'email' => 'user@bomba.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        $this->command->info('Admin user created: admin@bomba.com / admin123');
        $this->command->info('Regular user created: user@bomba.com / user123');
    }
}
