<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOverhead extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'company_monthly_overhead';

    /**
     * @var string
     */
    protected $primaryKey = 'company_monthly_overhead_id';

    /**
     * @var bool
     */
    public $timestamps = false;
}
