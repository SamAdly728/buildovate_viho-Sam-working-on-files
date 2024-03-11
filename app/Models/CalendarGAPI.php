<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarGAPI extends Model
{
    protected $table = 'calendar_gapi';
    protected $primaryKey = 'id';
    use HasFactory;
}
