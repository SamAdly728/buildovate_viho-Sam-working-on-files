<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProUser extends Model
{
    use HasFactory;

    protected $table = 'pro_users';

    protected $primaryKey = 'pro_id';

    protected $hidden = [
        'password',
        'token',
        'token_created_at'
    ];

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'business_name',
        'business_phone',
        'cell_phone',
        'business_email',
        'password',
        'hear_from',
        'business_website',
        'street',
        'city',
        'state',
        'zipcode',
        'profile_image',
        'business_image',
        'is_licensed',
        'license_number',
        'status',
        'active_since',
        'occupation',
        'added_by_id'
    ];


    public function selected_specialties() 
    {
        return $this->hasMany(ProUserSpecialty::class, 'pro_id', 'pro_id')->where('is_active', 1);
    }
}
