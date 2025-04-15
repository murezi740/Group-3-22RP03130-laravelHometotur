<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\SubjectAssignment;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            'Mathematics' => [
                [
                    'title' => 'Introduction to Algebra',
                    'body' => 'Algebra is a branch of mathematics dealing with symbols and the rules for manipulating those symbols. In elementary algebra, those symbols (today written as Latin and Greek letters) represent quantities without fixed values, known as variables.'
                ],
                [
                    'title' => 'Basic Geometry Concepts',
                    'body' => 'Geometry is a branch of mathematics that studies the sizes, shapes, positions angles and dimensions of things. Flat shapes like squares, circles, and triangles are a part of flat geometry and are called 2D shapes.'
                ]
            ],
            'Physics' => [
                [
                    'title' => 'Newton\'s Laws of Motion',
                    'body' => 'Newton\'s laws of motion are three basic laws of classical mechanics that describe the relationship between the motion of an object and the forces acting on it.'
                ],
                [
                    'title' => 'Introduction to Energy',
                    'body' => 'Energy is the capacity for doing work. It may exist in potential, kinetic, thermal, electrical, chemical, nuclear, or other various forms.'
                ]
            ],
            'English' => [
                [
                    'title' => 'Basic Grammar Rules',
                    'body' => 'Grammar is the system and structure of a language. The rules of grammar help us decide the order we put words in and which form of a word to use.'
                ],
                [
                    'title' => 'Essay Writing Tips',
                    'body' => 'An essay is a focused piece of writing that develops an argument or narrative based on evidence, analysis, and interpretation.'
                ]
            ]
        ];

        foreach ($contents as $subjectName => $subjectContents) {
            $assignment = SubjectAssignment::whereHas('subject', function($query) use ($subjectName) {
                $query->where('name', $subjectName);
            })->first();

            if ($assignment) {
                foreach ($subjectContents as $content) {
                    Content::create([
                        'title' => $content['title'],
                        'body' => $content['body'],
                        'subject_id' => $assignment->subject_id,
                        'tutor_id' => $assignment->tutor_id
                    ]);
                }
            }
        }
    }
}
