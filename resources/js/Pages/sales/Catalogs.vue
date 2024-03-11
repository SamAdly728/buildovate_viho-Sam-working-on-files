<template>
    <div class="page-header p-3">
        <div class="row">
            <div class="col-sm-3">
                <input type="text" placeholder="Search Item" class="px-3 py-1 b-primary" style="border-radius: 2px;"/>
            </div>
            <div class="col-sm-9">
                <input type="file" @change="processExcel" style="display: none;" id="import-catalog-input"/>
                <div class="d-flex align-items-center justify-content-between gap-2" style="width: auto; float: right;" v-if="rowData.length != 0">
                    <div class="d-flex gap-2" v-if="selectedItems.length != 0">
                        <a class="btn btn-danger" style="width: auto;" :style="{'cursor': updating ? 'not-allowed' : 'pointer'}" @click="handleDeleteClicked"><i class="fa fa-spin fa-spinner me-2" v-if="this.updating"></i>{{ this.updating ? 'Deleting...' : 'Delete' }}</a>
                        <a class="btn btn-primary-v2" style="width: auto;"  v-if="selectedItems.length === 1" @click="handleUpdateCostItem">Update Cost Item</a>
                    </div>
		            <a class="btn btn-outline-light"  style="width: auto;" @click="handleExport"><i class="icon-export mr-2"></i> &nbsp;Export</a>
		            <a class="btn btn-outline-light"  style="width: auto;" @click="handleImport"><i class="icon-import mr-2"></i> &nbsp;Import</a>
		            <a class="btn btn-primary-v2" style="width: auto;" @click="handleNewCostItem">New Cost Item</a>
                </div>
            </div>
        </div>
    </div>
    <div class="p-0" style="width: 100%; height: calc(100vh - 208px);">
        <div v-if="loading">
            <div class="col-md-12 d-flex flex-column align-items-center justify-content-center b-l-light " style="height: 100%; margin-top: 50px;">
                <div style="height: 40px;">
                    <LoadingStyleMetric />
                </div>
                <a class="f-w-600 mt-1 mb-5">Retreiving catalog items...</a>
            </div>
        </div>
        <div v-else-if="rowData.length === 0" class="d-flex justify-content-center align-items-center" style="width: 100%;">
            <div class="card m-0 shadow-sm d-flex flex-row align-items-center p-5 gap-4" style="border-radius: 10px;">
                <img src="https://buildovate-development.s3.us-west-1.amazonaws.com/images/sales/empty_catalog.png" alt="" style="height: 50vh;">
                <div>
                    <h3 class="f-50 f-w-800 text-primary m-0 p-0">Catalogs</h3>
                    <a class="f-20 f-w-600 text-primary" style="margin-top: -20px;">EFFICIENT, SEAMLESS and EFFECTIVE</a>
                    <p class="f-14 f-w-600 text-muted mt-3" style="width: 600px;">Enhance your proposal efficiency by detailing your products and services here. This streamlined list will not only simplify calculations but also integrate seamlessly with smart estimates, presenting your offerings in the most effective and appealing manner. </p>
                    <p class="f-16 f-w-600 text-primary mt-3">Elevate your business proposals with this essential tool for success.</p>
                    <div class="d-flex gap-3">
                        <a class="btn btn-primary-v2" style="width: auto;" @click="handleImport">IMPORT</a>
                        <a class="btn btn-primary-v2" style="width: auto;" @click="handleNewCostItem">CREATE ITEM</a>
                    </div>
                </div>
            </div>
        </div>
        <div v-else style="height: 100%;" class="position-relative">
            <RichTable 
                :headers="headers"
                :rows="rowData"
                :editable="false"
                :pagination="true"
                :currentPage="currentPage"
                :limit="pageLimit"
                :starting="startingEntry"
                :ending="endingEntry"
                :total="totalEntries"
                :totalPages="totalPages"
                :selectable="true"
                :rowHeight="125"
                @reload="handleTableReload"
                @onSelectionChange="handleSelectChange"
                />
            <div v-if="updating" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0;" class="bg-gray-25 d-flex align-items-center">
                <div class="col-md-12 d-flex flex-column align-items-center justify-content-center" style="height: 100%;">
                    <div style="height: 40px;">
                        <LoadingStyleMetric />
                    </div>
                    <a class="f-w-600 text-light f-20">Updating...</a>
                </div>
            </div>
        </div>
    </div>
    <CatalogImport :rows="excelData" />
