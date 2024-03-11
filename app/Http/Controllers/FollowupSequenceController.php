<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FollowupSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FollowupSequenceController extends Controller
{
    private function getValidationRules()
    {
        return [
            'deal_stage_id' => 'required',
            'sequence_name' => 'required|string',
            'sort_order' => 'required',
            'changes_by' => 'required|exists:users,user_id',
        ];
    }
    private function authUserId()
    {
        return Auth::user()->user_id;
    }

    public function index(){
        try {
            
            $sequences = FollowupSequence::with('sequences.drips')->get();

            return response()->json(['message' => 'Record retrieved successfully', 'data' => $sequences], 201);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id){
        try {
            
            $sequences = FollowupSequence::findOrFail($id);

            return response()->json(['message' => 'Record retrieved successfully', 'data' => $sequences], 201);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        try {
            $request->merge(['changes_by' => $this->authUserId()]);

            $validator = Validator::make($request->all(), $this->getValidationRules());

            if ($validator->fails()) {
                return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
            }

            FollowupSequence::create($request->all());
            
            return response()->json(['message' => 'Record retrieved successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request,$id){
        try {
            $request->merge(['changes_by' => $this->authUserId()]);

            $validator = Validator::make($request->all(), $this->getValidationRules());

            if ($validator->fails()) {
                return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
            }

            FollowupSequence::where('id',$id)->update($request->except('_method'));
            
            return response()->json(['message' => 'Record updated successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try {
            $sequences = FollowupSequence::findOrFail($id);
            $sequences->delete();
         
            return response()->json(['message' => 'Record deleted successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }
}
