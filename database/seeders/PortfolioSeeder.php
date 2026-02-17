<?php

namespace Database\Seeders;

use App\Models\Portofolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolios = [
            [
                'title' => 'E-Commerce Platform',
                'category' => 'Development',
                'description' => 'A full-stack e-commerce platform built with Laravel and React featuring product management, shopping cart, and payment integration.',
                'image' => 'portfolio-1.jpg',
                'project_url' => 'https://example.com/ecommerce',
                'display_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Mobile App Design',
                'category' => 'UI/UX',
                'description' => 'User interface and experience design for a modern mobile application with focus on usability and aesthetics.',
                'image' => 'portfolio-2.jpg',
                'project_url' => 'https://example.com/mobile-app',
                'display_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Website Redesign',
                'category' => 'Design',
                'description' => 'Complete website redesign including new branding, layout, and responsive design for optimal user experience.',
                'image' => 'portfolio-3.jpg',
                'project_url' => 'https://example.com/website',
                'display_order' => 3,
                'is_featured' => false,
            ],
            [
                'title' => 'CMS Dashboard',
                'category' => 'Development',
                'description' => 'Custom content management system dashboard with advanced analytics, user management, and reporting features.',
                'image' => 'portfolio-4.jpg',
                'project_url' => 'https://example.com/cms',
                'display_order' => 4,
                'is_featured' => false,
            ],
            [
                'title' => 'Brand Identity',
                'category' => 'Design',
                'description' => 'Complete brand identity design including logo, color palette, typography, and brand guidelines.',
                'image' => 'portfolio-5.jpg',
                'project_url' => 'https://example.com/brand',
                'display_order' => 5,
                'is_featured' => false,
            ],
            [
                'title' => 'Real Estate Portal',
                'category' => 'Development',
                'description' => 'Real estate listing portal with advanced search, filters, property management, and agent dashboard.',
                'image' => 'portfolio-6.jpg',
                'project_url' => 'https://example.com/realestate',
                'display_order' => 6,
                'is_featured' => false,
            ],
        ];

        foreach ($portfolios as $portfolio) {
            Portofolio::create($portfolio);
        }
    }
}
