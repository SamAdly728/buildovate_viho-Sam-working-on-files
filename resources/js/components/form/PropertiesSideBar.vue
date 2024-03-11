<template>
    <div class="row properties-container m-0 p-0" v-if="isOpen">
      <a class="col-md-7 p-0" @click="closeProperties">

      </a>
      <div class="properties-content col-md-5 p-0">
        <div class="card d-flex flex-column" style="height: 100%;">
          <div class="pb-0 d-flex justify-content-between align-items-center" style="background-color: rgb(240, 240, 240);">
            <div>
                <label class="f-20 px-4 py-3 m-0 cursor-pointer header-pill" :class="{'active': activeTab === 'Properties'}" @click="toggleTab('Properties')">Properties</label>
                <label class="f-20 px-4 py-3 m-0 cursor-pointer header-pill" :class="{'active': activeTab === 'Rules'}" @click="toggleTab('Rules')">Rules</label>
            </div>
            <label class="cursor-pointer text-danger f-w-700 f-14 px-4 py-3 m-0 " @click="closeProperties">Close</label>
          </div>
          <div class="flex-grow-1 mt-3" style="overflow: auto;" id="field-options" v-if="activeTab === 'Properties'">

            <div class="px-4 mt-3">
                <div class="d-flex flex-row align-items-center gap-2">
                    <label class="f-14" style="width: 95px;">{{ fieldType == 'Form Header' ? 'Header Label:' : 'Field Label:'}}</label>
                    <input class="b-primary flex-grow-1 p-1 px-2 m-0" type="text"  v-model="fieldLabel" style="border-radius: 3px;">
                </div>
                
                <div class="d-flex flex-row align-items-center gap-2">
                    <label style="width: 95px;"></label>
                    <div class="checkbox checkbox-dark mt-2 ml-1" v-if="fieldType != 'Form Header'">
                        <input id="hide-label" type="checkbox" v-model="hideLabel">
                        <label class="mt-0 f-12 p-0 px-2" for="hide-label">Hide Label</label>
                    </div>
                </div>
            </div>
            
            <div class="px-4 mt-3">
                <div class="d-flex flex-row align-items-center gap-2">
                    <label class="f-14" style="width: 95px;">Instruction: </label>
                    <input class="b-primary flex-grow-1 p-1 px-2" type="text" v-model="instruction" style="border-radius: 3px;">
                </div>
                <div class="d-flex flex-row align-items-center gap-2">
                    <label style="width: 95px;"></label>
                    <div class="checkbox checkbox-dark mt-2 ml-1" v-if="fieldType != 'Form Header'">
                        <input id="hide-instuction" type="checkbox" v-model="hideInstruction">
                        <label class="mt-0 f-12 p-0 px-2" for="hide-instuction">Hide Instruction</label>
                    </div>
                </div>
            </div>

            <div class="px-4 mt-3">
                <div class="d-flex flex-row align-items-center gap-2">
                    <label class="f-14" style="width: 95px;">Visibility: </label>
                    <div class="d-flex gap-3">
                        <div class="radio radio-dark m-squar mt-2 ml-1">
                            <input id="show-field" type="radio" name="visibility" checked="" value="1" v-model="visibility">
                            <label class="mt-0" for="show-field">Visible</label>
                        </div>
                        <div class="radio radio-dark m-squar mt-2 ml-1">
                            <input id="hide-field" type="radio" name="visibility" value="0" v-model="visibility">
                            <label class="mt-0" for="hide-field">Hidden</label>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="px-4 mt-3">
                <div class="d-flex flex-row align-items-center gap-2">
                    <label class="f-14" style="width: 95px;">Mandatory: </label>
                    <div class="d-flex gap-3">
                        <div class="radio radio-dark m-squar mt-2 ml-1">
                            <input id="required-yes" type="radio" name="mandatory" checked="" value="1" v-model="mandatory">
                            <label class="mt-0" for="required-yes">Yes</label>
                        </div>
                        <div class="radio radio-dark m-squar mt-2 ml-1">
                            <input id="required-no" type="radio" name="mandatory" value="0" v-model="mandatory">
                            <label class="mt-0" for="required-no">No</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Option for radio picker! -->
            <div class="px-4 py-3" v-if="fieldType === 'Radio Style 1' || fieldType === 'Radio Style 2'">
                <div class="d-flex justify-content-between mb-2 align-items-center">
                    <label class="f-18">Options</label>
                    <a class="btn btn-outline-primary m-0 px-3 py-1" style="border-radius: 5px; width: auto;" @click="handleNewOption"><i class="icon-plus"></i> ADD</a>
                </div>
                <template v-for="(option, index) in options">
                    <div class="d-flex gap-2 mb-2 align-items-center">
                        <input class="flex-grow-1 b-primary" type="text" v-model="option.label" style="padding: 5px 15px; border-radius: 5px;">
                        <a class="btn btn-outline-danger" @click="handleRemoveAttachment(option.value)" v-if="option.attached_item && option.attached_item != null" style="width: 180px !important;">Remove Item</a>
                        <a class="btn btn-outline-primary" @click="handleSelectFromCalatog(option.value)"  v-else style="width: 180px !important;">Attach Item</a>
                        <a class="btn btn-outline-danger px-2 py-1 cursor-pointer" style="border-radius: 5px;" @click="handleDeleteOption(index)">
                            <i class="icon-trash f-20"></i>
                        </a>
                    </div>
                </template>
            </div>
            <!-- Option for radio picker! -->

            <!-- Option for color picker! -->
            <div class="px-4 py-3" v-if="fieldType === 'Color Picker'">
                <div class="d-flex justify-content-between mb-2 align-items-center">
                    <label class="f-18">Color Options</label>
                    <a class="btn btn-outline-primary m-0 px-3 py-1" style="border-radius: 5px; width: auto;" @click="handleNewOption"><i class="icon-plus"></i> ADD</a>
                </div>
                <div class="row m-0 p-0 b-primary p-3" style="border-radius: 5px;" v-if="toggleAddColor">
                    <div class="col-md-12 d-flex gap-3 mb-3 align-items-center flex-wrap">
                        <template v-for="(hexColor) in colorSelections">
                            <a class="option f-w-500 f-16 cursor-pointer"
                                v-if="!options.some(option => option.value === hexColor)" 
                                @click="handleNewColorPicked(hexColor)">
                                <div style="width: 25px; height: 25px;" :style="{'background-color' : hexColor}">

                                </div>
                            </a>
                        </template>
                    </div>
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            HEX: 
                            <input class="form-control mx-2 b-primary" type="text" style="width: 100px;" v-model="newHexColor"/>
                            <a class="btn btn-outline-primary m-0 px-3 py-1 float-right" style="border-radius: 5px; width: auto;" @click="handleAddColor">Add</a>
                        </div>
                        <a class="btn btn-outline-primary m-0 px-3 py-1 float-right" style="border-radius: 5px; width: auto;" @click="handlCloseColor">Close</a>
                    </div>
                </div>
                <div class="d-flex gap-3 mb-3 mt-3 align-items-center flex-wrap">
                    <template v-for="(option, index) in options">
                        <a class="option f-w-500 f-16 cursor-pointer">
                            <div style="width: 25px; height: 25px;" :style="{'background-color' : option.value}">

                            </div>
                            <span class="option-delete"  @click="handleDeleteOption(index)"><i class="icon-close"></i></span>
                        </a>
                    </template>
                </div>
            </div>
            <!-- Option for color picker! -->

            <div class="px-4 py-3" v-if="fieldType === 'Image Picker'">
                <div class="d-flex justify-content-between mb-2 align-items-center">
                    <label class="f-18">Image Options</label>
                    
                    <div class="d-flex p-2 gap-2">
                        <a class="btn btn-outline-primary" @click="handleNewOption">Upload Image</a>
                        <a class="btn btn-outline-primary">Select from Files</a>
                        <input type="file" @change="previewImage" accept="image/*" id="image-upload" style="display: none;">
                    </div>
                </div>
                <div class="d-flex gap-3 flex-wrap">
                    <template v-for="(option, index) in options">
                        <a class="option f-w-500 f-16 cursor-pointer" :class="{'active': selectOption === option.value}" @click="handleSelect(option.value)">
                            <div style="width: 180px; height: 180px;" class="d-flex flex-column p-2 align-items-center pb-0">
                                <div class="flex-grow-1 b-primary" style="width: 100%; max-height: 120px; overflow: hidden;">
                                    <img :src="option.img_url" alt="Option Image" style="width: 100%; height: auto;">
                                </div>
                                <input type="text" class="form-control m-2 p-2 b-primary" v-model="option.label"/>
                            </div>
                            <span class="option-delete"  @click="handleDeleteOption(index)"><i class="icon-close"></i></span>
                        </a>
                    </template>
                </div>
            </div>

            <div class="px-4 py-3" v-if="fieldType === 'Item Picker'">
                <div class="d-flex justify-content-between mb-2 align-items-center">
                    <label class="f-18">Item Picker Options</label>
                    
                    <div class="d-flex p-2 gap-2">
                        <a class="btn btn-outline-primary" @click="handleSelectFromCalatog(null)">Select from Catalog</a>
                    </div>
                </div>
                <div class="d-flex gap-3 flex-wrap">
                    <template v-for="(option, index) in options">
                        <a class="option f-w-500 f-16 cursor-pointer" :class="{'active': selectOption === option.value}" @click="handleSelect(option.value)">
                            <div style="width: 180px; height: 180px;" class="d-flex flex-column p-2 pb-0">
                                <div class="flex-grow-1 b-primary" style="width: 100%; max-height: 120px; overflow: hidden;">
                                    <img :src="option.img_url" alt="Option Image" style="width: 100%; height: auto;">
                                </div>
                                <div class="d-flex flex-column py-2" style="overflow: hidden;">
                                    <a class="f-12 f-w-700 truncate">{{ option.label }}</a>
                                    <a class="f-12">Builder Cost: $0.0</a>
                                    <a class="f-12">Owner Price: $0.0</a>
                                </div>
                            </div>
                            <span class="option-delete"  @click="handleDeleteOption(index)"><i class="icon-close"></i></span>
                        </a>
                    </template>
                </div>
            </div>

          </div>

          <!-- RULES -->
          <div class="flex-grow-1 mt-3" style="overflow: auto;" id="field-rules" v-else-if="activeTab === 'Rules'">
            <template v-for="(ruleExtra, index) in ruleExtras">
                <hr v-if="index != 0">
                <div class="row d-flex align-items-center m-0 p-0 px-2">
                    <div class="d-flex justify-content-between" style="width: 100%;">
                        <a class="f-18 f-w-700">{{ index === 0 ? '' : `${ruleExtra.logic} `}}IF THIS </a>
                        <a class="f-18 text-danger cursor-pointer" v-if="index != 0" @click="handleRemoveCondition(ruleExtra)"><i class="icofont icofont-ui-delete"></i></a>
                    </div>

                    <div class="col-md-4 mt-2 d-flex gap-2 flex-column">
                        <div class="d-flex align-items-center gap-1 my-1 ">
                            <label class="m-0 p-0">Field:</label>
                            <a class="badge badge-sm rounded-pill badge-primary m-0 p-1 cursor-pointer"><i class="icon-info"></i></a>
                        </div>
                        <select class="form-control flex-grow-1 b-primary" v-model="ruleExtra.field" @change="handleFieldChange(ruleExtra)" v-if="props.fields">
                            <option value="">Select Field</option>
                            <template v-for="field in props.fields">
                                <option :value="field.id" v-if="field.label !== 'Separator' && field.label !== 'Form Header'">{{ field.data.label }}</option>
                            </template>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mt-2 d-flex gap-2 flex-column">
                    <div class="d-flex align-items-center gap-1 my-1">
                        <label class="m-0 p-0">Condition:</label>
                        <a class="badge badge-sm rounded-pill badge-primary m-0 p-1 cursor-pointer"><i class="icon-info"></i></a>
                    </div>
                    <select class="form-control flex-grow-1  b-primary" v-model="ruleExtra.condition">
                        <template v-for="condition in ruleExtra.conditions">
                        <option :value="condition">{{ condition }}</option>
                        </template>
                    </select>
                    </div>

                    <div class="col-md-4 mt-2 d-flex gap-2 flex-column" v-if="ruleExtra.selectedField && !(noValueCondition.includes(ruleExtra.condition))">
                    <div class="d-flex align-items-center gap-1 my-1">
                        <label class="m-0 p-0">Value:</label>
                        <a class="badge badge-sm rounded-pill badge-primary m-0 p-1 cursor-pointer"><i class="icon-info"></i></a>
                    </div>
                    <select class="form-control flex-grow-1  b-primary" v-if="ruleExtra.selectedField.data.options && ruleExtra.selectedField.data.options.length != 0"  v-model="ruleExtra.value">
                        <option value="">Select Value</option>
                        <template v-for="option in ruleExtra.selectedField.data.options">
                            <option :value="option.value">{{ option.label }}</option>
                        </template>
                    </select>
                    <input type="number" class="form-control b-primary" v-else v-model="ruleExtra.value"/>    
                    </div>
                </div>
            </template>
            
            <div class="d-flex align-items-center justify-content-center mt-4 px-4">
                <div style="height: 1px;" class="bg-primary mr-5 flex-grow-1"></div>
                <a class="f-14 my-2 cursor-pointer f-w-700" @click="handleNewCondition('AND')">AND IF</a>
                <div style="height: 1px;" class="bg-primary mx-3 flex-grow-1"></div>
                <a class="f-14 my-2 cursor-pointer f-w-700" @click="handleNewCondition('OR')">OR IF</a>
                <div style="height: 1px;" class="bg-primary ml-5 flex-grow-1"></div>
            </div>

            <hr>

            <div class="row d-flex align-items-center m-0 p-0 px-4 pb-2 mt-2">
                <a class="f-18 f-w-700 m-0 p-0">THEN THIS </a>
                <div class="col-md-4 m-0 p-0">
                  <div class="d-flex align-items-center gap-1 my-1">
                    <label class="m-0 p-0">Do following action:</label>
                    <a class="badge badge-sm rounded-pill badge-primary m-0 p-1 cursor-pointer"><i class="icon-info"></i></a>
                  </div>
                  <select class="form-control flex-grow-1  b-primary" v-model="ruleAction">
                    <option value="show">Show</option>
                    <option value="hide">Hide</option>
                    <option value="calculate">Calculate</option>
                  </select>
                </div>
                <div class="col-md-4 m-0 p-0  px-2" v-if="ruleAction === 'calculate'">
                  <div class="d-flex align-items-center gap-1 my-1">
                    <label class="m-0 p-0">{{ capitalizeFirstLetter(ruleOperation) }} {{ ruleOperationExtra }}:</label>
                    <a class="badge badge-sm rounded-pill badge-primary m-0 p-1 cursor-pointer"><i class="icon-info"></i></a>
                  </div>
                  <div class="d-flex gap-1">
                    <select class="form-control flex-grow-1  b-primary" v-model="ruleOperation">
                        <option value="add">Add</option>
                        <option value="subtract">Subtract</option>
                        <option value="multiply">Multiply</option>
                        <option value="divide">Divide</option>
                    </select>
                    
                    <select class="form-control flex-grow-1  b-primary" v-model="ruleOperationExtra">
                        <option value="with">With</option>
                        <option value="by">By</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 m-0 p-0"  v-if="ruleAction === 'calculate' && ruleOperationExtra === 'with'">
                    <div class="d-flex align-items-center gap-1 my-1 ">
                        <label class="m-0 p-0">Field:</label>   
                        <a class="badge badge-sm rounded-pill badge-primary m-0 p-1 cursor-pointer"><i class="icon-info"></i></a>
                    </div>
                    <select class="form-control flex-grow-1 b-primary" v-model="operationField">
                        <option value="">Select Field</option>
                        <template v-for="field in props.fields">
                            <option :value="field.id" v-if="field.label !== 'Separator' && field.label !== 'Form Header' && field.id !== props.data.id">{{ field.data.label }}</option>
                        </template>
                    </select>
                </div>
                <div class="col-md-4 m-0 p-0"  v-else-if="ruleAction === 'calculate' && ruleOperationExtra === 'by'">
                    <div class="d-flex align-items-center gap-1 my-1 ">
                        <label class="m-0 p-0">Value:</label>   
                        <a class="badge badge-sm rounded-pill badge-primary m-0 p-1 cursor-pointer"><i class="icon-info"></i></a>
                    </div>
                    <input type="number" class="form-control b-primary" v-model="operationValue"/>    
                </div>
                <div class="m-0 p-0" :class="{'col-md-12': ruleId || ruleAction === 'calculate', 'col-md-4': !ruleId}">
                  <div class="d-flex align-items-center gap-1 my-1">
                    <label class="m-0 p-0" style="visibility: hidden;">:</label>
                  </div>
                  <div class="d-flex gap-1 justify-content-end pl-2">
                    <a class="btn btn-primary flex-grow-1" @click="handleAddRule">{{ ruleId ? 'Update' : 'Create' }} Rule</a>
                    <a class="btn btn-outline-primary" @click="handleClear" v-if="ruleId">Cancel</a>
                  </div>
                </div>
            </div>
            
            <hr>
            <div class="row d-flex align-items-center m-0 p-0 px-4 pb-2" v-if="rules.length != 0">
                <a class="f-18 f-w-700 m-0 p-0">RULE LIST</a>
                <template v-for="rule in rules">
                    <div class="px-3 py-2 b-primary mt-2 d-flex flex-column position-relative">
                        <div class="d-flex gap-2" style="position: absolute; right: 10px; top: 15px;">
                            <i class="icofont icofont-ui-edit text-success cursor-pointer f-18" @click="handleEditRule(rule)"></i>
                            <i class="icofont icofont-ui-delete text-danger cursor-pointer f-18" @click="handleDeleteRule(rule.id)"></i>
                        </div>
                        <label v-html="getRuleActionDefinition(rule)"></label>
                        <template v-for="(logic) in rule.logics">
                            <label v-html="getRuleDefinition(logic)"></label>
                        </template>
                    </div>
                </template>
            </div>
          <!-- END RULES -->
          </div>
        </div>
      </div>
    </div>

    <CostItemListModal 
        @selectedItems="handleSelectedCostItems"
        @selectedItem="handleSelectedCostItem"
        :reloadData="reloadCostItems"
        :selectedItems="items"/>

