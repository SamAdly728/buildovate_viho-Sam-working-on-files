<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Source;
use App\Models\LeadSource;
use Illuminate\Support\Facades\Session;

class SourceController extends Controller{
        
    public function getAll(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $companyId = Session::get('company_id');
        
        if (!$companyId) {
            return response()->json(['message' => 'No company ID found in session.'], 422);
        }

        $sources = Source::where('company_id', $companyId)->get();
    
        return response()->json(['data' => $sources]);
    }

    public function add(Request $request)
    {
        try{
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            $request->validate([
                'source_name' => 'required|string|max:255|unique:source,source_name'
            ]);

            $user = Auth::user(); 
            $source = new Source;
            $source->source_name = $request->source_name;
            $source->user_id = $user->user_id;
            $source->company_id = Session::get('company_id');
            $source->save();

            return response()->json(['message' => 'Source created successfully', 'data' => $source->source_id], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function edit(Request $request, $id)
    {
        try{

            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            $request->validate([
                'source_name' => 'required|string|max:255|unique:source,source_name'
            ]);

            $user = Auth::user(); 
            $source = Source::find($id);

            if (!$source) {
                return response()->json(['message' => 'Lead Source not found'], 404);
            }

            $source->source_name = $request->source_name;
            $source->user_id = $user->user_id;
            $source->company_id = Session::get('company_id');
            $source->save();

            return response()->json(['message' => 'Lead Source updated successfully', 'data' => $source->source_id], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $source = Source::find($id);

        if (!$source) {
            return response()->json(['message' => 'Lead Source not found'], 404);
        }

        $source->delete();

        return response()->json(['message' => 'Lead Source deleted successfully'], 201);
    }
        
}