<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateFieldRuleLogic extends Model
{
    use HasFactory;

    protected $table = 'estimate_field_rule_logics';
    protected $primaryKey = 'estimate_field_rule_logic_id';

    public $timestamps = false;

    protected $fillable = [
        'estimate_field_rule_id',    
        'connecting_label',
        'connecting_field_id',
        'connecting_value',
        'connecting_value_display',
        'condition',
        'logic',
        'placement'
    ];

    public function estimateFieldRule()
    {
        return $this->belongsTo(EstimateFieldRule::class, 'estimate_field_rule_id', 'estimate_field_rule_id');
    }

}