</template>
<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import CostItemListModal from '../modals/CostItemListModal.vue';

const page = usePage();
const props = defineProps({
    isOpen: {
        typeof: Boolean,
        default: false
    },
    data: {
        typeof: Object,
        default: {}
    },
    fields: {

    }
});
const emit = defineEmits(['onClose', 'onValueChange']);
const toggleAddColor = ref(false);
const fieldId = ref(''); 
const estimate_field_id = ref(null); 
const fieldType = ref(''); 
const fieldLabel = ref(''); 
const hideLabel = ref(false); 
const instruction = ref(''); 
const hideInstruction = ref(false); 
const visibility = ref(1); 
const mandatory = ref(0); 
const options = ref([]);
const rules = ref([]);
const colorSelections = window.colors;
const newHexColor = ref('');
const fileUrl = ref(null);
const reloadCostItems = ref(false);
const items = ref([]);
const activeTab = ref('Properties');

// RULES
const optionAttached = ref(null);
const ruleId = ref(null);
const ruleAction = ref('show');
const ruleOperation = ref('add');
const ruleOperationExtra = ref('with');
const operationField = ref('');
const operationValue = ref(0);
const noValueCondition = ['Is Empty', 'Is Not Empty'];
const globalConditions = ref(window.conditions);
const ruleExtras = ref([
  {
    id: uniqueId(),
    field: '',
    condition: '',
    conditions: globalConditions.value.number,
    value: '',
    selectedField: null
  }
]);


