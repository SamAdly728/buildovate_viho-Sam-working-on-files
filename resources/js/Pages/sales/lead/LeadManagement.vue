<template>
    <div class="page-header m-0 p-0">
        <div style="max-height: 130px; overflow: hidden;">
            <LeadListTopCards/>
        </div>
	    <div class="row m-0 px-3" v-if="!updating" style="height: 50px;">
            <div class="col-sm-3 m-0 p-0">
                <input type="text" placeholder="Search Lead" class="px-3 py-1 b-primary" style="border-radius: 2px;"/>
            </div>
            <div class="col-sm-9" v-if="selectedLeads.length == 0">
                <div class="d-flex gap-2 align-items-center justify-content-between" style="width: auto; float: right;">
                    <a class="btn btn-outline-light ml-3"><i class="icon-import mr-2"></i> Import</a>
                    <a class="btn btn-outline-light ml-3 px-4" @click="handleToggleFilter"><i class="icon-filter"></i> Filter</a>
                    <div class="ml-3" style="width: 200px;">
                        <Select2 
                            v-model="selectedColumns"
                            :className="'container-style-outlined-light'"
                            :placeholder="'Column Visibility'" 
                            :id="'lead-management'"
                            :purpose="'multiple-select-no-chips'"
                            :items="selectOptions"
                            :noChipsDisplay="select2Labels"
                            :isLoading="false"
                            :hasChecks="true"
                        />
                    </div>
                    <!-- <a class="btn btn-primary-v2 px-4" href='/sales/lead-management/new'  style="width: auto;">New Lead</a> -->
                    <a v-if="!overviewpage" class="btn btn-primary-v2 px-4"  @click="handleNewLeadClick"  style="width: auto;">New Lead</a>
                </div>
            </div>
            <div class="col-sm-9" v-else>
                <div class="d-flex align-items-center justify-content-between gap-2" style="width: auto; float: right;">
                    <a class="btn btn-outline-light">Print</a>
                    <a class="btn btn-outline-light"><i class="icon-import mr-2"></i> Import Activity</a>
                    <a class="btn btn-outline-light"><i class="icon-import mr-2"></i> Import Proposal</a>
                    <a class="btn btn-outline-light"><i class="icon-export mr-2"></i> Export</a>
                    <a class="btn btn-danger">Delete</a>
                    <a class="btn btn-primary-v2">Update Status</a>
                    <a class="btn btn-primary-v2">Assign</a>
                    <a class="btn btn-success">Send Email</a>
                    <a class="btn btn-primary-v2 px-4" style="width: auto;" v-if="selectedLeads.length === 1" @click="handleEditLead">Edit Lead</a>
                </div>
            </div>
	    </div>
        <div class="d-flex align-items-center justify-content-between gap-2" style="width: auto; float: right;"  v-else>
            <a class="btn btn-outline-light" style="width: auto; cursor: not-allowed;"><i class="fa fa-spin fa-spinner me-2"></i>Loading...</a>
        </div>
    </div>
    <div style="width: 100%; height: calc(100vh - 278px);">
        <div v-if="loading">
            <div class="col-md-12 d-flex flex-column align-items-center justify-content-center b-l-light " style="height: 100%; margin-top: 50px;">
                <div style="height: 40px;">
                    <LoadingStyleMetric />
                </div>
                <a class="f-w-600 mt-1 mb-5">Retreiving leads...</a>
            </div>
        </div>
        <div v-else-if="rowData.length === 0" class="d-flex justify-content-center align-items-center" style="width: 100%;">
            <div class="card m-0 shadow-sm d-flex flex-row align-items-center p-5 gap-4" style="border-radius: 10px;">
                <img :src="fileAddress + 'lead_management.png'" alt="" style="height: 50vh;">
                <div>
                    <h3 class="f-50 f-w-800 text-primary m-0 p-0">Lead Management</h3>
                    <a class="f-20 f-w-600 text-primary" style="margin-top: -20px;">MAKING IT EASY AND BETTER</a>
                    <p class="f-14 f-w-600 text-muted mt-3" style="width: 600px;">Optimize your proposal management by clearly outlining your products and services in this space. This structured approach to managing proposals not only simplifies the calculation process but also provides visibility into the status of your proposals, enabling efficient handling of multiple proposals at once.</p>
                    <p class="f-16 f-w-600 text-primary mt-3">Enhance your business proposals using this vital tool for achievement.</p>
                    <div class="d-flex gap-3">
                        <a class="btn btn-primary-v2" style="width: auto;" href='lead-management/proposal'>CREATE LEAD</a>
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
                @cellClick="cellClicked"
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
    <SideListFilter :open="toggleFilter" @filter="applyFilter"/>
