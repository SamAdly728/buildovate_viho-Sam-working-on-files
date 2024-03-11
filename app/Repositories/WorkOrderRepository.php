<?php

namespace App\Repositories;

use App\Models\ProposalItem;

class WorkOrderRepository 
{
    public function getAll($proposalId, $perPage = 10)
    {
        return ProposalItem::with(['createdBy', 'updatedBy'])
                        ->where('status', 1)
                        ->where('proposal_id', $proposalId)
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage);
    }

    public function get($id)
    {
        return ProposalItem::where('proposal_item_id', $id)
                       ->first();
    }

    public function add(array $data, $userId)
    {
        $proposalItem = new ProposalItem;
        $proposalItem->fill($data);
        $proposalItem->created_by = $userId;
        $proposalItem->save();

        return $proposalItem;
    }

    public function edit($id, array $data, $userId)
    {
        $proposalItem = ProposalItem::find($id);
        if ($proposalItem) {
            $proposalItem->fill($data);
            $proposalItem->updated_by = $userId;
            $proposalItem->save();
        }

        return $proposalItem;
    }

    public function delete($id)
    {
        $proposalItem = ProposalItem::find($id);
        if ($proposalItem) {
            $proposalItem->fill(['status' => 0]);
            $proposalItem->save();
        }

        return $proposalItem;
    }
}
