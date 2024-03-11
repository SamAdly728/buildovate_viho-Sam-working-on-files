<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name', 
        'email', 
        'profile_picture', 
        'created_on', 
        'first_name', 
        'last_name', 
        'phone', 
        'status',
        'role_id'
    ];

    public function credentials() {
        return $this->hasOne(UserCredential::class, 'user_id', 'user_id');
    }

    public function ownedCompany() {
        return $this->hasOne(Company::class, 'user_id', 'user_id');
    }
    
    public function partOfCompany() {
        return $this->hasMany(CompanyUser::class, 'user_id', 'user_id');
    }

    function canJoinRoom($roomId): bool {
        return true;
    }
    
}
