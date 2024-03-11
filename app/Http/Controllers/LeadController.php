<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Stage;
use App\Models\LeadTag;
use App\Models\LeadSource;
use App\Models\LeadJobType;
use App\Models\LeadAssignment;
use App\Models\CompanyLead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Appointment;
use App\Models\AppointmentAssignment;
use Carbon\Carbon;

class LeadController extends Controller
{
    public function getAll(Request $request)
    {
        $userCredential = $request->user();
        $user = $userCredential->user;$user = $user->load(
            'ownedCompany.leads.leadCustomer', 
            'ownedCompany.leads.salesPeople.user', 
            'ownedCompany.leads.jobTypes.jobType', 
            'ownedCompany.leads.tags.tag', 
            'ownedCompany.leads.sources.source', 
            'ownedCompany.leads.proposals', 
            'partOfCompany.company.leads.leadCustomer',
            'partOfCompany.company.leads.salesPeople.user',
            'partOfCompany.company.leads.jobTypes.jobType',
            'partOfCompany.company.leads.tags.tag',
            'partOfCompany.company.leads.sources.source',
            'partOfCompany.company.leads.proposals'
        );

        $companyId = Session::get('company_id');
        $query = Lead::where('company_id', $companyId)
        ->where('status', '!=', 'deleted')
        ->with([
            'leadCustomer',
            'salesPeople.user',
            'jobTypes.jobType',
            'tags.tag',
            'sources.source',
            'proposals'
        ]);
        
        $sorts = $request->input('sort', []);
        $defaultSortApplied = false;
        foreach ($sorts as $column => $direction) {
            if ($direction !== 'none') {
                if ($column === 'created_at') {
                    $defaultSortApplied = true;
                }
                $query->orderBy($column, $direction);
            }
        }

        $query->orderBy('updated_at', 'desc');
        if (!$defaultSortApplied) {
            $query->orderBy('created_at', 'desc');
        }

        $filters = $request->input('filters', []);

        // Apply filters
        if (!empty($filters['oppurtunityTitle'])) {
            $query->where('opportunity_title', 'like', '%' . $filters['oppurtunityTitle'] . '%');
        }

        if (!empty($filters['customerName'])) {
            $query->where(function($query) use ($filters) {
                $query->whereHas('leadCustomer', function ($q) use ($filters) {
                    $q->where('display_name', 'like', '%' . $filters['customerName'] . '%');
                });
            });
        }

        if (!empty($filters['salesperson'])) {
            $query->whereHas('salesPeople', function ($q) use ($filters) {
                $q->whereIn('user_id', $filters['salesperson']);
            });
        }

        if (!empty($filters['tags'])) {
            $query->whereHas('tags.tag', function ($q) use ($filters) {
                $q->whereIn('tags_id', $filters['tags']);
            });
        }

        if (!empty($filters['leadStatus'])) {
            $query->whereIn('status', $filters['leadStatus']);
        }

        if (!empty($filters['sources'])) {
            $query->whereHas('sources.source', function ($q) use ($filters) {
                $q->whereIn('source_id', $filters['sources']);
            });
        }

        if (!empty($filters['jobtypes'])) {
            $query->whereHas('jobTypes.jobType', function ($q) use ($filters) {
                $q->whereIn('job_type_id', $filters['jobtypes']);
            });
        }

        $search = $request->input('search');
        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('opportunity_title', 'like', '%' . $search . '%');
            });
        }

        // if (!empty($filters['proposalStatus'])) {
        //     $query->whereHas('proposals', function ($q) use ($filters) {
        //         $q->where('status', $filters['proposalStatus']);
        //     });
        // }

        $lead_id = $request->input('lead_id');
        if($lead_id){
            $query->where(function($query) use ($lead_id) {
                $query->where('lead_id', $lead_id);
            });
        }

        // Paginating the results
        $limit = $request->input('limit');

        // Check if limit is defined and is a valid positive integer
        if (!is_null($limit) && intval($limit) > 0) {
            $perPage = intval($limit);
            $paginatedLeads = $query->paginate($perPage);
        
            return response()->json([
                'status' => 'success',
                'data' => $paginatedLeads,
            ]);
        } else {
            // If limit is not defined or is not a valid positive integer, return all leads without pagination
            $allLeads = $query->get();
        
            return response()->json([
                'status' => 'success',
                'data' => $allLeads,
            ]);
        }
    }

    public function getLeadsForModal(Request $request)
    {
        $userCredential = $request->user();
        $user = $userCredential->user;
        $user = $user->load(
            'ownedCompany.leads.leadCustomer', 
            'ownedCompany.leads.salesPeople.user', 
            'ownedCompany.leads.jobTypes.jobType', 
            'ownedCompany.leads.tags.tag', 
            'ownedCompany.leads.sources.source',
            'partOfCompany.company.leads.leadCustomer',
            'partOfCompany.company.leads.salesPeople.user',
            'partOfCompany.company.leads.jobTypes.jobType',
            'partOfCompany.company.leads.tags.tag',
            'partOfCompany.company.leads.sources.source'
        );
    
        // Get lead IDs for owned company
        $ownedCompanyLeadIds = ($user->ownedCompany) ? $user->ownedCompany->leads->pluck('lead_id') : collect();
    
        // Get lead IDs for companies user is a part of
        $partOfCompaniesLeadIds = $user->partOfCompany->flatMap(function ($companyUser) {
            return $companyUser->company->leads->pluck('lead_id');
        });
    
        // Merge both ID collections and remove duplicates
        $allLeadIds = $ownedCompanyLeadIds->concat($partOfCompaniesLeadIds)->unique();
    
        // Define the base query
        $query = Lead::whereIn('lead_id', $allLeadIds)
            ->where('status', '!=', 'deleted')
            ->with([
                'leadCustomer',
                'salesPeople.user',
                'jobTypes.jobType',
                'tags.tag',
                'sources.source'
            ]);
        
        // Apply search conditionally
        $search = $request->input('search');
        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('opportunity_title', 'LIKE', '%' . $search . '%')
                      ->orWhere('street_address', 'LIKE', '%' . $search . '%');
            });
        }
    
        // Execute query with pagination
        $perPage = 5;
        $paginatedLeads = $query->paginate($perPage);
    
        return response()->json(
            [
                'status' => 'success',
                'data' => $paginatedLeads
            ]
        );
    }
    
    public function createLead(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'cust_id' => 'required|integer|exists:customers,cust_id',
                'opportunity_title' => 'required|string|unique:leads,opportunity_title',
                'street_address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zipcode' => 'required',
                'opportunity_phone' => 'nullable|digits:10',
                'status' => 'required|string',
                'description' => 'nullable|string',
                'cost_of_lead' => 'numeric',
                'updated_by' => 'nullable|integer',
                'tag_ids' => 'array',
                'tag_ids.*' => 'integer|exists:tags,tags_id',
                'source_ids' => 'array',
                'source_ids.*' => 'integer|exists:source,source_id',
                'jobtype_ids' => 'array',
                'jobtype_ids.*' => 'integer|exists:job_type,job_type_id',
                'salesperson_ids' => 'array',
                'salesperson_ids.*' => 'integer|exists:users,user_id',
                'stage_id' => 'nullable|integer',
                'stage_date' => 'nullable|string',
                'reminder' => 'nullable|boolean',
                'followup' => 'nullable|boolean'
            ]);
            
            // Create the lead using the validated data
            $companyId = Session::get('company_id');
            $user_id = Session::get('user_id');
            $validatedData['created_by'] = $user_id;
            $validatedData['company_id'] = $companyId;
            $lead = Lead::create($validatedData);

            // Associating the tags with the created lead
            if ($request->has('tag_ids')) {
                foreach ($request->tag_ids as $tagId) {
                    LeadTag::create([
                        'lead_id' => $lead->lead_id,
                        'tags_id' => $tagId
                    ]);
                }
            }

            // Associating the sources with the created lead
            if ($request->has('source_ids')) {
                foreach ($request->source_ids as $source_id) {
                    LeadSource::create([
                        'lead_id' => $lead->lead_id,
                        'source_id' => $source_id
                    ]);
                }
            }

            // Associating the jobtypes with the created lead
            if ($request->has('jobtype_ids')) {
                foreach ($request->jobtype_ids as $jobtype_id) {
                    LeadJobType::create([
                        'lead_id' => $lead->lead_id,
                        'job_type_id' => $jobtype_id
                    ]);
                }
            }

            // // Associating the salespeople with the updated lead
            if ($request->has('salesperson_ids')) {
                foreach ($request->salesperson_ids as $user_id) {
                    LeadAssignment::create([
                        'lead_id' => $lead->lead_id,
                        'user_id' => $user_id
                    ]);
                }
            }

            //Lead Assignment
            if($request->appointment["selectedSalesId"] > 0){
                LeadAssignment::create([
                    'lead_id' => $lead->lead_id,
                    'user_id' => $request->appointment["selectedSalesId"]
                ]);
            }

            // Create appointment for Lead
            if ($request->has('appointment') && $request->appointment["apptDate"] && $request->appointment["startDate"] && $request->appointment["endDate"]) {

                $apptDate = Carbon::createFromFormat('m/d/Y, h:i A', $request->appointment["apptDate"])->format('Y-m-d H:i:00');
                $startDate = Carbon::createFromFormat('m/d/Y, h:i A', $request->appointment["startDate"])->format('Y-m-d H:i:00');
                $endDate = Carbon::createFromFormat('m/d/Y, h:i A', $request->appointment["endDate"])->format('Y-m-d H:i:00');

                $newappt = Appointment::create([
                    'title' => $lead->opportunity_title,
                    'description' => $lead->description,
                    'street' => $lead->street_address,
                    'city' => $lead->city,
                    'state' => $lead->state,
                    'zipcode' => $lead->zipcode,
                    'entityType' => "leads",
                    'entityId' => $lead->lead_id,
                    'user_id' => $user_id,

                    'date' => $apptDate,
                    'Meeting_date' => $apptDate,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'assignedToUserId' => $request->appointment["selectedSalesId"],

                    'created_by' => $user_id,
                    'appointedBy' => $request->appointment["appointedBy"]
                ]);

                if($newappt){
                    AppointmentAssignment::create([
                        'appointment_id' => $newappt->appointment_id,
                        'user_id' => $request->appointment["selectedSalesId"]
                    ]);
                }
            }
            
            if ($lead) {
                return response()->json(['status' => 'success', 'data' => ['id' => $lead->lead_id]]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to create lead.']);
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Fetch the lead from the database
            $lead = Lead::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'cust_id' => 'required|integer|exists:customers,cust_id',
                'opportunity_title' => 'required|string|unique:leads,opportunity_title,' . $lead->lead_id . ',lead_id',
                'street_address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zipcode' => 'required',
                'opportunity_phone' => 'nullable',
                'status' => 'required|string',
                'description' => 'nullable|string',
                'cost_of_lead' => 'numeric',
                'updated_by' => 'nullable|integer',
                'tag_ids' => 'array',
                'tag_ids.*' => 'integer|exists:tags,tags_id',
                'source_ids' => 'array',
                'source_ids.*' => 'integer|exists:source,source_id',
                'jobtype_ids' => 'array',
                'jobtype_ids.*' => 'integer|exists:job_type,job_type_id',
                'salesperson_ids' => 'array',
                'salesperson_ids.*' => 'integer|exists:users,user_id'
            ]);            
            
            $user_id = Session::get('user_id');
            $validatedData['updated_by'] = $user_id;

            $lead->update($validatedData);

            
            // Associating the tags with the updated lead
            if ($request->has('tag_ids')) {
                // Delete existing associated tags
                LeadTag::where('lead_id', $lead->lead_id)->delete();

                // Create the new associations
                foreach ($request->tag_ids as $tagId) {
                    LeadTag::create([
                        'lead_id' => $lead->lead_id,
                        'tags_id' => $tagId
                    ]);
                }
            }

            // Associating the sources with the updated lead
            if ($request->has('source_ids')) {
                // Delete existing associated sources
                LeadSource::where('lead_id', $lead->lead_id)->delete();

                // Create the new associations
                foreach ($request->source_ids as $source_id) {
                    LeadSource::create([
                        'lead_id' => $lead->lead_id,
                        'source_id' => $source_id
                    ]);
                }
            }

            // Associating the jobtypes with the updated lead
            if ($request->has('jobtype_ids')) {
                // Delete existing associated job types
                LeadJobType::where('lead_id', $lead->lead_id)->delete();

                // Create the new associations
                foreach ($request->jobtype_ids as $jobtype_id) {
                    LeadJobType::create([
                        'lead_id' => $lead->lead_id,
                        'job_type_id' => $jobtype_id
                    ]);
                }
            }
            
            // Associating the salespeople with the updated lead
            if ($request->has('salesperson_ids')) {
                // Delete existing associated job types
                LeadAssignment::where('lead_id', $lead->lead_id)->delete();

                // Create the new associations
                foreach ($request->salesperson_ids as $user_id) {
                    LeadAssignment::create([
                        'lead_id' => $lead->lead_id,
                        'user_id' => $user_id
                    ]);
                }
            }
            
            return response()->json(['status' => 'success', 'data' => ['id' => $lead->lead_id]]);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Lead not found.']);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            // Fetch the lead from the database
            $lead = Lead::findOrFail($id);
    
            // Update the lead status to "deleted" and set the updated_by field
            $user = Auth::user();
            $lead->status = 'deleted';
            $lead->updated_by = $user->user_id;
    
            // Save the changes to the database
            $lead->save();
    
            return response()->json(['status' => 'success', 'data' => ['id' => $lead->lead_id]]);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Lead not found.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred.']);
        }
    }
    
    public function getLeadDetails(Request $request, $id = null){
        try {
            // Fetch the lead from the database
            $lead = Lead::with('leadCustomer', 'jobTypes.jobType', 'tags.tag', 'sources.source', 'salesPeople.user')
            ->where('jobsite_id', $id) // specify your condition here
            ->first();
    
            return response()->json(['status' => 'success', 'data' => ['lead' => $lead]]);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Lead not found.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred.']);
        }
    }

    public function getLeadsGroupedByStage()
    {
        $stages = Stage::with(['leads' => function($query) {
            $query->where('status', 'open');
        }])->where('status', '1')->where('stage_for','leads')->get();
    
        // Now we will format the stages with their leads as required
        $formattedStages = $stages->map(function ($stage) {
            return [
                'id' => $stage->id,
                'name' => $stage->name,
                'title' => $stage->title,
                'items' => $stage->leads->map(function ($lead) {
                    return $lead;
                })->toArray()
            ];
        });
    
        return response()->json([
            'lists' => $formattedStages
        ]);
    }

    /**
     * Update the stage_id for a lead.
     *
     * @param  Request  $request
     * @param  int  $leadId
     * @return \Illuminate\Http\Response
     */
    public function updateStage(Request $request, $leadId)
    {
        $request->validate([
            'stage_id' => 'required|exists:lib_stage,id', // Ensure the stage_id exists in the stages table
        ]);

        $lead = Lead::findOrFail($leadId);
        $lead->stage_id = $request->stage_id;
        $lead->stage_date = Carbon::now();
        $lead->save();

        return response()->json([
            'message' => 'Lead stage updated successfully.',
            'lead' => $lead
        ]);
    }

    public function getLeadTitleVersion(Request $request){
        $opportunityTitle = $request->opportunity_title;
        $total = Lead::where('opportunity_title', $opportunityTitle)
                    ->orWhereRaw("opportunity_title REGEXP ?", ["^" . preg_quote($opportunityTitle, '/') . " V[0-9]+$"])
                    ->count();

        return response()->json([
            'opportunityTitleVersion' => $total
        ]);
    }
    
}