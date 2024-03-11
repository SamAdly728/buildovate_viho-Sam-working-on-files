<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Proposal;
use App\Models\ProposalBilling;
use App\Models\ProposalItem;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProposalRepository;
use Illuminate\Support\Facades\Session;

class ProposalController extends Controller
{
    protected $proposalRepository;
    
    public function __construct(ProposalRepository $proposalRepository)
    {
        $this->proposalRepository = $proposalRepository;
    }

    public function updateProposalData(Request $request, $id){
        $request->validate([
            'key' => 'required', 
            'value' => 'required', 
        ]);
        
        $key = $request->input('key', null);
        $value = $request->input('value', null);

        $result = $this->proposalRepository->updateProposal($key, $value, $id);

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }

    public function getAllByLead(Request $request, $lead_id){
        $result = $this->proposalRepository->getAllByLead($lead_id);

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }

    public function getAll(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }
        
        $companyId = Session::get('company_id');
        $status = $request->input('status', null);
        $perPage = intval($request->input('limit', 25));
        $lead_id = $request->input('lead_id', null);

        $paginatedList = $this->proposalRepository->getAll($companyId, $perPage, $status, $lead_id);

        return response()->json([
            'status' => 'success',
            'data' => $paginatedList
        ]);
    }

    public function getEmail(Request $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $proposalEmail = $this->proposalRepository->getEmail($id);

        if (!$proposalEmail) {
            return response()->json(['message' => 'Proposal Email not found.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $proposalEmail
        ]);
    }
    

    public function updateEmail(Request $request, $proposal_email_id){
        try{
            $validatedData = $request->validate([
                'notes' => 'nullable',
                'status' => 'nullable',
            ]);

            $proposalEmail = $this->proposalRepository->updateEmail($validatedData, $proposal_email_id);

            return response()->json(['message' => 'Proposal Email updated successfully', 'data' => $proposalEmail], 201);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function addEmail(Request $request, $proposal_id){
        try{
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            $validatedData = $request->validate([
                'proposal_id' => 'required',
                'receiver_emails' => 'nullable',
                'status' => 'nullable',
            ]);

            $user_id = Session::get('user_id');
            $proposalEmail = $this->proposalRepository->addEmail($validatedData, $proposal_id, $user_id);

            return response()->json(['message' => 'Propsao Email created successfully', 'data' => $proposalEmail], 201);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function getProposal($id){
        // if (!Auth::check()) {
        //     return response()->json(['message' => 'Not authenticated.'], 401);
        // }

        $item = $this->proposalRepository->get($id);

        if (!$item) {
            return response()->json(['message' => 'Proposal not found.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $item
        ]);
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $user_id = Session::get('user_id');
        $deleted = $this->proposalRepository->delete($id, $user_id);

        if (!$deleted) {
            return response()->json(['message' => 'Proposal not found'], 404);
        }

        return response()->json(['message' => 'Proposal deleted successfully'], 201);
    }


    //ALL FUNCTIONS BELOW NEEDS CHANGES TO REPOSITORY
    public function createProposal(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string|unique:proposals,title',
                'approval_deadline' => 'nullable',
                'status' => 'required|string',
                'discount' => 'nullable',
                'internal_notes' => 'nullable|string',
                'introductory_text' => 'nullable',
                'closing_text' => 'nullable',
                'updated_by' => 'nullable|integer',
                'lead_id' => 'required|integer|exists:leads,lead_id',
                'worksheet' => 'array',
                'payment_request' => 'nullable'
            ]);
            
            // Create the lead using the validated data
            $user = Auth::user(); 
            $proposal = Proposal::create($validatedData);

            if ($request->has('worksheet')) {
                $itemsData = $request->input('worksheet');

                if ($itemsData && is_array($itemsData)) {
                    foreach ($itemsData as $itemData) {
                        $itemData['proposal_id'] =  $proposal->proposal_id;
                        $itemData['created_by'] = $user->user_id;
                        // dd($itemData);
                        ProposalItem::create($itemData);
                    }
                }
            }

            if (isset($validatedData['payment_request'])) {
                $paymentRequest = $validatedData['payment_request'];
                $stagePayments = $paymentRequest['stage_payments'];

                if($paymentRequest['deposit_type'] != 'amount'){
                    $paymentRequest['deposit_type'] = $paymentRequest['percentage'] . '%';
                }else{
                    $paymentRequest['deposit_type'] = 'amount';
                }

                if($paymentRequest['payment_due'] != 'upon'){
                    $paymentRequest['payment_due'] = $paymentRequest['payment_due_day'] . ' days after';
                }else{
                    $paymentRequest['payment_due'] = 'upon';
                }
                unset($paymentRequest['percentage']);
                unset($paymentRequest['payment_due_day']);
                unset($paymentRequest['stage_payments']);

                $paymentRequest['updated_by'] = $user->user_id;
                $billing = null;
                if($paymentRequest['proposal_billing_id'] == 0){
                    $billing = $proposal->billing()->create($paymentRequest);
                }else{
                    $proposal->billing()->update($paymentRequest);
                    $billing = $proposal->billing;
                }

                if ($billing) {
                    $existingStages = $billing->stages_detail->pluck('proposal_billing_stage_id')->toArray();

                    foreach ($stagePayments as $index => $stagePaymentSet) {
                        foreach ($stagePaymentSet as $stagePayment) {
                            
                            if($stagePayment['proposal_billing_stage_id'] == 0){
                                $billing->stages_detail()->create([
                                    'proposal_billing_id' => $billing->proposal_billing_id, // Ensure the correct billing ID
                                    'stage_name' => $stagePayment['stage_name'],
                                    'stage_amount' => $stagePayment['stage_amount'],
                                    'stage_number' => ($index + 1)
                                ]);
                            }else{
                                $proposalBillingStageId = $stagePayment['proposal_billing_stage_id'];
                                $billing->stages_detail()->where('proposal_billing_stage_id', $proposalBillingStageId)->update([
                                    'proposal_billing_id' => $billing->proposal_billing_id, // Ensure the correct billing ID
                                    'stage_name' => $stagePayment['stage_name'],
                                    'stage_amount' => $stagePayment['stage_amount'],
                                    'stage_number' => ($index + 1)
                                ]);

                                $existingStages = array_diff($existingStages, [$proposalBillingStageId]);
                            }

                        }
                    }

                    // Set the date_archived to the current date for the remaining existing stages
                    $billing->stages_detail()->whereIn('proposal_billing_stage_id', $existingStages)->update([
                        'date_archived' => now(),
                    ]);
                }
            }
            
            if ($proposal) {
                return response()->json(['status' => 'success', 'data' => ['id' => $proposal->proposal_id]]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to create proposal.']);
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function updateProposal(Request $request, $id)
    {
        try {
            // Fetch the proposal from the database
            $proposal = Proposal::findOrFail($id);
            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string|unique:proposals,title,' . $proposal->proposal_id . ',proposal_id',
                'approval_deadline' => 'nullable',
                'status' => 'required|string',
                'discount' => 'nullable',
                'internal_notes' => 'nullable|string',
                'introductory_text' => 'nullable',
                'closing_text' => 'nullable',
                'lead_id' => 'required|integer|exists:leads,lead_id',
                'worksheet' => 'array',
                'payment_request' => 'nullable'
            ]);
            
            // Create the lead using the validated data
            $user = Auth::user(); 
            $proposal->update($validatedData);

            if ($request->has('worksheet')) {
                $itemsData = $request->input('worksheet');

                if ($itemsData && is_array($itemsData)) {
                    
                    // Change status to 0 for those deleted item
                    $worksheetItemIds = array_column($itemsData, 'proposal_item_id');
                    $existingProposalItems = $proposal->items->pluck('proposal_item_id')->toArray();
                    $itemsToUpdate = array_diff($existingProposalItems, $worksheetItemIds);
                    ProposalItem::whereIn('proposal_item_id', $itemsToUpdate)->update(['status' => 0]);

                    foreach ($itemsData as $itemData) {
                        $itemData['proposal_id'] =  $proposal->proposal_id;

                        if (isset($itemData['proposal_item_id']) && $itemData['proposal_item_id'] == 0) {
                            $itemData['created_by'] = $user->user_id;
                            ProposalItem::create($itemData);
                        } else {
                            $itemData['updated_by'] = $user->user_id;
                            $itemId = $itemData['proposal_item_id'];
                            $item = ProposalItem::findOrFail($itemId);
                            $item->update($itemData);
                        }
                    }
                }
            }

            if (isset($validatedData['payment_request'])) {
                $paymentRequest = $validatedData['payment_request'];
                $stagePayments = $paymentRequest['stage_payments'];

                if($paymentRequest['deposit_type'] != 'amount'){
                    $paymentRequest['deposit_type'] = $paymentRequest['percentage'] . '%';
                }else{
                    $paymentRequest['deposit_type'] = 'amount';
                }

                if($paymentRequest['payment_due'] != 'upon'){
                    $paymentRequest['payment_due'] = $paymentRequest['payment_due_day'] . ' days after';
                }else{
                    $paymentRequest['payment_due'] = 'upon';
                }
                unset($paymentRequest['percentage']);
                unset($paymentRequest['payment_due_day']);
                unset($paymentRequest['stage_payments']);

                $paymentRequest['updated_by'] = $user->user_id;
                $billing = null;
                if($paymentRequest['proposal_billing_id'] == 0){
                    $billing = $proposal->billing()->create($paymentRequest);
                }else{
                    $proposal->billing()->update($paymentRequest);
                    $billing = $proposal->billing;
                }

                if ($billing) {
                    $existingStages = $billing->stages_detail->pluck('proposal_billing_stage_id')->toArray();

                    foreach ($stagePayments as $index => $stagePaymentSet) {
                        foreach ($stagePaymentSet as $stagePayment) {
                            
                            print_r(isset($stagePayment['proposal_billing_stage_id']));
                            if(isset($stagePayment['proposal_billing_stage_id']) && $stagePayment['proposal_billing_stage_id'] != 0){
                                $proposalBillingStageId = $stagePayment['proposal_billing_stage_id'];
                                $billing->stages_detail()->where('proposal_billing_stage_id', $proposalBillingStageId)->update([
                                    'proposal_billing_id' => $billing->proposal_billing_id, // Ensure the correct billing ID
                                    'stage_name' => $stagePayment['stage_name'],
                                    'stage_amount' => $stagePayment['stage_amount'],
                                    'stage_number' => ($index + 1)
                                ]);

                                $existingStages = array_diff($existingStages, [$proposalBillingStageId]);
                            }else{
                                $billing->stages_detail()->create([
                                    'proposal_billing_id' => $billing->proposal_billing_id, // Ensure the correct billing ID
                                    'stage_name' => $stagePayment['stage_name'],
                                    'stage_amount' => $stagePayment['stage_amount'],
                                    'stage_number' => ($index + 1)
                                ]);
                            }

                        }
                    }

                    // Set the date_archived to the current date for the remaining existing stages
                    $billing->stages_detail()->whereIn('proposal_billing_stage_id', $existingStages)->update([
                        'date_archived' => now(),
                    ]);
                }
            }

            if ($proposal) {
                return response()->json(['status' => 'success', 'data' => ['id' => $proposal->proposal_id]]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to update proposal.']);
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Proposal not found.']);
        }
    }   

    public function getProposalItems($proposalId)
    {
        try {
            // Fetch the proposal and its associated items
            $proposal = Proposal::with(['items' => function ($query) {
                $query->where('status', 1);
            }])->findOrFail($proposalId);

            // Return the items
            return response()->json([
                'status' => 'success',
                'data' => $proposal->items
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Proposal not found.']);
        }
    }

    public function getProposalPaymentRequest($proposalId)
    {
        try {
            // Fetch the proposal and its associated billing
            $proposalBilling = ProposalBilling::with(['stages_detail'])->where('proposal_id', $proposalId)->firstOrFail();

            // Return the items
            return response()->json([
                'status' => 'success',
                'data' => $proposalBilling
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Proposal not found.']);
        }
    }

    public function getProposalByJobsiteId(Request $request, $id){
        try {
            $lead = Lead::where('jobsite_id', $id)
                ->with(['proposals' => function($query) {
                    $query->where('status', 'Approved');
                }])->firstOrFail();
            $approvedProposal = null;
            $errorMessage = '';

            if($lead){
                if(count($lead->proposals) === 0){
                    $errorMessage = 'THE ASSOCIATED LEAD HAS NO PROPOSALS';
                }else{
                    foreach($lead->proposals as $proposal){
                        if($proposal){
                            $approvedProposal = $proposal;
                        }
                    }

                    if($approvedProposal === null) {
                        $errorMessage = 'THE ASSOCIATED LEAD HAS NO APPROVED PROPOSAL';
                    }
                }
            }else{
                $errorMessage = 'NO LEAD FOUND WITH ASSOCIATED JOBSITE ID';
            }

            if($errorMessage === ''){
                return response()->json([
                    'status' => 'success',
                    'data' => $approvedProposal
                ]);
            }else{
                return response()->json([
                    'status' => 'failure',
                    'data' => $errorMessage
                ]);
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Jobsite Transaction not found.']);
        }
    }

    public function currentDate(){
        return (new \DateTime())->format('Y-m-d');
    }    

}