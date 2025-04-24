<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormSubmission;
use App\Models\User;

class FormSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 'user')->get();
        
        if ($users->count() > 0) {
            // Create sample submissions with different statuses
            $statusOptions = ['pending', 'accepted', 'rejected'];
            
            foreach ($users as $index => $user) {
                $status = $statusOptions[$index % 3]; // Cycle through statuses
                
                FormSubmission::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'address' => fake()->address(),
                    'aadhar_number' => '123456789012', // Dummy Aadhar number
                    'annual_income' => fake()->numberBetween(50000, 300000),
                    'message' => 'I am applying for the rural housing scheme to improve my living conditions.',
                    'status' => $status,
                ]);
            }
            
            $this->command->info('Sample form submissions created successfully.');
        } else {
            $this->command->error('No users found. Please run the UserSeeder first.');
        }
    }
}
