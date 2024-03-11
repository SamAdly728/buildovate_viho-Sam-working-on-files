<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobsite extends Model
{
    use HasFactory;

    protected $table = 'jobsites';
    protected $primaryKey = 'jobsite_id';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'proposal_id',
        'cust_id',
        'jobsite_name',
        'street',
        'city',
        'state',
        'zipcode',
        'proposal_line_items',
        'proposal_legal_content',
        'proposal_payment',
        'apply_estimate_line',
        'created_by',
        'updated_by',
    ];
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function customer()
    {
        // Assuming you have a Customer model, you might need to adjust the class path according to your actual model structure
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }

    public function transactions() {
        return $this->hasMany(JobsiteTransaction::class, 'jobsite_id', 'jobsite_id');
    }

    public function proposal() 
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'proposal_id');
    }
    // Add other necessary methods below. For example, if there are other relationships, scopes, or helper methods specific to job sites, define them here.
}