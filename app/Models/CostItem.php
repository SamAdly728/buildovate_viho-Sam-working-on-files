<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostItem extends Model
{
    use HasFactory;

    protected $table = 'cost_items';
    protected $primaryKey = 'cost_item_id';

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'internal_notes',
        'unit_cost',
        'unit',
        'unit_quantity',
        'unit_mark_up',
        'unit_mark_up_type',
        'labor',
        'material',
        'quantity_included',
        'tiered_price_included',
        'owner_price_included',
        'discount',
        'discount_type',
        'item_photo_url',
        'status',
        'created_by',
        'updated_by',
    ];

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true; // Since you have a custom `created_on` and no updated_on field
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at'; 

    /**
     * Get the company associated with the cost item.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    /**
     * Get the cost item create by.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }    

    /**
     * Get the cost item create by.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }
}
