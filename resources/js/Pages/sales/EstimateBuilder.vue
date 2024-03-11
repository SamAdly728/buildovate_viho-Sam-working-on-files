<template>
    <div class="px-3 pb-3 row pt-4 m-0" style="width: 100vw; height: calc(100vh - 130px); overflow: hidden;">
      <div class="col-md-3 form-preview" style="overflow: auto; max-height: calc(100vh - 130px);">
        <div class="card b-light">
          <div class="mx-4 mt-3">
            <label>Form Name: </label>
            <input class="form-control b-primary" type="text" placeholder="Enter form name..." v-model="estimateFormName" :disabled="loading"/>
          </div>
          <hr>
          <div class="d-flex flex-column">
            <a class="mx-4 mt-0 f-18 f-w-600">Form Fields</a>
            <small class="mb-3 mx-4 f-12">Drag the items into the form</small>
            <draggable :list="list1" class="row m-0 px-3 pb-4" item-key="id" :group="{ name: 'fields', pull: 'clone', put: false }" @update:list="list1 = $event" :clone="cloneElement" @end="onEndFieldDrag" :disabled="loading">
              <template v-for="element in list1">
                <div class="field_container col-sm-6">
                  <div class="field" :class="{'cursor-not-allowed': loading, 'cursor-grab': !loading}">
                    <i :class="element.icon"></i>
                    <span class="ml-2">{{ element.label }}</span>
                  </div>
                </div>
              </template>
            </draggable>
          </div>
        </div>
      </div>

      <!-- FORM -->
      <div class="col-md-9 px-2" style="overflow: hidden;">
        <div class="card">
            <div style="width: 100%;" class="p-3 float-right d-flex justify-content-between align-items-center flex-wrap gap-2" v-if="!loading">
              <div class="d-flex gap-2">
                <a class="btn btn-sm btn-outline-primary" style="width: auto;">Tutorial</a>
                <a class="btn btn-sm btn-outline-primary" style="width: auto;">Need Help?</a>
              </div>
              <div class="d-flex flex-row gap-2 align-items-center">
                  <div class="checkbox checkbox-dark ml-2">
                    <input id="checkbox-state-dark" type="checkbox" v-model="showFields">
                    <label for="checkbox-state-dark">Show Fields</label>
                  </div>
                  <a class="btn btn-sm btn-outline-danger" style="width: auto;" v-if="page.props.estimated_id" @click="handleDeleteForm">Delete</a>
                  <a class="btn btn-sm btn-outline-primary" style="width: auto;" @click="handleSaveForm('preview')">Preview</a>
                  <a class="btn btn-sm btn-primary" style="width: auto;" @click="handleSaveForm">Save Changes</a>
              </div>
            </div>
            <div style="width: 100%;" class="p-3 float-right d-flex justify-content-center align-items-center flex-wrap gap-2" v-else>
              <label for="checkbox-state-dark">{{ loadingLabel }}</label>
            </div>
        </div>
        <div class="form-preview" style="max-height: calc(100vh - 250px); overflow-y: auto; overflow-x: hidden;">
          <div class="card">
          <div class="card-header pb-0" v-if="!loading">
            <h3>{{ estimateFormName ? estimateFormName : 'Input Title for this Form' }}</h3>
          </div>
          <hr v-if="!loading">
          <div class="card-body p-0 m-0">
            <draggable :list="list2" item-key="id" group="fields" @update:list="list2 = $event" @add="onAdd" :disabled="loading">
              <template v-for="element in list2">
                <div v-if="element.label === 'Input Number'" class="position-relative"
                  @click="handleFieldClick(element)" 
                  @dblclick="handleDuobleClick(element.id)" 
                  :class="{'active': activeField && element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <InputNumber :data="element.data" :type="showFields ? '-' : 'builder'"/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" v-if="!loading"/>
                </div>
                <div v-else-if="element.label === 'Radio Style 1'" class="position-relative"  
                  @click="handleFieldClick(element)" 
                  @dblclick="handleDuobleClick(element.id)" 
                  :class="{'active': activeField &&  element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <RadioStyle1 :data="element.data" :id="element.id"  :type="showFields ? '-' : 'builder'"/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" v-if="!loading"/>
                </div>
                <div v-else-if="element.label === 'Radio Style 2'" class="position-relative"  
                  @click="handleFieldClick(element)" 
                  @dblclick="handleDuobleClick(element.id)" 
                  :class="{'active': activeField && element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <RadioStyle2 :data="element.data" :type="showFields ? '-' : 'builder'"/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" v-if="!loading"/>
                </div>
                <div v-else-if="element.label === 'Color Picker'" class="position-relative"  
                  @click="handleFieldClick(element)" 
                  @dblclick="handleDuobleClick(element.id)" 
                  :class="{'active': activeField && element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <ColorPicker :data="element.data"  :type="showFields ? '-' : 'builder'"/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" v-if="!loading"/>
                </div>
                <div v-else-if="element.label === 'Form Header'" class="position-relative"  
                  @click="handleFieldClick(element)" 
                  @dblclick="handleDuobleClick(element.id)" 
                  :class="{'active': activeField && element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <FormHeader :data="element.data"/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" v-if="!loading"/>
                </div>
                <div v-else-if="element.label === 'Separator'" class="position-relative"  
                  @click="handleFieldClick(element)" :class="{'active': activeField &&  element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <Separator/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" :hideProperties="true" v-if="!loading"/>
                </div>
                <div v-else-if="element.label === 'Item Picker'" class="position-relative" 
                  @click="handleFieldClick(element)" 
                  @dblclick="handleDuobleClick(element.id)" 
                  :class="{'active': activeField && element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <ItemPicker :data="element.data"  :type="showFields ? '-' : 'builder'"/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" v-if="!loading"/>
                </div>
                <div v-else-if="element.label === 'Image Picker'" class="position-relative"  
                  @click="handleFieldClick(element)" 
                  @dblclick="handleDuobleClick(element.id)" 
                  :class="{'active': activeField && element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <ImagePicker :data="element.data" :type="showFields ? '-' : 'builder'"/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" v-if="!loading"/>
                </div>
                <div v-else-if="element.label === 'Summary'"  class="position-relative" 
                  @click="handleFieldClick(element)" 
                  @dblclick="handleDuobleClick(element.id)" 
                  :class="{'active': activeField && element.id == activeField.id, 'form-field-cotainer': !loading}">
                  <Formula :data="element.data" :type="showFields ? '-' : 'builder'"/>
                  <FieldOptions :id="element.id" :display="!(activeField && element.id == activeField.id)" @option="handleOption" v-if="!loading"/>
                </div>
              </template>
              <div v-if="!loading && list2.length == 0">
                <div class="empty-form-container">
                  Start creating your smart estimate by dragging a form field to this area.
                </div>
                <div class="d-flex flex-column align-items-center justify-content-center my-5">
                  <h3 class="f-w-600">What is a Smart Estimate?</h3>
                  <div class="d-flex align-items-center" style="width: 600px;">
                    <span class="f-20 f-w-600 text-background">
                      A smart estimate allows you to easily create forms that will populate a unique price according to your answers on the form.
                    </span>
                    <img src="../../../../resources/assets/sales/information.png" style="height: 300px; margin-left: -100px;"/>
                  </div>
                  <label class="mt-3">Want to see an example? <span class="f-w-700 txt-primary">Click here.</span></label>
                </div>
              </div>
            </draggable>
          </div>
        </div>
        </div>
      </div>
      <!-- END FORM -->

    </div>
    <Properties :isOpen="propertiesOpen" :data="selectedField" :fields="list2" @onValueChange="handleChangeValue" @onClose="handlePropertiesClose"/>
