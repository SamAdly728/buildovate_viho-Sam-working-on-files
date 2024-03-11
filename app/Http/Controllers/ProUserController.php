<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProUserController extends Controller
{

    public function getProUsers(Request $request) {
        try {
            
            $records = \App\Models\ProUser::where('status', 'active')->get();
            if($records) {
                return response()->json([
                    'status' => 'success',
                    'data' => $records,
                    'query' => $request->all() 
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new record in Pro User']);    
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function saveProUser(Request $request) {
        try {

            $user = Auth::user(); 
            // Validate the request data
            $validatedData = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'business_name' => 'required',
                'cell_phone' => 'required',
                'business_email' => 'required',
                'business_website' => 'required',
                'street' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zipcode' => 'required',
                'is_licensed' => 'required',
                'occupation'=> 'required',
            ]);

            $data = array(
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'business_name' => $request->business_name,
                'cell_phone' => $request->cell_phone,
                'business_email' => $request->business_email,
                'business_website' => $request->business_website,
                'street' => $request->street,
                'city' => $request->city,
                'state'=> $request->state,
                'zipcode' => $request->zipcode,
                'is_licensed' => $request->is_licensed,
                'license_number' => $request->license_number,
                'occupation' => $request->occupation,
                'user_id' => session()->get('user_id'),
                'added_by_id' => session()->get('user_id'),
            );
            $record = \App\Models\ProUser::updateOrCreate(['user_id' => session()->get('user_id')],$data);
            if($record) {
                return response()->json(['status' => 'success', 'data' => $record]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new record in Pro User']);    
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function search(Request $request) {
        
        $search_str = "";
        $specialty_search = "";
        try {            
            if(isset($request->specialties) and $request->specialties!="") {
                $specialty_search = " AND p.specialty_id IN ({$request->specialties})";
            }

            if(isset($request->search) and $request->search!="") {
                $q=$request->search;
                $search_str = " AND (u.firstname LIKE '%{$q}%' OR u.lastname LIKE '%{$q}%' OR u.business_name LIKE '%{$q}%' OR u.street LIKE '%{$q}%' OR u.city LIKE '%{$q}%' OR u.state LIKE '%{$q}%' OR u.zipcode LIKE '%{$q}%' )";
            }

            // $sql = "SELECT u.pro_id, u.firstname, u.lastname, u.business_name, u.street, u.city, u.state 
            // FROM pro_users u 
            // JOIN pro_user_specialties p ON p.pro_id = u.pro_id 
            // WHERE u.status='active'
            // {$search_str}
            // GROUP BY u.pro_id ORDER BY u.firstname, u.lastname;";

            $sql = "SELECT u.pro_id FROM pro_users u  JOIN pro_user_specialties p ON p.pro_id = u.pro_id  WHERE u.status='active' AND p.is_active=1 {$search_str} {$specialty_search} GROUP BY u.pro_id ORDER BY u.firstname, u.lastname;";
            $records = \DB::connection()->select($sql);

            $data = [];
            foreach($records as $record) {
                $data[] = $record->pro_id;
            }

            $records = \App\Models\ProUser::whereIn('pro_id', $data)->get();
            $data = [];
            foreach($records as $record) {
                $specialties = $record->selected_specialties;
                $my_specialties = [];
                foreach($specialties as $specialty) {
                    $my_specialties[] = $specialty->specialtyInfo->name;
                }
                
                $record['tags'] = $my_specialties;
                $data[] = $record;
            }
            if($records) {
                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                    'query' => $sql
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add new record in Pro User']);    
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    
}
