<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{
    use HasFactory;

    protected $table = 'lead_sources';
    protected $primaryKey = 'lead_source_id';

    protected $fillable = [
        'lead_id',
        'source_id'
    ];

    public $timestamps = false;

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'lead_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'source_id');
    }
}
