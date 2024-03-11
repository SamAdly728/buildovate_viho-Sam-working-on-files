<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowupSequence extends Model
{
    use HasFactory;

    protected $table = 'followup_sequences';

    protected $fillable = [
        'deal_stage_id',
        'sequence_name',
        'sort_order',
        'changes_by',
    ];

    protected $casts = [
        'deal_stage_id' => 'integer',
        'sort_order' => 'integer',
        'changes_by' => 'integer',
    ];

    public function dealStage()
    {
        return $this->belongsTo(FollowupDealStage::class, 'deal_stage_id');
    }

    public function drips()
    {
        return $this->hasMany(FollowupDrip::class, 'sequence_id');
    }
}