</template>
<script setup>
import Breadcrumb from '../../components/Breadcrumb.vue';
import { VueDraggableNext } from 'vue-draggable-next';
import InputNumber from '../../components/form/InputNumber.vue';
import RadioStyle1 from '../../components/form/RadioStyle1.vue';
import RadioStyle2 from '../../components/form/RadioStyle2.vue';
import ItemPicker from '../../components/form/ItemPicker.vue';
import ColorPicker from '../../components/form/ColorPicker.vue';
import FieldOptions from '../../components/form/FieldOptions.vue';
import FormHeader from '../../components/form/FormHeader.vue';
import Separator from '../../components/form/Separator.vue';
import Properties from '../../components/form/PropertiesSideBar.vue';
import ImagePicker from '../../components/form/ImagePicker.vue';
import Formula from '../../components/form/Formula.vue';
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const draggable = VueDraggableNext;
const page = usePage();
const showFields = ref(true);
const loading = ref(false);
const loadingLabel = ref('Saving Estimated Form...');
const estimateFormName = ref('');
const propertiesOpen = ref(false);
const selectedField = ref(null);
const activeField = ref(null);
const originalList1 = ref(window.form_builder_fields);
const list1 = ref([...originalList1.value]);
const list2 = ref([]);

function cloneElement(el) {
    const clonedElement = { ...el };
    
    if (clonedElement.data && Array.isArray(clonedElement.data.options)) {
        clonedElement.data.options = clonedElement.data.options.map(option => ({ ...option }));
    }

    clonedElement.id = uniqueId();

    return clonedElement;
}

