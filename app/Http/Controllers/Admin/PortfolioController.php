<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class PortfolioController extends Controller
{
    /**
     * Display a listing of portfolios
     */
    public function index()
    {
        $portfolios = Portofolio::active()->ordered()->get();
        return response()->json($portfolios);
    }
    
    /**
     * Store a newly created portfolio
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'category' => 'nullable|max:50',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_url' => 'nullable|url|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_featured' => 'nullable|boolean',
            'display_order' => 'nullable|integer'
        ]);
        
        // Handle tags (convert array to JSON)
        if ($request->has('tags')) {
            $validated['tags'] = $request->tags;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Validasi image
            $validation = ImageHelper::validateImage($request->file('image'), 5);
            
            if (!$validation['valid']) {
                return redirect()->back()
                    ->withErrors(['image' => $validation['error']])
                    ->withInput();
            }
            
            // Upload & compress
            $uploadResult = ImageHelper::uploadAndCompress(
                $request->file('image'),
                'portfolio',
                1200,  // max width
                85     // quality
            );
            
            $validated['image'] = $uploadResult['compressed'];
        }
        
        // Set default values
        $validated['is_featured'] = $request->has('is_featured');
        
        Portofolio::create($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Portfolio added successfully!');
    }
    
    /**
     * Display the specified portfolio
     */
    public function show($id)
    {
        $portfolio = Portofolio::findOrFail($id);
        return response()->json($portfolio);
    }
    
    /**
     * Update the specified portfolio
     */
    public function update(Request $request, $id)
    {
        $portfolio = Portofolio::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|max:200',
            'category' => 'nullable|max:50',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_url' => 'nullable|url|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_featured' => 'nullable|boolean',
            'display_order' => 'nullable|integer'
        ]);
        
        // Handle tags
        if ($request->has('tags')) {
            $validated['tags'] = $request->tags;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Validasi image
            $validation = ImageHelper::validateImage($request->file('image'), 5);
            
            if (!$validation['valid']) {
                return redirect()->back()
                    ->withErrors(['image' => $validation['error']])
                    ->withInput();
            }
            
            // Delete old image
            if ($portfolio->image) {
                ImageHelper::deleteImage($portfolio->image, 'portfolio');
            }
            
            // Upload & compress new image
            $uploadResult = ImageHelper::uploadAndCompress(
                $request->file('image'),
                'portfolio',
                1200,
                85
            );
            
            $validated['image'] = $uploadResult['compressed'];
        }
        
        $validated['is_featured'] = $request->has('is_featured');
        
        $portfolio->update($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Portfolio updated successfully!');
    }
    
    /**
     * Soft delete the specified portfolio
     */
    public function destroy($id)
    {
        $portfolio = Portofolio::findOrFail($id);
        
        $portfolio->deleted_by = Auth::id();
        $portfolio->save();
        $portfolio->delete();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Portfolio deleted successfully!');
    }
    
    /**
     * Restore soft deleted portfolio
     */
    public function restore($id)
    {
        $portfolio = Portofolio::withTrashed()->findOrFail($id);
        
        $portfolio->deleted_by = null;
        $portfolio->restore();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Portfolio restored successfully!');
    }
}