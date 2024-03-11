<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateField extends Model
{
    use HasFactory;

    protected $table = 'estimate_fields';
    protected $primaryKey = 'estimate_field_id';
    public $timestamps = false; // Assuming no timestamps are used in this table

    protected $fillable = [
        'estimate_id',
        'field_type',
        'field_label',
        'hide_label',
        'instruction',
        'hide_instruction',
        'default_value',
        'visibility',
        'sequence'
    ];

    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'estimate_id', 'estimate_id');
    }

    public function estimateFieldOptions() {
        return $this->hasMany(EstimateFieldOption::class, 'estimate_field_id', 'estimate_field_id');
    }

    public function fieldRules() {
        return $this->hasMany(EstimateFieldRule::class, 'estimate_field_id', 'estimate_field_id');
    }

    public static function boot(){
        parent::boot();

        static::deleting(function ($estimateField) {
            foreach ($estimateField->fieldRules as $fieldRule) {
                $fieldRule->fieldRuleLogics()->delete();
                $fieldRule->delete();
            }

            $estimateField->estimateFieldOptions()->delete();
        });
    }
    

}
