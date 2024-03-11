<template>
    <div class="row p-0 m-0" style="overflow: hidden"> 
        <div v-if="loading">
            <div class="col-md-12 d-flex flex-column align-items-center justify-content-center b-l-light " style="height: 100%; margin-top: 50px;">
                <div style="height: 40px;">
                    <LoadingStyleMetric />
                </div>
                <a class="f-w-600 mt-1 mb-5">Retreiving worksheets data...</a>
            </div>
        </div>
        <div class="container" v-else-if="worksheet.length == 0">
            <div class="col-md-12 d-flex align-items-center gap-5 justify-content-center my-4">
                <div class="d-flex flex-column align-items-center gap-3">
                    <img :src="asset_link + 'sales/add+item.png'" alt="" style="height: 180px;">
                    <p class="f-w-600 text-center text-muted m-0">Add your very first item in this proposal.</p>
                    <a class="btn btn-primary-v2" style="width: auto;" @click="handleAddItem">CREATE ITEM</a>
                </div>
                <div class="d-flex flex-column align-items-center gap-3">
                    <img :src="asset_link + 'sales/import+catalog.png'" alt="" style="height: 180px;">
                    <p class="f-w-600 text-center text-muted m-0">Import items from catalog to this proposal.</p>
                    <a class="btn btn-primary-v2" style="width: auto;" @click="handleCatalogClicked">IMPORT FROM CATALOG</a>
                </div>
                <div class="d-flex flex-column align-items-center gap-3">
                    <img :src="asset_link + 'sales/import+estimates.png'" alt="" style="height: 180px;">
                    <p class="f-w-600 text-center text-muted m-0">Import items from smart estimate</p>
                    <a class="btn btn-primary-v2" style="width: auto;" @click="handleEstimateClicked">IMPORT SMART ESTIMATE</a>
                </div>
            </div>
        </div>
        <div class="m-0 p-0" v-else>
            <div class="col-md-12 m-0 p-0 d-flex">
                <div class="m-0 p-0 px-2 py-1">
                    <Estimate 
                        :owner_price="this.sumOwnerPrice" 
                        :builder_cost="this.sumBuilderCost" 
                        :markup="this.totalMarkup" 
                        :margin="this.totalMargin" 
                        :profit="formatCurrency((worksheetStore.profit - worksheetStore.discount).toFixed(2))" 
                        :discount="formatCurrency(worksheetStore.discount)"/>
                </div>
                <div class="m-0 p-0 d-flex align-items-center justify-content-end flex-grow-1">
                    <div class="d-flex justify-content-between flex-grow-1" v-if="proposal_form && proposal_form.status != 'Approved'">
                        <div class="btn btn-outline-light" @click="handleDiscount">Discount</div>
                        <button 
                            class="btn btn-secondary mr-2 d-none" 
                            type="button"
                            style="color: white"
                            @click="undoChanges"
                            :class="JSON.stringify(initialWorksheet) !== JSON.stringify(proposal_form.worksheet) ? '' : 'd-none'">Undo Changes</button>
                        <div class="flex-grow-1">

                        </div>
                        <div class="d-flex gap-2">
                            <div class="btn position-relative p-0">
                                <div class="btn btn-outline-light import-pop-over" @click="toggleImportPopover"  style="width: auto;"><i class="icon-import mr-2"></i> Import</div>
                                <div v-if="showImportOptions"
                                    @click="toggleImportPopover"
                                    class="import-popover d-flex cursor-default">

                                <div class="d-flex flex-column justify-item-center align-items-center text-dark import-hover-effect p-2 cursor-pointer"
                                    @click="handleCatalogClicked">
                                    <i class="icon-book f-40"></i>
                                    <span class="mt-2 f-w-600">From Catalog</span>
                                </div>
                                <div class="bg-primary mx-3" style="width: 1px; height: 120;"></div>
                                <div class="d-flex flex-column justify-item-center align-items-center text-dark import-hover-effect p-2 cursor-pointer"
                                    @click="handleEstimateClicked">
                                    <i class="icon-stats-up f-40"></i>
                                    <span class="mt-2 f-w-600">From Estimates</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2" v-if="checkedItems.length != 0" >
                            <button class="btn btn-danger-v2" 
                                type="button" 
                                style="color: white"
                                @click="deleteCheckedItems">Delete</button>
                        </div>
                        <button v-else
                            class="btn btn-primary-v2" 
                            type="button"  
                            @click="handleAddItem">Add Item</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="height: 100%; max-height: calc(100vh - 460px);">
                <RichTable 
                    :headers="headers"
                    :rows="rowData"
                    :editable="editable"
                    :selectable="selectable"
                    @onSelectionChange="handleSelectChange"
                    @onRowChanged="handleRowChange"
                    @cellClick="cellClicked"
                />
            </div>
        </div>
    </div>
