<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;

    protected $table = 'estimates';
    protected $primaryKey = 'estimate_id';
    public $timestamps = true; // Using the default 'created_at' and 'updated_at' fields

    protected $fillable = [
        'company_id',
        'title',
        'favorite',
        'created_by',
        'updated_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }

    public function estimateFields()
    {
        return $this->hasMany(EstimateField::class, 'estimate_id', 'estimate_id');
    }
}
