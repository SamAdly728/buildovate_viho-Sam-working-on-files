<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerController extends Controller{
    
    public function getAllCustomer(Request $request){
        $userCredential = $request->user();
        $user = $userCredential->user;

        $user = $user->load(
            'ownedCompany.customers.customer', 
            'partOfCompany.company.customers.customer'
        );

        // Fetch customers of owned company
        $ownedCompanyCustomers = $user->ownedCompany 
                                ? $user->ownedCompany->customers->map(function ($customer) {
                                    return $customer;
                                }) 
                                : collect();

        // Fetch customers of companies user is part of
        $partOfCompaniesCustomers = $user->partOfCompany->flatMap(function ($companyUser) {
            return $companyUser->company->customers->map(function ($customer) {
                return $customer;
            });
        });

        // Merge the customers from both sets
        $allCustomers = $ownedCompanyCustomers->concat($partOfCompaniesCustomers)->unique('cust_id');

        return response()->json(['data' => $allCustomers]);
    }


    public function create(Request $request)
    {
        try{
            // Validate the request data
            $validatedData = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'display_name' => 'required|string',
                'street_address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip_code' => 'required',
                // 'phone' => 'required|digits:10',
                'phones.*' => ['required', 'string'],
                'phones' => 'array',
                'cell_phone' => 'nullable|digits:10',
                'email' => 'nullable|email'
            ]);
        
            // Create the customer using the validated data
            $company_id = null;

            $user = Auth::user();
            $user_data = $user->user;
            if ($user_data->ownedCompany) {
                $company_id = $user_data->ownedCompany->company_id;
            }
            else if ($user_data->partOfCompany && $user_data->partOfCompany->isNotEmpty()) {
                $company_id = $user_data->partOfCompany->first()->company->company_id;
            }
            
            $validatedData['company_id'] = $company_id;

            if ($request->has('phones')) {
                $validatedData['phone'] = implode(', ', $request->phones);
            }
            if ($request->has('emails')) {
                $validatedData['email'] = implode(', ', $request->emails);
            }

            $customer = Customer::create($validatedData);
        
            if ($customer) {
                return response()->json(['status' => 'success', 'data' => ['id' => $customer->cust_id]]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to create customer.']);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }

    }
   
    public function update(Request $request, $id){
        try{
            // Fetch the customer using the provided ID
            $customer = Customer::findOrFail($id);
            
            // Validate the request data
            $validatedData = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'display_name' => 'required|string',
                'street_address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip_code' => 'required',
                // 'phone' => 'required|digits:10',
                'phones.*' => ['required', 'string'],
                'phones' => 'array',
                'cell_phone' => 'nullable|digits:10',
                'email' => 'nullable|email',
                'company' => 'nullable',
            ]);
            
            if ($request->has('phones')) {
                $validatedData['phone'] = implode(', ', $request->phones);
            }
            if ($request->has('emails')) {
                $validatedData['email'] = implode(', ', $request->emails);
            }

            // Update the customer using the validated data
            $customer->update($validatedData);
            
            return response()->json(['status' => 'success', 'data' => ['id' => $customer->cust_id, 'message' => 'Customer updated successfully.']]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Customer not found.']);
        }
    }


}
