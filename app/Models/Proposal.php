<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $table = 'proposals';
    protected $primaryKey = 'proposal_id';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'lead_id',
        'title',
        'approval_deadline',
        'status',
        'discount',
        'internal_notes',
        'introductory_text',
        'closing_text',
        'stage_id',
        'stage_date',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }
    
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'user_id');
    }
    
    public function items()
    {
        return $this->hasMany(ProposalItem::class, 'proposal_id', 'proposal_id');
    }

    public function billing()
    {
        return $this->hasOne(ProposalBilling::class, 'proposal_id', 'proposal_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'lead_id');
    }

    public function jobsite()
    {
        return $this->hasOne(Jobsite::class, 'proposal_id', 'proposal_id');
    }

    public function sentEmail()
    {
        return $this->hasOne(ProposalEmail::class, 'proposal_id', 'proposal_id');
    }
    
    public function stage()
    {
        return $this->belongsTo(Stage::class,'stage_id', 'id');
    }
}
