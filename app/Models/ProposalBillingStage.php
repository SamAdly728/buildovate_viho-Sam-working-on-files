<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalBillingStage extends Model
{
    use HasFactory;

    protected $table = 'proposal_billing_stages';

    protected $primaryKey = 'proposal_billing_stage_id';

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'proposal_billing_id',
        'stage_name',
        'stage_number',
        'stage_amount',
        'date_archived',
        'created_by',
        'updated_by'
    ];

    // Define any relationships with other models if needed
    // For example, you can define a relationship to the parent proposal_billing table.
    public function proposalBilling()
    {
        return $this->belongsTo(ProposalBilling::class, 'proposal_billing_id', 'proposal_billing_id');
    }
}
