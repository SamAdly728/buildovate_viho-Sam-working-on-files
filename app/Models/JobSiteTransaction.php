<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsiteTransaction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobsite_transaction';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'jobsite_transaction_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */    
    public $timestamps = true;
    const CREATED_AT = 'date_attached';
    const UPDATED_AT = 'date_updated'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jobsite_id',
        'plaid_transaction_id',
        'amount',
        'attached_type',
        'date_paid',
        'transaction_description',
        'recorded_by',
        'status',
    ];

    /**
     * Get the job site that owns the transaction.
     */
    public function Jobsite()
    {
        return $this->belongsTo(Jobsite::class, 'jobsite_id', 'jobsite_id');
    }

    public function recordedBy(){
        return $this->hasOne(User::class, 'user_id', 'recorded_by');
    }

    // Here, you can add any other methods relevant to your JobsiteTransaction model,
    // such as scopes, accessors & mutators, additional relationships, and so on.
}
