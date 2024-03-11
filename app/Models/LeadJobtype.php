<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadJobtype extends Model
{
    use HasFactory;

    protected $table = 'lead_job_types';
    protected $primaryKey = 'lead_job_id';

    protected $fillable = [
        'lead_id',
        'job_type_id'
    ];

    public $timestamps = false;

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'lead_id');
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'job_type_id');
    }
}
