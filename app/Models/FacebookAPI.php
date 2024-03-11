<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookAPI extends Model
{
    use HasFactory;
    protected $table = 'facebook_api';
    protected $primaryKey = 'id';
}
