<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoMembers extends Model
{
    use HasFactory;
    
    protected $table = 'todo_members';

    protected $fillable = [
        'todo_id',
        'user_id',
        'owner',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function todo()
    {
        return $this->belongsTo(ToDo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
}
