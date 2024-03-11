<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkload extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_workloads';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_workload_id';

    /**
     * Indicates if the model should be timestamped.
     * Since you don't have the typical created_at and updated_at timestamps, I'll set this to false.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'proposal_item_id',
        'user_id',
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
        'material',
        'category_id',
        'discount',
        'discount_type',
        'invited_by',
        'invited_date',
        'approved_by',
        'approved_date',
        'completed_by',
        'completed_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'invited_date' => 'datetime',
        'approved_date' => 'datetime',
    ];

    // Relationships and additional methods would go here, e.g.,

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inviter() 
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function approver() 
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function completedBy() 
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    // ... more relationships and methods as necessary.
}
