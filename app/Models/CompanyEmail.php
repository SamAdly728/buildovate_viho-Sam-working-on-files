<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyEmail extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'company_email';

    /**
     * @var string
     */
    protected $primaryKey = 'company_email_id';

    /**
     * @var bool
     */
    public $timestamps = false;
}
