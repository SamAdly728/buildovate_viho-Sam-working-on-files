<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateFieldOption extends Model
{
    use HasFactory;

    protected $table = 'estimate_field_options';
    protected $primaryKey = 'estimate_field_option_id';
    public $timestamps = false; // Assuming no timestamps are used in this table

    protected $fillable = [
        'estimate_field_id',
        'label',
        'value',
        'img_url',
        'attached_item'
    ];

    public function estimateField()
    {
        return $this->belongsTo(EstimateField::class, 'estimate_field_id', 'estimate_field_id');
    }

    public function attachedItem()
    {
        return $this->belongsTo(CostItem::class, 'attached_item', 'cost_item_id');
    }

}