function closeProperties(){
    emit('onClose', false);
}

function handleFieldChange(extraField){
    let conditionsList = globalConditions.value.number;
    const selectedField = props.fields.find(field => field.id === extraField.field);
    const label = selectedField.label;
    
    if(label === 'Radio Style 1' || label === 'Radio Style 2' || label === 'Color Picker'  || label === 'Item Picker'){
        conditionsList = globalConditions.value.single;
    }else if(label === ''){
        conditionsList = globalConditions.value.multiple;
    }


    ruleExtras.value = ruleExtras.value.map(field => {
        if(field.id === extraField.id){
            return {
                ...field,
                conditions: conditionsList,
                selectedField: selectedField,
                value: ''
            }
        }else{
            return field;
        }
    });
}

function handleRemoveCondition(ruleCondition){
    ruleExtras.value = ruleExtras.value.filter(rule => rule.id !== ruleCondition.id);
}

function handleNewCondition(logic){
    ruleExtras.value.push({
        id: uniqueId(),
        field: '',
        condition: '',
        conditions: globalConditions.value.number,
        value: '',
        selectedField: null,
        logic: logic
    });
}

function clearConditions(){
    ruleExtras.value = [{
        field: '',
        condition: '',
        conditions: globalConditions.value.number,
        value: '',
        selectedField: null
    }];

    ruleAction.value = 'show';
    ruleOperation.value = 'add';
    operationField.value = '';
    ruleId.value = null;
}

