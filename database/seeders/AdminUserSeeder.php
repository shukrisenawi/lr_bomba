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

        User::create([
            'name' => 'Admin Aftar',
            'email' => 'aftar27@gmail.com',
            'password' => Hash::make('bomba2025'),
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
        $this->command->info('Admin Aftar created: aftar27@gmail.com / bomba2025');
        $this->command->info('Regular user created: user@bomba.com / user123');
    }
}
