<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalItem extends Model
{
    use HasFactory;

    protected $table = 'proposal_items';

    protected $primaryKey = 'proposal_item_id';

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'proposal_id',
        'title',
        'description',
        'internal_notes',
        'unit_cost',
        'unit',
        'unit_quantity',
        'unit_mark_up',
        'unit_mark_up_type',
        'status',
        'labor',
        'category_id',
        'discount',
        'discount_type',
        'created_by',
        'updated_by'
    ];

    // Relationship to Proposal model, assuming it's in App\Models namespace
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'proposal_id');
    }

    // Relationship to Category model, assuming it's in App\Models namespace
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get the proposal item create by.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }    

    /**
     * Get the proposal item create by.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }
}
