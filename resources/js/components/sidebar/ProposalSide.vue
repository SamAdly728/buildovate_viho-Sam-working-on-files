<template>
    <div class="d-flex flex-grow-1 flex-column" style="height: 100%; max-height: calc(100vh - 120px);">
        <div class="d-flex f-14 gap-2 px-4" v-if="this.store.selectedLead">
            <div class="btn btn-primary-v2 px-2 py-1" style="cursor: pointer" @click="handleLeadClicked">Lead Details</div>
            <div class="btn btn-primary-v2 px-2 py-1" style="cursor: pointer" @click="handleCustomerClicked">Customer Details</div>
        </div>
        <hr>
        <div class="d-flex gap-2 f-14">
            <a class="px-3 py-1 f-w-600 flex-grow-1 text-center" 
                :class="activeTab === 'leads' ? 'text-primary-v2 b-b-primary-2' : 'text-muted'"
                style="cursor: pointer;" 
                @click="handleActiveTabClicked('leads')">Leads</a>
            <a class="px-3 py-1 f-w-600 flex-grow-1 text-center" 
                :class="activeTab === 'estimates' ? 'text-primary-v2 b-b-primary-2' : 'text-muted'"
                style="cursor: pointer;" 
                @click="handleActiveTabClicked('estimates')">Estimates</a>
        </div>
        <div class="d-flex">
            <input type="text" class="b-primary-v2 f-12 px-3 flex-grow-1" placeholder="Search Lead" v-model="search"/>
            <div class="btn btn-primary-v2 px-3 py-2" style="border-radius: 0px;"><i class="icon-filter"></i></div>
        </div>

        <div class="flex-grow-1 slim-scroll-light" v-if="activeTab === 'leads'" style="max-height: calc(100vh - 200px); overflow: auto;">
            <div class="d-flex justify-content-center align-items-center f-14 f-w-600 text-muted p-3" v-if="loading || searching">
                <i class="fa fa-spin fa-spinner me-2"></i>{{ searching ? 'Searching...' : 'Loading...' }}
            </div>
            <div class="px-4 py-2" v-else>
                <template v-for="lead in leads">
                    <Link :href="`/sales/lead-management/proposal/0/${lead.lead_id}`">
                        <div class="p-2 d-flex gap-3 bg-hover-secondary b-radius-10 align-items-center" style="cursor: pointer;" 
                            @click="handleSelectedLead(lead)"
                            :class="selectedLead && selectedLead.lead_id === lead.lead_id ? 'bg-secondary-v2 text-white' : 'text-dark'">
                            <h5 class="m-0 p-0 f-12 f-w-500 text-truncated flex-grow-1"><b>{{ lead.lead_customer && lead.lead_customer.display_name ? lead.lead_customer.display_name : 'N/A' }}</b> - ({{ lead.opportunity_title }})</h5>
                            
                            <i :class="selectedLead && selectedLead.lead_id === lead.lead_id ? 'icon-angle-down f-12 text-white' : 'icon-angle-right f-12 text-muted'"></i>
                        </div>
                    </Link>
                    <div class="d-flex flex-column" v-if="selectedLead && selectedLead.lead_id === lead.lead_id">
                        <div class="d-flex flex-column mt-1 mb-1">
                            <div class="d-flex align-items-center f-w-600 text-muted p-3  f-12" v-if="proposal_loading">
                                <i class="fa fa-spin fa-spinner me-2"></i>Loading...
                            </div>
                            <div v-else-if="proposals && proposals.length != 0">
                                <template v-for="proposal in proposals">
                                    <Link :href="`/sales/lead-management/proposal/${proposal.proposal_id}/${lead.lead_id}`">
                                        <div class="px-3 py-2 d-flex gap-2 bg-hover-secondary b-radius-10 align-items-center" style="cursor: pointer;" 
                                            @click="handleSelectedProposal(proposal)"
                                            :class="selectedProposal && selectedProposal.proposal_id === proposal.proposal_id ? 'bg-secondary-v2 text-white' : 'text-muted'">
                                            <i :class="getStatusColor(proposal.status)" style="height: 10px; min-width: 10px !important; border-radius: 5px;"></i>
                                            <h5 class="m-0 p-0 f-12 f-w-500 text-truncated">{{ proposal.title }}</h5>
                                        </div>
                                    </Link>
                                </template>
                            </div>
                            <div class="d-flex align-items-center f-w-600 text-muted p-3  f-12" v-else>
                                No proposal found in this lead.
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="flex-grow-1" v-else>
            Estimates
        </div>

    </div>
