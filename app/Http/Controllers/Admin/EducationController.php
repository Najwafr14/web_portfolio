<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    /**
     * Display a listing of educations
     */
    public function index()
    {
        $educations = Education::active()->ordered()->get();
        return response()->json($educations);
    }
    
    /**
     * Store a newly created education
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree' => 'required|max:150',
            'institution' => 'required|max:150',
            'start_year' => 'required|integer|min:1900|max:2100',
            'end_year' => 'nullable|integer|min:1900|max:2100|gte:start_year',
            'description' => 'nullable',
            'display_order' => 'nullable|integer'
        ]);
        
        Education::create($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Education added successfully!');
    }
    
    /**
     * Display the specified education
     */
    public function show($id)
    {
        $education = Education::findOrFail($id);
        return response()->json($education);
    }
    
    /**
     * Update the specified education
     */
    public function update(Request $request, $id)
    {
        $education = Education::findOrFail($id);
        
        $validated = $request->validate([
            'degree' => 'required|max:150',
            'institution' => 'required|max:150',
            'start_year' => 'required|integer|min:1900|max:2100',
            'end_year' => 'nullable|integer|min:1900|max:2100|gte:start_year',
            'description' => 'nullable',
            'display_order' => 'nullable|integer'
        ]);
        
        $education->update($validated);
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Education updated successfully!');
    }
    
    /**
     * Soft delete the specified education
     */
    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        
        $education->deleted_by = Auth::id();
        $education->save();
        $education->delete();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Education deleted successfully!');
    }
    
    /**
     * Restore soft deleted education
     */
    public function restore($id)
    {
        $education = Education::withTrashed()->findOrFail($id);
        
        $education->deleted_by = null;
        $education->restore();
        
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Education restored successfully!');
    }
}