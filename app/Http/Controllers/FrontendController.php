<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Portofolio;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Testimonial;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    /**
     * Tampilkan halaman portfolio utama
     */
    public function index()
    {
        // Get all active data from database
        $skills = Skill::active()->ordered()->get();
        
        // Group skills by category
        $skillCategories = $skills->groupBy('category');
        
        $portfolios = Portofolio::active()->ordered()->get();
        
        // Get unique portfolio categories
        $portfolioCategories = Portofolio::active()
            ->select('category')
            ->distinct()
            ->pluck('category');
        
        $experiences = Experience::active()->ordered()->get();
        
        $educations = Education::active()->ordered()->get();
        
        $testimonials = Testimonial::active()->ordered()->get();
        
        // Separate critic and personal testimonials
        $criticReviews = Testimonial::active()->critic()->ordered()->get();
        $personalReviews = Testimonial::active()->personal()->ordered()->get();
        
        $socialLinks = SocialLink::active()->ordered()->get();
        
        // Profile data (opsional, jika ada tabel profiles)
        // $profile = Profile::first();
        
        
        return view('frontend.home', compact(
            'skills',
            'skillCategories',
            'portfolios',
            'portfolioCategories',
            'experiences',
            'educations',
            'testimonials',
            'criticReviews',
            'personalReviews',
            'socialLinks'
            // 'profile'
        ));
    }
    
    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|max:200',
            'message' => 'required'
        ]);
        
        // Simpan ke database (opsional, jika ada tabel contact_submissions)
        /*
        ContactSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip()
        ]);
        */
        
        // Atau kirim email
        // Mail::to('admin@example.com')->send(new ContactMail($validated));
        
        return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}