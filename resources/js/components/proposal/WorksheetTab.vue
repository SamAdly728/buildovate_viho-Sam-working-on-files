<template>
    <div class="d-flex flex-column py-3 gap-4">
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex bg-secondary-light b-radius-5 p-3 gap-3">
                <div class="d-flex flex-column">
                    <label class="m-0 f-14 f-w-500" style="height: 18px;">Total Client Price</label>
                    <label class="m-0 f-25 text-primary-v2 f-w-700">$500.0</label>
                </div>
                <div class="d-flex flex-column">
                    <label class="m-0 f-14 f-w-500" style="height: 18px;"></label>
                    <label class="m-0 f-25 text-primary-v2 f-w-700">-</label>
                </div>
                <div class="d-flex flex-column">
                    <label class="m-0 f-14 f-w-500" style="height: 18px;">Total Builder Cost</label>
                    <label class="m-0 f-25 text-primary-v2 f-w-700">$300.0</label>
                </div>
                <div class="d-flex flex-column">
                    <label class="m-0 f-14 f-w-500" style="height: 18px;"></label>
                    <label class="m-0 f-25 text-primary-v2 f-w-700">=</label>
                </div>
                <div class="d-flex flex-column">
                    <label class="m-0 f-14 f-w-500" style="height: 18px;">Estimated Profit</label>
                    <label class="m-0 f-25 text-primary-v2 f-w-700">$200.0</label>
                </div>
            </div>
            <div class="btn-outline-custom-muted px-3 py-2 b-radius-8 d-flex align-items-center gap-2" style="cursor: pointer;" @mouseenter="hovered(true)" @mouseleave="hovered(false)">
                <i class="fi fi-rr-plus" :class=" !discountHovered ? 'text-primary-v2' : 'text-white'" style="height: 16px;"></i> Discount
            </div>
            <span class="flex-grow-1"></span>
            <div class="d-flex gap-3">
                <div class="btn-danger-v2 px-3 py-2 b-radius-8 d-flex align-items-center gap-2" style="cursor: pointer;" @click="handleDeleteItem" v-if="selectedItems.length != 0">
                    <i class="fi fi-rr-trash-xmark" style="height: 16px;"></i> Delete
                </div>
                <div class="position-relative">
                    <div class="btn-primary-v2 px-3 py-2 b-radius-8 d-flex align-items-center gap-2" style="cursor: pointer;" @click="handleAddDropdown">
                        <i class="fi fi-rr-plus" style="height: 16px;"></i> Add
                    </div>
                    <div style="position: absolute; top: 35px; width: 200px; left: -115px;" class="shadow-lg b-radius-10" v-if="toggleAddDropdown">
                        <div class="bg-white d-flex flex-column b-radius-10" style="overflow: hidden;">
                            <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleAddItem">
                                <i class="fi fi-rr-add text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">New Item</span>
                            </div>
                            <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleAddItem">
                                <i class="fi fi-rr-list text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">Optional Item</span>
                            </div>
                            <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleEstimateItem">
                                <i class="fi fi-rr-folder-tree text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">Smart Estimate</span>
                            </div>
                            <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleCatalogItem">
                                <i class="fi fi-rr-book-alt text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">From Catalog</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <DesignTable 
            :rows="workOrders"
            :headers="headers"
            :editable="false"
            :pagination="true"
            :selectable="true"
            :currentPage="currentPage"
            :limit="pageLimit"
            :starting="starting"
            :ending="ending"
            :total="total"
            :totalPages="totalPages"
            :loading="loading || updating"
            :resetCounter="resetCounter"
            @updatedItem="handleUpdatedItem"
            @selectedItems="handleSelectedItems"
            />
    </div>