function handleClear(){
    clearConditions();
}

function handleEditRule(rule){
    ruleId.value = rule.id;
    const action = rule.action;
    const operation = rule.operation;
    const operation_field_id = rule.operation_field_id;
    const operation_value = rule.operation_value;
    const logics = rule.logics;

    ruleAction.value = action;
    ruleOperation.value = action === 'calculate' ? operation : '';
    ruleOperationExtra.value = operation_field_id ? 'with' : 'by';
    operationField.value = action === 'calculate' ? operation_field_id : '';
    operationValue.value = action === 'calculate' ? operation_value : '';

    ruleExtras.value = [];
    logics.forEach(logic => {
        const selectedField = props.fields.find(field => field.id === logic.connecting_field_id);
        let conditionsList = globalConditions.value.number;
        const label = selectedField.label;
        
        if(label === 'Radio Style 1' || label === 'Radio Style 2' || label === 'Color Picker'  || label === 'Item Picker'){
            conditionsList = globalConditions.value.single;
        }else if(label === ''){
            conditionsList = globalConditions.value.multiple;
        }

        ruleExtras.value.push({
            id: logic.id,
            field: logic.connecting_field_id,
            condition: logic.condition,
            conditions: conditionsList,
            value: logic.connecting_value,
            selectedField: selectedField,
            logic: logic.logic
        });
    });
}

