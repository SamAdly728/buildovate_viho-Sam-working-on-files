<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FollowupDealStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FollowupDealStageController extends Controller
{
    // // format 
    // public function index(){
    //     try {
    //         //logic
    //         return response()->json(['message' => 'Record created successfully', 'data' => $dealStage], 201);
    //     } catch (\Exception $e) {
            
    //         return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
    //     }
    // }
    private function getValidationRules()
    {
        return [
            'deal_stage' => 'required|string',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string',
            'changes_by' => 'required|exists:users,user_id',
        ];
    }
    private function authUserId()
    {
        return Auth::user()->user_id;
    }

    public function index(){
        try {
           
            $dealStage = FollowupDealStage::get();

            return response()->json(['message' => 'Record retrieved successfully', 'data' => $dealStage], 201);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function indexAll(){
        try {
           
            $dealStage = FollowupDealStage::with('sequences.drips')->get();

            return response()->json(['message' => 'Record retrieved successfully', 'data' => $dealStage], 201);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id){
        try {
            
            $dealStage = FollowupDealStage::findOrFail($id);

            return response()->json(['message' => 'Record retrieved successfully', 'data' => $dealStage], 201);
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

            FollowupDealStage::create($request->all());
            
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

            FollowupDealStage::where('id',$id)->update($request->except('_method'));
            
            return response()->json(['message' => 'Record updated successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try {
            $dealStage = FollowupDealStage::findOrFail($id);
            $dealStage->delete();
         
            return response()->json(['message' => 'Record deleted successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }
}
