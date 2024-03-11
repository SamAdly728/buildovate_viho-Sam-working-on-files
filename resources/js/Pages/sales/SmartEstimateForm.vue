<template>
    <div class="p-3 d-flex" style="width: 100%; height: calc(100vh - 123px); overflow: hidden;" v-if="!loading">
      <div class="flex-grow-1 p-3" style="overflow: auto; max-height: calc(100vh - 123px);" id="form-preview">
        <div class="card">
          <div class="card-header pb-0">
            <h3>{{ estimateFormName ? estimateFormName : 'Input Title for this Form' }}</h3>
          </div>
          <hr>
          <div class="card-body p-0 m-0">
            <draggable :list="list2" item-key="id" group="fields" @update:list="list2 = $event" @add="onAdd" :disabled="true">
              <template v-for="element in list2">
                <div v-if="element.label === 'Input Number' && !element.hidden" class="form-field-cotainer position-relative">
                  <InputNumber :data="element.data" @onChange="handleFormChanges"/>
                </div>
                <div v-else-if="element.label === 'Radio Style 1' && !element.hidden" class="form-field-cotainer position-relative">
                  <RadioStyle1 :data="element.data" @onChange="handleFormChanges"/>
                </div>
                <div v-else-if="element.label === 'Radio Style 2' && !element.hidden" class="form-field-cotainer position-relative">
                  <RadioStyle2 :data="element.data" @onChange="handleFormChanges"/>
                </div>
                <div v-else-if="element.label === 'Color Picker' && !element.hidden" class="form-field-cotainer position-relative">
                  <ColorPicker :data="element.data"/>
                </div>
                <div v-else-if="element.label === 'Form Header' && !element.hidden" class="form-field-cotainer position-relative">
                  <FormHeader :data="element.data"/>
                </div>
                <div v-else-if="element.label === 'Separator' && !element.hidden" class="form-field-cotainer position-relative">
                  <Separator/>
                </div>
                <div v-else-if="element.label === 'Item Picker' && !element.hidden" class="form-field-cotainer position-relative">
                  <ItemPicker :data="element.data" @onChange="handleFormChanges"/>
                </div>
                <div v-else-if="element.label === 'Image Picker' && !element.hidden" class="form-field-cotainer position-relative">
                  <ImagePicker :data="element.data"/>
                </div>
                <!-- <div class="form-element position-relative" v-else>
                  {{ element.label }}
                </div> -->
              </template>
            </draggable>
          </div>
        </div>
      </div>
      <div class="mx-3" style="width: 500px !important; max-width: 500px !important;  min-width: 500px !important;">
        <div class="card d-flex flex-column" style="height: 100%;">
          <div style="height: 300px; max-height: 300px;" class="position-relative">
            Carousel here for selected Items
            <div style="position: absolute; bottom: 10px; right: 0; left: 0;" class="d-flex justify-content-between mx-4">
              <a class="f-24 f-w-600">TOTAL PRICE: </a>
              <a class="f-24 f-w-600">{{ formatCurrency(totalPrice) }}</a>
            </div>
          </div>
          <a class="btn btn-primary" style="border-radius: 0px !important;" @click="handleAttachedToProposal">Attached To Proposal</a>
          <div id="form-preview" class="flex-grow-1" style="overflow: auto;">
            <template v-for="item in selectedItems">
              <div class="b-b-primary px-2 py-1">
                <div class="p-3 d-flex flex-column">
                  <a class="f-w-700 truncate">{{ item.data.title }}</a>
                  <a class="f-w-500 truncate text-muted">{{ item.data.description }}</a>
                  <a class="f-w-500 truncate text-muted mt-1 f-w-600">Client Price: {{ formatCurrency(getOwnerPrice(item.data)) }} / {{ item.data.unit_quantity }} {{ item.data.unit }}</a>
                  <a class="f-18 f-w-700 mt-2 text-right">{{ item.data.calculated_amount ? formatCurrency(item.data.calculated_amount) : formatCurrency(getOwnerPrice(item.data)) }}</a>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <h3 class="text-center mt-5">Preparing Smart Estimate Form</h3>
      <h6 class="text-center text-secondary">Please wait...</h6>
    </div>
