<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ContactRepository 
{
    public function getAllContacts()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $companyId = Session::get('company_id');

        if (!$companyId) {
            return response()->json(['message' => 'No company ID found in session.'], 422);
        }
        
        $company = Company::with(['user', 'customers', 'companyUsers.user'])->find($companyId);

        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        // Fetch Users
        $owner = $company->user;
        $companyUsers = $company->companyUsers->map(function ($companyUser) {
            return $companyUser->user;
        });

        if ($owner) {
            $companyUsers->prepend($owner);
        }

        // Fetch Customers
        $companyCustomers = $company->customers->map(function ($customer) {
            return $customer;
        })->unique('cust_id');

        // Combine Users and Customers
        $allContacts = $companyUsers->concat($companyCustomers);

        return $allContacts;
    }
}
