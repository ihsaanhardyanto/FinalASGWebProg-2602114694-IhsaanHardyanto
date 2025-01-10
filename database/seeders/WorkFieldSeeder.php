<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkField;

class WorkFieldSeeder extends Seeder
{
    public function run(): void
    {
        $workFields = [
            'Information Technology',
            'Marketing',
            'Finance',
            'Human Resources',
            'Education',
            'Healthcare',
            'Engineering',
            'Design',
            'Sales',
            'Research'
        ];

        foreach ($workFields as $field) {
            WorkField::create(['name' => $field]);
        }
    }
}