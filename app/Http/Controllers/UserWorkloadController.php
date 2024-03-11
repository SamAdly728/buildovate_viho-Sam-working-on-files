<?php

namespace App\Http\Controllers;

use App\Models\UserWorkload;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserWorkloadController extends Controller
{
    /**
     * Display a listing of all user workloads.
     */
    public function getAll()
    {
        try{
            $userWorkloads = UserWorkload::with(['user', 'inviter', 'approver'])->get();

            return response()->json([
                'status' => 'success',
                'data' => $userWorkloads
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Fetching user workload error.']);
        }
    }

    /**
     * Store a newly created user workload in storage.
     */
    public function add(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,user_id',
                'proposal_item_id' => 'required|integer|exists:proposal_item,proposal_item_id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'internal_notes' => 'nullable|string',
                'unit_cost' => 'required|numeric',
                'unit' => 'required|string|max:255',
                'unit_quantity' => 'required|numeric',
                'unit_mark_up' => 'nullable|numeric',
                'unit_mark_up_type' => 'nullable|string|max:255',
                'status' => ['required', Rule::in(['not yet invited', 'invited', 'accepted', 'validated'])],
                'labor' => 'nullable|numeric',
                'material' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'discount_type' => 'nullable|string|max:255',
            ]);

            $userWorkload = UserWorkload::create($validatedData);
            
            return response()->json([
                'status' => 'success',
                'data' => $userWorkload->user_workload_id
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Add user workload error.']);
        }
    }

    /**
     * invite the specified user workload in storage.
     */
    public function invite(Request $request, $id)
    {
        try{
            $userWorkload = UserWorkload::findOrFail($id);

            $user = Auth::user();
            $userWorkload->status = 'invited';
            $userWorkload->invited_date = new \DateTime();
            $userWorkload->invited_by = $user->user_id;
    
            $userWorkload->save();

            return response()->json([
                'status' => 'success',
                'data' => $userWorkload
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Invite user workload error.']);
        }
    }

    /**
     * approve the specified user's workload confirmation in storage.
     */
    public function approve(Request $request, $id)
    {
        try{
            $userWorkload = UserWorkload::findOrFail($id);

            $user = Auth::user();
            $userWorkload->status = 'approved';
            $userWorkload->approved_date = new \DateTime();
            $userWorkload->approved_by = $user->user_id;
    
            $userWorkload->save();

            return response()->json([
                'status' => 'success',
                'data' => $userWorkload
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Approved workload user workload error.']);
        }
    }

    /**
     * Approve all the specified user's workload confirmations in storage.
     */
    public function approveAll(Request $request, $user_id)
    {
        $userWorkLoadIds = $request->input('user_workload_ids');

        if (!is_array($userWorkLoadIds)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid workload IDs.']);
        }

        try {
            $user = Auth::user();
            $affectedRows = UserWorkload::where('user_id', $user_id)
                                        ->whereIn('user_workload_id', $userWorkLoadIds)
                                        ->update([
                                            'status' => 'approved',
                                            'approved_date' => new \DateTime(),
                                            'approved_by' => $user->user_id,
                                        ]);

            if ($affectedRows > 0) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'status' => 'approved',
                        'approved_date' => new \DateTime(),
                        'approved_by' =>  $user->user_id
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No workloads were updated, check if the IDs are correct and belong to the user.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e]);
        }
    }

    /**
     * invite all the specified user's workload confirmations in storage.
     */
    public function inviteAll(Request $request, $user_id)
    {
        $userWorkLoadIds = $request->input('user_workload_ids');

        if (!is_array($userWorkLoadIds)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid workload IDs.']);
        }

        try {
            $user = Auth::user();
            $affectedRows = UserWorkload::where('user_id', $user_id)
                                        ->whereIn('user_workload_id', $userWorkLoadIds)
                                        ->update([
                                            'status' => 'invited',
                                            'invited_date' => new \DateTime(),
                                            'invited_by' => $user->user_id,
                                        ]);

            if ($affectedRows > 0) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'status' => 'invited',
                        'invited_date' => new \DateTime(),
                        'invited_by' =>  $user->user_id
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No workloads were updated, check if the IDs are correct and belong to the user.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e]);
        }
    }


    /**
     * complete the specified user's workload in storage.
     */
    public function complete(Request $request, $id)
    {
        try{
            $userWorkload = UserWorkload::findOrFail($id);

            $user = Auth::user();
            $userWorkload->status = 'completed';
            $userWorkload->completed_date = new \DateTime();
            $userWorkload->completed_by = $user->user_id;
    
            $userWorkload->save();

            return response()->json([
                'status' => 'success',
                'data' => $userWorkload
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Complete workload user workload error.']);
        }
    }

    /**
     * Update the specified user workload in storage.
     */
    public function edit(Request $request, $id)
    {
        $userWorkload = UserWorkload::findOrFail($id);

        $userWorkload->update($validatedData);
        return response()->json($userWorkload);
    }

    /**
     * Remove the specified user workload from storage.
     */
    public function delete($proposal_item_id, $user_id)
    {
        try {
            // Find the user workload by proposal_item_id and user_id
            $userWorkload = UserWorkload::where('proposal_item_id', $proposal_item_id)
                                        ->where('user_id', $user_id)
                                        ->firstOrFail();
            $userWorkload->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User with id: ' . $user_id . ' assigned with item id: ' . $proposal_item_id . ' successfully deleted!'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'User workload not found.'], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions that occur
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

}
