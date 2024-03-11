<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'source';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'source_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_name',
        'user_id',
        'company_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the company that owns the job type.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    /**
     * Get the user that created the job type.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
