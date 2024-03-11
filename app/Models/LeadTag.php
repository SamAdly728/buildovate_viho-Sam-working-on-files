<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadTag extends Model
{
    use HasFactory;

    protected $table = 'lead_tags';
    protected $primaryKey = 'lead_tags_id';

    protected $fillable = [
        'lead_id',
        'tags_id'
    ];

    public $timestamps = false;

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'lead_id');
    }
    
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tags_id', 'tags_id');
    }
}
