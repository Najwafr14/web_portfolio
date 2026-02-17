<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of social links
     */
    public function index()
    {
        $socialLinks = SocialLink::active()->ordered()->get();
        return response()->json($socialLinks);
    }
    
    /**
     * Store a newly created social link
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|max:50',
            'url' => 'required|url|max:255',
            'icon' => 'required|max:50',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer'
        ]);
        
        $validated['is_active'] = $request->has('is_active') ? true : true;
        
        SocialLink::create($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Social link added successfully!');
    }
    
    /**
     * Display the specified social link
     */
    public function show($id)
    {
        $socialLink = SocialLink::findOrFail($id);
        return response()->json($socialLink);
    }
    
    /**
     * Update the specified social link
     */
    public function update(Request $request, $id)
    {
        $socialLink = SocialLink::findOrFail($id);
        
        $validated = $request->validate([
            'platform' => 'required|max:50',
            'url' => 'required|url|max:255',
            'icon' => 'required|max:50',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer'
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        $socialLink->update($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Social link updated successfully!');
    }
    
    /**
     * Soft delete the specified social link
     */
    public function destroy($id)
    {
        $socialLink = SocialLink::findOrFail($id);
        
        $socialLink->deleted_by = Auth::id();
        $socialLink->save();
        $socialLink->delete();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Social link deleted successfully!');
    }
    
    /**
     * Restore soft deleted social link
     */
    public function restore($id)
    {
        $socialLink = SocialLink::withTrashed()->findOrFail($id);
        
        $socialLink->deleted_by = null;
        $socialLink->restore();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Social link restored successfully!');
    }
}