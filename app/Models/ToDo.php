<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entityId',
        'entityType',
        'title',
        'description',
        'start_date',
        'due_date',
        'due_time',
        'reminder',
        'reminder_date',
        'labels',
        'is_completed',
        'is_deleted'
    ];

    public function todoActivities()
    {
        return $this->hasMany(ToDoActivities::class, 'todo_id', 'id');
    }    
    public function toDoMembers()
    {
        return $this->hasMany(ToDoMembers::class, 'todo_id', 'id');
    } 
    public function toDoAttachments()
    {
        return $this->hasMany(ToDoAttachments::class, 'todo_id', 'id');
    }
    public function toDoLabels()
    {
        return $this->hasMany(ToDoLabels::class, 'todo_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
}
