<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\CostItemRepository;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\CostItem;

class CostItemController extends Controller{
    
    protected $costItemRepository;
    
    public function __construct(CostItemRepository $costItemRepository)
    {
        $this->costItemRepository = $costItemRepository;
    }

    public function getAll(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $companyId = Session::get('company_id');
        $perPage = intval($request->input('limit', 10));

        $paginatedList = $this->costItemRepository->getAll($companyId, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => $paginatedList
        ]);
    }

    public function get(Request $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $companyId = Session::get('company_id');
        $item = $this->costItemRepository->get($companyId, $id);

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
                'title' => 'required|string|unique:cost_items,title',
                'description' => 'nullable|string',
                'internal_notes' => 'nullable|string',
                'unit_cost' => 'required|numeric',
                'unit' => 'nullable|string',
                'unit_quantity' => 'nullable|integer',
                'unit_mark_up' => 'nullable|numeric',
                'unit_mark_up_type' => 'nullable|string',
                'labor' => 'nullable|integer',
                'quantity_included' => 'required|integer',
                'tiered_price_included' => 'nullable|integer',
                'owner_price_included' => 'nullable|integer',
                'discount' => 'nullable|numeric',
                'discount_type' => 'nullable|string',
                'item_photo_url' => 'nullable|string',
            ]);

            $companyId = Session::get('company_id');
            $costItem = $this->costItemRepository->add($validatedData, $companyId);

            return response()->json(['message' => 'Cost item created successfully', 'data' => $costItem], 201);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function import(Request $request)
    {
        try {
            set_time_limit(300); // Sets maximum execution time to 5 minutes

            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            if (!$request->has('cost_items') || !is_array($request->cost_items)) {
                return response()->json(['status' => 'error', 'message' => 'Invalid cost items data.'], 422);
            }

            $companyId = Session::get('company_id');
            $resultOutPut = [];

            foreach ($request->cost_items as $itemData) {
                $existingItem = CostItem::where('title', $itemData['title'])
                                        ->where('description', $itemData['description'])
                                        ->where('unit_cost', $itemData['unit_cost'])
                                        ->first();

                if ($existingItem && $existingItem->cost_item_id == ($itemData['cost_item_id'] ?? null)) {
                    continue;
                }

                $validator = Validator::make($itemData, [
                    'title' => 'required|string',
                    'description' => 'nullable|string',
                    'unit_quantity' => 'nullable|integer',
                    'unit_mark_up' => 'nullable|numeric',
                    'unit_mark_up_type' => 'nullable|string',
                    'unit' => 'nullable|string',
                    'unit_cost' => 'nullable|numeric',
                    'labor' => 'nullable|integer',
                    'quantity_included' => 'nullable|integer',
                    'owner_price_included' => 'nullable|integer',
                    'cost_item_id' => 'nullable|integer'
                ]);

                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
                }

                if($itemData['action']){
                    if($itemData['action'] === 'delete' && $itemData['cost_item_id'] && $itemData['cost_item_id'] != 0){
                        unset($itemData['action']);
                    }else if($itemData['action'] === 'update' && $itemData['cost_item_id'] && $itemData['cost_item_id'] != 0){
                        unset($itemData['action']);
                        $resultOutPut[] = $this->costItemRepository->delete($itemData['cost_item_id']);
                    }
                }else{
                    $resultOutPut[] = $this->costItemRepository->add($itemData, $companyId);
                }
            }

            return response()->json(['message' => 'Cost items processed successfully', 'data' => $resultOutPut], 201);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try{
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            $validatedData = $request->validate([
                'title' => 'required|string|unique:cost_items,title,' . $id . ',cost_item_id',
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
                'status' => 'nullable|integer'
            ]);

            $user_id = Session::get('user_id');
            $costItem = $this->costItemRepository->edit($id, $validatedData, $user_id);

            if (!$costItem) {
                return response()->json(['message' => 'Cost Item not found'], 404);
            }

            return response()->json(['message' => 'Cost item updated successfully', 'data' => $costItem], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $deleted = $this->costItemRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Cost Item not found'], 404);
        }

        return response()->json(['message' => 'Cost item deleted successfully'], 201);
    }

        
}