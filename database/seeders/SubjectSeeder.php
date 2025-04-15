<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            'Mathematics',
            'English',
            'Science',
            'History',
            'Geography',
            'Physics',
            'Chemistry',
            'Biology'
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject
            ]);
        }
    }
}
