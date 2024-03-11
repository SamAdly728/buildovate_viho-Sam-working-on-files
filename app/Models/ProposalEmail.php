<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalEmail extends Model
{
    use HasFactory;

    protected $table = 'proposal_emails';

    protected $primaryKey = 'proposal_email_id';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'proposal_id',
        'receiver_emails',
        'proposal_validity',
        'notes',
        'status',
        'account_email',
        'sent_by'
    ];

    // Relationship to Proposal model, assuming it's in App\Models namespace
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'proposal_id');
    }

    // Relationship to User model for created_by and updated_by, assuming it's in App\Models namespace
    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by', 'id');
    }
}
