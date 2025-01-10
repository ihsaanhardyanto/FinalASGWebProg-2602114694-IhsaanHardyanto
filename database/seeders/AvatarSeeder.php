<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avatar;

class AvatarSeeder extends Seeder
{
    public function run(): void
    {
        $avatars = [
            ['path' => 'avatars/avatar1.jpg', 'price' => 50],
            ['path' => 'avatars/avatar2.jpg', 'price' => 100],
            ['path' => 'avatars/avatar3.jpg', 'price' => 150],
            ['path' => 'avatars/premium1.jpg', 'price' => 500],
            ['path' => 'avatars/premium2.jpg', 'price' => 1000],
        ];

        foreach ($avatars as $avatar) {
            Avatar::create([
                'image_path' => $avatar['path'],
                'price' => $avatar['price']
            ]);
        }
    }
}