</template>
<script>
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { useSideBar } from '../../stores/sidebar';
import { useCustomersModal } from "../../stores/customers-modal";
import { useLeadDetails } from "../../stores/lead-details-modal";
import axios from "axios";

export default {
    components: { Link },
    setup(){
        const page = usePage();
        const store = useSideBar();
        const customersStore = useCustomersModal();
        const leadDetailsStore = useLeadDetails();

        return { page, store, customersStore, leadDetailsStore }
    },
    data(){
        const activeTab = 'leads';
        const leads = null;
        const proposals = null;
        const loading = false;
        const proposal_loading = false;
        const selectedLead = null;
        const selectedProposal = null;
        const search = '';
        const searching = false;
        const searchTimeout = null;

        return { activeTab, leads, loading, proposal_loading, proposals, selectedLead, selectedProposal, search, searching, searchTimeout };
    },
    methods: {
        handleLeadClicked(){
            this.leadDetailsStore.setSelected(this.store.selectedLead);
            this.leadDetailsStore.toggleModal();
        },
        handleCustomerClicked(){
            this.customersStore.setType('view');
            this.customersStore.setSelectedCustomers(this.store.selectedLead.lead_customer);
            this.customersStore.toggleModal();
        },
        getStatusColor(status){
            let statusColor = 'bg-muted';

            if(status === 'Not Sent'){
                statusColor = 'bg-muted';
            }else if(status === 'Approved'){
                statusColor = 'bg-success-v2';
            }else if(status === 'Sent'){
                statusColor = 'bg-warning-v2';
            }

            return statusColor
        },
        handleActiveTabClicked(type){
            this.activeTab = type;
        },
        handleSelectedProposal(proposal){
            this.selectedProposal = proposal;
            this.store.setSelectedProposal(proposal);
        },
        handleSelectedLead(lead){
            this.selectedLead = lead;
            this.store.setSelectedLead(lead);
            this.fetchProposals(lead.lead_id);
        },
        async fetchLeads(search, searching = false) {
            if(!searching){
                this.loading = true;
            }else{
                this.searching = true;
            }
            
            try {
                const response = await axios.get('/api/leads', {
                    params: { search },
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if(response.data.status === 'success'){
                    const data = response.data.data;

                    this.leads = data;
                    this.store.setLeads(this.leads);
                }else{
                    console.error("Error fetching leads:", response.data);
                }
                this.loading = false;
                this.searching = false;
            } catch (error) {
                console.error("Error fetching leads:", error);
                this.loading = false;
                this.searching = false;
            }
        },
        async fetchProposals(lead_id) {
            this.proposal_loading = true;
            try {
                const response = await axios.get('/api/proposals', {
                    params: { lead_id },
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if(response.data.status === 'success'){
                    const data = response.data.data;

                    this.proposals = data.data;
                    this.store.setProposals(data.data);
                }else{
                    console.error("Error fetching proposals:", response.data);
                }
                this.proposal_loading = false;
            } catch (error) {
                console.error("Error fetching proposals:", error);
                this.proposal_loading = false;
            }
        },
        debounceSearch(newValue) {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.fetchLeads(newValue, true);
            }, 500);
        }
    },
    mounted() {
        if(this.store.leads){
            this.leads = this.store.leads;
        }else{
            this.fetchLeads('');
        }

        if(this.store.selectedLead){
            this.selectedLead = this.store.selectedLead;
            this.fetchProposals(this.selectedLead.lead_id);
        }

        if(this.store.selectedProposal){
            this.selectedProposal = this.store.selectedProposal;
        }
    },
    watch: {
        search: {
            handler(search){
                this.debounceSearch(search);
            }
        }
    }
}
</script>