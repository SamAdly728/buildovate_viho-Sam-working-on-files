<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;
    
    protected $table = 'lib_label';

    protected $fillable = [
        'title',
        'color',
        'created_at',
        'updated_at',
    ];
}
