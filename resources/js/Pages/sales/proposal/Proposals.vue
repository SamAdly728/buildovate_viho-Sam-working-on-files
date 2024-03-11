<template>    
    <div class="page-header p-3">
        <div class="row" v-if="rowData.length !== 0">
            <div class="col-sm-3">
                <input type="text" placeholder="Search Proposal" class="px-3 py-1 b-primary" style="border-radius: 2px;"/>
            </div>
            <div class="col-sm-9">
                <div class="d-flex align-items-center justify-content-between gap-2" style="width: auto; float: right;" v-if="!updating">
                    <a class="btn btn-outline-light ml-3"><i class="icon-export mr-2"></i> Export</a>        
                    <div style="width: 230px;">
                        <Select2 
                            v-model="selectedColumns"
                            :className="'container-style-outlined-light'"
                            :placeholder="'Column Visibility'" 
                            :id="'proposal-list'"
                            :purpose="'multiple-select-no-chips'"
                            :items="selectOptions"
                            :noChipsDisplay="select2Labels"
                            :isLoading="false"
                            :hasChecks="true"
                        />
                    </div>
                    <div class="d-flex gap-2" v-if="selectedProposals.length != 0">
                        <a class="btn btn-danger" style="width: auto;" :style="{'cursor': updating ? 'not-allowed' : 'pointer'}" @click="handleDeleteClicked">Delete</a>
                        <a class="btn btn-primary-v2"  v-if="selectedProposals.length === 1" style="width: auto;" :style="{'cursor': updating ? 'not-allowed' : 'pointer'}" @click="handleUpdateCostItem">Edit Proposal</a>
                    </div>
                    <a class="btn btn-primary-v2"  href='lead-management/proposal'  style="width: auto;">New Proposal</a>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-2" style="width: auto; float: right;"  v-else>
                    <a class="btn btn-outline-light" style="width: auto; cursor: not-allowed;"><i class="fa fa-spin fa-spinner me-2"></i>Updating...</a>
                </div>
            </div>
        </div>
    </div>
    <div class="p-0" style="width: 100%; height: calc(100vh - 165px);">
        <div v-if="loading">
            <div class="col-md-12 d-flex flex-column align-items-center justify-content-center b-l-light " style="height: 100%; margin-top: 50px;">
                <div style="height: 40px;">
                    <LoadingStyleMetric />
                </div>
                <a class="f-w-600 mt-1 mb-5">Retreiving proposals...</a>
            </div>
        </div>
        <div v-else-if="rowData.length === 0" class="d-flex justify-content-center align-items-center" style="width: 100%;">
            <div class="card m-0 shadow-sm d-flex flex-row align-items-center p-5 gap-4" style="border-radius: 10px;">
                <img :src="fileAddress + 'lead_management.png'" alt="" style="height: 50vh;">
                <div>
                    <h3 class="f-50 f-w-800 text-primary m-0 p-0">Proposals</h3>
                    <a class="f-20 f-w-600 text-primary" style="margin-top: -20px;">MAKING IT EASY AND BETTER</a>
                    <p class="f-14 f-w-600 text-muted mt-3" style="width: 600px;">Optimize your proposal management by clearly outlining your products and services in this space. This structured approach to managing proposals not only simplifies the calculation process but also provides visibility into the status of your proposals, enabling efficient handling of multiple proposals at once.</p>
                    <p class="f-16 f-w-600 text-primary mt-3">Enhance your business proposals using this vital tool for achievement.</p>
                    <div class="d-flex gap-3">
                        <a class="btn btn-primary-v2" style="width: auto;" href='lead-management/proposal'>CREATE PROPOSAL</a>
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
                :starting="starting"
                :ending="ending"
                :total="total"
                :totalPages="totalPages"
                :selectable="true"
                :loading="loading || updating"
                @reload="handleTableReload"
                @onSelectionChange="handleSelectChange"
                @cellClick="cellClicked"
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
</template>

<script>
import { usePage } from '@inertiajs/vue3';
import { useCustomersModal } from '../../../stores/customers-modal';
import { useUsersModal } from '../../../stores/users-modal';
import { useSideBar } from '../../../stores/sidebar';
import LoadingStyleMetric from '../../../components/LoadingStyleMetric.vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import RichTable from '../../../components/RichTable.vue';
import Select2 from '../../../components/Select2.vue';

