<template>
    <div class="b-radius-10 b-muted-v2" style="width: 100%; overflow: hidden;">
        <!-- Headers -->
        <div class="d-flex gap-2 align-items-center b-b-muted-v2 px-2">
            <template v-for="header in headers">
                <div class="p-2 "  
                    :class="{ 'flex-grow-1' : header.name !== 'checkbox' }"                           
                    :style="{
                        'min-width': header.min ? `${header.min}px` : 'auto',
                        'max-width': header.max ? `${header.max}px` : 'auto',
                    }" >
                    <div v-if="header.name === 'checkbox'" @click="handleAllCheck">
                        <div style="width: 19px; height: 19px; cursor: pointer;" class="b-muted-v2 b-radius-5" v-if="allChecked === 'none'">
                            <!-- <i class="fi fi-rr-check f-12 text-primary-v2" style="height: 12px;"></i> -->
                        </div>
                        <div style="width: 19px; height: 19px; cursor: pointer;" class="b-primary-v2 b-radius-5 d-flex align-items-center justify-content-center" v-else-if="allChecked === 'all'">
                            <i class="fi fi-rr-check f-12 text-primary-v2" style="height: 12px;"></i>
                        </div>
                        <div style="width: 19px; height: 19px; cursor: pointer;" class="b-primary-v2 b-radius-5 d-flex align-items-center justify-content-center" v-else>
                            <i class="fi fi-rr-minus-small f-12 text-primary-v2" style="height: 12px;"></i>
                        </div>
                    </div>
                    <label class="f-12 f-w-600 m-0" v-else>{{ header.name }}</label>
                </div>
            </template>
        </div>

        <!-- Content -->
        
        <div class="d-flex flex-column">
            <template v-for="(row, index) in rows">
                <div class="d-flex gap-2 px-2 b-b-muted-v2" :class="index%2 === 0 ? 'bg-white' : 'bg-secondary-light'">
                    
                    <template v-for="(header, headerIndex) in headers">
                        <div class="p-2" style="overflow: hidden;"   
                            :class="{ 'flex-grow-1' : header.name !== 'checkbox' }"          
                            :style="{
                                'min-width': header.min ? `${header.min}px` : 'auto',
                                'max-width': header.max ? `${header.max}px` : 'auto',
                                'height': editingIndex != null && editingIndex === index ? '150px' : '38px'
                            }">
                            <div v-if="editingIndex === index">
                                <div v-if="headerIndex === 0" class="d-flex flex-column gap-2">
                                    <div class="bg-danger-v2 px-1 text-white b-radius-5 pt-1 bigger" style="cursor: pointer;" @click="handleCellClick(null, -2)"><i class="fi fi-rr-cross"></i></div>
                                    <div class="bg-success-v2 px-1 text-white b-radius-5 pt-1 bigger" style="cursor: pointer;" @click="handleCellClick(null, -1)"><i class="fi fi-rr-check"></i></div>
                                </div>
                                <template  v-else-if="header.disabled">
                                    <label class="f-12 f-w-500 m-0" v-if="header.format && header.format === 'currency'"  @click="handleCellClick(row, index)">{{ formatCurrency(row[header.key]) }}</label>
                                    <label class="f-12 f-w-500 m-0 text-truncated" v-html="row[header.key]" v-else></label>
                                </template>
                                <input :id="`id-${header.key}`" class="f-12 b-muted-v2 b-radius-5 p-1" type="text" v-else-if="header.format === 'text'" :value="row[header.key]" style="width: 100%;"/>
                                <input :id="`id-${header.key}`" class="f-12 b-muted-v2 b-radius-5 p-1" type="number" v-else-if="header.format === 'currency' || header.format === 'number'" :value="parseFloat(row[header.key])" style="width: 100%;"/>
                                <textarea  :id="`id-${header.key}`" class="f-12 b-muted-v2 b-radius-5 slim-scroll-gray" v-else-if="header.format === 'textarea'" :value="row[header.key]" style="height: 130px; width: 100%;">

                                </textarea>
                                <div class="d-flex gap-1" v-else-if="header.format === 'mark_up'" style="width: 100%;">
                                    <input :id="`id-unit_mark_up`" class="f-12 b-muted-v2 b-radius-5 p-1 flex-grow-1" type="number" :value="parseFloat(row['unit_mark_up'])"  style="width: 100%;"/>
                                    <select :id="`id-unit_mark_up_type`" class="f-12 b-muted-v2 b-radius-5" :value="row['unit_mark_up_type']">
                                        <option value="--">--</option>
                                        <option value="%">%</option>
                                        <option value="$/">$/</option>
                                        <option value="$">$</option>
                                    </select>
                                </div>
                                <label class="f-12 f-w-500 m-0 text-truncated" v-else v-html="row[header.key]"></label>
                            </div>
                            <div v-else-if="header.name === 'checkbox'" @click="handleChecked(index)">
                                <div style="width: 19px; height: 19px; cursor: pointer;" class="b-muted-v2 b-radius-5" v-if="!selectedRow.includes(index)">
                                </div>
                                <div style="width: 19px; height: 19px; cursor: pointer;" class="b-primary-v2 b-radius-5 d-flex align-items-center justify-content-center" v-else>
                                    <i class="fi fi-rr-check f-12 text-primary-v2" style="height: 12px;"></i>
                                </div>
                            </div>
                            <label class="f-12 f-w-500 m-0" v-else-if="header.format && header.format === 'currency'"  @click="handleCellClick(row, index)">{{ formatCurrency(row[header.key]) }}</label>
                            <label class="f-12 f-w-500 m-0 text-truncated" v-else v-html="row[header.key]"  @click="handleCellClick(row, index)"></label>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="d-flex gap-2 align-items-center bg-secondary-light px-3 py-2">
            <div class="d-flex gap-2">
                <div class="btn-outline-custom-muted bg-white px-3 py-1 b-radius-8 d-flex align-items-center gap-1 f-w-500"  
                    :class="{ 'disabled': (currentPage <= 1) || loading }" 
                    @click="handlePageChange(currentPage - 1)"
                    @mouseenter="hovered('prev', true)" @mouseleave="hovered('prev', false)">
                    <i class="fi fi-rr-arrow-small-left f-25 m-0 d-flex align-items-center" :class=" !prevHovered ? 'text-primary-v2' : 'text-white'" style="height: 25px;"></i>Previous
                </div>
                <div class="btn-outline-custom-muted bg-white px-3 py-1 b-radius-8 d-flex align-items-center gap-1 f-w-500"
                    :class="{ 'disabled': (currentPage == totalPages) || loading }" 
                    @click="handlePageChange(currentPage + 1)"
                    @mouseenter="hovered('next', true)" @mouseleave="hovered('next', false)">
                    Next<i class="fi fi-rr-arrow-small-right f-25 m-0 d-flex align-items-center" :class=" !nextHovered ? 'text-primary-v2' : 'text-white'" style="height: 25px;"></i>
                </div>
            </div>

            <select :value="limit" @change="handleLimitChange" class="form-select b-muted-v2" id="page_limit" :class="{ 'disabled': loading }" style="width: 75px;">
                <option value="25" class="f-14 f-w-500">25</option>
                <option value="50" class="f-14 f-w-500">50</option>
                <option value="100" class="f-14 f-w-500">100</option>
            </select>

            <span class="flex-grow-1"></span>
            <ul class="pagination d-flex justify-content-end pagination-primary-v2">
                <li class="page-item" v-for="page in pagesToShow" :key="page" 
                    :class="[
                        { 'page-active': page === currentPage },
                        { 'disabled': loading },
                    ]">
                    <a class="page-link f-14" 
                    :class="{ 'text-white': page === currentPage }"
                    href="javascript:void(0)" 
                    @click="handlePageChange(page)"><span :class="{ 'page-link-edited': page === currentPage }">{{ page }}</span></a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        rows: {
            type: Array,
            default: () => [] 
        },
        headers: {
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
        resetCounter: {
            type: Number,
            default: () => 0
        }
    },
    emits: ['reload', 'updatedItem', 'selectedItems'],
    data(){
        const allChecked = 'none';
        const prevHovered = false;
        const nextHovered = false;
        const editing = false;
        const editingItem = null;
        const editingIndex = -1;
        const selectedRow = [];

        return { prevHovered, nextHovered, editingItem, editingIndex, editing, allChecked, selectedRow }
    },
    methods: {
        handleChecked(value){
            if(this.selectedRow.includes(value)){
                this.selectedRow = this.selectedRow.filter(rowIndex => rowIndex !== value);
                if(this.selectedRow.length === 0){
                    this.allChecked = 'none';
                }else{
                    this.allChecked = 'mid';
                }
            }else{
                this.selectedRow.push(value);
                if(this.selectedRow.length === this.rows.length){
                    this.allChecked = 'all';
                }else{
                    this.allChecked = 'mid';
                }
            }
        },
        handleAllCheck(){
            if(this.allChecked === 'none' || this.allChecked === 'mid'){
                this.allChecked = 'all';
                this.rows.forEach((_, index) => {
                    this.selectedRow.push(index);
                });
            }else{
                this.selectedRow = [];
                this.allChecked = 'none';
            }
        },
        handleCellClick(row, index){
            this.editing = !(index < 0);
            if(this.editing){
                this.editingItem = row;
            }
            this.editingIndex = index;
        },
        formatContent(content) {
            if (typeof content === 'string') {
                return content.replace(/\n/g, '<br>');
            } else {
                return content != null ? content.toString() : '-';
            }
        },
        hovered(type, hovered){
            if(type === 'prev'){
                this.prevHovered = hovered;
            }else{
                this.nextHovered = hovered;
            }
        },
        handleLimitChange() {
            const limit = document.querySelector('#page_limit').value;
            this.$emit('reload', { currentPage: 1, pageLimit: parseInt(limit) });
        },
        handlePageChange(pageNumber) {
            if (pageNumber >= 1 && pageNumber <= this.totalPages) {
                this.$emit('reload', { currentPage: pageNumber, pageLimit: this.limit });
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
        }
    },
    computed: {
        pagesToShow() {
            let range = 2; // Number of pages to show before and after the current page
            let startPage = Math.max(1, this.currentPage - range);
            let endPage = Math.min(this.totalPages, this.currentPage + range);

            return Array.from({ length: endPage - startPage + 1 }, (_, index) => startPage + index);
        }
    },
    watch:{
        editingIndex: {
            handler(index){
                if(this.editingItem && index != -2 && !this.editing){
                    this.headers.forEach(header => {
                        const field = document.querySelector(`#id-${header.key}`);

                        if(header.key === 'markup'){
                            const markUp = document.querySelector(`#id-unit_mark_up`);
                            const markUpType = document.querySelector(`#id-unit_mark_up_type`);

                            this.editingItem['unit_mark_up'] = markUp.value;
                            this.editingItem['unit_mark_up_type'] = markUpType.value;
                        }

                        if(field){
                            const value = field.value;
                            this.editingItem[header.key] = value;
                        }
                    });
                    
                    this.$emit('updatedItem', this.editingItem );
                }
            }
        },
        selectedRow: {
            handler(rows){
                const selectedItems = [];
                rows.forEach(index => {
                    selectedItems.push(this.rows[index]);
                });

                this.$emit('selectedItems', selectedItems );
            }, deep: true
        },
        resetCounter: {
            handler(counter){
                this.selectedRow = [];
                this.allChecked = 'none';
            }
        }
    }
}
</script>