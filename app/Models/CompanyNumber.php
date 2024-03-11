<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyNumber extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'company_number';

    /**
     * @var string
     */
    protected $primaryKey = 'company_number_id';

    /**
     * @var bool
     */
    public $timestamps = false;

    protected $casts = [
        'is_primary' => 'boolean',
        'status' => 'boolean',
    ];

    protected $fillable = [
        'company_id', 
        'number_title', 
        'company_number', 
        'is_primary', 
        'status', 
        'added_by', 
        'updated_by'
    ];
}
