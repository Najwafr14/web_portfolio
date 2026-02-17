<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials
     */
    public function index()
    {
        $testimonials = Testimonial::active()->ordered()->get();
        return response()->json($testimonials);
    }
    
    /**
     * Store a newly created testimonial
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'position' => 'nullable|max:100',
            'company' => 'nullable|max:100',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required',
            'is_critic' => 'nullable|boolean',
            'critic_name' => 'nullable|max:100',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Validasi image
            $validation = ImageHelper::validateImage($request->file('avatar'), 5);
            
            if (!$validation['valid']) {
                return redirect()->back()
                    ->withErrors(['avatar' => $validation['error']])
                    ->withInput();
            }
            
            // Upload & compress
            $uploadResult = ImageHelper::uploadAndCompress(
                $request->file('avatar'),
                'person',
                500,   // max width
                85     // quality
            );
            
            $validated['avatar'] = $uploadResult['compressed'];
        }
        
        // Set boolean values
        $validated['is_critic'] = $request->has('is_critic');
        $validated['is_active'] = $request->has('is_active') ? true : true; // Default active
        
        // Jika is_critic = false, critic_name harus null
        if (!$validated['is_critic']) {
            $validated['critic_name'] = null;
        }
        
        Testimonial::create($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Testimonial added successfully!');
    }
    
    /**
     * Display the specified testimonial
     */
    public function show($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return response()->json($testimonial);
    }
    
    /**
     * Update the specified testimonial
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|max:100',
            'position' => 'nullable|max:100',
            'company' => 'nullable|max:100',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required',
            'is_critic' => 'nullable|boolean',
            'critic_name' => 'nullable|max:100',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Validasi image
            $validation = ImageHelper::validateImage($request->file('avatar'), 5);
            
            if (!$validation['valid']) {
                return redirect()->back()
                    ->withErrors(['avatar' => $validation['error']])
                    ->withInput();
            }
            
            // Delete old avatar
            if ($testimonial->avatar) {
                ImageHelper::deleteImage($testimonial->avatar, 'person');
            }
            
            // Upload & compress new image
            $uploadResult = ImageHelper::uploadAndCompress(
                $request->file('avatar'),
                'person',
                500,
                85
            );
            
            $validated['avatar'] = $uploadResult['compressed'];
        }
        
        $validated['is_critic'] = $request->has('is_critic');
        $validated['is_active'] = $request->has('is_active');
        
        if (!$validated['is_critic']) {
            $validated['critic_name'] = null;
        }
        
        $testimonial->update($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Testimonial updated successfully!');
    }
    
    /**
     * Soft delete the specified testimonial
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        $testimonial->deleted_by = Auth::id();
        $testimonial->save();
        $testimonial->delete();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Testimonial deleted successfully!');
    }
    
    /**
     * Restore soft deleted testimonial
     */
    public function restore($id)
    {
        $testimonial = Testimonial::withTrashed()->findOrFail($id);
        
        $testimonial->deleted_by = null;
        $testimonial->restore();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Testimonial restored successfully!');
    }
}