</template>

<script>
    import { usePage } from '@inertiajs/vue3';
    import { useCustomersModal } from '../../../stores/customers-modal';
    import { useUsersModal } from '../../../stores/users-modal';
    import { useSideBar } from '../../../stores/sidebar';
    import { useNewLeadSidebar } from '../../../stores/new-lead';
    import axios from 'axios';
    import RichTable from '../../../components/RichTable.vue';
    import SideListFilter from '../../../components/SideListFilter.vue';
    import Select2 from '../../../components/Select2.vue';
    import LeadListTopCards from './LeadListTopCards.vue';
    import LoadingStyleMetric from '../../../components/LoadingStyleMetric.vue';

    export default {
        // props: ['errors', 'appName', 'company', 'support', 'csrf_token', 'style', 'flash', 'pageTitle', 'auth'],
        props: {
            errors: String,
            appName: String,
            company: String,
            support: String,
            csrf_token: String,
            style: String,
            flash: String,
            pageTitle: String,
            auth: String,
            overviewpage: {
                type: Boolean,
                default: false
            },
        },
        components: {
            RichTable,
            SideListFilter,
            Select2,
            LeadListTopCards,
            LoadingStyleMetric
        },
        setup(){
            const page = usePage();
            const customersStore = useCustomersModal();
            const usersStore = useUsersModal();
            const sidebarStore = useSideBar();
            const newLeadStore = useNewLeadSidebar();

            return { 
                page, 
                customersStore,
                usersStore,
                sidebarStore,
                newLeadStore
            }
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
            const toggleFilter = false;
            const filters = {};
            const selectedLeads = [];
            const selectedUser = {};
            const selectedSalespeople = [];
            const selectedColumns = [];
            const rowData = [];
            const defaultSort = {
                opportunity_title: 'none',
                customer_name: 'none',
                created_at: 'none',
            };
            const select2Labels = {
                no_selected: 'Column Visibility',
                multi_selected: 'Hidden Columns',
                one_selected: 'Hidden Column',
            };
            const selectOptions = [
                {id:'Lead Title', text: 'Lead Title'},
                {id:'Name', text: 'Name'},
                {id:`Phone`, text: `Phone`},
                {id:'Salesperson', text: 'Salesperson'},
                {id:'Status', text: 'Status'},
                {id:'Days Old', text: 'Days Old'},
            ];
            const headers = [
                { name: "check_column", min: 'auto'}, //Identifier for checklist
                { name: "ID #", max: '65px', min: '65px'},
                { name: "Lead Title", min: '300px', sorting: true, sortType: 'alpha', draggable: true, accordion_container: true},
                { name: "Name", min: '200px', sorting: true, sortType: 'alpha', draggable: true},
                { name: "Phone", min: '150px', sorting: true, sortType: 'alpha', draggable: true},
                { name: "Salesperson", min: '180px', draggable: true},
                { name: "Status", min: '120px', max: '120px', draggable: true},
                { name: "Days Old", min: '150px', max: '150px', sorting: true, sortType: 'numeric', draggable: true}
            ];

            return {
                fileAddress,
                updating,
                loading,
                pageLimit,
                currentPage,
                totalPages,
                starting,
                ending,
                total,
                toggleFilter,
                filters,
                selectedLeads,
                selectedUser,
                selectedSalespeople,
                selectedColumns,
                defaultSort,
                select2Labels,
                selectOptions,
                headers,
                rowData
            }
        },
        methods: {
            formatPhoneNumber(number) {
                const cleaned = ('' + number).replace(/\D/g, '');
                const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
                if (match) {
                    return '(' + match[1] + ') ' + match[2] + '-' + match[3];
                }
                return number;
            },
            handleEditLead(){
                this.selectedLeads.forEach(lead => {
                const lead_id = lead.lead_id;

                window.open(`lead-management/edit/${lead_id}`, '_blank');
            });
            },
            handleSelectChange(selectedLeads){
                this.selectedLeads = selectedLeads;
            },
            handleTableReload(data){
                this.currentPage = data.currentPage;
                this.pageLimit = data.pageLimit;
                this.fetchLeads(this.currentPage, this.pageLimit, true);
            },
            handleToggleFilter() {
                this.toggleFilter = this.toggleFilter;
            },
            filter(value) {
                if(value.sort && value.sort.length != 0){
                    value.sort.forEach(sort => {
                        if(sort.name === 'Opportunity Title'){
                            this.defaultSort.opportunity_title = sort.type;
                        }else if(sort.name === 'Customer Contact'){
                            this.defaultSort.opportunity_title = sort.type;
                        }else if(sort.name === 'Age'){
                            this.defaultSort.created_at = sort.type;
                        }else if(sort.name === 'Status'){
                            this.defaultSort.status = sort.type;
                        }
                    });
                }
                
                this.fetchLeads(this.currentPage, this.pageLimit);
            },
            cellClicked(value) {
                if(value.headerName === 'Name'){
                    this.customersStore.setType('view');
                    this.customersStore.setSelectedCustomers(value.data.lead_customer);
                    this.customersStore.toggleModal();
                }else if(value.headerName === 'Salesperson'){
                    const salespeople = value.data.sales_people;
                    if(salespeople && salespeople.length != 0){
                        const users = salespeople.map(item => {
                            return item.user
                        });
                        
                        this.usersStore.setType('view');
                        this.usersStore.setUsers(users);
                        this.usersStore.toggleModal();
                    }
                }else if(value.headerName === 'Lead Title'){
                    console.log('OPEN TAB');
                }
            },
            applyFilter(value) {
                this.filters = value;
                this.fetchLeads(this.currentPage, this.pageLimit);
            },
            async fetchLeads(pageNumber, limit = this.pageLimit, update = false) {
                if(!update){
                    this.loading = true;
                }else{
                    this.updating = true;
                }

                try {
                    const response = await axios.get('/api/leads', {
                        params: { 
                            page: pageNumber ,
                            limit: limit,
                            sort: this.defaultSort,
                            filters: this.filters
                        },
                        headers: {
                            'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if(response.data.status === 'success'){
                        const data = response.data.data;
                        this.rowData = Object.values(data.data).map(lead => {
                            return {
                                id: lead.lead_id,
                                content: this.getRowContent(lead),
                                data: lead
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

                if (headerName === 'Name'){
                    const customer = lead.lead_customer;
                    defaultCell = {
                        content: `<a class='f-12 f-w-600 text-muted' style="cursor: pointer !important;">${customer ? customer.display_name : 'N/A'}</a>`,
                        style: 'default',
                        action: 'click',
                        data: lead
                    }
                }
                

                if (headerName === 'Lead Title'){
                    defaultCell = {
                        content: `<a class='f-12 f-w-600 text-dark' style="cursor: pointer !important;">${lead.opportunity_title}</a>`,
                        style: 'default',
                        action: 'click',
                        data: lead
                    }
                }

                if (headerName === 'Phone') {
                    const customer = lead.lead_customer;
                    defaultCell = {
                        content: customer ? this.formatPhoneNumber(customer.phone) : 'N/A',
                        style: 'html-content',
                        action: 'none',
                        data: lead
                    }
                }

                if (headerName === 'Status') {
                    defaultCell = {
                        content: this.getStatus(lead.status),
                        style: 'html-content',
                        action: 'none',
                        data: lead
                    }
                }

                if (headerName === 'Days Old') {
                    defaultCell = {
                        content: this.getAgeInDays(lead.created_at),
                        style: 'default',
                        action: 'none',
                        data: lead
                    }
                }

                if (headerName === 'Salesperson'){
                    const salespeople = lead.sales_people;
                    let display = `<small class='text-danger'>No one assigned</small>`;
                    let count = 0;
                    if(salespeople && salespeople.length != 0){
                        count = salespeople.length - 1;
                        const moreBadge = count != 0 ? `<span class="badge rounded-pill badge-light text-dark">+${count}</span>` : '';
                        display = `<div class="cursor-pointer">${salespeople[0].user.display_name} ${moreBadge}</div>`;
                    }

                    defaultCell = {
                        content: display,
                        style: 'html-content',
                        action: 'click',
                        data: lead
                    }
                }

                return defaultCell;
            },
            getStatus(status) {
                let badgeClass = '';
                let badgeText = '';
                switch (status.toLowerCase()) {
                    case 'open':
                        badgeClass = 'badge-secondary';
                        badgeText = 'Open';
                    break;
                    case 'pitch':
                        badgeClass = 'badge-danger';
                        badgeText = 'Pitch - No Sale';
                    break;
                    case 'returned':
                        badgeClass = 'badge-warning';
                        badgeText = 'Returned to Provider';
                    break;
                    case 'sold':
                        badgeClass = 'badge-primary';
                        badgeText = 'Sold';
                    break;
                    default:
                        return status;
                }
                return `<div><span class="badge ${badgeClass} position-relative cursor-pointer">${badgeText}</span></div>`;
            },
            getAgeInDays(dateString) {
                const today = new Date();
                const createDate = new Date(dateString);
                const differenceInTime = today.getTime() - createDate.getTime();
                const differenceInDays = differenceInTime / (1000 * 3600 * 24);
                return Math.floor(differenceInDays);
            },
            getMultipleString(lists, type){
                let listItems = `-`;
                if(lists && lists.length !== 0){
                    listItems = lists.map(data => {
                        let name = '-';
                        if(type === 'Job Type'){
                            name = data.job_type.job_type_name;
                        }else if(type === 'Tags'){
                            name = data.tag.tags_name;
                        }else if(type === 'Lead Source'){
                            name = data.source.source_name;
                        }
                        return `<small>${name}</small>`
                    }).join(', ');
                }

                return `<a class="truncate">${listItems}</a>`;
            },
            getSelectedProposal(proposals){
                let selectedProposal = null;
                
                if(proposals.length != 0){
                    const approvedProposal = proposals.find(data => data.status === "Approved");

                    if (approvedProposal) {
                        selectedProposal = approvedProposal;
                    } else {
                        const sentProposals = proposals.filter(data => data.status === "Sent")
                                            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                                            
                        if (sentProposals.length > 0) {
                            selectedProposal = sentProposals[0];
                        } else {
                            proposals.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));
                            selectedProposal = proposals[0];
                        }
                    }
                }
                return selectedProposal;
            },
            getLeadProposal(proposals) {
                let selectedProposal = this.getSelectedProposal(proposals);

                const status = selectedProposal.status;
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
            },
            handleNewLeadClick() {
                this.newLeadStore.open();
            },
        },
        mounted() {
            this.fetchLeads(this.currentPage, this.pageLimit);
            if(!this.overviewpage){
                this.sidebarStore.close();
                this.sidebarStore.setDisabled(true);
            }
        },
        watch: {
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