function handleDeleteRule(id){
    rules.value = rules.value.filter(rule => rule.id !== id);
}

function handleAddRule(){
    let rulesData = {
        id: ruleId.value ? ruleId.value : uniqueId(),
        action: ruleAction.value,
        operation: ruleAction.value === 'calculate' ? ruleOperation.value : '',
        operation_field_id: ruleAction.value === 'calculate' && ruleOperationExtra.value === 'with' ? operationField.value : '',
        operation_value: ruleAction.value === 'calculate' && ruleOperationExtra.value === 'by' ? operationValue.value : '',
        logics: []
    };

    let counter = 0;
    ruleExtras.value.forEach(ruleExtra => {
        if(ruleExtra.selectedField && ruleExtra.condition){
            counter++;

            const newRule = {
                id: ruleExtra.selectedField.id,
                connecting_label: ruleExtra.selectedField.data.label,
                connecting_field_id: ruleExtra.selectedField.id,
                condition: ruleExtra.condition,
                connecting_value: ruleExtra.value,
                connecting_value_display: ruleExtra.value ? getActualConnectingLabel(ruleExtra.selectedField, ruleExtra.value) : '',
                logic: ruleExtra.logic ? ruleExtra.logic : '',
                placement: counter
            };
            
            rulesData['logics'].push(newRule);
        }
    });

    if(rulesData['logics'].length !== 0){
        if(ruleId.value){
            rules.value = rules.value.map(rule => {
                if(rule.id === ruleId.value){
                    return rulesData;
                }else{
                    return rule;
                }
            });
        }else{
            rules.value.push(rulesData);
        }

        clearConditions();
    }else{
        console.log('Please add conditions first.');
    }
}