</template>
<script>
    import { useSmartEstimateListModal } from '@/stores/smart-estimate-list-modal';
    import { useSmartEstimateModal } from '@/stores/smart-estimate-modal';
    import { useCostItemsModal } from '@/stores/cost-items-modal';
    import { useCostItemModal } from '@/stores/cost-item-modal';
    import { useWorksheet } from '@/stores/worksheet-table';
    import { usePage } from '@inertiajs/inertia-vue3';
    import RichTable from '../RichTable.vue';
    import Estimate from '../Estimate.vue';
    import LoadingStyleMetric from '../LoadingStyleMetric.vue';
    import axios from 'axios';
    import Swal from 'sweetalert2';

    export default {
        components: { RichTable, Estimate, LoadingStyleMetric },
        setup() {
            const page = usePage();
            const smartEstimateListStore = useSmartEstimateListModal();
            const store = useSmartEstimateModal();
            const costItemsStore = useCostItemsModal();
            const costItemStore = useCostItemModal();
            const worksheetStore = useWorksheet();

            return { page, store, smartEstimateListStore, costItemsStore, worksheetStore, costItemStore };
        },
        data(){
            const asset_link = window.asset_link;
            const initialWorksheet = [];
            const worksheet = [];
            const checkedItems = [];
            const rowData = [];
            const sumBuilderCost = 0.0;
            const sumOwnerPrice = 0.0;
            const estimatedProfit = 0.0;
            const totalMargin = 0.0;
            const totalMarkup = 0.0;
            const loading = false;
            const showImportOptions = false;
            const selectedItem = {};
            const costItemType = 'default';
            const headers = [
                    { name: "check_column", min: 'auto'}, //Identifier for checklist
                    { name: "Item", min: '200px', max: '300px', form_type: 'text', disabled_edit: true},
                    { name: "Description", min: '250px', form_type: 'textarea'},
                    { name: "Unit Cost", min: '150px', max: '150px', form_type: 'decimal'},
                    { name: "Quantity", min: '100px', max: '100px', form_type: 'number'},
                    { name: "Unit", min: '100px', max: '100px', form_type: 'text'},
                    { name: "Labor Type", min: '150px', max: '150px', form_type: 'selection', selection_options: [
                        { display: 'Labor', value: 1},
                        { display: 'Labor + Material', value: 2}
                    ]},
                    { name: "Margin", min: '100px', max: '100px', disabled_edit: true},
                    { name: "Markup", min: '200px', form_type: 'mark_up'},
                    { name: "Builder Cost", min: '150px', max: '150px', form_type: 'builder_cost'},
                    { name: "Client Price", min: '150px', max: '150px', form_type: 'owner_price'},
                ];
            return {
                initialWorksheet,
                worksheet,
                checkedItems,
                rowData,
                sumBuilderCost,
                sumOwnerPrice,
                estimatedProfit,
                totalMargin,
                totalMarkup,
                loading,
                showImportOptions,
                selectedItem,
                costItemType,
                headers,
                asset_link
            };
        },
        props: {
            propsWorksheet: {
                typeof: Array,
                default: []
            },
            proposal_id: {
                typeof: Number,
                default: 0
            },
            selectable: {
                typeof: Boolean,
                default: true
            },
            editable: {
                typeof: Boolean,
                default: true
            },
            proposal_form: {
                typeof: Object,
                default: null
            }
        },
        emits: ['onSelectedItems', 'onRowChanged'],
        mounted() {
            document.addEventListener('click', this.handleDocumentClick());
        },
        beforeDestroy() {
            document.removeEventListener('click', this.handleDocumentClick());
        },
        methods: {
            formatCurrency(amount) {
                    if(amount){
                        const formatter = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD',
                        });
                        return formatter.format(parseFloat(amount));
                    }else{
                        return '$0.0';
                    }
            },
            handleDiscount(){
                const modalElement = document.getElementById('addDiscount');
                const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});
                modalInstance.show();
            },
            cellClicked(value){
                if(value.headerName === 'Item'){
                    console.log(value);
                    this.costItemStore.setSelectedItem(value.data);
                    this.costItemStore.setType('worksheet');
                    this.costItemStore.toggleModal();
                }
            },
            getRowContent(item){
                let rowCells = [];
                this.headers.forEach(header => {
                    const headerName = header.name;
                    rowCells[headerName] = this.getCellContent(item, headerName);

                });
                return rowCells;
            },
            getCellContent(item, headerName){
                let className = '';
                let content = '-';
                let action = 'none';

                const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });

                if (headerName === 'Item'){
                    className = 'text-truncated underline-effect';
                    action = 'click';
                    content = `<a class='f-w-700 text-primary-v2' style='cursor: pointer;'>${item.title}</a>`;
                }
                
                if (headerName === 'Description'){
                    className = 'text-truncated';
                    content = item.description;
                }

                if (headerName === 'Unit Cost'){
                    content = formatter.format(item.unit_cost);
                }

                if (headerName === 'Quantity'){
                    content = item.unit_quantity;
                }
                
                if(headerName === 'Unit'){
                    content = item.unit;
                }

                if (headerName === 'Labor Type'){
                    content = item.labor == 1 ? 'Labor' : 'Labor + Material';
                }

                if (headerName === 'Builder Cost'){
                    content = formatter.format(item.unit_cost * item.unit_quantity);
                }

                if (headerName === 'Markup'){
                    const type = item.unit_mark_up_type ? item.unit_mark_up_type : '--';
                    const unit = item.unit ? item.unit : 'Unit';
                    if(type === '%'){
                        content = parseFloat(item.unit_mark_up) + item.unit_mark_up_type;
                    }else if(type === '$/'){
                        content = formatter.format(parseFloat(item.unit_mark_up)) + '/' + unit;
                    }else{
                        content = formatter.format(parseFloat(item.unit_mark_up));
                    }
                }
                
                if (headerName === 'Client Price'){
                    content = this.setOwnerPrice(item);
                }

                if (headerName === 'Margin') {
                    const builder_cost = item.unit_cost * item.unit_quantity;
                    const client_price = this.setOwnerPrice(item);
                    
                    const margin = (parseFloat(client_price.replace(/[$,]/g, '')) - builder_cost) / builder_cost;
                    content = (margin * 100).toFixed(2) + "%";
                }

                return {
                        className: className,
                        content: content,
                        style: 'default',
                        action: action,
                        data: item
                    }
            },
            setOwnerPrice(item){
                if(item){
                    const builder_cost = parseFloat(item.unit_cost * item.unit_quantity);
                    const item_m_type = item.unit_mark_up_type ? item.unit_mark_up_type : '--';
                    const item_m_amount = parseFloat(item.unit_mark_up ? item.unit_mark_up : 0.0);
                    const quantity = item.unit_quantity ? item.unit_quantity : 0;
                    let markUpReturn = '';

                    const formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                    });

                    if(item_m_type === '%'){
                        return formatter.format(builder_cost + ((item_m_amount/100) * builder_cost));
                    }else if(item_m_type === '$/'){
                        return formatter.format(builder_cost + (item_m_amount * quantity));
                    }else if(item_m_type === '$'){
                        return formatter.format(builder_cost + item_m_amount);
                    }else if(item_m_type === '--'){
                        return formatter.format(builder_cost);
                    }

                    return markUpReturn;
                }else{
                    return '$0.0';
                }
            },
            setMarkupColumn(item){
                if(item){
                    const item_m_type = item.unit_mark_up_type;
                    const item_m_amount = item.unit_mark_up;
                    const item_unit = item.unit;
                    let markUpReturn = '';

                    const formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                    });

                    if(item_m_type === '%'){
                        return formatter.format(item_m_amount) + '%';
                    }else if(item_m_type === '$/'){
                        return formatter.format(item_m_amount) + '/' + item_unit;
                    }else if(item_m_type === '$'){
                        return formatter.format(item_m_amount);
                    }else if(item_m_type === '--'){
                        return '--'
                    }

                    return markUpReturn;
                }else{
                    return 'N/A';
                }
            },
            getMarkup(unit_mark_up_type, unit_mark_up, unit_quantity, builder_cost){
                let markUpReturn = 0.0;

                if(unit_mark_up_type === '%'){
                    return ((unit_mark_up/100) * builder_cost);
                }else if(unit_mark_up_type === '$/'){
                    return (unit_mark_up * unit_quantity);
                }else if(unit_mark_up_type === '$'){
                    return unit_mark_up;
                }else if(unit_mark_up_type === '--'){
                    return 0.0;
                }

                return markUpReturn;
            },
            async getProposalItems(proposal_id){
                try {
                    this.loading = true;
                    this.worksheetStore.setLoading(this.loading);

                    const response = await axios.get(`/api/proposals/items/${proposal_id}`, {}, {
                        headers: {
                            'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = response.data;
                    const worksheets = data.data.map(worksheet => {
                        if (!worksheet.uid) {
                            let uniqueId;
                            do {
                                uniqueId = this.uniqueId();
                            } while (this.isUniqueIdTaken(uniqueId));
                            return { ...worksheet, uid: uniqueId };
                        }
                        return worksheet;
                    });
                    this.worksheet = worksheets;
                    this.worksheetStore.setWorksheet(this.worksheet);
                    this.calculateEstimate(data.data)
                    
                    this.loading = false;
                    this.worksheetStore.setLoading(this.loading);
                } catch (error) {
                    console.error("Error fetching proposal items: ", error);
                    this.loading = false;
                    this.worksheetStore.setLoading(this.loading);
                }
            },
            handleEstimateClicked(){
                this.smartEstimateListStore.toggleModal();
            },
            handleNewCostItem(value){
                const item = value;
                const newItem = {
                    proposal_item_id: 0,
                    proposal_id: this.proposal_id,
                    ...item,
                }
                this.worksheet.push(newItem);
            },
            handleAddItem(){
                this.costItemStore.setSelectedItem(null);
                this.costItemStore.setType('worksheet');
                this.costItemStore.toggleModal();
            },
            handleCatalogClicked(){
                this.costItemsStore.toggleModal();
            },
            handleDocumentClick(event){
                if (!event || !event.target) {
                    return;
                }
                if (!event.target.closest('.import-pop-over')) {
                    this.showImportOptions = false;
                }
            },
            handleSelectChange(selectedItems){
                this.checkedItems = selectedItems.map(item => { return `${item.proposal_item_id}_${item.item_index}`; });
                // this.$emit('onSelectedItems', selectedItems);
            },
            handleRowChange(rowChanged){
                if(rowChanged){
                    const rowIndex = rowChanged.index;
                    const rowData = rowChanged.data;
                    this.worksheet.map((field, index) => {
                        if(index === rowIndex){
                            Object.keys(rowData).forEach(key => {
                                const value = rowData[key];
                                if(key === 'Unit Cost'){
                                    field.unit_cost = value;
                                }else if(key === 'Description'){
                                    field.description = value;
                                }else if(key === 'Item'){
                                    field.title = value;
                                }else if(key === 'Quantity'){
                                    field.unit_quantity = value;
                                }else if(key === 'Unit'){
                                    field.unit = value;
                                }else if(key === 'Labor Type'){
                                    field.labor = value;
                                }else if(key === 'Markup'){
                                    field.unit_mark_up = value;
                                }else if(key === 'Markup Type'){
                                    field.unit_mark_up_type = value;
                                }
                            });
                        }
                    });
                }
                this.$emit('onRowChanged', rowChanged);
            },
            toggleImportPopover(){
                this.showImportOptions = !this.showImportOptions;
            },
            undoChanges(){
                this.worksheet = this.winitialWorksheet;
            },
            deleteCheckedItems(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You can still redo it later, as long as you don't update the proposal.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.worksheet = this.worksheet.filter((item, index) => 
                            !this.checkedItems.includes(`${item.proposal_item_id}_${index}`)
                        );
                        this.checkedItems = []; 
                        this.worksheetStore.setWorksheet(this.worksheet);
                    }
                });
            },
            populateModalFromCheckedItem(){
                if (this.checkedItems.length === 1) {
                    let item = this.worksheet.find((item, index) => {
                        return this.checkedItems.includes(`${item.proposal_item_id}_${index}`)
                    });
                    
                    this.costItemType = 'default';
                    this.selectedItem = item;
                    var modal = document.querySelector('#costItemModal');
                    var bootstrapModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
                    bootstrapModal.show();
                }
            },
            uniqueId() {
                return 'id-' + Math.random().toString(36).slice(2, 11);
            },
            isUniqueIdTaken(id) {
                return this.worksheet.some(row => row.uid === id);
            },
            calculateEstimate(data){
                const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });

                this.rowData = Object.values(data).map(item => {
                    return {
                        id: item.proposal_item_id,
                        content: this.getRowContent(item)
                    };
                });

                const project = data.map(item => ({
                        ...item,   
                        unit_cost: formatter.format(item.unit_cost),
                        unit_mark_up: this.setMarkupColumn(item),
                        builder_cost: formatter.format(item.unit_cost * item.unit_quantity),
                        discount: formatter.format(item.discount),
                        owner_price: this.setOwnerPrice(item),
                        labor: (item.labor === 0) ? 'Labor' : 'Labor + Material'
                }));

                // Compute the sums
                const sumBuilderCost = project.reduce((acc, item) => acc + parseFloat(item.builder_cost.replace(/[$,]/g, '')), 0);
                const sumOwnerPrice = project.reduce((acc, item) => acc + parseFloat(item.owner_price.replace(/[$,]/g, '')), 0);
                const totalMarkup = data.reduce((acc, item) => acc + parseFloat(this.getMarkup(item.unit_mark_up_type, item.unit_mark_up, item.unit_quantity, (item.unit_cost * item.unit_quantity))), 0);
                    
                // Format the sums back to currency format for display
                this.worksheetStore.setClientPrice(sumOwnerPrice);
                this.worksheetStore.setEstimatedProfit(sumOwnerPrice - sumBuilderCost);
                this.worksheetStore.setTotalMargin(((sumOwnerPrice - sumBuilderCost)/sumOwnerPrice) * 100);
                this.worksheetStore.setSumBuilderCost(sumBuilderCost);
                this.worksheetStore.setTotalMarkup(totalMarkup);

                this.estimatedProfit = formatter.format(sumOwnerPrice - sumBuilderCost);
                this.totalMargin = formatter.format(((sumOwnerPrice - sumBuilderCost)/sumOwnerPrice) * 100) + '%';
                this.sumBuilderCost = formatter.format(sumBuilderCost);
                this.sumOwnerPrice = formatter.format(sumOwnerPrice);
                this.totalMarkup = formatter.format(totalMarkup);
            }
        },
        computed: {
            selectedEstimates() {
                if(this.smartEstimateListStore){
                    return this.smartEstimateListStore.selectedEstimates;
                }else{
                    return null;
                }
            },
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
        watch: {
            proposal_id: {
                handler(newValue, _) {
                    const worksheets = this.worksheetStore.worksheet;
                    if(worksheets && worksheets.length != 0){
                        this.worksheet = worksheets;
                        this.calculateEstimate(this.worksheet);
                        return;
                    }
                    
                    if(newValue && newValue !== 0){
                        this.getProposalItems(newValue);
                    }else{
                        this.rowData = [];
                    }
                },
                immediate: true 
            },
            worksheet: {
                handler(newValue, _) {
                    if(newValue && newValue.length !== 0){
                        this.calculateEstimate(newValue);
                    }
                },
                deep: true 
            },
            selectedEstimates: {
                handler(newEstimates, _) {
                    if (newEstimates) {
                        const estimate_id = newEstimates.estimate_id;
                        this.store.estimated_id = estimate_id;
                        this.store.toggleModal();
                    }
                },
                deep: true
            },
            selectedCostItems: {
                handler(newValue){
                    if(newValue){
                        newValue.forEach(item => {
                            const newItem = {
                                proposal_item_id: 0,
                                proposal_id: this.proposal_id,
                                ...item,
                                unit_quantity: item.unit_quantity === null ? 0 : item.unit_quantity,
                            }
                            this.worksheet.push(newItem);
                        });
                        this.worksheetStore.setWorksheet(this.worksheet);
                    }
                }
            },
            submitedItem: {
                handler(newValue){
                    if(newValue){
                        let uniqueId;
                        do {
                            uniqueId = this.uniqueId();
                        } while (this.isUniqueIdTaken(uniqueId));

                        const newItem = {
                            ...newValue,
                            uid: uniqueId
                        }
                        this.worksheet.push(newItem);
                        this.worksheetStore.setWorksheet(this.worksheet);
                    }
                }
            }
        }
    }
</script>