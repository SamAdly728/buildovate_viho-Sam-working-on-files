<template>
    <div class="modal fade" id="leadList" tabindex="-1" role="dialog" aria-labelledby="leadList" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"  style="height: 85vh !important;">
                <div class="modal-body p-0 m-0 d-flex flex-column" style="max-height: 93vh !important; background-color: rgb(228, 228, 228);">
                    <div class="px-4 py-3 m-0 b-b-primary-v2 d-flex align-items-center bg-white">
                        <h5 class="f-18 f-w-600 text-dark flex-grow-1 m-0 p-0">Select Lead</h5>
                        <span class="bg-hover m-0 p-1 f-w-700 text-dark f-18 close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"><i class="icon-close"></i></span>
                    </div>
                    <div class="d-flex gap-2 justify-content-between px-3 py-2 b-b-primary-v2 bg-white">
                        <input class="form-control b-primary-v2" type="text" placeholder="Search lead" v-model="searchTerm"/>
                        <div class="d-flex gap-2" v-if="selected && selected.length === 1">
                            <a class="btn btn-primary-v2" @click="handleSelectLead" data-bs-dismiss="modal">Select</a>
                        </div>
                        <i class="f-12 text-danger-v2 bg-white" v-if="selected && selected.length !== 1">**You can only select 1 lead**</i>
                    </div>
                    <div class="card-body flex-grow-1 m-0 p-0 bg-white" style="max-height: calc(100vh -300px); overflow: hidden;">
                        <div v-if="loading">
                            <div class="col-md-12 d-flex flex-column align-items-center justify-content-center b-l-light " style="height: 100%; margin-top: 50px;">
                                <div style="height: 40px;">
                                    <LoadingStyleMetric />
                                </div>
                                <a class="f-w-600 mt-1 mb-5">Retreiving leads...</a>
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
                                :starting="starting"
                                :ending="ending"
                                :total="total"
                                :totalPages="totalPages"
                                :selectable="true"
                                :loading="loading || updating"
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useLeadsModal } from '../../stores/lead-list-modal';
import { usePage } from '@inertiajs/vue3';
import RichTable from '../RichTable.vue';
import axios from 'axios';
import LoadingStyleMetric from '../LoadingStyleMetric.vue';

export default {
    components: { RichTable, LoadingStyleMetric },
    setup(){
        const store = useLeadsModal();
        const page = usePage();

        return { store, page }
    },
    data(){
        const updating = false;
        const loading = false;
        const pageLimit = 25;
        const currentPage = 1;
        const totalPages = 0;
        const starting = 0;
        const ending = 0;
        const total = 0;
        const headers = [
            { name: "check_column", min: 'auto'},
            { name: "ID #", max: '65px', min: '65px'},
            { name: "Lead Title", min: '300px'},
            { name: "Customer Details", min: '200px'},
        ];
        const rowData = [];
        const selected = null;
        const searchTerm = '';
        const searchTimeout = null;

        return { updating, loading, pageLimit, currentPage, totalPages, starting, ending, total, headers, selected, searchTerm, searchTimeout, rowData }
    },
    methods: {
        handleSelectLead(){
            this.store.setSelected(this.selected[0]);
            this.store.closeModal();
        },
        handleTableReload(data){
            this.currentPage = data.currentPage;
            this.pageLimit = data.pageLimit;
            this.fetchLeads(this.currentPage, this.pageLimit, this.searchTerm, true);
        },
        updateModalVisibility() {
            const modalElement = document.getElementById('leadList');
            const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

            if (this.store.isModalOpen) {
                modalInstance.show();
                this.fetchLeads(this.currentPage, this.pageLimit, this.searchTerm);
            } else {
                document.querySelector(`#leadList .close`).click();
            }
        },
        handleSelectChange(selected){
            this.selected = selected;
        },
        async fetchLeads(page, limit, search, update = false) {
            try {
                if(!update){
                    this.loading = true;
                }else{
                    this.updating = true;
                }
                const response = await axios.get('/api/leads', {
                        params: { page, limit, search },
                        headers: {
                            'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                const data = response.data.data;
                this.rowData = Object.values(data.data).map(lead => {
                     return {
                        id: lead.lead_id,
                        content: this.getRowContent(lead),
                        data: lead
                    };
                });

                this.starting = data.from;
                this.ending = data.to;
                this.total = data.total;
                this.totalPages = data.last_page || 0;
                this.loading = false;
                this.updating = false;
            } catch (error) {
                this.loading = false;
                this.updating = false;
                console.error("Error fetching customers: ", error);
            }
        },
        getRowContent(lead){
            let rowCells = [];
            this.headers.forEach(header => {
                const headerName = header.name;
                rowCells[headerName] = this.getCellContent(lead, headerName);
            });
            
            return rowCells
        },
        getCellContent(lead, headerName) {
            const lead_id = lead.lead_id;
            let defaultCell = {
                content: '-',
                style: 'default',
                action: 'none',
                data: lead
            }
            
            if (headerName === 'ID #'){
                defaultCell = {
                    content:lead.lead_id,
                    style: 'default',
                    action: 'none',
                    data: lead
                }
            }
                
            if (headerName === 'Lead Title'){
                defaultCell = {
                    content: `<a class='f-12 f-w-600 text-dark' style="cursor: pointer !important;">${lead.opportunity_title}</a>`,
                    style: 'default',
                    action: 'none',
                    data: lead
                }
            }

            if (headerName === 'Customer Details'){
                const customer = lead.lead_customer;
                defaultCell = {
                    content: `<a class='f-12 f-w-600 text-muted' style="cursor: pointer !important;">${customer ? customer.display_name : 'N/A'}</a>`,
                    style: 'default',
                    action: 'none',
                    data: lead
                }
            }
            
            return defaultCell;
        },
        debounceSearch(newValue) {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.fetchLeads(this.currentPage, this.pageLimit, newValue, true);
            }, 500);
        }
    },
    computed: {
        isModalOpen() {
            return this.store.isModalOpen;
        }
    },
    watch: {
        isModalOpen: {
            handler() {
                this.updateModalVisibility();
            }
        },
        searchTerm: {
            handler(newValue) {
                this.debounceSearch(newValue);
            }
        }
    }
}
</script>