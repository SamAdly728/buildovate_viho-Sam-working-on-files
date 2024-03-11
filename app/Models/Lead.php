<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'leads';
    protected $primaryKey = 'lead_id';
    public $timestamps = true; // Since you have a custom `created_on` and no updated_on field
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at'; 

    protected $fillable = [
        'cust_id',
        'company_id',
        'opportunity_title',
        'street_address',
        'city',
        'state',
        'zipcode',
        'opportunity_phone',
        'status',
        'description',
        'cost_of_lead',
        'stage_id',
        'stage_date',
        'reminder',
        'followup',
        'drip',
        'created_by',
        'updated_by',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }

    public function leadCustomer(){
        return $this->hasOne(Customer::class, 'cust_id', 'cust_id');
    }

    public function salesPeople() {
        return $this->hasMany(LeadAssignment::class, 'lead_id', 'lead_id');
    }  
    
    public function jobTypes() {
        return $this->hasMany(LeadJobtype::class, 'lead_id', 'lead_id');
    }

    public function tags() {
        return $this->hasMany(LeadTag::class, 'lead_id', 'lead_id');
    }

    public function sources() {
        return $this->hasMany(LeadSource::class, 'lead_id', 'lead_id');
    }

    public function proposals(){
        return $this->hasMany(Proposal::class, 'lead_id', 'lead_id');
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class,'stage_id', 'id');
    }

}