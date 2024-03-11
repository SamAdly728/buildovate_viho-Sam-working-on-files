<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CrewManagement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Proposal;
use App\Models\Stage;
use Carbon\Carbon;

class ProductionController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('ProductionV2',
            ['pageTitle' => ""]);
    }

    public function material_take_off(Request $request)
    {
        return Inertia::render('production/MaterialTakeOff',
            ['pageTitle' => "Material Take Off"]);
    }

    public function material_orders(Request $request)
    {
        return Inertia::render('production/MaterialOrders',
            ['pageTitle' => "Material Orders"]);
    }

    public function production_calendar(Request $request)
    {
        return Inertia::render('production/ProductionCalendar',
            ['pageTitle' => "Production Calendar"]);
    }

    public function crew_management(Request $request)
    {
        return Inertia::render('production/CrewManagement',
            [
                "pageTitle" => "",
                "crews" => CrewManagement::get_crews(),
                "checklists" => array()
            ]);
    }

    public function plans_and_permits(Request $request)
    {
        return Inertia::render('production/PlansAndPermits',
            ['pageTitle' => "Plans and Permits"]);
    }

    public function site_plan(Request $request)
    {
        return Inertia::render('production/plans_permits/SitePlan',
            ['pageTitle' => "Site Plan"]);
    }

    public function engineering_plan(Request $request)
    {
        return Inertia::render('production/plans_permits/EngineeringPlan',
            ['pageTitle' => "Engineering Plan"]);
    }

    public function permit_services(Request $request)
    {
        return Inertia::render('production/plans_permits/PermitServices',
            ['pageTitle' => "Permit Services"]);
    }

    public function floor_plan(Request $request)
    {
        return Inertia::render('production/plans_permits/FloorPlan',
            ['pageTitle' => "Floor Plan"]);
    }

    public function landscape_plan(Request $request)
    {
        return Inertia::render('production/plans_permits/LandscapePlan',
            ['pageTitle' => "Landscape Plan"]);
    }

    public function structural_plan(Request $request)
    {
        return Inertia::render('production/plans_permits/StructuralPlan',
            ['pageTitle' => "Structural Plan"]);
    }

    public function plumbing_plan(Request $request)
    {
        return Inertia::render('production/plans_permits/PlumbingPlan',
            ['pageTitle' => "Plumbing Plan"]);
    }

    public function electrical_plan(Request $request)
    {
        return Inertia::render('production/plans_permits/ElectricalPlan',
            ['pageTitle' => "Electrical Plan"]);
    }

    public function getProposalsGroupedByStage()
    {
        $stages = Stage::with(['proposals' => function($query) {
            $query->where('status', 'Approved');
        }])->where('status', '1')->where('stage_for','proposals')->get();
    
        // Now we will format the stages with their leads as required
        $formattedStages = $stages->map(function ($stage) {
            return [
                'id' => $stage->id,
                'name' => $stage->name,
                'title' => $stage->title,
                'items' => $stage->proposals->map(function ($proposal) {
                    return $proposal;
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
    public function updateStage(Request $request, $proposalId)
    {
        $request->validate([
            'stage_id' => 'required|exists:lib_stage,id', // Ensure the stage_id exists in the stages table
        ]);

        $proposal = Proposal::findOrFail($proposalId);
        $proposal->stage_id = $request->stage_id;
        $proposal->stage_date = Carbon::now();
        $proposal->save();

        return response()->json([
            'message' => 'Lead stage updated successfully.',
            'proposal' => $proposal
        ]);
    }
        
}
