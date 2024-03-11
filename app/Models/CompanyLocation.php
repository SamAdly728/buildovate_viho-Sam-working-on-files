<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    use HasFactory;

    protected $table = 'company_location';
    protected $primaryKey = 'company_location_id';

    protected $fillable = [
        'company_id',
        'location_address',
        'location_street',
        'location_city',
        'location_zipcode',
        'is_primary',
        'status',
        'added_by',
        'updated_by'
    ];

    public $timestamps = false;

    /**
     * Get the company associated with the location.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    /**
     * Relationship with User for 'added_by'.
     */
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    /**
     * Relationship with User for 'updated_by'.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