function onAdd(event) {
  const newField = event.item._underlying_vm_;
  if(newField.label === 'Radio Style 1' || newField.label === 'Radio Style 2'){
    const newOptions = [{ label: 'Option 1', value: uniqueId()}, { label: 'Option 2', value: uniqueId()}];
    list2.value = list2.value.map(field => {
      if(field.id === newField.id){
        return {
          ...field,
          data: {
            ...field.data,
            options: newOptions
          }
        }
      }

      return field;
    });

    console.log(list2.value);
  }
}

function uniqueId() {
  return 'id-' + Math.random().toString(36).slice(2, 11);
}

function onEndFieldDrag(event) {
  if (event.from === event.to) {
    list1.value = deepCopy(originalList1.value);
  }
}

function deepCopy(arr) {
  return arr.map(item => ({ ...item }));
}

function handleOption(value){
  if (value.type === 'delete') {
    const index = list2.value.findIndex(item => item.id === value.id);
    if (index !== -1) {
      list2.value.splice(index, 1);
    }
  } else if (value.type === 'duplicate') {
    const indexToDuplicate = list2.value.findIndex(item => item.id === value.id);
    if (indexToDuplicate !== -1) {
      const itemToDuplicate = list2.value[indexToDuplicate];
      const duplicatedItem = { ...itemToDuplicate, id: uniqueId() }; 
      list2.value.push(duplicatedItem); 
    }
  } else if (value.type === 'properties') {
    populateProperties(value.id);
    propertiesOpen.value = true;
  }
}

function getIconByType(type){
  if(type === 'Input Number'){
    return 'icon-pencil-alt';
  }else if(type === 'Radio Style 1'){
    return 'icon-control-record';
  }else if(type === 'Radio Style 2'){
    return 'icon-flickr';
  }else if(type === 'Color Picker'){
    return 'icon-hummer';
  }else if(type === 'Form Header'){
    return 'icon-text';
  }else if(type === 'Separator'){
    return 'icon-line-double';
  }else if(type === 'Image Picker'){
    return 'icon-image';
  }else if(type === 'Item Picker'){
    return 'icon-shopping-cart';
  }

  return 'icon-text';
}

function handleFieldClick(value){
  if(activeField.value && activeField.value.id === activeField.id){
    activeField.value = null;
    selectedField.value = null;
  }else{
    activeField.value = value;
  }
}

function handleDuobleClick(id){
  populateProperties(id);
  propertiesOpen.value = true;
}

function handlePropertiesClose(){
  propertiesOpen.value = false;
}

function handleChangeValue(value){
  const id = value.id;
  const index = list2.value.findIndex(item => item.id === id);

  // console.log(index);
  if (index !== -1) {
    const updatedItem = { ...list2.value[index], ...value };
    list2.value = [...list2.value.slice(0, index), updatedItem, ...list2.value.slice(index + 1)];
  }
}

