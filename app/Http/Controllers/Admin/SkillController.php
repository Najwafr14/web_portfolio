<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class SkillController extends Controller
{
    /**
     * Display a listing of skills (included in dashboard)
     */
    public function index()
    {
        $skills = Skill::active()->ordered()->get();
        return response()->json($skills);
    }
    
    /**
     * Store a newly created skill
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'category' => 'required|max:50',
            'percentage' => 'required|integer|min:0|max:100',
            'icon' => 'nullable|max:50',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer'
        ]);
        
        // Handle image upload (opsional)
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
                'skills',
                800,  // max width
                85    // quality
            );
            
            $validated['image'] = $uploadResult['compressed'];
        }
        
        Skill::create($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Skill added successfully!');
    }
    
    /**
     * Display the specified skill
     */
    public function show($id)
    {
        $skill = Skill::findOrFail($id);
        return response()->json($skill);
    }
    
    /**
     * Update the specified skill
     */
    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|max:100',
            'category' => 'required|max:50',
            'percentage' => 'required|integer|min:0|max:100',
            'icon' => 'nullable|max:50',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer'
        ]);
        
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
            if ($skill->image) {
                ImageHelper::deleteImage($skill->image, 'skills');
            }
            
            // Upload & compress new image
            $uploadResult = ImageHelper::uploadAndCompress(
                $request->file('image'),
                'skills',
                800,
                85
            );
            
            $validated['image'] = $uploadResult['compressed'];
        }
        
        $skill->update($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Skill updated successfully!');
    }
    
    /**
     * Soft delete the specified skill
     */
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        
        // Set deleted_by before soft delete
        $skill->deleted_by = Auth::id();
        $skill->save();
        
        // Soft delete
        $skill->delete();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Skill deleted successfully!');
    }
    
    /**
     * Restore soft deleted skill
     */
    public function restore($id)
    {
        $skill = Skill::withTrashed()->findOrFail($id);
        
        $skill->deleted_by = null;
        $skill->restore();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Skill restored successfully!');
    }
}