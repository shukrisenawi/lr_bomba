<?php

namespace Database\Seeders;

use App\Models\Respondent;
use App\Models\User;
use Illuminate\Database\Seeder;

class RespondentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure user with ID 1 exists
        $user = User::find(1);

        if (!$user) {
            $this->command->info('User with ID 1 not found. Creating a new user...');
            $user = User::factory()->create(['id' => 1]);
        }

        // Create respondent for user_id=1
        Respondent::updateOrCreate(
            ['user_id' => 1], // Unique constraint
            [
                'phone_number' => '012-3456789',
                'age' => 35,
                'place_of_birth' => 'Kuala Lumpur',
                'gender' => 'Laki-laki',
                'ethnicity' => 'Melayu',
                'marital_status' => 'Berkahwin',
                'education_level' => 'Ijazah',
                'monthly_income_self' => 5500,
                'monthly_income_spouse' => 3000,
                'other_income' => 500,
                'current_position' => 'Pegawai Tadbir',
                'grade' => 'Gred 41',
                'location' => 'Putrajaya',
                'position' => 'Pegawai',
                'state' => 'Selangor',
                'years_of_service' => 8,
                'service_status' => 'Tetap',
                'consent_given' => true,
            ]
        );

        $this->command->info('Respondent seed for user_id=1 completed successfully!');
    }
}
