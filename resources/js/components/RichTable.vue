<!-- NOTES: 
    id: can be change on the parent component
    uid: is generated in this component to ensure that each item has unique id
    onSelectionChange: returns the selected rows data, id and uid.

    //Add check_column on the headers to add checkboxes
-->
<template>
    <!-- if shadow is not needed then kindly add props for it and make shadow default -->
    <div class="d-flex flex-column b-light bg-white position-relative" style="height: 100%;" ref="tableContainer">
        <div  class="d-flex position-relative slim-scroll-light" style="overflow: auto;">

            <draggable class="d-flex flex-grow-1" :list="headers" group="people" @change="log" handle=".handle" style="height: 100%; width: 100% !important;">
                <template v-for="(header, index) in headers" :key="header.name">
                    <div class="d-flex flex-column" id="column-container" ref="columnContainers"
                            :class="{
                                'flex-grow-1': !header.max && header.name !== 'check_column',
                            }"
                            :style="{
                                'min-width': header.min ? header.min : 'auto',
                                'max-width': header.max ? header.max : header.name === 'check_column' ? '50px' : 'auto',
                                'max-width': header.max ? header.max : header.name === 'select_item' ? '110px' : 'auto',
                                'height': totalHeight + 'px'
                            }" 
                            v-if="!header.hide">

                        <!-- HEADER -->
                        <div class='f-w-500 px-3 py-2 d-flex align-items-center f-14 table_header'
                            :class="{
                                'justify-content-between': header.name !== 'select_item',
                                'justify-content-center': header.name === 'select_item',
                                'px-2': header.name === 'notification_bell',
                            }">

                            <div v-if="header.name === 'check_column'" style="height: 21px ;">
                                <div class="b-light cursor-pointer m-0 checkbox-style">
                                    <div style="height: 100%; width: 100%;" class="bg-white m-0" v-if="checkAllState === 'checked'"></div>
                                    <div style="height: 40%; width: 100%; margin: 3px 0px !important;" class="bg-white" v-else-if="checkAllState === 'intermidiate'"></div>
                                    <a style="position: absolute; top: 0; bottom: 0; left: 0; right: 0;" @click="toggleCheckBox(null, 0, 0)"></a>
                                </div>
                            </div>
                            <div v-else-if="header.name === 'select_item'" style="height: 21px ;">
                                <a style="width: 100%;">
                                    Action
                                </a>
                            </div>
                            <div v-else-if="header.name === 'notification_bell'" style="height: 21px ;">
                                <i style="width: 100%;"  class="fa fa-bell me-2"></i>
                            </div>
                            <template v-else>
                                {{ header.name }} 
                                <div class="d-flex gap-1" >
                                    <i class="icofont icofont-drag handle hidden-sort" style="cursor: grab;" v-if="header.draggable"></i>
                                    <i class="cursor-pointer" 
                                        @click="applySort(header.name)" 
                                        :class="{ 'hidden-sort': checkSorting(header.name) == 'none' },
                                            { 'icon-exchange-vertical': checkSorting(header.name) == 'none' },
                                            { 'fa fa-sort-alpha-asc': checkSorting(header.name) == 'asc' && header.sortType == 'alpha'},
                                            { 'fa fa-sort-alpha-desc': checkSorting(header.name) == 'desc' && header.sortType == 'alpha'},
                                            { 'fa fa-sort-numeric-asc': checkSorting(header.name) == 'asc' && header.sortType == 'numeric'},
                                            { 'fa fa-sort-numeric-desc': checkSorting(header.name) == 'desc' && header.sortType == 'numeric'}" 
                                        v-if="header.sorting"></i>
                                </div>
                            </template>
                        </div>
                        <!-- END HEADER -->

                        <!-- ROWS -->
                        <template v-for="(row, row_index) in tableRows">

                            <a class='p-0 position-relative b-b-secondary b-l-secondary b-r-secondary'
                                :class="{ 'light-row': row_index % 2 !== 0 }" 
                                id="cell-container" v-if="header.type && header.type === 'image'">

                                <div v-if="editable && editingRow != null && editingRow === row_index && row.content[header.name].action !== 'click'" v-html="setupRowForm(row.content[header.name].content, row.uid, header, row.content[header.name].data)"></div>
                                <div v-html="formatContent(row.content[header.name].content)" v-else></div>

                            </a>

                            <a class='f-w-500 py-2 text-muted f-12 position-relative'
                                :class="{ 
                                    'light-row': row_index % 2 !== 0,
                                    'px-2': header.name === 'notification_bell',
                                    'px-3': header.name !== 'notification_bell' 
                                    }" 
                                id="cell-container"
                                @click="handleClickedRow(row, row_index, header)" v-else>

                                <div class="b-primary cursor-pointer m-0 checkbox-style" v-if="header.name === 'check_column'">
                                    <div style="height: 100%; width: 100%;" 
                                        class="bg-primary-v2 m-0" :class="{'d-none': !selectedRows.some(selectedRow => selectedRow.uid === row.uid)}">
                                    </div>
                                    <a style="position: absolute; top: 0; bottom: 0; left: 0; right: 0;" @click="toggleCheckBox(row.content[header.name].data, row, row_index)"></a>
                                </div>

                                <div v-else-if="header.name === 'select_item'">
                                    <a class="btn btn-sm btn-primary-v2 m-0 px-3 py-1" style="border-radius: 20px;" @click="handleSelect(row.content[header.name].data)">SELECT</a>
                                </div>

                                <div v-else>
                                    <div  v-if="editable && editingRow != null && editingRow === row_index && row.content[header.name].action !== 'click'" v-html="setupRowForm(row.content[header.name].content, row.uid, header, row.content[header.name].data)"></div>
                                    <div :class="row.content[header.name].className" v-html="formatContent(row.content[header.name].content)" v-else></div>
                                </div>
                            </a>

                            <!-- <div class="position-relative" v-if="open_container === row_index">
                                <div style="position: absolute; left: 0; top: 0; bottom: 0; z-index: 2;" 
                                    :class="{ 'light-row': row_index % 2 !== 0}" 
                                    :style="{'width': tableContainerWidth + 'px'}" 
                                    v-if="index === 0">
                                    <LeadSubRow :data="row.content[header.name].data" :row="row" @appointmentClick="appointmentClick"/>
                                </div>
                            </div> -->

                            <div class="position-relative" v-if="open_container === row_index">
                                <div style="position: absolute; left: 725px; top: 0; bottom: 0; z-index: 2; width: 100%;" 
                                    :class="{ 'light-row': row_index % 2 !== 0}" v-if="index === 0">
                                    <LeadSubRow :data="row.content[header.name].data" :row="row" @appointmentClick="appointmentClick"/>
                                </div>
                            </div>

                        </template>
                        <!-- END ROWS -->
                    </div>
                </template>
            </draggable>
        </div>
        <div style="height: 48px;" class="b-t-primary-v2 shadow bg-white table_footer" v-if="pagination">
            <nav class="d-flex justify-content-between align-items-center px-2" style="height: 100%;">
                <a class="mt-1">Showing <b>{{ starting }}</b> to <b>{{ ending }}</b> out of <b>{{ total }}</b> entries</a>
                <ul class="pagination d-flex justify-content-end pagination-primary-v2">
                    <li :class="{ 'disabled': loading }">
                        <select :value="limit" @change="handleLimitChange" class="form-select b-primary" id="page_limit">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </li>
                    <li style="width: 15px;"></li>
                    <li class="page-item" :class="{ 'disabled': (currentPage <= 1) || loading }">
                        <a class="page-link" href="javascript:void(0)" @click="handlePageChange(currentPage - 1)">Previous</a>
                    </li>

                    <li class="page-item" v-for="page in pagesToShow" :key="page" 
                        :class="[
                            { 'page-active': page === currentPage },
                            { 'disabled': loading },
                            ]">
                        <a class="page-link" 
                            :class="{ 'text-white': page === currentPage }"
                            href="javascript:void(0)" 
                            @click="handlePageChange(page)"><span :class="{ 'page-link-edited': page === currentPage }">{{ page }}</span></a>
                    </li>

                    <li class="page-item" :class="{ 'disabled': (currentPage == totalPages) || loading}">
                        <a class="page-link" href="javascript:void(0)" @click="handlePageChange(currentPage + 1)">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
