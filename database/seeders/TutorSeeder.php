<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\SubjectAssignment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutors = [
            [
                'name' => 'John Smith',
                'username' => 'john.smith',
                'subjects' => ['Mathematics', 'Physics']
            ],
            [
                'name' => 'Sarah Johnson',
                'username' => 'sarah.johnson',
                'subjects' => ['English', 'History']
            ],
            [
                'name' => 'Michael Brown',
                'username' => 'michael.brown',
                'subjects' => ['Chemistry', 'Biology']
            ]
        ];

        $admin = User::where('role', 'admin')->first();

        foreach ($tutors as $tutorData) {
            $tutor = User::create([
                'name' => $tutorData['name'],
                'username' => $tutorData['username'],
                'password' => Hash::make('password123'),
                'role' => 'tutor'
            ]);

            // Assign subjects to tutor
            foreach ($tutorData['subjects'] as $subjectName) {
                $subject = Subject::where('name', $subjectName)->first();
                if ($subject) {
                    SubjectAssignment::create([
                        'tutor_id' => $tutor->id,
                        'subject_id' => $subject->id,
                        'assigned_by' => $admin->id
                    ]);
                }
            }
        }
    }
}
