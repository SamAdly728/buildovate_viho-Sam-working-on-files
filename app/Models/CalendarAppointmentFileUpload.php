<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarAppointmentFileUpload extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'calendar_upload_files';

    /**
     * @var string
     */
    protected $primaryKey = 'file_id';
}
