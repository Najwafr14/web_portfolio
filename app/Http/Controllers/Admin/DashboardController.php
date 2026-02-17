<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Portofolio;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Testimonial;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard CMS dengan semua data untuk tabs
     */
    public function index()
    {
        // Get all data for tabs
        $skills = Skill::active()->ordered()->get();
        $portfolios = Portofolio::active()->ordered()->get();
        $experiences = Experience::active()->ordered()->get();
        $educations = Education::active()->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $socialLinks = SocialLink::active()->ordered()->get();
        
        // Get statistics (opsional)
        $stats = [
            'skills_count' => Skill::active()->count(),
            'portfolios_count' => Portofolio::active()->count(),
            'experiences_count' => Experience::active()->count(),
            'educations_count' => Education::active()->count(),
            'testimonials_count' => Testimonial::active()->count(),
            'social_links_count' => SocialLink::active()->count(),
        ];
        
        return view('admin.dashboard', compact(
            'skills',
            'portfolios',
            'experiences',
            'educations',
            'testimonials',
            'socialLinks',
            'stats'
        ));
    }
}