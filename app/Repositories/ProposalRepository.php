<?php

namespace App\Repositories;

use App\Models\Lead;
use App\Models\Proposal;
use App\Models\ProposalEmail;

class ProposalRepository 
{

    // proposal changes (auto save)
    // Title
    // Approval date
    // add discount
    // salesperson notes (header/note)
    // customer notes (header/note)
    // company notes (header/note)
    // Video
    // Introductory Text
    // Closing Text
    // add/remove/update item
    // add/remove/update stage payment

    public function updateProposal($key, $value, $proposal_id){
        $proposal = Proposal::find($proposal_id);
        $proposal->$key = $value;
        $proposal->save();

        return $proposal;
    }

    public function getAllByLead($lead_id){
        return Proposal::where('lead_id', $lead_id)->get();
    }

    public function getAll($companyId, $perPage = 10, $status = null, $lead_id = null)
    {
        $leads = Lead::where('company_id', $companyId)->get();

        // Use flatMap on the Collection
        $allIds = $leads->flatMap(function ($lead) {
            return $lead->proposals->pluck('proposal_id');
        });

        $mainQuery = Proposal::whereIn('proposal_id', $allIds->all())
        ->where('deleted_at', null);

        if($status){
            $mainQuery->where('status', $status);
        }

        if($lead_id){
            $mainQuery->where('lead_id', $lead_id);
        }
        
        return $mainQuery->with(['lead' => function($query){
                $query->with(['leadCustomer', 'salesPeople.user']);
            }, 'jobsite'])
            ->orderBy('status', 'asc')
            ->paginate($perPage);
    }

    public function updateEmail(array $data, $proposal_email_id){
        $proposalEmail = ProposalEmail::find($proposal_email_id);
        $proposalEmail->fill($data);
        $proposalEmail->save();

        return $proposalEmail;
    }

    public function addEmail(array $data, $proposal_id, $sent_by){
        $proposalEmail = new ProposalEmail;
        $proposalEmail->fill($data);
        $proposalEmail->proposal_id = $proposal_id;
        $proposalEmail->sent_by = $sent_by;
        $proposalEmail->save();

        return $proposalEmail;
    }
    
    public function getEmail($id)
    {
        return ProposalEmail::where('proposal_id', $id)->first();
    }
    

    public function get($id)
    {
        return Proposal::with(
            [
                'lead.company.primaryLocation', 
                'lead.company.primaryNumber', 
                'lead.company.primaryEmail', 
                'lead.company.primaryWebsite',
                'lead.leadCustomer',
                'sentEmail'
            ])->where('proposal_id', $id)
                       ->first();
    }

    public function delete($id, $user_id)
    {
        $proposal = Proposal::find($id);
        if ($proposal) {
            $proposal->deleted_by = $user_id;
            $proposal->deleted_at = date('Y-m-d H:i:s');;
            $proposal->save();
        }

        return $proposal;
    }
    
    // public function add(array $data, $companyId)
    // {
    //     $costItem = new CostItem;
    //     $costItem->fill($data);
    //     $costItem->company_id = $companyId;
    //     $costItem->save();

    //     return $costItem;
    // }

    // public function edit($id, array $data)
    // {
    //     $costItem = CostItem::find($id);
    //     if ($costItem) {
    //         $costItem->fill($data);
    //         $costItem->save();
    //     }

    //     return $costItem;
    // }

    // public function delete($id)
    // {
    //     $costItem = CostItem::find($id);
    //     if ($costItem) {
    //         $costItem->delete();
    //         return true;
    //     }

    //     return false;
    // }
}
