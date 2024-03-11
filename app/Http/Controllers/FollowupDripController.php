<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FollowupDrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FollowupDripController extends Controller
{
    private function getValidationRules()
    {
        return [
            'sequence_id' => 'required',
            'drip_name' => 'required|string',
            'send_time' => 'required',
            'type' => 'required',
            'email_subject' => 'required_if:type,Email',
            'email_body' => 'required_if:type,Email',
            'sms_msg' => 'required_if:type,SMS Message',
            'active' => 'required',
            'changes_by' => 'required|exists:users,user_id',
        ];
    }
    private function authUserId()
    {
        return Auth::user()->user_id;
    }

    public function index(){
        try {
            
            $drips = FollowupDrip::get();

            return response()->json(['message' => 'Record retrieved successfully', 'data' => $drips], 201);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id){
        try {
            
            $drips = FollowupDrip::findOrFail($id);

            return response()->json(['message' => 'Record retrieved successfully', 'data' => $drips], 201);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        try {
            $request->merge(['changes_by' => $this->authUserId()]);

            foreach ($request->all() as $key => $value) {
                if ($key == 'active' && $value === 'true') {
                    $request->merge([$key => true]);
                }
            }

            $validator = Validator::make($request->all(), $this->getValidationRules());

            if ($validator->fails()) {
                return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
            }

            FollowupDrip::create($request->all());
            
            return response()->json(['message' => 'Record retrieved successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request,$id){
        try {
            $request->merge(['changes_by' => $this->authUserId()]);

            foreach ($request->all() as $key => $value) {
                if ($key == 'active' && $value === 'true') {
                    $request->merge([$key => true]);
                }
            }

            $validator = Validator::make($request->all(), $this->getValidationRules());

            if ($validator->fails()) {
                return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
            }

            //itereate $request then if active: "true"  set true

            FollowupDrip::where('id',$id)->update($request->except('_method'));
            
            return response()->json(['message' => 'Record updated successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            

            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try {
            $drips = FollowupDrip::findOrFail($id);
            $drips->delete();
         
            return response()->json(['message' => 'Record deleted successfully', 'data' => null], 200);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }
}
