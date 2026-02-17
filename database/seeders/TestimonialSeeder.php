<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            // Critic Reviews
            [
                'name' => 'Sarah Chen',
                'position' => 'Project Manager',
                'company' => 'Tech Media Weekly',
                'rating' => 5,
                'review_text' => 'Outstanding work on the web platform. The developer demonstrated exceptional problem-solving skills and attention to detail.',
                'is_critic' => true,
                'critic_name' => 'Tech Media Weekly',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'James Wilson',
                'position' => 'Editor',
                'company' => 'Digital Review Journal',
                'rating' => 5,
                'review_text' => 'Impressive technical implementation with clean, maintainable code. Highly recommend for complex web projects.',
                'is_critic' => true,
                'critic_name' => 'Digital Review Journal',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Michelle Davis',
                'position' => 'Lead Critic',
                'company' => 'Web Development Today',
                'rating' => 4,
                'review_text' => 'Excellent frontend design and responsive implementation. Great collaboration throughout the project lifecycle.',
                'is_critic' => true,
                'critic_name' => 'Web Development Today',
                'display_order' => 3,
                'is_active' => true,
            ],
            
            // Personal Reviews
            [
                'name' => 'Emily Rodriguez',
                'position' => 'CEO',
                'company' => 'StartUp Innovations',
                'rating' => 5,
                'review_text' => 'Transformed our entire web presence. Professional, reliable, and delivered beyond expectations. Highly recommended!',
                'is_critic' => false,
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'David Kumar',
                'position' => 'Marketing Director',
                'company' => 'Global Brands Co',
                'rating' => 5,
                'review_text' => 'The developer is a true professional. Excellent communication, on-time delivery, and quality work. Will definitely hire again.',
                'is_critic' => false,
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Lisa Thompson',
                'position' => 'Product Owner',
                'company' => 'Future Tech Solutions',
                'rating' => 5,
                'review_text' => 'Outstanding technical expertise combined with great communication skills. A pleasure to work with!',
                'is_critic' => false,
                'display_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Michael Park',
                'position' => 'Business Analyst',
                'company' => 'Strategic Growth Partners',
                'rating' => 4,
                'review_text' => 'Delivered a robust solution that met all our requirements. Great problem solver and very responsive to feedback.',
                'is_critic' => false,
                'display_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
