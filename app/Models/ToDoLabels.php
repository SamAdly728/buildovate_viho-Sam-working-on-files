<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoLabels extends Model
{
    use HasFactory;
    
    protected $table = 'todo_labels';

    protected $fillable = [
        'todo_id',
        'user_id',
        'label_id',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function todo()
    {
        return $this->belongsTo(ToDo::class);
    }

    public function label()
    {
        return $this->belongsTo(Label::class,"user_id");
    }
}
