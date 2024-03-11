<template>
    <div class="modal fade" id="importCatalogReviewModal" tabindex="-1" role="dialog" aria-labelledby="importCatalogReviewModal" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0" style="max-height: 93vh !important;">
                    <div class="card p-0 m-0" style="max-height: 93vh !important; overflow: hidden;">
                        <div class="card-header border">
                            <h5>Import Preview</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card-body row p-0 m-0" v-if="!loading">
                            <div class="p-0" style="width: 100%; height: calc(90vh - 190px);">
                                <RichTable 
                                    :headers="headers"
                                    :rows="rowData"
                                    @onSelectionChange="handleSelectedRow"
                                />
                            </div>
                            <div class="col-md-12 bg-white">
                                <div class="d-flex justify-content-between m-3">
                                    <button class="btn btn-danger" @click="handleRemoveSelected" v-if="selectedRows.length != 0">Remove Selected</button>                          
                                    <div></div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-light mr-3" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn btn-primary-v2" @click="handleImportClick">Proceed Import</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="d-flex align-items-center justify-content-center">
                            <a class="f-20 f-w-700 m-5 p-5">IMPORTING COST ITEMS...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import { watch, ref } from 'vue';
import RichTable from '../RichTable.vue';
import { usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import axios from 'axios';

const page = usePage();
const selectedRows = ref([]);
const rowData = ref([]);
const loading = ref(false);
const props = defineProps({
    rows: {
        type: Array,
         default: () => []
    }
});
const headers = ref([
       { name: "check_column", min: '25px'}, //Identifier for checklist
       { name: "Action", min: '80px'},
       { name: "Title", min: '250px', max: '250px'},
       { name: "Description", min: '500px', max: '500px'},
       { name: "Unit Cost", min: '150px'},
       { name: "Unit", min: '150px'},
       { name: "Quantity", min: '150px'},
       { name: "Builder Cost", min: '150px'},
       { name: "Markup %", min: '150px'},
       { name: "$/Unit", min: '150px'},
       { name: "Markup", min: '150px'},
       { name: "Owner Price", min: '150px'},
]);

function getRowContent(proposal){
    let rowCells = [];
    headers.value.forEach(header => {
        const headerName = header.name;
        rowCells[headerName] = getCellContent(proposal, headerName);
    });
    
    return rowCells
}

function getCellContent(data, headerName) {
    if(headerName === 'Action'){
        return {
            className: '',
            content: setActionBadge(data['Item ID'], data[headerName]),
            style: 'default',
            action: 'none',
            data: data
        }
    }
    return {
        className: '',
        content: data[headerName] ? data[headerName] : '-',
        style: 'default',
        action: 'none',
        data: data
    }
}

function setActionBadge(id, action){
    let statusStr = 'new';
    let statusColor = 'primary';
    if(id){
        if(action === 'update'){
            statusStr = 'update';
            statusColor = 'warning';
        }else if(action === 'delete'){
            statusStr = 'delete';
            statusColor = 'danger';
        }else{
            statusStr = 'new';
            statusColor = 'primary';
        }
    }
    return `<a class='badge badge-${statusColor}'>${statusStr.toLocaleUpperCase()}</a>`;
}

function uniqueId() {
  return 'id-' + Math.random().toString(36).slice(2, 11);
}

function handleSelectedRow(rows){
    selectedRows.value = rows;
    console.log(selectedRows.value);
}

function handleRemoveSelected(){
    rowData.value = rowData.value.filter(row => {
        return !selectedRows.value.some(selectedRow => selectedRow.id === row.id);
    });
}

function handleImportClick(){
    const dataToSave = rowData.value.map(row => {
        const action = row.content['Action'].data['Action'];
        const item = {
            ...row.content['Action'].data, 
            action: action ? action : null
        }
        delete item.check_column;

        const unit_quantity = item['Quantity'] ? item['Quantity'] : 1;
        const mark_up = item['Markup'] ? item['Markup'].replace(/[$,]/g, '') : 0;
        const percentage = item['Markup %'] ? item['Markup %'].replace('%', '') : 0;
        const unit_mark_up_type = unit_quantity > 1 ? '$/' : '%';
        const unit_mark_up = unit_mark_up_type === '%' ? percentage : mark_up;

        return {
            cost_item_id: item['Item ID'] ? item['Item ID'] : 0,
            title: item['Title'] ? item['Title'] : '',
            description:  item['Description'] ? item['Description'] : '',
            unit_cost:  item['Unit Cost'] ?  item['Unit Cost'].replace(/[$,]/g, '') : '' ,
            unit:  item['Unit'] ? item['Unit'] : '' ,
            unit_quantity: unit_quantity,
            unit_mark_up:  unit_mark_up ,
            unit_mark_up_type:  unit_mark_up_type ,
            labor:  item['Labor Type'] ? item['Labor Type'] : 0,
            quantity_included: unit_quantity > 1 ? 1 : 0,
            owner_price_included: mark_up != 0 ? 1 : 0,
            action: item.action,
        };
    });

    // console.log(dataToSave);
    costItemImport(dataToSave);
}

const costItemImport = async (cost_items) => {
    try {
        loading.value = true;
        const response = await axios.post('/api/costItems/import', 
        {
            cost_items: cost_items
        }, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.status === 201) {
            // const costItemDetails = response.data.data;
            loading.value = false;

            document.querySelector(`#importCatalogReviewModal .btn-close`).click();
            
            Swal.fire({
                icon: 'success',
                title: 'Imported Item Successful!',
                text: 'You can now add the newly created Cost Items to your proposals.',
            });
        } else {
            loading.value = false;
            const message = response.data.errors.title;
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: message? message : 'ERROR MESSAGE: ADDING COST ITEM.',
            });
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            Swal.fire({
                icon: 'error',
                title: 'Unexpected Error!',
                text: 'Error adding cost item: ' + error.response?.data || error.message
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
    }
}


watch(() => props.rows, (newValue) => {
    if(newValue && newValue.length > 0){
        const headers = newValue[0];
        const transformedData = newValue.slice(1).map(row => {
            let rowObject = {};
            headers.forEach((header, index) => {
                rowObject[header] = row[index];
            });
            return rowObject;
        });

        rowData.value = Object.values(transformedData).map(item => {
            return {
                id: item['Item ID'] ? item['Item ID'] : uniqueId(),
                content: getRowContent(item)
            };
        });
    }
}, { deep: true });

</script>