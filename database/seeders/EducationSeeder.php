<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educations = [
            [
                'degree' => 'Bachelor of Science in Computer Science',
                'institution' => 'University of Technology',
                'start_year' => 2015,
                'end_year' => 2019,
                'description' => 'Studied computer science with focus on web development, database design, and software engineering. Completed various projects using modern technologies.',
                'display_order' => 1,
            ],
            [
                'degree' => 'Web Development Bootcamp',
                'institution' => 'Code Academy Online',
                'start_year' => 2019,
                'end_year' => 2019,
                'description' => 'Intensive bootcamp covering full-stack web development with focus on JavaScript, React, Node.js, and practical project experience.',
                'display_order' => 2,
            ],
            [
                'degree' => 'Advanced Laravel & API Development',
                'institution' => 'Tech Training Center',
                'start_year' => 2021,
                'end_year' => 2021,
                'description' => 'Advanced course covering Laravel framework, RESTful API design, database optimization, and best practices for modern web applications.',
                'display_order' => 3,
            ],
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }
    }
}
