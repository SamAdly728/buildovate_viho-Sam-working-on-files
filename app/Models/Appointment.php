<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'appointment';

    /**
     * @var string
     */
    protected $primaryKey = 'appointment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'street', 
        'city', 
        'state', 
        'zipcode', 
        'description', 
        'date', 
        'attachment', 
        'created_at', 
        'color', 
        'Meeting_date', 
        'start_date', 
        'end_date', 
        'entityType', 
        'entityId', 
        'reminder_sms', 
        'reminder_email', 
        'assignedToUserId', 
        'stage', 
        'created_by',
        'appointedBy',
        'updated_by'
    ];

    public function appointmentAssignment()
    {
        return $this->hasMany(AppointmentAssignment::class, 'appointment_id', 'appointment_id');
    }
}