</template>
<script setup>
import { VueDraggableNext } from 'vue-draggable-next';
import InputNumber from '../../components/form/InputNumber.vue';
import RadioStyle1 from '../../components/form/RadioStyle1.vue';
import RadioStyle2 from '../../components/form/RadioStyle2.vue';
import ItemPicker from '../../components/form/ItemPicker.vue';
import ColorPicker from '../../components/form/ColorPicker.vue';
import FormHeader from '../../components/form/FormHeader.vue';
import Separator from '../../components/form/Separator.vue';
import ImagePicker from '../../components/form/ImagePicker.vue';
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const draggable = VueDraggableNext;
const page = usePage();
const loading = ref(false);
const estimateFormName = ref('');
const list2 = ref([]);
const formValues = ref([]);
const selectedItems = ref([]);
const totalPrice = ref(0);

const ruleSets = ref([]);

function uniqueId() {
  return 'id-' + Math.random().toString(36).slice(2, 11);
}

function handleAttachedToProposal(){
  if(selectedItems.value.length != 0){
    
  }else{
    Swal.fire({
      icon: 'warning',
      title: 'No Item Found',
      text: 'Make sure there is an item in the project summary.',
    });
  }
}

function handleFormChanges(value) { 
  const index = formValues.value.findIndex(field => field.estimate_field_id === value.estimate_field_id);
  const exist = selectedItems.value.filter(item => item.estimate_field_id == value.estimate_field_id);
  let itemData = null;

  if(value.type === 'Item Picker'){
    if(value.value){    
      itemData = value.data;
    }else{
      itemData = null;
    }
  }else if(value.type === 'Radio Style 1' || value.type === 'Radio Style 2'){
    const field = list2.value.find(field => field.data.estimate_field_id === value.estimate_field_id);
    if(field && field.data && field.data.options && field.data.options.length != 0){
      const option = field.data.options.find(option => option.value === value.value);
        
      itemData = option.attached_item;
    }else{
      itemData = null;
    }
  }

  if (index !== -1) {
    formValues.value[index] = value;
  } else {
    formValues.value.push(value);
  }

  if(value.type === 'Radio Style 1' || value.type === 'Radio Style 2' || value.type === 'Item Picker'){
    if(exist.length != 0){
      if(itemData){
        selectedItems.value = selectedItems.value.map(item => {
          if(item.estimate_field_id === value.estimate_field_id){
            return {
              ...item,
              value: value.value,
              data: value.data
            }
          }else{
            return item
          }
        });
      }else{
        selectedItems.value = selectedItems.value.filter(item => item.estimate_field_id !== value.estimate_field_id);
      }
    }else{
      if(itemData){
        selectedItems.value.push({
          data: itemData,
          estimate_field_id: value.estimate_field_id,
          label: value.label,
          type: value.type,
          value: value.value
        });
      }
    }
  }
  
  processRules();
}

  //Make sure all operations are handled properly
  // - Multiply
  // - Add
  // - Subtract
  // - Divide
  //Make sure all conditions are handled properly
  // - (SINGLE)           - (MULTIPLE)          - (NUMBER)
  // -- Is                -- Contains           -- Is (DONE)
  // -- Is Not            -- Not Contains       -- Is Not (DONE)
  // -- Is Empty          -- Is Any of          -- Is Empty (DONE)
  // -- Is Not Empty      -- Is None of         -- Is Not Empty (DONE)
  // -- Starts With       -- Contains Any of    -- Less than (DONE)
  // -- Ends With         -- Contains All of    -- Greater than (DONE)
  // -- Other Choice is   -- Contains None of   -- Between
  // --                                         -- Outside

function calculateTotalPrice(){
  totalPrice.value = 0;
  selectedItems.value = selectedItems.value.filter(item => {
    const fieldItem = list2.value.find(field => field.data.estimate_field_id === item.estimate_field_id);

    return !fieldItem.hidden;
  });

  selectedItems.value.forEach(item => {
    const owner_price = getOwnerPrice(item.data);
    const total_amount = item.data.calculated_amount ? item.data.calculated_amount : owner_price;

    totalPrice.value = totalPrice.value + total_amount;
  });
}

