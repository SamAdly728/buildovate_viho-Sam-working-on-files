<template>
    <div class="modal fade" id="costItemListModal" tabindex="-1" role="dialog" aria-labelledby="costItemListModal" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0" style="max-height: 93vh !important;">
                    <div class="card p-0 m-0" style="max-height: 93vh !important; overflow: hidden;">
                        <div class="card-header border">
                            <h5>Select Cost Item</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"></button>
                        </div>
                        <div class="card-body row p-0 m-0">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center justify-content-start m-3 gap-2" style="height: 50px; width: auto; float: right; width: auto;">
                                    <a class="btn btn-outline-light ml-2"  style="width: auto;"><i class="icon-import mr-2"></i> Export</a>
                                    <a class="btn btn-outline-light ml-2"  style="width: auto;"><i class="icon-export mr-2"></i> Import</a>
                                    <a class="btn btn-primary-v2 ml-2" style="width: auto;" @click="handleNewCostItem">New Cost Item</a>
                                </div>
                            </div>
                            <div class="p-0" style="width: 100%; height: calc(90vh - 208px);">
                                <RichTable 
                                    :headers="headers"
                                    :rows="rowData"
                                    :editable="false"
                                    :selectable="true"
                                    :rowHeight="125"
                                    @onSelectionChange="handleSelectChange"
                                />
                            </div>
                            <div class="col-md-12 bg-white">
                                <div class="d-flex justify-content-between m-3">                          
                                    <button class="btn btn-light mr-2" data-bs-dismiss="modal"  @click="store.closeModal()">Close</button>
                                    <div class="d-flex align-items-center gap-2" v-if="selectedCostItems.length != 0">
                                        <a class="f-14 text-muted text-right">Selected {{ selectedCostItems.length }} item{{ selectedCostItems.length > 1 ? 's' : ''}}</a>
                                        <button class="btn btn-primary-v2" @click="handleSelectedCostItems" data-bs-dismiss="modal">SELECT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import { useCostItemsModal } from '../../stores/cost-items-modal';
import { usePage } from '@inertiajs/vue3';
import RichTable from '../RichTable.vue';
import axios from 'axios';


export default {
    components: {
        RichTable
    },
    setup() {
        const store = useCostItemsModal();
        const page = usePage();

        return {
            page,
            store
        }
    },
    data(){
        const loading = false;
        const pageLimit = 25;
        const currentPage = 1;
        const totalPages = 0;
        const startingEntry = 0;
        const endingEntry = 0;
        const totalEntries = 0;
        const rowData = [];
        const selectedCostItems = [];
        const selectCostItem = null;
        const headers = [
            { name: "check_column", min: 'auto'}, //Identifier for checklist
            { name: "Photo", min: '250px', max: '250px', type: 'image'},
            { name: "Item Description", min: '250px', max: '400px'},
            { name: "Owner Price", min: '150px'},
            { name: "Builder Price", min: '150px'},
        ];

        return {
            loading,
            pageLimit,
            currentPage,
            totalPages,
            startingEntry,
            endingEntry,
            totalEntries,
            rowData,
            selectedCostItems,
            selectCostItem,
            headers
        }
    },
    methods: {
        handleSelectChange(items) {
            this.selectedCostItems = items;
        },
        handleNewCostItem() {
            var modal = document.querySelector('#costItemModal');
            var bootstrapModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
            bootstrapModal.show();
            this.store.setSelectedItems(null);
        },
        selectedRows(value) {
            this.selectedCostItems = value;
        },
        handleSelectedCostItems() {
            this.store.toggleModal();
            this.store.setSelectedItems(this.selectedCostItems);
            this.selectCostItem = null;
        },
        getRowContent(proposal){
            let rowCells = [];
            this.headers.forEach(header => {
                const headerName = header.name;
                rowCells[headerName] = this.getCellContent(proposal, headerName);
            });

            return rowCells;
        },
        updateModalVisibility() {
            const modalElement = document.getElementById('costItemListModal');
            const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

            if (this.store.isModalOpen) {
                this.fetchCostItems(this.currentPage, this.pageLimit);
                modalInstance.show();
            } else {
                document.querySelector(`#costItemListModal .btn-close`).click();
            }
        },
        async fetchCostItems(pageNumber, limit = this.pageLimit) {
            this.loading = true;
            try {
                const response = await axios.get('/api/costItems', {
                    params: { 
                        page: pageNumber ,
                        limit: limit
                    },
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
                            content: this.getRowContent(cost_item),
                            data: cost_item
                        };
                    });

                    this.startingEntry = data.from;
                    this.endingEntry = data.to;
                    this.totalEntries = data.total;
                    this.totalPages = data.last_page || 0;
                }else{
                    console.error("Error fetching cost items:", response.data);
                }
                this.loading = false;
            } catch (error) {
                console.error("Error fetching cost itens:", error);
                this.loading = false;
            }
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

                                    
            if (headerName === 'Owner Price'){
                defaultCell = {
                    className: 'truncate f-14',
                    content: this.formatCurrency(this.getOwnerPrice(costitem)),
                    style: 'default',
                    action: 'none',
                    popoverContent: null,
                    data: costitem
                }
            }

            if (headerName === 'Builder Price'){
                defaultCell = {
                    className: 'truncate f-14',
                    content: this.getBuilderPrice(costitem),
                    style: 'default',
                    action: 'none',
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
        getOwnerPrice(costitem){
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
        getBuilderPrice(costitem){
            const owner_price = this.getOwnerPrice(costitem);
            const markup = costitem.unit_mark_up;
            const markup_type = costitem.unit_mark_up_type;
            const unit_quantity = costitem.unit_quantity;
            const unit_cost = costitem.unit_cost;
            let totalMarkup = 0;

            if(markup_type){
                if(markup_type === '%'){
                    totalMarkup =  owner_price + ((owner_price) * (markup/100));
                }else if(markup_type === '$/'){
                    totalMarkup = (markup * unit_quantity) + owner_price;
                }else{
                    totalMarkup = markup + owner_price;
                }
            }
                
            return this.formatCurrency(totalMarkup);
        }
    },
    mounted() {
        this.updateModalVisibility();
    },
    computed: {
        isModalOpen() {
            return this.store.isModalOpen;
        }
    },
    watch: {
        pageLimit: {
            handler(newValue){
                this.currentPage = 1;
                if (this.store.isModalOpen) {
                    this.fetchCostItems(this.currentPage, newValue);
                }
            }
        },
        isModalOpen: {
            handler() {
                this.updateModalVisibility();
            }
        }
    }
}
</script>