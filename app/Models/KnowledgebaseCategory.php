<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgebaseCategory extends Model
{
    use HasFactory;

    public static function get_all()
    {
        return self::select('id','title')
                ->orderBy('id','asc')
                ->get();
    }

    public static function get_name($id)
    {
        $categ = self::select('title')
                ->where('id',$id)
                ->first();
        return $categ->title;
    }
}