function getActualConnectingLabel(field, value){
    const fieldType = field.label;

    if(fieldType === 'Input Number'){
        return '';
    }else{
        return field.data.options ? field.data.options.find(f => f.value === value).label  : '';
    }
}

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function getRuleActionDefinition(rule){
    const operation = rule.operation;
    const action = rule.action;
    const opField = props.fields.filter(field => field.id === rule.operation_field_id);
    const opValue = rule.operation_value;
    const currenField = fieldLabel.value;

    if(action === 'calculate' && opField.length != 0){
        return capitalizeFirstLetter(operation) + ' <i>`' + currenField + '`</i> with <i>`' + opField[0].data.label + '`</i>';
    }else if(opValue){
        return capitalizeFirstLetter(operation) + ' <i>`' + currenField + '`</i> by <b>`' + formatCurrency(opValue) + '`</b>';
    }else{
        return capitalizeFirstLetter(rule.action) + ' <i>`' + currenField + '`</i>.'
    }
}

function getRuleDefinition(logic){
    const connecting_label = logic.connecting_label;
    const condition = mapCondition(logic.condition);
    const connecting_value = logic.connecting_value;
    const connecting_value_display = logic.connecting_value_display ? logic.connecting_value_display : logic.connecting_value;
    const ifString = logic.logic ? logic.logic + ' IF' : 'IF ';
    const valueDisplay = connecting_value_display ? '`' + connecting_value_display + '`': connecting_value;
    const displayeValue = noValueCondition.includes(logic.condition) ? '</span>' : ' to</span> ' + valueDisplay;

    const caption = '<span class="f-w-800 text-success">' + ifString + '</span> <i>`' + connecting_label + '`</i> <span class="text-muted">' + condition + ' ' + displayeValue;
    return capitalizeFirstLetter(caption); 
}

