<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalBilling extends Model
{
    use HasFactory;

    protected $table = 'proposal_billings';

    protected $primaryKey = 'proposal_billing_id';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'proposal_id',
        'proposal_amount',
        'request_deposit',
        'deposit',
        'deposit_type',
        'payment_due',
        'stages',
        'payment_method',
        'created_by',
        'updated_by'
    ];

    // Relationship to Proposal model, assuming it's in App\Models namespace
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'proposal_id');
    }

    // Relationship to User model for created_by and updated_by, assuming it's in App\Models namespace
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function stages_detail()
    {
        return $this->hasMany(ProposalBillingStage::class, 'proposal_billing_id', 'proposal_billing_id');
    }
}