<script>
import { VueDraggableNext } from 'vue-draggable-next';
import LeadSubRow from './tables/LeadSubRow.vue';
import { useScheduleAppointmentModal } from '../stores/schedule-appointment';
import axios from 'axios';

export default {
    components: {
        draggable: VueDraggableNext,
        LeadSubRow
    },
    setup(){
        //const page = usePage();
        const useScheduleAppointment = useScheduleAppointmentModal();

        return { 
            useScheduleAppointment,
        }
    },
    props: {
        headers: {
            type: Array,
            default: () => []
        },
        rows: {
            type: Array,
            default: () => []
        },
        editable: {
            type: Boolean,
            default: () => false
        },
        selectable: {
            type: Boolean,
            default: () => false
        },
        pagination: {
            type: Boolean,
            default: () => false
        },
        currentPage: {
            type: Number,
            default: () => 1
        },
        limit: {
            type: Number,
            default: () => 25
        },
        starting: {
            type: Number,
            default: () => 1
        },
        ending: {
            type: Number,
            default: () => 1
        },
        total: {
            type: Number,
            default: () => 1
        },
        totalPages: {
            type: Number,
            default: () => 1
        },
        loading: {
            type: Boolean,
            default: () => false
        },
        rowHeight: {
            type: Number,
            default: () => 0
        }
    },
    emits: ['onSelectionChange', 'onSelectedItem', 'onRowChanged', 'reload', 'cellClick'],
    data() {
        return {
            tableRows: [],
            sortBy: [],
            selectedRows: [],
            checkAllState: 'unchecked',
            totalHeight: 40,
            editingData: null,
            editingRow: null,
            editingRowClicked: false,
            open_container: null,
            tableContainerWidth: 0,
        };
    },
    mounted() {
        this.adjustRowHeights();
        if(this.editable){
            document.addEventListener('click', this.handleOutsideClick);
        }
        this.updateTableContainerWidth();
        window.addEventListener('resize', this.updateTableContainerWidth);
        this.getUserOptions();
    },
    beforeDestroy() {
        if(this.editable){
            document.removeEventListener('click', this.handleOutsideClick);
        }
        window.removeEventListener('resize', this.updateTableContainerWidth);
    },
    computed: {
        pagesToShow() {
            let range = 2; // Number of pages to show before and after the current page
            let startPage = Math.max(1, this.currentPage - range);
            let endPage = Math.min(this.totalPages, this.currentPage + range);

            return Array.from({ length: endPage - startPage + 1 }, (_, index) => startPage + index);
        }
    },
    watch: {
        rows: {
            handler() {
                this.selectedRows = [];
                this.$emit('onSelectionChange', this.selectedRows);
                this.checkAllState = 'unchecked'
                this.tableRows = this.rows.map(row => {
                    if (!row.uid) {
                        let uniqueId;
                        do {
                            uniqueId = this.uniqueId();
                        } while (this.isUniqueIdTaken(uniqueId));
                        return { ...row, uid: uniqueId };
                    }
                    return row;
                });
                this.$nextTick(() => {
                    this.adjustRowHeights();
                     this.$forceUpdate();
                });
            },
            deep: true,
            immediate: true 
        },
        headers: {
            handler() {
                this.$nextTick(() => {
                    this.adjustRowHeights();
                     this.$forceUpdate();
                });
            },
            deep: true,
            immediate: true 
        },
        editingData: {
            handler(_, oldVal){
                if(this.editable && oldVal != null){
                    let rowChangeIndex = 0;
                    let rowData = [];
                    this.headers.forEach(header => {
                    if(header.name != "check_column" && header.name != "select_item"){
                        const id = oldVal.uid+'_'+header.name.replace(' ', '___');
                            
                        const rowIndex = this.tableRows.map((field, index) => {
                            if(field.uid === oldVal.uid){
                                return index;
                            }
                            }).find(field => (field != null));

                            if(header.form_type === 'mark_up'){
                                const mark_up_value = $(`#${id}_mark_up`).val();
                                const mark_up_type_value = $(`#${id}_mark_up_type`).val();

                                if(rowIndex != null){
                                    rowChangeIndex = rowIndex;

                                    this.tableRows[rowIndex].content[header.name].content = mark_up_value + ' / ' + mark_up_type_value;
                                    rowData['Markup'] = mark_up_value;  
                                    rowData['Markup Type'] = mark_up_type_value;
                                }
                            }else{
                                const value = $(`#${id}`).val();
                                if(value != null){

                                    if(rowIndex != null){
                                        rowChangeIndex = rowIndex;

                                        this.tableRows[rowIndex].content[header.name].content = value;
                                        rowData[header.name] = value;
                                    }
                                }
                            }
                        }
                    });

                    this.$emit('onRowChanged', {
                        index: rowChangeIndex,
                        data: rowData
                    });
                }
            }
        }
    },
    methods: {
        updateTableContainerWidth() {
            this.$nextTick(() => {
            if (this.$refs.tableContainer) {
                this.tableContainerWidth = this.$refs.tableContainer.clientWidth;
            }
            });
        },
        handleLimitChange() {
            const limit = document.querySelector('#page_limit').value;
            this.$emit('reload', { currentPage: 1, pageLimit: parseInt(limit), sort: this.sortBy });
        },
        handlePageChange(pageNumber) {
            if (pageNumber >= 1 && pageNumber <= this.totalPages) {
                this.$emit('reload', { currentPage: pageNumber, pageLimit: this.limit, sort: this.sortBy });
            }
        },
        handleOutsideClick(event) {
            if(!this.editingRowClicked){
                this.editingData = null;
                this.editingRow = null;
            }
            this.editingRowClicked = false;
            this.adjustRowHeights();
        },
        toggleCheckBox(value, row, index){
            if(value){
                if(!this.selectedRows.some((selectedRow) => selectedRow.uid === row.uid)){
                    const newSelected = {
                        ...value,
                        uid: row.uid,
                        item_index: index,
                        id: row.id
                    }
                    this.selectedRows.push(newSelected);
                }else{
                    this.selectedRows = this.selectedRows.filter(selectedRow => selectedRow.uid !== row.uid);
                }
                
                if(this.tableRows.length === this.selectedRows.length){
                    this.checkAllState = 'checked'
                }else if(this.selectedRows.length == 0){
                    this.checkAllState = 'unchecked'
                }else{
                    this.checkAllState = 'intermidiate'
                }
            }else{
                if(this.checkAllState === 'unchecked' || this.checkAllState === 'intermidiate'){
                    this.checkAllState = 'checked'
                    this.tableRows.forEach((row, index) => {
                        const newSelected = {
                            ...row.content['check_column'].data,
                            uid: row.uid,
                            item_index: index,
                            id: row.id
                        }
                        this.selectedRows.push(newSelected);
                    });
                }else{
                    this.checkAllState = 'unchecked'
                    this.selectedRows = [];
                }
            }
            
            this.$emit('onSelectionChange', this.selectedRows);
        },
        formatContent(content) {
            if (typeof content === 'string') {
                return content.replace(/\n/g, '<br>');
            } else {
                return content != null ? content.toString() : '-';
            }
        },
        setupRowForm(content, uid, header, data){
            const type = header.form_type;
            const header_name = header.name;
            const disabled = header.disabled_edit ? 'disabled' : '';

            if(type === 'textarea'){
                return `<textarea id="${uid+'_'+header_name.replace(' ', '___')}" class="form-control b-primary slim-scroll-gray" type="text" value="${content}" style="font-size: 12px !important; padding: 5px 10px !important; height: 180px;">${content}</textarea>`;
            }else if(type === 'selection'){
                const options = Array.isArray(header.selection_options) ? header.selection_options : [];
                let optionsHtml = '';

                if(options){
                    options.forEach(option => {
                        const selected = option.display === content ? 'selected' : '';
                        optionsHtml = optionsHtml + `<option value="${option.value}" ${selected}>${option.display}</option>`;
                    });
                }

                return `<select id="${uid+'_'+header_name.replace(' ', '___')}" class="form-control b-primary" style="font-size: 12px !important; padding: 5px 10px !important;">${optionsHtml}</select>`;
            }else if(type === 'builder_cost' || type === 'owner_price' || type === 'none'){
                return `<input id="${uid+'_'+header_name.replace(' ', '___')}" class="form-control b-muted" type="${type}" value="${content}" disabled style="font-size: 12px !important; padding: 5px 10px !important;"/>`;
            }else if(type === 'mark_up'){
                let mark_up = data.unit_mark_up ? parseFloat(data.unit_mark_up) : 0.0;
                let mark_up_type = data.unit_mark_up_type ? data.unit_mark_up_type : '--';
                return `<div class="d-flex gap-1">
                        <input id="${uid+'_'+header_name.replace(' ', '___')}_mark_up" class="form-control b-primary" type="number" value="${mark_up}" style="font-size: 12px !important; padding: 5px 10px !important;"/>
                        <select id="${uid+'_'+header_name.replace(' ', '___')}_mark_up_type" class="form-control b-primary" style="font-size: 12px !important; padding: 5px 10px !important; width: 25%;">
                            <option value="--" ${mark_up_type === '--' ? 'selected' : ''}>--</option>
                            <option value="%" ${mark_up_type === '%' ? 'selected' : ''}>%</option>
                            <option value="$" ${mark_up_type === '$' ? 'selected' : ''}>$</option>
                            <option value="$/" ${mark_up_type === '$/' ? 'selected' : ''}>$/</option>
                        </select>
                    </div>`;
            }else if(type === 'decimal'){
                return `<input id="${uid+'_'+header_name.replace(' ', '___')}" class="form-control b-primary" type="${type}" value="${parseFloat(content.replace(/[$,]/g, ''))}" style="font-size: 12px !important; padding: 5px 10px !important;"/>`;
            }else{
                return `<input id="${uid+'_'+header_name.replace(' ', '___')}" class="form-control b-primary" type="${type}" ${disabled} value="${content}" style="font-size: 12px !important; padding: 5px 10px !important;"/>`;
            }
        },
        applySort(headerName) {
            if(this.sortBy.length !== 0){
                let sortApplied = false;

                this.sortBy.filter(sort => {
                    if(sort.name === headerName){
                        sortApplied = true;
                        if (sort.type === 'asc') {
                            sort.type = 'desc';
                        } else if (sort.type === 'desc') {
                            sort.type = 'none';
                        }else if (sort.type === 'none') {
                            sort.type = 'asc';
                        }
                    }
                });

                if (!sortApplied) {
                    this.sortBy.push({
                        name: headerName,
                        type: 'asc'
                    });
                }
            }else{
                this.sortBy.push({
                    name: headerName,
                    type: 'asc'
                });
            }
        },
        checkSorting (headerName) {
            let type = 'none';

            this.sortBy.filter(sort => {
                if(sort.name === headerName){
                    if (sort.type === 'asc') {
                        type = 'asc';
                    } else if (sort.type === 'desc') {
                        type = 'desc';
                    }else if (sort.type === 'none') {
                        type = 'none';
                    }
                }
            });

            return type;
        },
        log (event) {
            // handleResize();
        },    
        adjustRowHeights() {
            this.$nextTick(() => {
                    if (this.$refs.columnContainers) {
                        const numberOfColumns = this.$refs.columnContainers.length;
                        let numberOfRows = 0;
                        if (numberOfColumns > 0) {
                            numberOfRows = this.$refs.columnContainers[0].children.length;

                            // Reset all heights
                            for (let columnIndex = 0; columnIndex < numberOfColumns; columnIndex++) {
                                const column = this.$refs.columnContainers[columnIndex];
                                Array.from(column.children).forEach(cell => {
                                    cell.style.height = ''; // Reset height
                                });
                            }
                            
                            let totalHeight = 0;
                            for (let rowIndex = 0; rowIndex < numberOfRows; rowIndex++) {
                                let maxHeight = 38;
                                
                                for (let columnIndex = 0; columnIndex < numberOfColumns; columnIndex++) {
                                    const column = this.$refs.columnContainers[columnIndex];
                                    if (column.children[rowIndex]) {
                                        let height = column.children[rowIndex].offsetHeight;

                                        if(rowIndex === 0){
                                            height = 38;
                                        }else{
                                            if((this.editingRow + 1) !== rowIndex){
                                                height = 48;
                                            }else{
                                                height = (this.editingRow != null) ? 200 : 48;
                                            }
                                        }

                                        if(this.rowHeight !== 0){
                                            maxHeight = rowIndex === 0 ? 48 : this.rowHeight;
                                        }else{
                                            if (height > maxHeight) maxHeight = height;
                                        }
                                    }
                                }
                                

                                    
                                        
                                if(this.open_container != null && this.open_container === (rowIndex - 2)){
                                    for (let columnIndex = 0; columnIndex < numberOfColumns; columnIndex++) {
                                        const column = this.$refs.columnContainers[columnIndex];
                                        if (column.children[rowIndex]) {
                                            column.children[rowIndex].style.height = `130px`; //can be put in props or header.accordion_height
                                        }
                                    }
                                }else{
                                    for (let columnIndex = 0; columnIndex < numberOfColumns; columnIndex++) {
                                        const column = this.$refs.columnContainers[columnIndex];
                                        if (column.children[rowIndex]) {
                                            column.children[rowIndex].style.height = `${maxHeight}px`;
                                        }
                                    }
                                }

                                totalHeight = totalHeight + maxHeight;
                            }

                            const footerHeight = this.pagination ? 48 : 0;
                            const accordionHeight = this.open_container ? 130 : 0; //can be put in props or header.accordion_height
                            this.totalHeight = totalHeight + footerHeight + accordionHeight;
                        }
                    }
            });
        },
        uniqueId() {
            return 'id-' + Math.random().toString(36).slice(2, 11);
        },
        isUniqueIdTaken(id) {
            return this.tableRows.some(row => row.uid === id);
        },
        updated() {
            this.adjustRowHeights();
        },
        handleSelect(selected_item){
            this.$emit('onSelectedItem', selected_item);
        },
        handleClickedRow(row, index, header){
            const headerName = header.name;
            if (headerName === 'check_column') {
                return;
            }

            if(header.accordion_container){
                if(this.open_container != null && this.open_container === index){
                    this.open_container = null;
                }else{
                    this.open_container = index;
                }
                this.adjustRowHeights();
                return;
            }else if(row.content[headerName].action === 'click'){
                this.$emit('cellClick', {
                    headerName: headerName,
                    data: row.content[headerName].data
                });
                return;
            }
            this.editingRowClicked = true;
            this.editingRow = index;
            this.editingData = row;
            this.adjustRowHeights();
        },
        appointmentClick(data) {
            this.useScheduleAppointment.setType('add');
            this.useScheduleAppointment.setSelected(data.data);
            this.useScheduleAppointment.toggleModal();
        },
        getUserOptions(){
            axios.get('/api/calendar/getLib') // Your Laravel endpoint to fetch events
            .then(response => {
                this.userOptions = response.data.users;
                this.useScheduleAppointment.setUserOptions(response.data.users);
            });
        }
    }
};
</script>
<style scoped>

    .intermidiate{
        padding: 5px 0px !important;
    }

    #cell-container{
        min-height: 38px; 
        height: auto; 
        overflow: hidden;
        white-space: nowrap; /* Prevents the text from wrapping */
        text-overflow: ellipsis;
    }
</style>