function mapCondition(condition){
    if(condition === 'Is'){
        return 'is equal';
    }else if(condition === 'Is Not'){
        return 'is not equal';
    }else if(['Less than', 'Greater than'].includes(condition)){
        return 'is ' + condition.toLowerCase();
    }

    return condition.toLowerCase();
}

function toggleTab(name){
    activeTab.value = name;
}

function handleSelectedCostItems(value) {
    if(value){
        if(optionAttached.value){
            options.value = options.value.map(option => {
                if (option.value === optionAttached.value) {
                    return {
                        ...option,
                        attached_item: value[0].cost_item_id
                    };
                }
                return option;
            });
        }else{
            value.forEach(item => {
                options.value = [
                    ...options.value, 
                    { 
                        label: item.title, 
                        value: item.cost_item_id, 
                        img_url: item.item_photo_url
                    }
                ];
            });
        }
    }
}

function handleRemoveAttachment(value) {
    options.value = options.value.map(option => {
        if (option.value === value) {
            return {
                ...option,
                attached_item: null
            };
        }
        return option;
    });
    console.log(options.value);
}

function handleSelectedCostItem(value) {
    console.log('handleSelectedCostItem', value);
}

function handleSelectFromCalatog(value){
    var modal = document.querySelector('#costItemListModal');
    var bootstrapModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
    bootstrapModal.show();
    reloadCostItems.value = true;
    optionAttached.value = value;
}

function handleNewOption(){
    if(fieldType.value === 'Color Picker'){
        toggleAddColor.value = true;
    }else if(fieldType.value === 'Image Picker'){
        document.querySelector('#image-upload').click();
    }else{
        const newOptions = [...options.value, { label: 'Option ' + (options.value.length + 1), value: uniqueId() }];
        options.value = newOptions;
    }
}

function handleDeleteOption(index){
    if(options.value.length !== 1){
        const newOptions = options.value.filter((_, idx) => idx !== index);
        options.value = newOptions;
    }
}

function handleNewColorPicked(hexColor){
    const newOptions = [...options.value, { label: hexColor, value: hexColor }];
    options.value = newOptions;
}

function handlCloseColor(){
    toggleAddColor.value = false;
}

function handleAddColor(){
    const newOptions = [...options.value, { label: newHexColor.value, value: newHexColor.value }];
    options.value = newOptions;
}