export default {
    components: {
        RichTable,
        Select2,
        LoadingStyleMetric
    },
    setup(){
        const page = usePage();
        const customersStore = useCustomersModal();
        const usersStore = useUsersModal();
        const sidebarStore = useSideBar();

        return { page, customersStore, usersStore, sidebarStore }
    },
    data(){
        const fileAddress = window.asset_link + 'sales/';
        const updating = false;
        const loading = false;
        const pageLimit = 25;
        const currentPage = 1;
        const totalPages = 0;
        const starting = 0;
        const ending = 0;
        const total = 0;
        const filters = {};
        const selectedCustomer = {};
        const selectedColumns = [];
        const selectedProposals = [];
        const rowData = [];
        const select2Labels = {
            no_selected: 'Column Visibility',
            multi_selected: 'Hidden Columns',
            one_selected: 'Hidden Column',
        };
        const selectOptions = [
            {id:'Proposal Title', text: 'Proposal Title'},
            {id:'Lead Opportunity', text: 'Lead Opportunity'},
            {id:'Customer Contact', text: 'Customer Contact'},
            {id:'Salesperson', text: 'Salesperson'},
            {id:'Owner Price', text: 'Owner Price'},
            {id:`Proposal Status`, text: `Proposal Status`},
            {id:'Required Payment', text: 'Required Payment'},
            {id:'Payment Status', text: 'Payment Status'},
        ];
        const headers = [
            { name: "check_column", min: 'auto'}, //Identifier for checklist
            { name: "notification_bell", min: '40px', max: '40px'},
            { name: "Proposal Title", min: '250px'},
            { name: "Lead Opportunity", min: '250px'},
            { name: "Customer Contact", min: '250px'},
            { name: "Salesperson", min: '180px'},
            { name: "Proposal Status", min: '200px'},
            { name: "Owner Price", min: '150px'},
            { name: "Required Payment", min: '200px'},
            { name: "Payment Status", min: '200px'},
        ];

        return { 
            fileAddress,
            loading, 
            pageLimit, 
            currentPage, 
            totalPages, 
            starting, 
            ending, 
            total, 
            filters, 
            selectedCustomer,
            selectedColumns,
            select2Labels,
            selectOptions,
            headers,
            rowData,
            selectedProposals,
            updating
        }
    },
    methods: {
        handleDeleteClicked(){
            if(this.updating){
                return;
            }
            Swal.fire({
                icon: 'warning',
                title: `Delete ${this.selectedProposals.length} selected proposal${this.selectedProposals.length == 1 ? '' : 's'}?`,
                text: `Are you sure you want to delete this proposal${this.selectedProposals.length == 1 ? '' : 's'}?`,
                showCancelButton: true,        // Show cancel button
                confirmButtonText: 'Delete',  // Text on the confirm button
                cancelButtonText: 'Cancel',   // Text on the cancel button
                confirmButtonColor: '#d33',   // Color of the confirm button
                cancelButtonColor: '#3085d6', // Color of the cancel button
                reverseButtons: true,         // Swap button positions
            }).then((result) => {
                if (result.isConfirmed) {
                    this.updating = true;
                    Promise.all(this.selectedProposals.map(item => this.deleteCostItem(item.proposal_id)))
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Proposal Delete Successful!',
                                text: `There's a ${this.selectedProposals.length} total proposal deleted.`,
                            });
                        })
                        .catch(error => {
                            console.error('Error during deletion:', error);
                        })
                        .finally(() => {
                            this.fetchProposals(this.currentPage, this.pageLimit, true);
                        });
                }
            });
        },
        handleUpdateCostItem(){
            this.selectedProposals.forEach(proposal => {
                const proposal_id = proposal.proposal_id;
                const lead_id = proposal.lead_id;

                window.open(`lead-management/proposal/${proposal_id}/${lead_id}`, '_blank');
            });
        },
        handleSelectChange(selectedProposals){
            this.selectedProposals = selectedProposals;
        },
        handleTableReload(data){
            this.currentPage = data.currentPage;
            this.pageLimit = data.pageLimit;
            this.fetchProposals(this.currentPage, this.pageLimit, true);
        },
        cellClicked(value){
            if(value.headerName === 'Customer Contact'){
                this.customersStore.setType('view');
                this.customersStore.setSelectedCustomers(value.data.lead.lead_customer);
                this.customersStore.toggleModal();
            }else if(value.headerName === 'Salesperson'){
                const salespeople = value.data.lead.sales_people;
                if(salespeople && salespeople.length != 0){
                    const users = salespeople.map(item => {
                        return item.user
                    });
                    
                    this.usersStore.setType('view');
                    this.usersStore.setUsers(users);
                    this.usersStore.toggleModal();
                }
            }
        },
        async deleteCostItem(proposal_id){
            try {
                const response = await axios.delete(`/api/proposals/${proposal_id}`, {}, {
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
        async fetchProposals(pageNumber, limit = this.pageLimit, update = false) {
            if(!update){
                this.loading = true;
            }else{
                this.updating = true;
            }

            try {
                const response = await axios.get('/api/proposals', {
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

                    console.log(data.data);
                    this.rowData = Object.values(data.data).map(proposal => {
                        return {
                            id: proposal.proposal_id,
                            content: this.getRowContent(proposal)
                        };
                    });
                    const allEmpty = Object.values(this.filters).every(value => {
                        if (Array.isArray(value)) {
                            return value.length === 0;
                        } else {
                            return value === '';
                        }
                    });

                    this.starting = data.from;
                    this.ending = data.to;
                    this.total = data.total;
                    this.totalPages = data.last_page || 0;
                }else{
                    console.error("Error fetching leads:", response.data);
                }

                this.updating = false;
                this.loading = false;
            } catch (error) {
                console.error("Error fetching leads:", error);
                this.updating = false;
                this.loading = false;
            }
        },
        getRowContent(proposal){
            let rowCells = [];
            this.headers.forEach(header => {
                const headerName = header.name;
                rowCells[headerName] = this.getCellContent(proposal, headerName);

            });

            return rowCells
        },
        getCellContent(proposal, headerName) {
            const proposal_id = proposal.proposal_id;
            const lead_id = proposal.lead_id;
            let defaultCell = {
                className: '',
                content: '-',
                style: 'default',
                action: 'none',
                data: proposal
            }
            
            if (headerName === 'notification_bell'){
                let notifs = `-`;
                if(!proposal.jobsite && proposal.status === 'Approved'){
                    notifs = `<a class='badge badge-danger f-12 f-w-700 m-0' style="cursor: pointer !important;">1</a>`
                }

                defaultCell = {
                    className: 'truncate cursor-pointer',
                    content: notifs,
                    style: 'default',
                    action: 'click',
                    data: proposal
                }
            }

            if (headerName === 'Proposal Title'){
                defaultCell = {
                    className: 'truncate cursor-pointer',
                    content: `<a class='f-12 f-w-700 text-dark' style="cursor: pointer !important;" href='lead-management/proposal/${proposal_id}/${lead_id}'>${proposal.title}</a>`,
                    style: 'default',
                    action: 'click',
                    data: proposal
                }
            }

            if (headerName === 'Lead Opportunity'){
                defaultCell = {
                    className: 'truncate cursor-pointer',
                    content: `<a class='f-12 f-w-600 text-muted' style="cursor: pointer !important;" href='lead-management/view-lead/${lead_id}'>${proposal.lead.opportunity_title}</a>`,
                    style: 'default',
                    action: 'click',
                    data: proposal
                }
            }

            if (headerName === 'Customer Contact'){
                defaultCell = {
                    className: 'cursor-pointer',
                    content: `<a class='f-12 f-w-600 text-muted' style="cursor: pointer !important;">${proposal.lead.lead_customer ? proposal.lead.lead_customer.display_name : 'N/A'}</a>`,
                    style: 'default',
                    action: 'click',
                    data: proposal
                }
            }

            if(headerName === 'Proposal Status'){
                defaultCell = {
                    className: '',
                    content: this.getLeadProposal(proposal),
                    style: 'html-content',
                    action: 'none',
                    data: proposal
                }
            }

            if (headerName === 'Salesperson'){
                const salespeople = proposal.lead.sales_people;
                let display = `<small class='text-danger'>No one assigned</small>`;
                let count = 0;
                if(salespeople && salespeople.length != 0){
                    count = salespeople.length - 1;
                    const moreBadge = count != 0 ? `<span class="badge rounded-pill badge-light text-dark">+${count}</span>` : '';
                    display = `<div style="cursor: pointer;">${salespeople[0].user.display_name} ${moreBadge}</div>`;
                }

                defaultCell = {
                    className: 'truncate',
                    content: display,
                    style: 'html-content',
                    action: 'click',
                    popoverContent: null,
                    data: proposal
                }
            }

            return defaultCell;
        },
        getLeadProposal(proposal) {
            const status = proposal.status;
            let statusLabel = 'NOT SENT';
            let statusColor = 'badge-info';

            if(status === 'Not Sent'){
                statusLabel = 'NOT SENT';
                statusColor = 'badge-info';
            }else if(status === 'Approved'){
                statusLabel = 'APPROVED';
                statusColor = 'badge-primary';
            }else if(status === 'Sent'){
                statusLabel = 'SENT';
                statusColor = 'badge-warning';
            }

            return `<div><span class="badge ${statusColor} position-relative cursor-pointer">${statusLabel}</span></div>`;
        }
    },
    mounted(){
        this.fetchProposals(this.currentPage, this.pageLimit);
        this.sidebarStore.close();
        this.sidebarStore.setDisabled(true);
    },
    watch: {
        pageLimit: {
            handler(newValue){
                this.currentPage = 1;
                this.fetchProposals(this.currentPage, newValue, true);
            }
        },
        selectedColumns: {
            handler(newColumns){
                const updatedHeaders = this.headers.map(column => {
                    return {
                        ...column,
                        hide: newColumns.includes(column.name)
                    };
                });
                this.headers = updatedHeaders;
            },
            deep: true
        }
    }
}
</script>
