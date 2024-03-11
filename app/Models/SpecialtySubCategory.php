<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialtySubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link_specialty_category_id',
        'is_active'
    ];


    public function specialties() 
    {
        return $this->hasMany(Specialty::class, 'link_specialty_sub_category_id', 'id')->where('is_active', 1);
    }
}
