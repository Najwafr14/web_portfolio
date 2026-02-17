<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Display a listing of experiences
     */
    public function index()
    {
        $experiences = Experience::active()->ordered()->get();
        return response()->json($experiences);
    }
    
    /**
     * Store a newly created experience
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|max:150',
            'company' => 'required|max:150',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'achievements' => 'nullable|array',
            'achievements.*' => 'nullable|string',
            'is_current' => 'nullable|boolean',
            'display_order' => 'nullable|integer'
        ]);
        
        // Handle achievements (convert array to JSON, filter empty values)
        if ($request->has('achievements') && is_array($request->achievements)) {
            $filtered = array_filter($request->achievements, function($value) {
                return !empty(trim($value ?? ''));
            });
            $validated['achievements'] = !empty($filtered) ? array_values($filtered) : null;
        } else {
            $validated['achievements'] = null;
        }
        
        // Set is_current properly
        $validated['is_current'] = $request->has('is_current') && $request->is_current == 1;
        
        // If is_current = true, end_date must be null
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }
        
        // Ensure display_order has a default value
        if (!isset($validated['display_order']) || $validated['display_order'] === null) {
            $validated['display_order'] = 0;
        }
        
        Experience::create($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Experience added successfully!');
    }
    
    /**
     * Display the specified experience
     */
    public function show($id)
    {
        $experience = Experience::findOrFail($id);
        return response()->json($experience);
    }
    
    /**
     * Update the specified experience
     */
    public function update(Request $request, $id)
    {
        $experience = Experience::findOrFail($id);
        
        $validated = $request->validate([
            'position' => 'required|max:150',
            'company' => 'required|max:150',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'achievements' => 'nullable|array',
            'achievements.*' => 'nullable|string',
            'is_current' => 'nullable|boolean',
            'display_order' => 'nullable|integer'
        ]);
        
        // Handle achievements
        if ($request->has('achievements') && is_array($request->achievements)) {
            $filtered = array_filter($request->achievements, function($value) {
                return !empty(trim($value ?? ''));
            });
            $validated['achievements'] = !empty($filtered) ? array_values($filtered) : null;
        } else {
            $validated['achievements'] = null;
        }
        
        // Set is_current properly
        $validated['is_current'] = $request->has('is_current') && $request->is_current == 1;
        
        // If is_current = true, end_date must be null
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }
        
        // Ensure display_order has a default value
        if (!isset($validated['display_order']) || $validated['display_order'] === null) {
            $validated['display_order'] = 0;
        }
        
        $experience->update($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Experience updated successfully!');
    }
    
    /**
     * Soft delete the specified experience
     */
    public function destroy($id)
    {
        $experience = Experience::findOrFail($id);
        
        $experience->deleted_by = Auth::id();
        $experience->save();
        $experience->delete();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Experience deleted successfully!');
    }
    
    /**
     * Restore soft deleted experience
     */
    public function restore($id)
    {
        $experience = Experience::withTrashed()->findOrFail($id);
        
        $experience->deleted_by = null;
        $experience->restore();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Experience restored successfully!');
    }
}