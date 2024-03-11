<template>
    <!-- if shadow is not needed then kindly add props for it and make shadow default -->
    <div class="d-flex flex-column shadow b-light bg-white position-relative" style="height: 100%;">
        <div  class="d-flex position-relative b-b-dark" style="overflow: auto;"  id="table-lists">
            <div v-if="selectable">
                <div class='f-w-500 px-3 py-2 header_style d-flex justify-content-between align-items-center b-l-primary b-t-primary b-b-primary f-14'
                     :style="{'width': '50px'}">
                    <input type="checkbox" v-model="selectAll">
                </div>
                
                <template v-for="(row, row_index) in rows"  v-if="!isLoading">
                    <div class='f-w-500 px-3 py-2 d-flex justify-content-between align-items-center text-muted f-12 position-relative'
                        :class="{ 'bg-row': row_index % 2 !== 0, }"
                        :style="{
                            'width': '50px',
                            'height': defaultHeight != 'auto' ? defaultHeight : '40px',
                            'min-height': defaultHeight != 'auto' ? defaultHeight : '40px'
                        }">
                        <input type="checkbox" v-model="selectedItems[row_index]">
                    </div>
                </template>
            </div>
            <draggable class="d-flex align-items-center flex-grow-1" :list="headers" group="people" @change="log" handle=".handle">
                <template v-for="(header, index) in headers" :key="header.name">
                    <div class="d-flex flex-column" style="max-height: 100%;"
                            :style="{
                                'min-width': header.min ? header.min : 'auto',
                                'max-width': header.max ? header.max : 'auto',
                                }"
                            :class="{
                                'flex-grow-1': !header.max,
                                'd-none': header.hide,
                            }">

                        <!-- HEADER -->
                        <div class='f-w-500 px-3 py-2 header_style d-flex justify-content-between align-items-center b-l-primary b-t-primary b-b-primary f-14'
                            :class="{
                                'b-r-primary': index === (headers.length - 1),
                            }">
                            {{ header.name }} 
                            <div class="d-flex gap-1">
                                <i class="icofont icofont-drag handle cursor-pointer hidden-sort"></i>
                                <i class="cursor-pointer" 
                                    @click="applySort(header.name)" 
                                    :class="{ 'hidden-sort': checkSorting(header.name) == 'none' },
                                        { 'icon-exchange-vertical': checkSorting(header.name) == 'none' },
                                        { 'fa fa-sort-alpha-asc': checkSorting(header.name) == 'asc' && header.sortType == 'alpha'},
                                        { 'fa fa-sort-alpha-desc': checkSorting(header.name) == 'desc' && header.sortType == 'alpha'},
                                        { 'fa fa-sort-numeric-asc': checkSorting(header.name) == 'asc' && header.sortType == 'numeric'},
                                        { 'fa fa-sort-numeric-desc': checkSorting(header.name) == 'desc' && header.sortType == 'numeric'},
                                        { 'text-muted': isLoading}" 
                                    v-if="header.sorting"></i>
                            </div>
                        </div>
                        <!-- END HEADER -->

                        <!-- ROWS -->
                        <template v-for="(row, row_index) in rows"  v-if="!isLoading">
                                <div class='f-w-500 px-3 py-2 d-flex justify-content-between align-items-center text-muted f-12 position-relative'
                                        :class="{
                                            'flex-grow-1': !header.max,
                                            'bg-row': row_index % 2 !== 0,
                                            'd-none': header.hide,
                                        }"

                                        :style="{
                                            'height': defaultHeight != 'auto' ? defaultHeight : '40px',
                                            'min-height': defaultHeight != 'auto' ? defaultHeight : '40px'
                                        }"
                                    >
                                    <a 
                                        v-if="row.content[header.name].style === 'default'"
                                        :class="row.content[header.name].className" 
                                        @click="row.content[header.name].action === 'click' ?  handleContentClick(row.content[header.name].data, header.name) : null"
                                    >
                                        {{ row.content[header.name].content }}
                                    </a>
                                    <div :class="row.content[header.name].className" v-else-if="row.content[header.name].style === 'html-content'" 
                                        @click="row.content[header.name].action === 'click' ?  handleContentClick(row.content[header.name].data, header.name) : null"
                                        v-html="row.content[header.name].content">
                                    </div>
                                    <div :class="row.content[header.name].className" v-else-if="row.content[header.name].style === 'action'">
                                        <a class="badge badge-danger cursor-pointer" 
                                            @click="handleContentClick(row.content[header.name].data, header.name, 'delete')"
                                            v-if="row.content[header.name].action.indexOf('delete') != -1" 
                                            :style="{'width' : '80px'}">
                                            DELETE</a>
                                        <a class="badge badge-primary cursor-pointer" 
                                            v-if="row.content[header.name].action.indexOf('edit') != -1" 
                                            @click="handleContentClick(row.content[header.name].data, header.name, 'edit')"
                                            :style="{'width' : '80px'}">
                                            EDIT</a>
                                    </div>
                                </div>
                        </template>
                        <!-- END ROWS -->

                    </div>
                </template>
            </draggable>
        </div>

        <div class="flex-grow-1" style="overflow-y: auto; overflow-x: hidden;">
            <div class="f-w-500 px-3 py-2 d-flex justify-content-center align-items-center text-muted f-14 w-100" v-if="isLoading">
                <a><i class="fa fa-spin fa-spinner me-2"></i>Populating table...</a>
            </div>
        </div>

        <div class="bg-white" v-if="disable_pagination">
            <div class="px-3 py-2" v-if="rows.length !== 0">
                <nav class="d-flex justify-content-between align-items-center">
                    <a class="mt-1">Showing <b>{{ startingEntry }}</b> to <b>{{ endingEntry }}</b> out of <b>{{ totalEntries }}</b> entries</a>
                    <ul class="pagination justify-content-end pagination-primary">
                        <li class="mr-3" :class="{ 'disabled': isLoading }">
                            <select :value="pageLimit" @change="handlePageChange" class="form-select border-success" id="page_limit">
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </li>
                        <li class="page-item" :class="{ 'disabled': (currentPage <= 1) || isLoading }">
                            <a class="page-link" href="javascript:void(0)" @click="changePage(currentPage - 1)">Previous</a>
                        </li>

                        <li class="page-item" v-for="page in pagesToShow" :key="page" 
                            :class="[
                                { 'page-active': page === currentPage },
                                { 'disabled': isLoading },
                                ]">
                            <a class="page-link" 
                                :class="{ 'text-white': page === currentPage }"
                                href="javascript:void(0)" 
                                @click="changePage(page)"><span :class="{ 'page-link-edited': page === currentPage }">{{ page }}</span></a>
                        </li>

                        <li class="page-item" :class="{ 'disabled': (currentPage >= totalPages)|| isLoading}">
                            <a class="page-link" href="javascript:void(0)" @click="changePage(currentPage + 1)">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>