function returnData(){
    const returnValue = {
        id: fieldId.value, label: fieldType.value, icon: props.data.icon,
        data: {
            label: fieldLabel.value,
            hideLabel: hideLabel.value,
            instruction: instruction.value,
            hideInstruction: hideInstruction.value,
            visibility: visibility.value,
            estimate_field_id: estimate_field_id.value,
            options: options.value.length != 0 ? options.value : [],
            rules: rules.value.length != 0 ? rules.value : [],
        }
    }
    
    emit('onValueChange', returnValue);
}

async function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        fileUrl.value = input.files[0];

        const response = await upload();
        if(response){
            const photo_url = response.data.s3Url;
            options.value = [
                ...options.value, 
                { 
                    label: 'Option ' + (options.value.length + 1), 
                    value: uniqueId(), 
                    img_url: photo_url
                }
            ];
        }
    }
}

function uniqueId() {
  return 'id-' + Math.random().toString(36).slice(2, 11);
}

const upload = async () => {
    const response = await axios.post('/api/upload', {
        file: fileUrl.value,
        'upload-file-from': 'estimate-builder'
    }, {
        headers: {
            'Authorization': 'Bearer ' + page.props.csrf_token,
            'Content-Type': 'multipart/form-data',
        }
    });

    return response;
}

function formatCurrency(amount) {
  if(amount){
    const formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
    });
    return formatter.format(parseFloat(amount).toFixed(2));
  }else{
    return '$0.0';
  }
}

watch(() => props.data, (newValue) => {
    if(newValue){
        fieldId.value = newValue.id;
        fieldType.value = newValue.label;

        if(newValue.data){
            fieldLabel.value = newValue.data.label;
            hideLabel.value = newValue.data.hideLabel;
            instruction.value = newValue.data.instruction;
            hideInstruction.value = newValue.data.hideInstruction;
            visibility.value = newValue.data.visibility;
            estimate_field_id.value = newValue.data.estimate_field_id ? newValue.data.estimate_field_id : null;

            if(newValue.data.options){
                options.value = newValue.data.options;
            }else{
                options.value = [];
            }

            if(newValue.data.rules){
                rules.value = newValue.data.rules;
            }else{
                rules.value = [];
            }

            clearConditions();
            ruleExtras.value = [{
                id: uniqueId(),
                field: fieldId,
                condition: '',
                conditions: globalConditions.value.number,
                value: '',
                selectedField: props.data
            }];

        }
    }
}, { deep: true });

watch(fieldLabel, () => {
    returnData();
});

watch(hideLabel, () => {
    returnData();
});

watch(instruction, () => {
    returnData();
});

watch(hideInstruction, () => {
    returnData();
});

watch(visibility, () => {
    returnData();
});

watch(() => options, () =>  {
    returnData();
}, { deep: true });

watch(() => rules, () => {
    returnData();
}, { deep: true });

</script>
<style scoped>
.properties-container{
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.332);
}

.properties-content{
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  background-color: white;
  overflow: hidden;
}

#field-options::-webkit-scrollbar {
    width: 6px; /* Adjust to make it slim */
    height: 4px; /* Adjust to make it slim */
}

#field-options::-webkit-scrollbar-thumb {
    background-color: #888; /* Customize the thumb color */
    border-radius: 3px; /* Rounded corners for the thumb */
}

#field-options::-webkit-scrollbar-track {
    background-color: #ccc; /* Customize the track color */
}

#field-rules::-webkit-scrollbar {
    width: 6px; /* Adjust to make it slim */
    height: 4px; /* Adjust to make it slim */
}

#field-rules::-webkit-scrollbar-thumb {
    background-color: #888; /* Customize the thumb color */
    border-radius: 3px; /* Rounded corners for the thumb */
}

#field-rules::-webkit-scrollbar-track {
    background-color: #ccc; /* Customize the track color */
}

.option{
    border: 1px solid #989a99;
    padding: 5px;
    border-radius: 5px;
    position: relative;
}

.option-delete{
    position: absolute;
    top: -5px;
    right: -8px;
    background-color: red;
    color: white;
    font-size: 8px;
    padding: 3px 5px;
    border-radius: 10px;
}

.header-pill:hover{
    background-color: rgb(238, 237, 237);
}

.header-pill.active{
    background-color: white;
}
</style>