<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProUserSpecialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'pro_id',
        'specialty_id',
        'is_active'
    ];

    public function specialtyInfo() 
    {
        return $this->hasOne(Specialty::class, 'id', 'specialty_id');
    }
}
