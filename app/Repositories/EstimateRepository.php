<?php

namespace App\Repositories;

use App\Models\Estimate;
use App\Models\EstimateField;
use App\Models\EstimateFieldOption;
use App\Models\EstimateFieldRule;
use App\Models\EstimateFieldRuleLogic;
use DB; // Import the DB facade for database transactions

class EstimateRepository 
{

    public function getAll($companyId)
    {
        return Estimate::where('company_id', $companyId)
                       ->get();
    }

    public function get($id)
    {
        return Estimate::with(['createdBy', 'updatedBy', 'estimateFields' => function($query) {
            $query->orderBy('sequence', 'asc'); 
        }, 'estimateFields.estimateFieldOptions.attachedItem', 'estimateFields.fieldRules.fieldRuleLogics'])
        ->where('estimate_id', $id)
        ->first();
    }
    

    public function add($data, $companyId, $user_id, array $estimateFieldsData)
    {
        DB::beginTransaction();
    
        try {
            $estimate = new Estimate;
            $estimate->fill($data);
            $estimate->company_id = $companyId;
            $estimate->created_by = $user_id;
            $estimate->save();
    
            $sequence = 1;
            $estimatedFieldIds = [];
            $pendingFieldLogics = [];
            $pendingFieldOperations = [];
            foreach ($estimateFieldsData as $fieldData) {
                $unqId = $fieldData['id'];
                $fieldData['sequence'] = $sequence;

                $field = $estimate->estimateFields()->create($fieldData);
                $estimatedFieldIds[$unqId] = $field->estimate_field_id;
                $sequence++;

                if (isset($fieldData['fieldOptions']) && is_array($fieldData['fieldOptions'])) {
                    foreach ($fieldData['fieldOptions'] as $option) {
                        $field->estimateFieldOptions()->create($option);
                    }
                }

                
                if (isset($fieldData['fieldRules']) && is_array($fieldData['fieldRules'])) {
                    
                    foreach ($fieldData['fieldRules'] as $rule) {
                        if($rule['action'] === 'calculate'){
                            if (array_key_exists($rule['operation_field_id'], $estimatedFieldIds)) {
                                $rule['operation_field_id'] = $estimatedFieldIds[$rule['operation_field_id']];
                                $fieldRule = $field->fieldRules()->create($rule);

                                foreach ($rule['logics'] as $logic) {
                                    if (array_key_exists($logic['connecting_field_id'], $estimatedFieldIds)) {
                                        $logic['connecting_field_id'] = $estimatedFieldIds[$logic['connecting_field_id']];
                                        $fieldRule->fieldRuleLogics()->create($logic);
                                    } else {
                                        $pendingFieldLogics[] = [
                                            'rule' => $fieldRule,
                                            'logic' => $logic
                                        ];
                                    }
                                }
                            }else{
                                $pendingFieldOperations[] = [
                                    'field' => $field,
                                    'rule' => $rule
                                ];
                            }
                        }else{
                            $fieldRule = $field->fieldRules()->create($rule);

                            foreach ($rule['logics'] as $logic) {
                                if (array_key_exists($logic['connecting_field_id'], $estimatedFieldIds)) {
                                    $logic['connecting_field_id'] = $estimatedFieldIds[$logic['connecting_field_id']];
                                    $fieldRule->fieldRuleLogics()->create($logic);
                                } else {
                                    $pendingFieldLogics[] = [
                                        'rule' => $fieldRule,
                                        'logic' => $logic
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            foreach ($pendingFieldOperations as $pending) {
                if (array_key_exists($pending['rule']['operation_field_id'], $estimatedFieldIds)) {
                    $pending['rule']['operation_field_id'] = $estimatedFieldIds[$pending['rule']['operation_field_id']];
                    $fieldRule = $pending['field']->fieldRules()->create($pending['rule']);

                    foreach ($pending['rule']['logics'] as $logic) {
                        if (array_key_exists($logic['operation_field_id'], $estimatedFieldIds)) {
                            $logic['operation_field_id'] = $estimatedFieldIds[$logic['operation_field_id']];
                            $fieldRule->fieldRuleLogics()->create($logic);
                        } 
                    }
                }
            }

            foreach ($pendingFieldLogics as $pending) {
                if (array_key_exists($pending['logic']['connecting_field_id'], $estimatedFieldIds)) {
                    $pending['logic']['connecting_field_id'] = $estimatedFieldIds[$pending['logic']['connecting_field_id']];
                    $pending['rule']->fieldRuleLogics()->create($pending['logic']);
                }
            }

            DB::commit();
            return ['success' => true, 'data' => $estimate];
        } catch (\Exception $e) {
            DB::rollBack();
            // Return a response indicating failure
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }    

    public function edit($id, $data, $user_id, array $estimateFieldsData)
    {
        DB::beginTransaction();

        try {
            $estimate = Estimate::where('estimate_id', $id)->first();

            if ($estimate) {
                $estimate->fill($data);
                $estimate->updated_by = $user_id;
                $estimate->save();

                //(START) DELETING ALL FIELDS THATS REMOVED FROM THE FORM
                $currentFieldIds = $estimate->estimateFields->pluck('estimate_field_id')->toArray();
                $updatedFieldIds = array_column($estimateFieldsData, 'estimate_field_id');
                $fieldsToDelete = array_diff($currentFieldIds, $updatedFieldIds);

                foreach ($fieldsToDelete as $fieldId) {
                    EstimateField::where('estimate_field_id', $fieldId)->delete();
                }
                //(END) 

                $sequence = 1;
                $estimatedFieldIds = [];
                $pendingFieldLogics = [];
                $pendingFieldOperations = [];
                foreach ($estimateFieldsData as $fieldData) {
                    $unqId = $fieldData['id'];
                    $fieldData['sequence'] = $sequence;

                    if (isset($fieldData['estimate_field_id'])) {
                        $fieldId = $fieldData['estimate_field_id'];
                        $field = EstimateField::with(['fieldRules.fieldRuleLogics', 'estimateFieldOptions'])->find($fieldId);
                        $field->update($fieldData);
                    }else{
                        $field = $estimate->estimateFields()->create($fieldData);
                    }
                    $estimatedFieldIds[$unqId] = $field->estimate_field_id;
                    $sequence++;

                    //(OPTION START) Create, updating and deleting
                    if (isset($fieldData['fieldOptions']) && is_array($fieldData['fieldOptions'])) {
                        
                        //(START) DELETING ALL OPTIONS THATS REMOVED FROM THE FIELD OPTIONS
                        $currentOptionIds = $field->estimateFieldOptions->pluck('estimate_field_option_id')->toArray();
                        $updatedOptionIds = array_column($fieldData['fieldOptions'], 'estimate_field_option_id');
                        $optionsToDelete = array_diff($currentOptionIds, $updatedOptionIds);
                        
                        foreach ($optionsToDelete as $optionId) {
                            EstimateFieldOption::where('estimate_field_option_id', $optionId)->delete();
                        }
                        //(END) 

                        foreach ($fieldData['fieldOptions'] as $option) {
                            if(isset($option['estimate_field_option_id'])){
                                $fieldOption = EstimateFieldOption::find($option['estimate_field_option_id']);
                                $fieldOption->update($option);
                            }else{
                                $field->estimateFieldOptions()->create($option);
                            }
                        }
                    }
                    //(OPTION START)

                    
                    //(RULE START) Create, updating and deleting
                    if (isset($fieldData['fieldRules']) && is_array($fieldData['fieldRules'])) {
                        
                        //(START) DELETING ALL RULES THATS REMOVED FROM THE FIELD RULES
                        $currentRuleIds = $field->estimateFieldOptions->pluck('estimate_field_rule_id')->toArray();
                        $updatedRuleIds = array_column($fieldData['fieldRules'], 'estimate_field_rule_id');
                        $rulesToDelete = array_diff($currentRuleIds, $updatedRuleIds);
                        
                        foreach ($rulesToDelete as $ruleId) {
                            EstimateFieldRule::where('estimate_field_rule_id', $ruleId)->delete();
                        }
                        //(END) 

                        foreach ($fieldData['fieldRules'] as $rule) {
                            if($rule['action'] === 'calculate'){
                                if (array_key_exists($rule['operation_field_id'], $estimatedFieldIds)) {
                                    $rule['operation_field_id'] = $estimatedFieldIds[$rule['operation_field_id']];
                                    $fieldRule = null;
                                    if(isset($rule['estimate_field_rule_id'])){
                                        $fieldRule = EstimateFieldRule::find($rule['estimate_field_rule_id']);
                                        $fieldRule->update($rule);
                                    }else{
                                        $fieldRule = $field->fieldRules()->create($rule);
                                    }

                                    //(RULE LOGIC START) Create, updating and deleting
                                    if (isset($rule['logics']) && is_array($rule['logics'])) {
                                    
                                        //(START) DELETING ALL RULE LOGICS THATS REMOVED FROM THE RULE LOGICS
                                        $currentLogicIds = $field->estimateFieldOptions->pluck('estimate_field_rule_logic_id')->toArray();
                                        $updatedLogicIds = array_column($rule['logics'], 'estimate_field_rule_logic_id');
                                        $logicsToDelete = array_diff($currentLogicIds, $updatedLogicIds);
                                        
                                        foreach ($logicsToDelete as $logicId) {
                                            EstimateFieldRuleLogic::where('estimate_field_rule_logic_id', $logicId)->delete();
                                        }
                                        //(END) 
                                        
                                        foreach ($rule['logics'] as $logic) {
                                            if (array_key_exists($logic['connecting_field_id'], $estimatedFieldIds)) {
                                                $logic['connecting_field_id'] = $estimatedFieldIds[$logic['connecting_field_id']];
                                                
                                                if(isset($logic['estimate_field_rule_logic_id'])){                                           
                                                    $fieldRuleLogic = EstimateFieldRuleLogic::find($logic['estimate_field_rule_logic_id']);
                                                    $fieldRuleLogic->update($logic);
                                                }else{
                                                    $fieldRule->fieldRuleLogics()->create($logic);
                                                }
                                            } else {
                                                $pendingFieldLogics[] = [
                                                    'rule' => $fieldRule,
                                                    'logic' => $logic
                                                ];
                                            }
                                        }
                                    }        
                                    //(RULE LOGIC END)

                                }else{
                                    $pendingFieldOperations[] = [
                                        'field' => $field,
                                        'rule' => $rule
                                    ];
                                }
                            }else{

                                //(RULE LOGIC START) for not calculation
                                $fieldRule = null;
                                if(isset($rule['estimate_field_rule_id'])){
                                    $fieldRule = EstimateFieldRule::find($rule['estimate_field_rule_id']);
                                    $fieldRule->update($rule);
                                }else{
                                    $fieldRule = $field->fieldRules()->create($rule);
                                }

                                if (isset($rule['logics']) && is_array($rule['logics'])) {
                                    
                                    //(START) DELETING ALL RULE LOGICS THATS REMOVED FROM THE RULE LOGICS
                                    $currentLogicIds = $field->estimateFieldOptions->pluck('estimate_field_rule_logic_id')->toArray();
                                    $updatedLogicIds = array_column($rule['logics'], 'estimate_field_rule_logic_id');
                                    $logicsToDelete = array_diff($currentLogicIds, $updatedLogicIds);
                                    
                                    foreach ($logicsToDelete as $logicId) {
                                        EstimateFieldRuleLogic::where('estimate_field_rule_logic_id', $logicId)->delete();
                                    }
                                    //(END) 
                                    
                                    foreach ($rule['logics'] as $logic) {
                                        if (array_key_exists($logic['connecting_field_id'], $estimatedFieldIds)) {
                                            $logic['connecting_field_id'] = $estimatedFieldIds[$logic['connecting_field_id']];
                                            
                                            if(isset($logic['estimate_field_rule_logic_id'])){                                           
                                                $fieldRuleLogic = EstimateFieldRuleLogic::find($logic['estimate_field_rule_logic_id']);
                                                $fieldRuleLogic->update($logic);
                                            }else{
                                                $fieldRule->fieldRuleLogics()->create($logic);
                                            }
                                        } else {
                                            $pendingFieldLogics[] = [
                                                'rule' => $fieldRule,
                                                'logic' => $logic
                                            ];
                                        }
                                    }
                                }
                                //(RULE LOGIC END)
                            }
                        }
                    }
                    //(RULE END)

                }

                foreach ($pendingFieldOperations as $pending) {
                    if (array_key_exists($pending['rule']['operation_field_id'], $estimatedFieldIds)) {
                        $pending['rule']['operation_field_id'] = $estimatedFieldIds[$pending['rule']['operation_field_id']];
                        $fieldRule = $pending['field']->fieldRules()->create($pending['rule']);
    
                        foreach ($pending['rule']['logics'] as $logic) {
                            if (array_key_exists($logic['operation_field_id'], $estimatedFieldIds)) {
                                $logic['operation_field_id'] = $estimatedFieldIds[$logic['operation_field_id']];
                                $fieldRule->fieldRuleLogics()->create($logic);
                            } 
                        }
                    }
                }
    
                foreach ($pendingFieldLogics as $pending) {
                    if (array_key_exists($pending['logic']['connecting_field_id'], $estimatedFieldIds)) {
                        $pending['logic']['connecting_field_id'] = $estimatedFieldIds[$pending['logic']['connecting_field_id']];
                        $pending['rule']->fieldRuleLogics()->create($pending['logic']);
                    }
                }
                
                DB::commit();
                return ['success' => true, 'data' => $estimate];
            } else {
                throw new \Exception("Estimate not found.");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Consider logging the error here
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }


    public function updateFavorite($id, $favoriteValue, $user_id)
    {
        DB::beginTransaction();

        try {
            $estimate = Estimate::find($id);
            if ($estimate) {
                // Update the 'favorite' column
                $estimate->favorite = $favoriteValue;
                $estimate->updated_by = $user_id;
                $estimate->save();

                DB::commit();
                return ['success' => true, 'data' => $estimate];
            } else {
                return ['success' => false, 'error' => 'Estimate not found.'];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, perhaps log it or return an error message
            return ['success' => false, 'error' => 'Failed to update favorite status.'];
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $estimate = Estimate::find($id);
            if ($estimate) {
                $estimate->estimateFields()->delete();
                $estimate->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