<script>
import { VueDraggableNext } from 'vue-draggable-next';

export default {
    components: {
        draggable: VueDraggableNext
    },
    props: {
        isLoading: {
            type: Boolean,
            default: false
        },
        headers: {
            type: Array,
            default: () => []
        },
        rows: {
            type: Array,
            default: () => []
        },
        pageLimit: {
            type: Number,
            default: 25
        },
        currentPage: {
            type: Number,
            default: 1
        },
        totalPages: {
            type: Number,
            default: 0
        },
        startingEntry: {
            type: Number,
            default: 0
        },
        endingEntry: {
            type: Number,
            default: 0
        },
        totalEntries: {
            type: Number,
            default: 0
        },
        defaultHeight: {
            type: String,
            default: 'auto'
        },
        selectable: {
            type: Boolean,
            default: false
        },
        disable_pagination: {
            typeof: Boolean,
            default: false
        }
    },
    emits: ['reload', 'cellClick', 'selectedRows'],
    data() {
        return {
            sortBy: [],
            selectAll: false,
            selectedItems: []
        };
    },
    computed: {
        pagesToShow() {
            let startPage = Math.max(1, this.currentPage - 1);
            let endPage = Math.min(this.totalPages, this.currentPage + 1);
            return Array.from({ length: endPage - startPage + 1 }, (_, index) => startPage + index);
        }
    },
    methods: {
        handlePageChange() {
            const limit = document.querySelector('#page_limit').value;
            this.$emit('reload', { currentPage: 1, pageLimit: parseInt(limit), sort: this.sortBy });
        },
        changePage(pageNumber) {
            if (pageNumber >= 1 && pageNumber <= this.totalPages) {
                this.$emit('reload', { currentPage: pageNumber, pageLimit: this.pageLimit, sort: this.sortBy });
            }
        },
        handleContentClick(data, headerName, type = 'default') {
            this.$emit('cellClick', {
                headerName: headerName,
                data: data,
                type: type
            });
        },
        applySort(headerName) {
            if(!this.isLoading){
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

                this.$emit('reload', { currentPage: this.currentPage, pageLimit: this.pageLimit, sort: this.sortBy});
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
        }
    },
    watch: {
        selectedItems: {
            handler(newChangeValue) {
                if (this.selectable) {
                    const selectedIndices = newChangeValue
                    .map((value, index) => (value ? index : -1))
                    .filter(index => index !== -1);
                    
                    const objects = selectedIndices.map(index => {
                        const row = this.rows[index];
                        return row && row.data ? row.data : false;
                    });
                    this.$emit('selectedRows', objects);
                }
            },

            deep: true
        }
    },
    mounted() {
        if(this.selectable){
        this.selectedItems = new Array(this.rows.length).fill(false);
        }
    }
};
</script>

<style scoped>
    .header_style{
        background-color: #e6edef;
        position: sticky;
        top: 0;
        z-index: 3;
        height: 39px;
    }

    .header-container {
        height: 39px; /* Adjust this height to match the height of your header rows */
        overflow: hidden;
    }

    .hidden-dropdown {
        position: absolute;
        right: 6px;
        background-color: white;
        top: 39px;
        width: 220px;
        border: rgb(179, 179, 179) solid 1px;
        z-index: 2;
    }

    .hidden-columns-style:hover{
        background-color: #e6edef;
    }

    .bg-row{
        background-color: #f7f7f7;
    }

    #table-lists::-webkit-scrollbar {
        width: 6px; /* Adjust to make it slim */
        height: 4px; /* Adjust to make it slim */
    }

    #table-lists::-webkit-scrollbar-thumb {
        background-color: #888; /* Customize the thumb color */
        border-radius: 3px; /* Rounded corners for the thumb */
    }

    #table-lists::-webkit-scrollbar-track {
        background-color: #ccc; /* Customize the track color */
    }

    .page-active a{
        background-color: #24695c !important;
    }

    .page-link-edited{
        color: white !important;
    }

    .hidden-sort {
        visibility: hidden;
    }

    /* This will make the sort icon visible when the parent div is hovered over */
    .header_style:hover .hidden-sort {
        visibility: visible;
    }

    .description-truncate{
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>