<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\LeadTag;
use Illuminate\Support\Facades\Session;

class TagController extends Controller{
    
    public function getAll(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $companyId = Session::get('company_id');
        
        if (!$companyId) {
            return response()->json(['message' => 'No company ID found in session.'], 422);
        }

        $tags = Tag::where('company_id', $companyId)->get();
    
        return response()->json(['data' => $tags]);
    }

    public function add(Request $request)
    {
        try{
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            $request->validate([
                'tags_name' => 'required|string|max:255|unique:tags,tags_name'
            ]);

            $user = Auth::user(); 
            $tag = new Tag;
            $tag->tags_name = $request->tags_name;
            $tag->user_id = $user->user_id;
            $tag->company_id = Session::get('company_id');
            $tag->save();

            return response()->json(['message' => 'Tag created successfully', 'data' => $tag->tags_id], 201);
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
                'tags_name' => 'required|string|max:255|unique:tags,tags_name'
            ]);

            $user = Auth::user(); 
            $tag = Tag::find($id);

            if (!$tag) {
                return response()->json(['message' => 'Tag not found'], 404);
            }

            $tag->tags_name = $request->tags_name;
            $tag->user_id = $user->user_id;
            $tag->company_id = Session::get('company_id');
            $tag->save();

            return response()->json(['message' => 'Tag updated successfully', 'data' => $tag->tags_id], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        $tag->delete();

        return response()->json(['message' => 'Tag deleted successfully'], 201);
    }



        
}