</template>
<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import DesignTable from './DesignTable.vue';
    import { useCostItemsModal } from '@/stores/cost-items-modal';
    import { useCostItemModal } from '@/stores/cost-item-modal';

    export default {
        components: { DesignTable },
        props: {
            proposalId: {
                typeof: Number,
                default: 0
            }
        },
        setup(){
            const costItemStore = useCostItemModal();
            const costItemsStore = useCostItemsModal();

            return { costItemStore, costItemsStore }
        },
        data(){
            const workOrders = [];
            const discountHovered = false;
            const headers = [
                {name: 'checkbox', max: 40, min: 40},
                {name: 'Item', key: 'title', max: 200, min: 200, format: 'text', disabled: true},
                {name: 'Description', key: 'description', format: 'textarea'},
                {name: 'Unit Cost', key: 'unit_cost', max: 100, min: 100, format: 'currency'},
                {name: 'Quantity', key: 'unit_quantity', max: 80, min: 80, format: 'number'},
                {name: 'Unit', key: 'unit', max: 80, min: 80, format: 'text'},
                {name: 'Labor Type', key: 'labor', max: 100, min: 100, format: 'options'},
                {name: 'Margin', key: 'margin', max: 80, min: 80, format: 'number', disabled: true},
                {name: 'Mark-up', key: 'markup', max: 130, min: 130, format: 'mark_up' },
                {name: 'Builder Cost', key: 'builder_cost', max: 100, min: 100, format: 'currency', disabled: true},
                {name: 'Client Price', key: 'client_price', max: 100, min: 100, format: 'currency', disabled: true},
            ];
            const updating = false;
            const loading = false;
            const pageLimit = 25;
            const currentPage = 1;
            const totalPages = 0;
            const starting = 0;
            const ending = 0;
            const total = 0;
            const selectedItems = [];
            const resetCounter = 0;
            const toggleAddDropdown = false;

            return { discountHovered, workOrders, headers, updating, loading, pageLimit, currentPage, totalPages, starting, ending, total, selectedItems, resetCounter, toggleAddDropdown }
        },
        computed: {
            // selectedEstimates() {
            //     if(this.smartEstimateListStore){
            //         return this.smartEstimateListStore.selectedEstimates;
            //     }else{
            //         return null;
            //     }
            // },
            selectedCostItems() {
                if(this.costItemsStore){
                    return this.costItemsStore.selectedItems;
                }else{
                    return null;
                }
            },
            submitedItem(){
                return this.costItemStore.itemObject;
            }
        },
        mounted(){
            if(this.proposalId){
                this.getProposals();
            }
        },
        watch: {
            submitedItem: {
                handler(item){
                    if(item){
                        if(item.proposal_item_id){
                            this.workOrders = this.workOrders.map(workOrder => {
                                if(workOrder.proposal_item_id == item.proposal_item_id){
                                    const builder_cost = (item.unit_cost) * (item.unit_quantity);
                                    const client_price = this.getClientPrice(item);
                                    const margin = this.getMargin(item);
                                    const markup = this.getMarkup(item);

                                    return {
                                        ...item,
                                        builder_cost,
                                        client_price,
                                        margin,
                                        markup
                                    }
                                }else{
                                    return {
                                        ...workOrder
                                    }
                                }
                            });
                            this.updateProposalItem(item, item.proposal_item_id);
                        }else{
                            const data = {
                                ...item,
                                proposal_id: this.proposalId
                            }
                            this.addProposalItem(data);
                        }
                    }
                }
            },
            selectedCostItems: {
                handler(newValue){
                    if(newValue){
                        newValue.forEach(item => {
                            const data = {
                                ...item,
                                proposal_id: this.proposalId
                            }
                            this.addProposalItem(data);
                        });
                    }
                }
            },
        },
        methods: {
            handleAddDropdown(){
                this.toggleAddDropdown = !this.toggleAddDropdown
            },
            handleDeleteItem(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "After deleting this, you won't be able to retrieve it.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.resetCounter++;
                        this.selectedItems.forEach(item => {
                            this.deleteProposalItem(item.proposal_item_id);
                        });

                        this.workOrders = this.workOrders.filter(item => !(this.selectedItems.find(selected => selected.proposal_item_id === item.proposal_item_id)));
                    }
                });
            },
            handleSelectedItems(items){
                this.selectedItems = items;
            },
            handleCatalogItem(){
                this.toggleAddDropdown = false;
                this.costItemsStore.toggleModal();
            },
            handleEstimateItem(){
                this.toggleAddDropdown = false;
            },
            handleAddItem(){
                this.toggleAddDropdown = false;
                this.resetCounter++;
                this.costItemStore.setSelectedItem(null);
                this.costItemStore.setType('worksheet');
                this.costItemStore.toggleModal();
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
            hovered(hovered) {
                this.discountHovered = hovered
            },
            handleUpdatedItem(item){
                this.workOrders = this.workOrders.map(workOrder => {
                    if(workOrder.proposal_item_id == item.proposal_item_id){
                        const builder_cost = (item.unit_cost) * (item.unit_quantity);
                        const client_price = this.getClientPrice(item);
                        const margin = this.getMargin(item);
                        const markup = this.getMarkup(item);

                        return {
                            ...item,
                            builder_cost,
                            client_price,
                            margin,
                            markup
                        }
                    }else{
                        return {
                            ...workOrder
                        }
                    }
                });
                this.updateProposalItem(item, item.proposal_item_id);
            },
            getClientPrice(item){
                if(item){
                    const unit_quantity = item.unit_quantity ? item.unit_quantity : 0;
                    const unit_cost = item.unit_cost ? item.unit_cost : 0;
                    const markup = item.unit_mark_up ? item.unit_mark_up : 0;
                    const markup_type = item.unit_mark_up_type ? item.unit_mark_up_type : '--';
                    const builderCost = unit_quantity * unit_cost;
                    let totalMarkup = 0;

                    if(markup_type){
                        if(markup_type === '%'){
                            totalMarkup =  builderCost + ((builderCost) * (markup/100));
                        }else if(markup_type === '$/'){
                            totalMarkup = (markup * unit_quantity) + builderCost;
                        }else{
                            totalMarkup = parseFloat(markup) + parseFloat(builderCost);
                        }
                    }
                        
                    return totalMarkup;
                }else{
                    return 0;
                }
            },
            getMargin(item){
                if(item){
                    const builderCost = item.unit_cost * item.unit_quantity;
                    const clientPrice = this.getClientPrice(item);
                    
                    const margin = (parseFloat(clientPrice) - builderCost) / builderCost;
                    return (margin * 100).toFixed(2) + "%";
                }else{
                    return '0%';
                }
            },
            getMarkup(item){
                if(item){
                    const type = item.unit_mark_up_type ? item.unit_mark_up_type : '--';
                    const unit = item.unit ? item.unit : 'Unit';
                    if(type === '%'){
                        return parseFloat(item.unit_mark_up) + type;
                    }else if(type === '$/'){
                        return this.formatCurrency(parseFloat(item.unit_mark_up)) + '/' + unit;
                    }else{
                        return this.formatCurrency(parseFloat(item.unit_mark_up));
                    }
                }else{
                    return '0%';
                }
            },
            async updateProposalItem(data, id) {
                try {
                    await axios.put(`/api/work-orders/${id}`, data, {
                        headers: {
                            'Authorization': 'Bearer ',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                } catch (error) {
                    console.error("Error fetching customers: ", error);
                }
            },
            async deleteProposalItem(id) {
                try {
                    await axios.delete(`/api/work-orders/${id}`, {}, {
                        headers: {
                            'Authorization': 'Bearer ',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                } catch (error) {
                    console.error("Error fetching customers: ", error);
                }
            },
            async addProposalItem(data) {
                try {
                    const response = await axios.post(`/api/work-orders`, data, {
                        headers: {
                            'Authorization': 'Bearer ',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if(response){
                        const result = response.data;
                        if(result){
                            const data = result.data;
                            const builder_cost = (data.unit_cost) * (data.unit_quantity);
                            const client_price = this.getClientPrice(data);
                            const margin = this.getMargin(data);
                            const markup = this.getMarkup(data);

                            this.workOrders.unshift({
                                ...data,
                                builder_cost,
                                client_price,
                                margin,
                                markup
                            });
                        }
                    }
                } catch (error) {
                    console.error("Error fetching customers: ", error);
                }
            },
            async getProposals() {
                this.loading = true;
                try {
                    const response = await axios.get(`/api/work-orders/all/${this.proposalId}`, {}, {
                        headers: {
                            'Authorization': 'Bearer ',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if(response){
                        const result = response.data;
                        if(result){
                            const data = result.data;

                            const calcultedData = data.data.map(item => {
                                const builder_cost = (item.unit_cost) * (item.unit_quantity);
                                const client_price = this.getClientPrice(item);
                                const margin = this.getMargin(item);
                                const markup = this.getMarkup(item);

                                return {
                                    ...item,
                                    builder_cost,
                                    client_price,
                                    margin,
                                    markup
                                }
                            });

                            this.workOrders = calcultedData;
                            this.starting = data.from;
                            this.ending = data.to;
                            this.total = data.total;
                            this.totalPages = data.last_page || 0;

                            console.log(this.workOrders);
                        }else{
                            console.log('Empty Data', result);
                        }
                    }

                    this.loading = false;
                    this.updating = false;
                } catch (error) {
                    console.error("Error fetching customers: ", error);
                    this.loading = false;
                    this.updating = false;
                }
            }
        }
    }
</script>