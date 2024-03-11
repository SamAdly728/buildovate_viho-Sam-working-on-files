<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHours extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'company_hours';

    /**
     * @var string
     */
    protected $primaryKey = 'company_hours_id';

    /**
     * @var bool
     */
    public $timestamps = false;
}
