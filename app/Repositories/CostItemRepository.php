<?php

namespace App\Repositories;

use App\Models\CostItem;

class CostItemRepository 
{
    public function getAll($companyId, $perPage = 10)
    {
        return CostItem::with(['createdBy', 'updatedBy'])
                        ->where('status', 1)
                        ->where('company_id', $companyId)
                        ->orderBy('title')
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage);
    }

    public function get($companyId, $id)
    {
        return CostItem::where('company_id', $companyId)
                       ->where('cost_item_id', $id)
                       ->first();
    }

    public function add(array $data, $companyId)
    {
        $costItem = new CostItem;
        $costItem->fill($data);
        $costItem->company_id = $companyId;
        $costItem->save();

        return $costItem;
    }

    public function edit($id, array $data, $user_id)
    {
        $costItem = CostItem::find($id);
        if ($costItem) {
            $costItem->fill($data);
            $costItem->updated_by = $user_id;
            $costItem->save();
        }

        return $costItem;
    }

    public function delete($id)
    {
        $costItem = CostItem::find($id);
        if ($costItem) {
            $costItem->fill(['status' => 0]);
            $costItem->save();
        }

        return $costItem;
    }
}
