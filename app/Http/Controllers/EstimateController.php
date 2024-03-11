<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\EstimateRepository;

class EstimateController extends Controller
{
    protected $estimateRepository;

    public function __construct(EstimateRepository $estimateRepository)
    {
        $this->estimateRepository = $estimateRepository;
    }

    public function getAll(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $companyId = Session::get('company_id');
        $perPage = intval($request->input('limit', 10));

        $estimates = $this->estimateRepository->getAll($companyId, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => $estimates
        ]);
    }

    public function get($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $estimates = $this->estimateRepository->get($id);

        return response()->json([
            'status' => 'success',
            'data' => $estimates
        ]);
    }

    public function changeFavorite(Request $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $user_id = Session::get('user_id');
        $favoriteValue = $request->input('favorite', 0);
        $estimates = $this->estimateRepository->updateFavorite($id, $favoriteValue, $user_id);

        return response()->json([
            'status' => 'success',
            'data' => $estimates
        ]);
    }

    public function add(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            // Add your validation logic here
            $validatedData = $request->validate([
                'title' => 'required|string|unique:estimates,title',
            ]);

            $estimateFieldsData = $request->input('estimateFields', []);
            $companyId = Session::get('company_id');
            $user_id = Session::get('user_id');
            $estimate = $this->estimateRepository->add($validatedData, $companyId, $user_id, $estimateFieldsData);

            return response()->json(['message' => 'Estimate created successfully', 'data' => $estimate], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Not authenticated.'], 401);
            }

            // Add your validation logic here
            $validatedData = $request->validate([
                'title' => 'required|string|unique:estimates,title,' . $id . ',estimate_id',
            ]);

            $estimateFieldsData = $request->input('estimateFields', []);
            $user_id = Session::get('user_id');
            $estimate = $this->estimateRepository->edit($id, $validatedData, $user_id, $estimateFieldsData);

            if (!$estimate) {
                return response()->json(['message' => $estimate], 404);
            }

            return response()->json(['message' => 'Estimate updated successfully', 'data' => $estimate], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()]);
        }
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        $deleted = $this->estimateRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Estimate not found'], 404);
        }

        return response()->json(['message' => 'Estimate deleted successfully'], 201);
    }
}
