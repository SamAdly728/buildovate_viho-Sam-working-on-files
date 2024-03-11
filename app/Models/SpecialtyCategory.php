<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialtyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'img_path'
    ];

    public function sub_categories() 
    {
        return $this->hasMany(SpecialtySubCategory::class, 'link_specialty_category_id', 'id')->where('is_active', 1);
    }
}