function handleDeleteForm(){
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you wish to proceed deleting this form?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Proceed'
  }).then((result) => {
    if (result.isConfirmed) {
      deleteEstimate();
    }
  });
}

function handleSaveForm(type = 'default'){
  const fieldList = list2.value.map(item => {
    if(item.data){
      return {
        id: item.id,
        field_type: item.label,
        field_label: item.data.label,
        hide_label: item.data.hideLabel ? 1 : 0,
        instruction: item.data.instruction,
        hide_instruction: item.data.hideInstruction ? 1 : 0,
        estimate_field_id: item.data.estimate_field_id ? item.data.estimate_field_id : null,
        visibility: item.data.visibility,
        fieldOptions: item.data.options ? item.data.options : null,
        fieldRules: item.data.rules ? item.data.rules : null,
      }
    }else{
      return null;
    }
  });

  if(fieldList){
    const form = {
      title: estimateFormName.value,
      estimateFields: fieldList
    }

    console.log(form);
    if(page.props.estimated_id){
      updateEstimate(form, type);
    }else{
      insertEstimate(form, type);
    }
  }
}

function populateProperties(id){
  const fieldData = list2.value.find(item => item.id === id);
  selectedField.value = fieldData ? { ...fieldData } : null;
}

async function fetchEstimate($id) {
  loading.value = true;
  loadingLabel.value = 'Retreving Estimated Form Fields...';
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

        const ids = data.estimate_fields.map(item => {
          return {
            id: uniqueId(),
            estimate_field_id: item.estimate_field_id
          }
        });

        const fields = data.estimate_fields.map(item => {
            const fieldId = ids.find(field => field.estimate_field_id === item.estimate_field_id);
            return {
              id: fieldId.id,
              label: item.field_type,
              icon: getIconByType(item.field_type),
              data: {
                estimate_field_id: item.estimate_field_id,
                label: item.field_label,
                hideLabel: item.hide_label != 0,
                instruction: item.instruction,
                hideInstruction: item.hide_instruction != 0,
                visibility: item.visibility, 
                options: item.estimate_field_options ? item.estimate_field_options : [],
                rules: item.field_rules ? item.field_rules.map(rule => {
                  const foundField = ids.find(field => field.estimate_field_id === rule.operation_field_id);
                  const logics = rule.field_rule_logics.map(ruleLogic => {
                      const connectedField = ids.find(field => field.estimate_field_id === ruleLogic.connecting_field_id);
                      return {
                        ...ruleLogic,
                        connecting_field_id: connectedField.id
                      }
                  });

                  return {
                    ...rule,
                    id: uniqueId(),
                    logics: logics,
                    operation_field_id: foundField ? foundField.id : ''
                  };
                }) : [],
              }
            }
          });

        list2.value = fields;
      }else{
        console.error("Error fetching cost items:", response.data);
      }
            
      loading.value = false;
    } catch (error) {
      loading.value = false;
      loadingLabel.value = 'Saving Estimated Form...';
    }
}

async function insertEstimate(form, type){
    try {
        loading.value = true;
        loadingLabel.value = 'Saving Estimated Form...';

        const response = await axios.post('/api/estimates', form, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.status === 201) {
            const estimate_details = response.data.data;

            if(type === 'preview'){
              const data = estimate_details.data;
              
              let url = `/sales/smart-estimates/${data.estimate_id}`;
              window.open(url, '_blank');

              let updateUrl = `/sales/smart-estimates/builder/${data.estimate_id}`;
              window.location.href = updateUrl;
            }

            list2.value = [];
            estimateFormName.value = '';

            Swal.fire({
                icon: 'success',
                title: 'Estimate Newly Added',
                text: 'You can now add the newly created Estimate to your proposals.',
            });
        } else {
            loading.value = false;
            const message = response.data.errors.title;
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: message? message : 'ERROR MESSAGE: ADDING ESTIMATES.',
            });
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Error adding estimate: ' + error.response?.data || error.message
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Non-HTTP error: ' + error
            });
        }
    } finally {
        loading.value = false;
        loadingLabel.value = 'Saving Estimated Form...';
    }
}


