<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserPortfolioFolder extends Model
{
    use HasFactory;
//    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'users_portfolio_folder';
    /**
     * @var string
     */
    protected $primaryKey = 'portfolio_folder_id';
}