function checkConditionByRule(field_value, condition, value){
  if(condition == 'Is'){
    return field_value == value;
  }else if(condition == 'Is Not'){
    return field_value != value;
  }else if(condition == 'Is Not Empty'){
    return !(field_value === null || field_value === undefined || field_value === '');
  }else if(condition == 'Less than'){
    return field_value < value;
  }else if(condition == 'Greater than'){
    return field_value > value;
  }
}

function getFieldValueById(id, type = 'default'){
  const value = formValues.value.find(field => field.estimate_field_id === id);
  if(value){
    let attached_item = null;
    const field = list2.value.find(field => field.data.estimate_field_id === value.estimate_field_id);
    if(field && field.data && field.data.options && field.data.options.length != 0){
      const option = field.data.options.find(option => option.value === value.value);
      if(option){
        attached_item = option.attached_item;
      }
    }

    if(value.type === 'Item Picker'){
      if(value.value){
        const itemData = value.data;
        return getOwnerPrice(itemData);
      }else{
        return 0;
      }
    }

    if(attached_item && type === 'attached_item'){
      return getOwnerPrice(attached_item);
    }

    return value.value;
  }else{
    return null;
  }
}

async function fetchEstimate($id) {
  loading.value = true;
    try {
      const response = await axios.get(`/api/estimates/${$id}`, {
        headers: {
          'Authorization': 'Bearer ' + page.props.csrf_token,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      if(response.data.status === 'success'){
        const data = response.data.data;
        estimateFormName.value = data.title;

        const fields = data.estimate_fields.map(item => {
          return {
            id: uniqueId(),
            label: item.field_type,
            hidden: item.visibility == 0,
            data: {
              estimate_field_id: item.estimate_field_id,
              label: item.field_label,
              hideLabel: item.hide_label != 0,
              instruction: item.instruction,
              hideInstruction: item.hide_instruction != 0,
              visibility: item.visibility,
              options: item.estimate_field_options ? item.estimate_field_options : [],
              rules: item.field_rules ? item.field_rules : []
            }
          }
        });
        ruleSets.value = fields.map(field => {
          return field.data.rules && field.data.rules.length != 0 ? field.data.rules : false;
        }).filter(rule => rule !== false);

        processRules();
        list2.value = fields;
      }else{
        console.error("Error fetching cost items:", response.data);
      }
            
      loading.value = false;
    } catch (error) {
      console.error("Error fetching cost itens:", error);
      loading.value = false;
    }
}

function processRules(){
  ruleSets.value.forEach(rules => {
    console.log('RULES: ', rules);
    rules.forEach(rule => {
      const logics = rule.field_rule_logics;
      const result = checkCondition(logics);
      
      if(result){
        processAction(rule);
      }else{
        list2.value = list2.value.map(field => {
          if(field.data.estimate_field_id === rule.estimate_field_id){
            return{
              ...field,
              hidden: field.data.visibility === 0
            }
          }
          return field;
        });
        calculateTotalPrice();
      }

    });
  });
}

function checkCondition(logics){
  let conditions = [];

  logics.forEach(logic => {
    const condition = logic.condition; //MAP THIS
    const connecting_field_id = logic.connecting_field_id;
    const connecting_value = logic.connecting_value;

    conditions.push({
      condition: condition,
      connecting_field_id: connecting_field_id,
      connecting_value: connecting_value,
      logic: logic.logic
    });
  });

  // let display = '';
  // let actualDisplay = '';
  let result = false;
  conditions.forEach(condition => {
    const logicalOperation = condition.logic ? condition.logic + ' IF' : 'IF';
    const connecting_field_id = condition.connecting_field_id;
    const connecting_value = condition.connecting_value;
    const cons = condition.condition;
    // const valueDisplay = connecting_value ? ' ' + connecting_value + ') ' : ')';
    const output =  checkConditionByRule(getFieldValueById(connecting_field_id), cons, connecting_value);

    // display = display + logicalOperation + '(' + getFieldValueById(connecting_field_id) + ' ' + cons + valueDisplay;
    // actualDisplay = actualDisplay + logicalOperation + '(' + output + ') ';

    if(logicalOperation === 'IF'){
      result = output;
    }else{
      if(condition.logic === 'AND'){
        result = result && output;
      }else{
        result = result || output;
      }
    }
  });

  // console.log('RULE:', display);
  // console.log('RULE: ACTUAL', actualDisplay);
  // console.log('RULE: RESULTS', result);
  return result;
}

function processAction(rule){
  const action = rule.action;
  const estimate_field_id = rule.estimate_field_id;
  const operation = rule.operation;
  const operation_field_id = rule.operation_field_id;
  const operation_value = rule.operation_value;

  if(action === 'calculate'){
    if(operation_value){
      console.log('RULE: DO ', action, ':', operation, estimate_field_id, 'by', operation_value);
      processCalculation(operation, getFieldValueById(estimate_field_id, 'attached_item'), operation_value, estimate_field_id);
    }else{
      console.log('RULE: DO ', action, ':', operation, getFieldValueById(estimate_field_id, 'attached_item'), 'with', getFieldValueById(operation_field_id));
      processCalculation(operation, getFieldValueById(estimate_field_id, 'attached_item'), getFieldValueById(operation_field_id), estimate_field_id);
    }
  }else{
    console.log('RULE: DO ', action, 'this field', estimate_field_id);
    processVisibility(action, estimate_field_id);
  }
  
  calculateTotalPrice();
}

function processVisibility(action, estimate_field_id){
  list2.value = list2.value.map(field => {
    if(field.data.estimate_field_id === estimate_field_id){
      return{
        ...field,
        hidden: action === 'show' ? false : true
      }
    }

    return field;
  });
}

function processCalculation(operation, number1, number2, estimate_field_id){
  let results = 0;

  if(operation === 'add'){
    results = number1+number2;
  }else if(operation === 'subtract'){
    results = number1-number2;
  }else if(operation === 'multiply'){
    results = number1*number2;
  }else if(operation === 'divide'){
    results = number1/number2;
  }

  selectedItems.value = selectedItems.value.map(item => {
    if(item.estimate_field_id === estimate_field_id){
      return {
        ...item,
        data: {
          ...item.data,
          calculated_amount: results
        }
      }
    }

    return item
  });

  return results;
}

function getBuilderPrice(costitem){
  let unit_cost = costitem.unit_cost;
  let unit_quantity = costitem.unit_quantity;

  if(!unit_cost){
    unit_cost = 0; 
  }

  if(!unit_quantity){
    unit_quantity = 1;
  }

  return (unit_cost * unit_quantity);
}

function getOwnerPrice(costitem){
  const builder_cost = getBuilderPrice(costitem);
  const markup = costitem.unit_mark_up;
  const markup_type = costitem.unit_mark_up_type;
  const unit_quantity = costitem.unit_quantity;
  let totalMarkup = 0;

  if(markup_type){
    if(markup_type === '%'){
      totalMarkup =  builder_cost + ((builder_cost) * (markup/100));
    }else if(markup_type === '$/'){
      totalMarkup = (markup * unit_quantity) + builder_cost;
    }else{
      totalMarkup = markup + builder_cost;
    }
  }
        
  return (totalMarkup);
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

onMounted(() => {
  if(page.props.estimated_id){
    fetchEstimate(page.props.estimated_id);

  }
});

</script>
<style scoped>
#form-preview::-webkit-scrollbar {
    width: 6px; /* Adjust to make it slim */
    height: 4px; /* Adjust to make it slim */
}

#form-preview::-webkit-scrollbar-thumb {
    background-color: #888; /* Customize the thumb color */
    border-radius: 3px; /* Rounded corners for the thumb */
}

#form-preview::-webkit-scrollbar-track {
    background-color: #ccc; /* Customize the track color */
}
</style>