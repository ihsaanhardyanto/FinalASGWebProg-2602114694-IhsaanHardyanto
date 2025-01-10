<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Hobby;
use App\Models\WorkField;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin/test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'gender' => 'male',
            'mobile_number' => '081234567890',
            'social_link' => 'https://instagram.com/testuser',
            'balance' => 1000,
            'is_visible' => true
        ]);

        // Get all available hobby and work field IDs
        $hobbyIds = Hobby::pluck('id')->toArray();
        $workFieldIds = WorkField::pluck('id')->toArray();

        // Attach random hobbies (3 hobbies)
        if (count($hobbyIds) >= 3) {
            $randomHobbies = array_rand(array_flip($hobbyIds), 3);
            $user->hobbies()->attach($randomHobbies);
        }

        // Attach random work fields (2 fields)
        if (count($workFieldIds) >= 2) {
            $randomWorkFields = array_rand(array_flip($workFieldIds), 2);
            $user->workFields()->attach($randomWorkFields);
        }

        // Create some regular users
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'gender' => $i % 2 == 0 ? 'male' : 'female',
                'mobile_number' => "08" . rand(100000000, 999999999),
                'social_link' => "https://instagram.com/user$i",
                'balance' => 100,
                'is_visible' => true
            ]);

            // Attach random hobbies (3 hobbies)
            if (count($hobbyIds) >= 3) {
                $randomHobbies = array_rand(array_flip($hobbyIds), 3);
                $user->hobbies()->attach($randomHobbies);
            }

            // Attach random work fields (3 fields)
            if (count($workFieldIds) >= 3) {
                $randomWorkFields = array_rand(array_flip($workFieldIds), 3);
                $user->workFields()->attach($randomWorkFields);
            }
        }
    }
}