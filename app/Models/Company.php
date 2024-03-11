<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'company_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'logo',
        'company_name',
        'industry',
        'license_number',
        'federal_tax_id',
        'timezone',
        'date_format',
        'time_format',
        'first_day',
        'status'
    ];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user associated with the company.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the company leads associated with the company.
     */
    public function companyLeads() {
        return $this->hasMany(CompanyLead::class, 'company_id', 'company_id');
    }
    
    public function leads() {
        return $this->belongsToMany(Lead::class, 'company_leads', 'company_id', 'lead_id');
    }

    /**
     * Get the company useres associated with the company.
     */
    public function companyUsers()
    {
        return $this->hasMany(CompanyUser::class, 'company_id', 'company_id');
    }

    
    /**
     * Get the company customers associated with the company.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'company_id', 'company_id');
    }

    /**
     * Get the company tag associated with the company.
     */
    public function companyTags()
    {
        return $this->hasMany(Tag::class, 'company_id', 'company_id');
    }

    /**
     * Get the company source associated with the company.
     */
    public function companySources()
    {
        return $this->hasMany(Source::class, 'company_id', 'company_id');
    }

    /**
     * Get the company job type associated with the company.
     */
    public function companyJobTypes()
    {
        return $this->hasMany(JobType::class, 'company_id', 'company_id');
    }

    public function primaryLocation()
    {
        return $this->hasOne(CompanyLocation::class, 'company_id', 'company_id')
                    ->where('is_primary', 1);
    }

    public function primaryNumber()
    {
        return $this->hasOne(CompanyNumber::class, 'company_id', 'company_id')
                    ->where('is_primary', 1);
    }

    public function primaryEmail()
    {
        return $this->hasOne(CompanyEmail::class, 'company_id', 'company_id')
                    ->where('is_primary', 1);
    }

    public function primaryWebsite()
    {
        return $this->hasOne(CompanyWebsite::class, 'company_id', 'company_id')
                    ->where('is_primary', 1);
    }
}
