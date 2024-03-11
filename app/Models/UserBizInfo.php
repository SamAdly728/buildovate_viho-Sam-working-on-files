<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBizInfo extends Model
{
    use HasFactory;
    protected $table = 'users_business_information';
    protected $primaryKey = 'user_business_information_id';
}
