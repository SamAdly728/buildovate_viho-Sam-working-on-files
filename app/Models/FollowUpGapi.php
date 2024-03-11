<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpGapi extends Model
{
    use HasFactory;

    protected $table = 'followup_gapi';

    protected $fillable = [
        'user_id',
        'code',
        'access_token', 
        'expires_in',
        'refresh_token',
        'token_type',
        'created_at',
        'updated_at',
    ];

    
}
