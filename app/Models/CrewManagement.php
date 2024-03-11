<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ProposalItem;

class CrewManagement extends Model
{
    use HasFactory;
    
    public static function get_proposals()
    {
        return ProposalItem::select('proposal_item_id as id','title','unit','unit_quantity as qnty')
                    //  ->where('status','Not Sent')
                     ->orderBy('proposal_item_id','asc')
                     ->get();
    }

    public static function get_crews()
    {
        return User::select('user_id as id','display_name as text', 'email')
                ->where('role_id',4)
                ->orderBy('display_name','asc')
                ->get();
    }
}
