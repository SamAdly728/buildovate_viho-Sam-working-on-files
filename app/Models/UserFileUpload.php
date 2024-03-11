<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFileUpload extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'users_file_upload';
    /**
     * @var string
     */
    protected $primaryKey = 'user_file_upload_id';

    /**
     * @var string[]
     */
    protected array $dates = ['deleted_at'];
}