async function updateEstimate(form, type){
    try {
        loading.value = true;
        loadingLabel.value = 'Updating Estimated Form...';

        const response = await axios.put(`/api/estimates/${page.props.estimated_id}`, form, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.status === 201) {
            const estimate_details = response.data.data;

            if(type === 'preview'){
              const data = estimate_details.data;

              let url = `/sales/smart-estimates/${data.estimate_id}`;
              window.open(url, '_blank');
            }

            Swal.fire({
                icon: 'success',
                title: 'Estimate Updated',
                text: 'You can now add the newly updated Estimate to your proposals.',
            });
        } else {
            loading.value = false;
            const message = response.data.errors.title;
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: message? message : 'ERROR MESSAGE: UPDATING ESTIMATES.',
            });
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Error updating estimate: ' + error.response?.data || error.message
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Non-HTTP error: ' + error
            });
        }
    } finally {
        loading.value = false;
        loadingLabel.value = 'Saving Estimated Form...';
    }
}

async function deleteEstimate(){
    try {
        loading.value = true;
        loadingLabel.value = 'Deleting Estimated Form...';

        const response = await axios.delete(`/api/estimates/${page.props.estimated_id}`, {}, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.status === 201) {
            Swal.fire({
                icon: 'success',
                title: 'Estimate Deleted',
                text: 'You can now add the newly updated Estimate to your proposals.',
            });
            
            let url = `/sales/smart-estimates/builder`;
            window.location.href = url;
        } else {
            loading.value = false;
            const message = response.data.errors.title;
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: message? message : 'ERROR MESSAGE: DELETING ESTIMATES.',
            });
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Error deleting estimate: ' + error.response?.data || error.message
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Non-HTTP error: ' + error
            });
        }
    } finally {
        loading.value = false;
        loadingLabel.value = 'Saving Estimated Form...';
    }
}

onMounted(() => {
  if(page.props.estimated_id){
    fetchEstimate(page.props.estimated_id);
  }
});

</script>
<style scoped>
.btn-outline-danger:hover{
  background-color: rgb(244, 107, 107) !important;
  color: white !important;
}    
    
.btn-outline-danger{
  border-color: #757575 !important;
  color: #757575 !important;
}

.form-element {
  border: 1px solid #ddd;
  padding: 10px;
  margin-bottom: 5px;
}

.field_container{
  padding: 4px;
}

.field{
  border: 1px solid #cfcfcf;
  padding: 10px 10px;
  border-radius: 5px;
  font-size: 12px;
}
.form-preview::-webkit-scrollbar {
    width: 6px; /* Adjust to make it slim */
    height: 4px; /* Adjust to make it slim */
}

.form-preview::-webkit-scrollbar-thumb {
    background-color: #888; /* Customize the thumb color */
    border-radius: 3px; /* Rounded corners for the thumb */
}

.form-preview::-webkit-scrollbar-track {
    background-color: #ccc; /* Customize the track color */
}
.form-field-cotainer:hover{
  background-color: #24695c0f;
  border-left: 5px solid #24695c;
}
.form-field-cotainer.active{

  background-color: #24695c09;
  border-left: 5px solid #24695c;
}

#rule-header-container{
  background-color: #24695c0f;
  border-left: 5px solid #24695c;
}

.field-list-item{
  border: 1px #24695c solid;
  padding: 2px 15px;
  cursor: pointer;
}

.field-list-item:hover{
  color: white;
  background-color: #24695c;
}

.empty-form-container{
  border: 3px dashed #24695c;
  margin: 0px 30px 15px 30px;
  padding: 10px 15px;
  border-radius: 5px;
  text-align: center;
  font-weight: 600;
  color: gray;
}

.text-background {
  background-color: rgba(255, 255, 255, 0.658); /* Choose your background color */
  line-height: 2; /* Adjust for better visual */
  padding: 0 2px; /* Small horizontal padding */
  display: inline; /* This makes the background wrap with the text */
  z-index: 1;
  color: gray;
}
</style>