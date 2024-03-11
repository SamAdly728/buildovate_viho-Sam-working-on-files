<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateFieldRule extends Model
{
    use HasFactory;

    protected $table = 'estimate_field_rules';
    protected $primaryKey = 'estimate_field_rule_id';

    public $timestamps = false;

    protected $fillable = [
        'estimate_field_id',
        'action',
        'operation',
        'operation_field_id',
        'operation_value'
    ];

    public function estimateField()
    {
        return $this->belongsTo(EstimateField::class, 'estimate_field_id', 'estimate_field_id');
    }

    public function fieldRuleLogics() {
        return $this->hasMany(EstimateFieldRuleLogic::class, 'estimate_field_rule_id', 'estimate_field_rule_id');
    }

}
