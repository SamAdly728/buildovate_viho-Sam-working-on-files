<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyFileUpload extends Model
{
    use HasFactory;


    protected $fillable = [
        'company_id',
        'file_name',
        'file_type',
        'file_size',
        's3_path'
    ];
}
