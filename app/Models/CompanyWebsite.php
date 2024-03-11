<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyWebsite extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'company_website';

    /**
     * @var string
     */
    protected $primaryKey = 'company_website_id';

    /**
     * @var bool
     */
    public $timestamps = false;
}
