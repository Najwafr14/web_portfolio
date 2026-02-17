<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experiences = [
            [
                'position' => 'Senior Web Developer',
                'company' => 'Tech Innovations Inc',
                'start_date' => '2022-01-15',
                'end_date' => null,
                'description' => 'Leading a team of developers to build scalable web applications using Laravel and React. Responsible for architecture decisions and code quality.',
                'is_current' => true,
                'display_order' => 1,
            ],
            [
                'position' => 'Full Stack Developer',
                'company' => 'Digital Solutions Ltd',
                'start_date' => '2020-06-01',
                'end_date' => '2021-12-31',
                'description' => 'Developed and maintained multiple web applications using PHP, Laravel, JavaScript and MySQL. Implemented responsive designs and optimized database queries.',
                'is_current' => false,
                'display_order' => 2,
            ],
            [
                'position' => 'Junior Web Developer',
                'company' => 'Creative Studios',
                'start_date' => '2019-03-15',
                'end_date' => '2020-05-30',
                'description' => 'Started career as junior developer, learning web development fundamentals and working on client projects. Contributed to frontend development using HTML, CSS and JavaScript.',
                'is_current' => false,
                'display_order' => 3,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::create($experience);
        }
    }
}
