<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Jobsite;
use Illuminate\Support\Facades\Auth;
use App\Models\Lead;
use App\Models\JobsiteTransaction;

class JobsiteController extends Controller
{
    public function getJobsites(Request $request)
    {
        try {
            $userCredential = $request->user();
            $user = $userCredential->user;
            $user = $user->load('ownedCompany.leads.proposals.jobsite', 'partOfCompany.company.jobsites');

            // Get jobsite IDs for owned company
            $ownedCompanyJobsiteIds = optional($user->ownedCompany)->leads->flatMap(function ($lead) {
                return $lead->proposals->flatMap(function ($proposal) {
                    return optional($proposal->jobsite)->pluck('jobsite_id');
                })->filter();
            })->unique()->values();
            
        
            // Ensure $user->partOfCompany is loaded and is a collection
            $partOfCompaniesJobsiteIds = optional($user->partOfCompany)->flatMap(function ($companyUser) {
                // Check if company and jobsites are loaded and are not null
                return optional($companyUser->company)->jobsites->pluck('jobsite_id');
            })->filter()->unique()->values() ?? collect();

            // Merge both ID collections and remove duplicates
            $allJobsiteIds = $ownedCompanyJobsiteIds->concat($partOfCompaniesJobsiteIds)->unique();
            
            // Define the base query
            $query = Jobsite::whereIn('jobsite_id', $allJobsiteIds);
                    // Apply search conditionally
            $search = $request->input('search');
            if ($search) {
                $query->where(function($query) use ($search) {
                    $query->where('jobsite_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('street', 'LIKE', '%' . $search . '%');
                });
            }


            $jobsite_id = $request->input('jobsite_id');
            if($jobsite_id){
                $query->where(function($query) use ($jobsite_id) {
                    $query->where('jobsite_id', $jobsite_id);
                });
            }

            // Execute query with pagination default 20, others can just be search
            $perPage = 20;
            $paginatedJobsites = $query->paginate($perPage);

            // Return the items
            return response()->json([
                'status' => 'success',
                'data' => $paginatedJobsites
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Proposal not found.']);
        }
    }
    
    public function saveJobsite(Request $request){
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'cust_id' => 'required|integer|exists:customers,cust_id',
                'jobsite_name' => 'required|string|unique:jobsites,jobsite_name',
                'street' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zipcode' => 'required',
                'proposal_line_items' => 'required|boolean',
                'proposal_legal_content' => 'required|boolean',
                'proposal_payment' => 'required|boolean',
                'apply_estimate_line' => 'required|boolean',
                'proposal_id' => 'required',
            ]);

            $fieldsToConvert = [
                'proposal_line_items',
                'proposal_legal_content',
                'proposal_payment',
                'apply_estimate_line',
            ];

            foreach ($fieldsToConvert as $field) {
                $validatedData[$field] = $validatedData[$field] ? 1 : 0;
            }
            $user = Auth::user(); 
            $company_id = null;
            $user_data = $user->user;
            if ($user_data->ownedCompany) {
                $company_id = $user_data->ownedCompany->company_id;
            }
            else if ($user_data->partOfCompany && $user_data->partOfCompany->isNotEmpty()) {
                $company_id = $user_data->partOfCompany->first()->company->company_id;
            }

            $jobsite = Jobsite::create($validatedData);
            
            if ($jobsite) {
                return response()->json(['status' => 'success', 'data' => ['id' => $jobsite->jobsite_id]]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to convert lead to jobsite.']);
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function addTransactions(Request $request)
    {
        try {
            $validatedData = $request->validate([
                '*.transaction_id' => 'required|string', 
                '*.jobsite_id' => 'required|integer|exists:jobsite,jobsite_id', 
                '*.amount' => 'required|numeric',
                '*.date_paid' => 'required',
                '*.transaction_description' => 'required|string',
                
            ]);
            $user = Auth::user(); 

            foreach ($validatedData as $transactionData) {
                JobsiteTransaction::create([
                    'plaid_transaction_id' => $transactionData['transaction_id'],
                    'jobsite_id' => $transactionData['jobsite_id'],
                    'amount' => $transactionData['amount'],
                    'date_paid' => $transactionData['date_paid'],
                    'transaction_description' => $transactionData['transaction_description'],
                    'status' => ($transactionData['amount'] < 0) ? 'void' : 'paid',
                    'attached_type' => count($validatedData) == 1 ? 'Full' : 'Split',
                    'recorded_by' => $user->user_id
                ]);
            }

            // Return a successful response (typically for an API call)
            return response()->json(['status' => 'success', 'data' => ['message' => 'transaction has been to jobsit.']]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function getJobsiteTransactions(Request $request)
    {
        try {
            $userCredential = $request->user();
            $user = $userCredential->user;
            $user = $user->load(
                'ownedCompany.jobsites.transactions.recordedBy', 
                'partOfCompany.company.jobsites.transactions.recordedBy',
            );
        
            // Get jobsite transaction IDs for owned company
            $ownedCompanyJobsiteTransactionIds = ($user->ownedCompany) ? $user->ownedCompany->jobsites->flatMap(function ($jobsite) {
                return $jobsite->transactions->pluck('jobsite_transaction_id');
            }) : collect();
        
            // Get jobsite transaction IDs for companies user is a part of
            $partOfCompaniesJobsiteTransactionIds = $user->partOfCompany->flatMap(function ($companyUser) {
                return $companyUser->company->jobsites->flatMap(function ($jobsite) {
                    return $jobsite->transactions->pluck('jobsite_transaction_id');
                });
            });
        
            // Merge both ID collections and remove duplicates
            $allIds = $ownedCompanyJobsiteTransactionIds->concat($partOfCompaniesJobsiteTransactionIds)->unique();
            
            // Define the base query
            $query = JobsiteTransaction::whereIn('jobsite_transaction_id', $allIds)->with([
                'recordedBy',
                'jobSite'
            ]);;

            // Execute query with pagination default 20, others can just be search
            $perPage = $request->input('limit', 10);
            $perPage = intval($perPage);
            $paginatedList = $query->paginate($perPage);

            // Return the items
            return response()->json([
                'status' => 'success',
                'data' => $paginatedList
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Jobsite Transaction not found.']);
        }
    }
}