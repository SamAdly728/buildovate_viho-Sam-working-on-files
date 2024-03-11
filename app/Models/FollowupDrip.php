<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowupDrip extends Model
{
    use HasFactory;

    protected $table = 'followup_drips';

    protected $fillable = [
        'sequence_id',
        'drip_name',
        'send_time',  // per minute
        'type',
        'email_subject',
        'email_body',
        'sms_msg',
        'active',
        'changes_by',
    ];

    protected $casts = [
        'sequence_id' => 'integer',
        'send_time' => 'integer',
        'active' => 'boolean',
        'changes_by' => 'integer',
    ];

    public function sequence()
    {
        return $this->belongsTo(FollowupSequence::class, 'sequence_id');
    }
}