</template>

<script>
import { usePage } from '@inertiajs/vue3';
import { useCostItemModal } from '../../stores/cost-item-modal';
import RichTable from '../../components/RichTable.vue';
import CatalogImport from '../../components/modals/CatalogImport.vue';
import LoadingStyleMetric from '../../components/LoadingStyleMetric.vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import * as XLSX from 'xlsx';

export default {
    props: {
        userId: {
            typeof: Number,
            default: 0
        }
    },
    components: {
        RichTable,
        CatalogImport,
        LoadingStyleMetric
    },
    setup(){
        const page = usePage();
        const store = useCostItemModal();

        return { page, store }
    },
    data(){
        const updating = false;
        const loading = false;
        const pageLimit = 25;
        const currentPage = 1;
        const totalPages = 0;
        const startingEntry = 0;
        const endingEntry = 0;
        const totalEntries = 0;
        const filters = {};
        const excelData = [];
        const rowData = [];
        const selectedItems = [];
        const selectCostItem = null;
        const headers = [
            { name: "check_column", min: 'auto'}, //Identifier for checklist
            { name: "Photo", min: '250px', max: '250px', type: 'image'},
            { name: "Item Description", min: '250px', max: '600px'},
            { name: "Owner Price", min: '150px'},
            { name: "Builder Price", min: '150px'},
            { name: "Last Updated", min: '150px'},
        ];

        return {
            updating,
            loading,
            pageLimit,
            currentPage,
            totalPages,
            startingEntry,
            endingEntry,
            totalEntries,
            filters,
            excelData,
            rowData,
            selectCostItem,
            selectedItems,
            headers
        }
    },
    methods: {
        handleImport() {
            document.querySelector('#import-catalog-input').click();
        },
        handleExport(){
            const cellValues = this.rowData.map(row => {
                const data = row.content['Action'].data;
                return data;
            })

            const arrayValue = [];
            const headers = ['Item ID', 'Title', 'Description', 'Unit Cost', 'Unit', 'Quantity', 'Builder Cost', 'Markup %', '$/Unit', 'Markup', 'Owner Price', 'Photo'];
            arrayValue.push(headers);

            cellValues.forEach(value => {
                const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });
                const numericFormatter = new Intl.NumberFormat('en-US', {
                    style: 'decimal',
                    minimumFractionDigits: 2, 
                });
                const builder_cost = (value.unit_cost * value.unit_quantity);
                const mark_up = value.unit_mark_up;
                const mark_up_type = value.unit_mark_up_type;
                const dollar_per_unit = mark_up_type === '$/' ? formatter.format(mark_up) : '';
                const actual_mark_up = this.getOwnerPrice(value) - builder_cost;
                const mark_up_percentage = mark_up_type === '%' ? numericFormatter.format(mark_up) + '%' : numericFormatter.format((actual_mark_up / builder_cost) * 100) + '%';

                arrayValue.push([
                        value.cost_item_id, 
                        value.title, 
                        value.description, 
                        formatter.format(value.unit_cost), 
                        value.unit, 
                        value.unit_quantity,
                        formatter.format(builder_cost),
                        mark_up_percentage,
                        dollar_per_unit,
                        actual_mark_up,
                        this.getOwnerPrice(value),
                        value.item_photo_url,
                    ]);
            });
            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(arrayValue);
            XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

            const wbout = XLSX.write(workbook, { bookType: 'xlsx', type: 'binary' });
            const blob = new Blob([this.s2ab(wbout)], { type: 'application/octet-stream' });
            const now = new Date();
            const formattedDate = now.toLocaleDateString('en-US', {
                year: 'numeric', month: '2-digit', day: '2-digit'
            }).replace(/\//g, '-');
            const formattedTime = now.toLocaleTimeString('en-US', {
                hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit'
            }).replace(/:/g, '-');

            const fileName = `Cost Items Export ${formattedDate} ${formattedTime}.xlsx`;
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);  
            }, 0);
        },
        s2ab(s){
            const buffer = new ArrayBuffer(s.length);
            const view = new Uint8Array(buffer);
            for (let i = 0; i < s.length; i++) {
                view[i] = s.charCodeAt(i) & 0xFF;
            }
            return buffer;
        },
        processExcel(event){
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                var modal = document.querySelector('#importCatalogReviewModal');
                var bootstrapModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
                bootstrapModal.show();

                const data = e.target.result;
                const workbook = XLSX.read(data, { type: 'binary' });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                this.excelData = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: false });

                event.target.value = '';
            };
            reader.readAsBinaryString(file);
        },
        handleDeleteClicked(){
            if(this.updating){
                return;
            }
            Swal.fire({
                icon: 'warning',
                title: `Delete ${this.selectedItems.length} selected item${this.selectedItems.length == 1 ? '' : 's'}?`,
                text: `Are you sure you want to delete this item${this.selectedItems.length == 1 ? '' : 's'}?`,
                showCancelButton: true,        // Show cancel button
                confirmButtonText: 'Delete',  // Text on the confirm button
                cancelButtonText: 'Cancel',   // Text on the cancel button
                confirmButtonColor: '#d33',   // Color of the confirm button
                cancelButtonColor: '#3085d6', // Color of the cancel button
                reverseButtons: true,         // Swap button positions
            }).then((result) => {
                if (result.isConfirmed) {
                    this.updating = true;
                    Promise.all(this.selectedItems.map(item => this.deleteCostItem(item.cost_item_id)))
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cost Item Delete Successful!',
                                text: `There's a ${this.selectedItems.length} total cost item deleted.`,
                            });
                        })
                        .catch(error => {
                            console.error('Error during deletion:', error);
                        })
                        .finally(() => {
                            this.fetchCostItems(this.currentPage, this.pageLimit, true);
                        });
                }
            });
        },
        handleUpdateCostItem() {
            this.store.setSelectedItem(this.selectedItems[0]);
            this.store.setType('database');
            this.store.toggleModal();
        },
        handleNewCostItem() {
            this.store.setSelectedItem(null);
            this.store.setType('database');
            this.store.toggleModal();
        },
        async deleteCostItem(cost_item_id){
            try {
                const response = await axios.delete(`/api/costItems/${cost_item_id}`, {}, {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                return response;
            } catch (error) {
                console.error('ERROR:', error);
                throw error;
            }
        },
        async fetchCostItems(pageNumber, limit = this.pageLimit, update = false) {
            if(!update){
                this.loading = true;
            }else{
                this.updating = true;
            }
            try {
                const response = await axios.get('/api/costItems', {
                    params: { 
                        page: pageNumber ,
                        limit: limit
                    },  // Pass the page as a query parameter
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if(response.data.status === 'success'){
                    const data = response.data.data;
                    
                    this.rowData = Object.values(data.data).map(cost_item => {
                        return {
                            id: cost_item.cost_item_id,
                            content: this.getRowContent(cost_item)
                        };
                    });

                    this.startingEntry = data.from;
                    this.endingEntry = data.to;
                    this.totalEntries = data.total;
                    this.totalPages = data.last_page || 0;
                }else{
                    console.error("Error fetching cost items:", response.data);
                }

                this.updating = false;
                this.loading = false;
            } catch (error) {
                console.error("Error fetching cost itens:", error);
                this.updating = false;
                this.loading = false;
            }
        },
        getRowContent(cost_item){
            let rowCells = [];
            this.headers.forEach(header => {
                const headerName = header.name;
                rowCells[headerName] = this.getCellContent(cost_item, headerName);

            });

            return rowCells
        },
        getCellContent(costitem, headerName) {
            let defaultCell = {
                className: '',
                content: '-',
                style: 'default',
                action: 'none',
                data: costitem
            }

            if (headerName === 'Photo'){
                defaultCell = {
                    className: '',
                    content: `<img style='overflow: hidden; height: 100%; width: 100%;' src='${costitem.item_photo_url}' alt='${costitem.cost_item_id}_${costitem.title}'/>`,
                    style: 'html-content',
                    action: 'click',
                    data: costitem
                }
            }

            if (headerName === 'Item Description'){
                defaultCell = {
                    className: 'cursor-pointer description-truncate',
                    content: `<a class="f-14 f-w-700">${costitem.title}</a><p class="m-0 p-">${costitem.description}</p>`,
                    style: 'html-content',
                    action: 'click',
                    data: costitem
                }
            }

            if (headerName === 'Description'){
                defaultCell = {
                    className: 'truncate cursor-pointer',
                    content: costitem.description ? costitem.description : 'N/A',
                    style: 'default',
                    action: 'none',
                    data: costitem
                }
            }

                                    
            if (headerName === 'Owner Price'){
                defaultCell = {
                    className: 'truncate',
                    content: `<a class="f-14 f-w-600">${this.formatCurrency(this.getOwnerPrice(costitem))}</a>`,
                    style: 'default',
                    action: 'none',
                    popoverContent: null,
                    data: costitem
                }
            }

            if (headerName === 'Builder Price'){
                defaultCell = {
                    className: 'truncate f-14',
                    content: `<a class="f-14 f-w-600">${this.formatCurrency(this.getBuilderPrice(costitem))}</a>`,
                    style: 'default',
                    action: 'none',
                    popoverContent: null,
                    data: costitem
                }
            }

            if (headerName === 'Last Updated'){
                const updated_by = costitem.updated_by;
                const changed_by = updated_by ? costitem.updated_by : costitem.created_by;
                const display_name = changed_by ? changed_by.display_name : this.userId;
                defaultCell = {
                    className: 'truncate f-14',
                    content:  `<a class="f-14 f-w-700">Date:  ${this.formatDate(costitem.updated_at)}</a><p class="m-0 p-">By: ${display_name}</p>`,
                    style: 'html-content',
                    action: 'none',
                    popoverContent: null,
                    data: costitem
                }
            }

            if (headerName === 'Action'){
                defaultCell = {
                    className: 'f-16',
                    content: this.getBuilderPrice(costitem),
                    style: 'action',
                    action: 'edit',
                    popoverContent: null,
                    data: costitem
                }
            }
            
            

            return defaultCell;
        },
        formatDate(date){
            if(date){
                const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                
                const d = new Date(date);
                const monthName = months[d.getMonth()]; // getMonth() returns month index (0-11)
                const day = d.getDate();
                const year = d.getFullYear();
                
                return `${monthName} ${day}, ${year}`;
            }else{
                return 'N/A';
            }
        },
        formatCurrency(amount) {
            if(amount){
                const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });
                return formatter.format(parseFloat(amount).toFixed(2));
            }else{
                return '$0.0';
            }
        },
        getBuilderPrice(costitem){
            let unit_cost = costitem.unit_cost;
            let unit_quantity = costitem.unit_quantity;

            if(!unit_cost){
                unit_cost = 0; 
            }

            if(!unit_quantity){
                    unit_quantity = 1;
            }

            return unit_cost * unit_quantity;
        },
        getOwnerPrice(costitem){
            const builder_cost = this.getBuilderPrice(costitem);
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
            
            return totalMarkup;
        },
        handleSelectChange(selectedItems){
            this.selectedItems = selectedItems;
        },
        handleTableReload(data){
            this.currentPage = data.currentPage;
            this.pageLimit = data.pageLimit;
            this.fetchCostItems(this.currentPage, this.pageLimit, true);
        }
    },
    mounted(){
        this.fetchCostItems(this.currentPage, this.pageLimit);
    },
    computed: {
        itemUpdate() {
            return this.store.updatedItem;
        }
    },
    watch: {
        itemUpdate: {
            handler(newItem) {
                if(newItem){
                    this.fetchCostItems(this.currentPage, this.pageLimit, true);
                }
            }, deep: true
        }
    }
}
</script>

