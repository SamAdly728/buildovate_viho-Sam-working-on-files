<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\JobType;
use Illuminate\Support\Facades\Session;

class JobTypeController extends Controller{
    
    public function getAll(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $companyId = Session::get('company_id');
        
        if (!$companyId) {
            return response()->json(['message' => 'No company ID found in session.'], 422);
        }

        $jobTypes = JobType::where('company_id', $companyId)->get();
    
        return response()->json(['data' => $jobTypes]);
    }

    public function add(Request $request)
    {
        try{
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            $request->validate([
                'job_type_name' => 'required|string|max:255|unique:job_type,job_type_name'
            ]);

            $user = Auth::user(); 
            $jobType = new JobType;
            $jobType->job_type_name = $request->job_type_name;
            $jobType->user_id = $user->user_id;
            $jobType->company_id = Session::get('company_id');
            $jobType->save();

            return response()->json(['message' => 'Job Type created successfully', 'data' => $jobType->job_type_id], 201);
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
                'job_type_name' => 'required|string|max:255|unique:job_type,job_type_name'
            ]);

            $user = Auth::user(); 
            $jobType = JobType::find($id);

            if (!$jobType) {
                return response()->json(['message' => 'Job Type not found'], 404);
            }

            $jobType->job_type_name = $request->job_type_name;
            $jobType->user_id = $user->user_id;
            $jobType->company_id = Session::get('company_id');
            $jobType->save();

            return response()->json(['message' => 'Job Type updated successfully', 'data' => $jobType->job_type_id], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $jobType = JobType::find($id);

        if (!$jobType) {
            return response()->json(['message' => 'Job Type not found'], 404);
        }

        $jobType->delete();

        return response()->json(['message' => 'Job Type deleted successfully'], 201);
    }
        
}