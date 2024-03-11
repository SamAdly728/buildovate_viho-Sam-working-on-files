<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\Proposal;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Salesv2');
    }

    public function lead_list(Request $request)
    {
        return Inertia::render('sales/lead/LeadManagement');
    }

    public function activities(Request $request)
    {
        return Inertia::render('sales/Activities',
            ['pageTitle' => "Activities"]);
    }

    public function estimator_tool(Request $request)
    {
        return Inertia::render('sales/EstimatorTool',
            ['pageTitle' => "Smart Estimate"]);
    }

    public function smart_estimates(Request $request, $id = null)
    {
        return Inertia::render('sales/SmartEstimate',
        ['pageTitle' => "Smart Estimate"]);
    }

    public function import_test(Request $request)
    {
        return Inertia::render('sales/EstimatorForm',
            ['pageTitle' => "Smart Estimate"]);
    }

    public function estimate_builder(Request $request, $id = null)
    {
        return Inertia::render('sales/EstimateBuilder',
            ['pageTitle' => "Smart Estimate Builder", 'estimated_id' => $id]);
    }


    public function proposals(Request $request)
    {
        return Inertia::render('sales/proposal/Proposals',
            ['pageTitle' => "Proposals"]);
    }

    public function map(Request $request)
    {
        return Inertia::render('sales/Map',
            ['pageTitle' => "Proposals"]);
    }

    public function change_orders(Request $request)
    {
        return Inertia::render('sales/ChangeOrders',
            ['pageTitle' => "Change Orders"]);
    }

    public function catalogs(Request $request)
    {
        $user_id = Session::get('user_id');
        return Inertia::render('sales/Catalogs',
            ['pageTitle' => "Catalogs", 'user_id' => $user_id]);
    }

    public function view_lead(Request $request, $id = null)
    {
        $lead = Lead::with('leadCustomer', 'jobTypes.jobType', 'tags.tag', 'sources.source', 'salesPeople.user', 'proposals.jobsite')->find($id);
        $lead = Lead::with('leadCustomer')->find($id);
        
        return Inertia::render('sales/lead/ViewLead',
            [
                'pageTitle' => "View Lead",
                'lead' => $lead
            ]);
    }

    public function edit_lead(Request $request, $id = null)
    {
        $lead = Lead::with('leadCustomer', 'jobTypes.jobType', 'tags.tag', 'sources.source', 'salesPeople.user')->find($id);
        
        return Inertia::render('sales/lead/EditLead',
        [
            'pageTitle' => "View Lead",
            'lead' => $lead
        ]);
    }

    public function proposal(Request $request, $proposal_id = null, $lead_id = null)
    {
        $proposal = null;
        $lead = null;

        if (!is_null($proposal_id) && $proposal_id != 0) {
            $proposal = Proposal::findOrFail($proposal_id);

            if(!is_null($lead_id) && $lead_id != 0){
                $lead = Lead::with('leadCustomer', 'jobTypes.jobType', 'tags.tag', 'sources.source', 'salesPeople.user')->find($lead_id);
            }
        }
    
        if (!is_null($lead_id) && $proposal_id == 0) {
            $lead = Lead::with('leadCustomer', 'jobTypes.jobType', 'tags.tag', 'sources.source', 'salesPeople.user')->find($lead_id);
        }

        return Inertia::render('sales/proposal/Proposal',
        [
            'pageTitle' => "Proposal",
            'proposal' => $proposal,
            'lead' => $lead,
            'user_id' => Session::get('user_id'),
            'company_name' => Session::get('company_name'),
            'user_display_name' => Session::get('user_display_name'),
            'company_license_number' => Session::get('company_license_number'),
            'company_address' => Session::get('company_address'),
            'company_city' => Session::get('company_city'),
            'company_state' => Session::get('company_state'),
            'company_zipcode' => Session::get('company_zipcode')
        ]);
    }

    public function change_order(Request $request, $proposal_id = null, $lead_id = null)
    {
        $proposal = null;
        $lead = null;

        if (!is_null($proposal_id) && $proposal_id != 0) {
            $proposal = Proposal::findOrFail($proposal_id);

            if(!is_null($lead_id) && $lead_id != 0){
                $lead = Lead::with('leadCustomer', 'jobTypes.jobType', 'tags.tag', 'sources.source', 'salesPeople.user')->find($lead_id);
            }
        }
    
        if (!is_null($lead_id) && $proposal_id == 0) {
            $lead = Lead::with('leadCustomer', 'jobTypes.jobType', 'tags.tag', 'sources.source', 'salesPeople.user')->find($lead_id);
        }

        return Inertia::render('sales/ChangeOrder',
        [
            'pageTitle' => "Proposal",
            'proposal' => $proposal,
            'lead' => $lead,
            'user_id' => Session::get('user_id'),
            'company_name' => Session::get('company_name'),
            'user_display_name' => Session::get('user_display_name'),
            'company_license_number' => Session::get('company_license_number'),
            'company_address' => Session::get('company_address'),
            'company_city' => Session::get('company_city'),
            'company_state' => Session::get('company_state'),
            'company_zipcode' => Session::get('company_zipcode')
        ]);
    }

    public function proposal_preview(){
        return Inertia::render('sales/proposal/AcceptProposal',
            ['pageTitle' => "Proposal Preview"]);
    }
    
}