<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowupDealStage extends Model
{
    use HasFactory;

    protected $table = 'followup_deal_stages';

    protected $fillable = [
        'deal_stage',
        'description',
        'image_path',
        'changes_by',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'deal_stage_id' => 'integer',
        'changes_by' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'changes_by');
    }

    public function sequences()
    {
        return $this->hasMany(FollowupSequence::class, 'deal_stage_id');
    }
}
