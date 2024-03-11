<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentAssignment extends Model
{
    use HasFactory;


    /**
     * @var string
     */
    protected $table = 'appointment_assignment';

    /**
     * @var string
     */
    protected $primaryKey = 'appointment_assignment_id';

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appointment_id', 
        'user_id', 
        'updated_at', 
        'created_at', 
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
}
