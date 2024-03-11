<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    
    protected $table = 'lib_stage';

    protected $fillable = [
        'name',
        'title',
        'created_at',
        'updated_at',
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}