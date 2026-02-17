<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Frontend
            ['name' => 'HTML5', 'category' => 'Frontend', 'percentage' => 95, 'display_order' => 1],
            ['name' => 'CSS3', 'category' => 'Frontend', 'percentage' => 90, 'display_order' => 2],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'percentage' => 85, 'display_order' => 3],
            ['name' => 'React', 'category' => 'Frontend', 'percentage' => 80, 'display_order' => 4],
            
            // Backend
            ['name' => 'PHP', 'category' => 'Backend', 'percentage' => 92, 'display_order' => 5],
            ['name' => 'Laravel', 'category' => 'Backend', 'percentage' => 90, 'display_order' => 6],
            ['name' => 'MySQL', 'category' => 'Backend', 'percentage' => 88, 'display_order' => 7],
            ['name' => 'RESTful API', 'category' => 'Backend', 'percentage' => 85, 'display_order' => 8],
            
            // Design
            ['name' => 'Figma', 'category' => 'Design', 'percentage' => 88, 'display_order' => 9],
            ['name' => 'UI/UX Design', 'category' => 'Design', 'percentage' => 85, 'display_order' => 10],
            ['name' => 'Adobe XD', 'category' => 'Design', 'percentage' => 82, 'display_order' => 11],
            ['name' => 'Prototyping', 'category' => 'Design', 'percentage' => 80, 'display_order' => 12],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
