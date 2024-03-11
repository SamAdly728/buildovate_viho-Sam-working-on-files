<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\WorkOrderRepository;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\ProposalItem;

class WorkOrderContoller extends Controller{
    
    protected $workOrderRepository;
    
    public function __construct(WorkOrderRepository $workOrderRepository)
    {
        $this->workOrderRepository = $workOrderRepository;
    }

    public function getAll(Request $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $perPage = intval($request->input('limit', 10));

        $paginatedList = $this->workOrderRepository->getAll($id, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => $paginatedList
        ]);
    }

    public function get(Request $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $item = $this->workOrderRepository->get($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $item
        ]);
    }
    
    public function add(Request $request)
    {
        try{
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            $validatedData = $request->validate([
                'proposal_id' => 'required',
                'title' => 'required|string',
                'description' => 'nullable|string',
                'internal_notes' => 'nullable|string',
                'unit_cost' => 'required|numeric',
                'unit' => 'nullable|string',
                'unit_quantity' => 'nullable|integer',
                'unit_mark_up' => 'nullable|numeric',
                'unit_mark_up_type' => 'nullable|string',
                'labor' => 'nullable|integer',
                'quantity_included' => 'nullable|integer',
                'tiered_price_included' => 'nullable|integer',
                'owner_price_included' => 'nullable|integer',
                'discount' => 'nullable|numeric',
                'discount_type' => 'nullable|string',
                'item_photo_url' => 'nullable|string',
            ]);

            $userId = Session::get('user_id');
            $workOrder = $this->workOrderRepository->add($validatedData, $userId);

            return response()->json(['message' => 'Cost item created successfully', 'data' => $workOrder], 201);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function edit(Request $request, $id)
    {
        try{
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            $validatedData = $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
                'internal_notes' => 'nullable|string',
                'unit_cost' => 'required|numeric',
                'unit' => 'nullable|string',
                'unit_quantity' => 'nullable|integer',
                'unit_mark_up' => 'nullable|numeric',
                'unit_mark_up_type' => 'nullable|string',
                'labor' => 'nullable|integer',
                'quantity_included' => 'nullable|integer',
                'tiered_price_included' => 'nullable|integer',
                'owner_price_included' => 'nullable|integer',
                'discount' => 'nullable|numeric',
                'discount_type' => 'nullable|string',
                'item_photo_url' => 'nullable|string',
            ]);

            $userId = Session::get('user_id');
            $workOrder = $this->workOrderRepository->edit($id, $validatedData, $userId);

            if (!$workOrder) {
                return response()->json(['message' => 'Cost Item not found'], 404);
            }

            return response()->json(['message' => 'Cost item updated successfully', 'data' => $workOrder], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $deleted = $this->workOrderRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Cost Item not found'], 404);
        }

        return response()->json(['message' => 'Cost item deleted successfully'], 201);
    }

        
}