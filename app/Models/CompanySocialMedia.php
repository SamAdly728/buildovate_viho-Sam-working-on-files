<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySocialMedia extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'company_social_media';

    /**
     * @var string
     */
    protected $primaryKey = 'company_social_media_id';

    /**
     * @var bool
     */
    public $timestamps = false;
}
