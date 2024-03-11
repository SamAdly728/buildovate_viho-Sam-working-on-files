<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserFileFolder extends Model
{
    use HasFactory;
//    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'users_file_folder';
    /**
     * @var string
     */
    protected $primaryKey = 'file_folder_id';

//    /**
//     * @var string[]
//     */
//    protected array $dates = ['deleted_at'];

    protected $fillable = ['folder_name'];
}