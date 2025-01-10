<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hobby;

class HobbySeeder extends Seeder
{
    public function run(): void
    {
        $hobbies = [
            'Reading',
            'Gaming',
            'Cooking',
            'Photography',
            'Traveling',
            'Music',
            'Sports',
            'Writing',
            'Drawing',
            'Dancing'
        ];

        foreach ($hobbies as $hobby) {
            Hobby::create(['name' => $hobby]);
        }
    }
}