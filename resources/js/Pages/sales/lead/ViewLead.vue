<template>    
    <div class="d-flex flex-column gap-3 px-3 pt-3" style="max-height: calc(100vh - 98px); height: 100vh; background-color: #EEF1F5;">
        <div class="d-flex justify-content-between align-items-center">
            <label>Breadcrums</label>
            <button class="btn btn-primary-v2">Edit Button</button>
        </div>
        <div class="d-flex gap-2">
            <label class="f-14 flex-grow-1 d-flex justify-content-center bg-secondary m-0" style="padding: 12px 0px;">Lead Added</label>
            <label class="f-14 flex-grow-1 d-flex justify-content-center bg-secondary m-0" style="padding: 12px 0px;">Appointment Booked</label>
            <label class="f-14 flex-grow-1 d-flex justify-content-center bg-secondary m-0" style="padding: 12px 0px;">Proposal Sent</label>
            <label class="f-14 flex-grow-1 d-flex justify-content-center bg-secondary m-0" style="padding: 12px 0px;">Follow Up</label>
            <label class="f-14 flex-grow-1 d-flex justify-content-center bg-secondary m-0" style="padding: 12px 0px;">Proposal Signed</label>
            <label class="f-14 flex-grow-1 d-flex justify-content-center bg-secondary m-0" style="padding: 12px 0px;">Convert To Job</label>
        </div>
        <div class="d-flex flex-grow-1 gap-3">
            <div class="bg-white b-radius-8 mb-3 d-flex flex-column p-3 gap-4" style="min-width: 320px; max-width: 320px;">
                <div class="d-flex align-items-center gap-3">
                    <img src="../../../assets/post-1.png" class="shadow-sm b-radius-8" style="height: 62px; width: 62px; border: 2px solid white;">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex flex-column">
                            <label class="m-0 p-0 f-16">{{ customer && customer.display_name ? customer.display_name : 'N/A' }}</label>
                            <label class="m-0 p-0 f-10 text-muted">{{ lead && lead.created_at ? `Created ${getAgeInDays(lead.created_at)} days ago.` : 'N/A' }}</label>
                        </div>
                        <div class="d-flex gap-2 text-primary-v2">
                            <i class="fi fi-rs-user m-0 p-0 bigger" style="height: 15px; cursor: pointer;"></i>
                            <i class="fi fi-rr-edit m-0 p-0 bigger" style="height: 15px; cursor: pointer;"></i>
                            <i class="fi fi-rs-menu-dots-vertical m-0 p-0 bigger" style="height: 15px; cursor: pointer;"></i>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column bg-secondary-light b-radius-8">
                    <div class="d-flex gap-2 px-3 py-2 align-items-center" style="cursor: pointer;">
                        <i class="fi fi-rs-user m-0 p-0 text-primary-v2" style="height: 16px;"></i>
                        <a class="m-0 flex-grow-1 f-14">Customer Info</a>
                        <i class="fi fi-rr-angle-right m-0 p-0 text-primary-v2" style="height: 16px;"></i>
                    </div>
                </div>
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex gap-2 px-3 py-2 align-items-center b-radius-5" style="cursor: pointer !important;"
                        :class="openTab === 'activity' ? 'bg-primary-v2 text-white' : ' bg-solid-hover-secondary-light'"
                        @click="handleTabChanged('activity')">
                        <i class="fi fi-rr-heart-rate m-0 p-0" style="height: 16px;"></i>
                        <label class="m-0 flex-grow-1 f-14 f-w-400"  style="cursor: pointer !important;">Activity</label>
                    </div>
                    <div class="d-flex gap-2 px-3 py-2 align-items-center b-radius-5" style="cursor: pointer !important;"
                        :class="openTab === 'job-info' ? 'bg-primary-v2 text-white' : ' bg-solid-hover-secondary-light'"
                        @click="handleTabChanged('job-info')">
                        <i class="fi fi-rr-comment-info m-0 p-0" style="height: 16px;"></i>
                        <label class="m-0 flex-grow-1 f-14 f-w-400"  style="cursor: pointer !important;">Job Info</label>
                    </div>
                    <div class="d-flex gap-2 px-3 py-2 align-items-center b-radius-5" style="cursor: pointer !important;"
                        :class="openTab === 'to-do' ? 'bg-primary-v2 text-white' : ' bg-solid-hover-secondary-light'"
                        @click="handleTabChanged('to-do')">
                        <i class="fi fi-rr-ballot-check m-0 p-0" style="height: 16px;"></i>
                        <label class="m-0 flex-grow-1 f-14 f-w-400"  style="cursor: pointer !important;">To Do</label>
                    </div>
                    <div class="d-flex gap-2 px-3 py-2 align-items-center b-radius-5" style="cursor: pointer !important;"
                        :class="openTab === 'proposal' ? 'bg-primary-v2 text-white' : ' bg-solid-hover-secondary-light'"
                        @click="handleTabChanged('proposal')">
                        <i class="fi fi-rr-database m-0 p-0" style="height: 16px;"></i>
                        <label class="m-0 flex-grow-1 f-14 f-w-400"  style="cursor: pointer !important;">Proposal</label>
                    </div>
                    <div class="d-flex gap-2 px-3 py-2 align-items-center b-radius-5" style="cursor: pointer !important;"
                        :class="openTab === 'appointment' ? 'bg-primary-v2 text-white' : ' bg-solid-hover-secondary-light'"
                        @click="handleTabChanged('appointment')">
                        <i class="fi fi-rr-calendar-clock m-0 p-0" style="height: 16px;"></i>
                        <label class="m-0 flex-grow-1 f-14 f-w-400"  style="cursor: pointer !important;">Appointment</label>
                    </div>
                    <div class="d-flex gap-2 px-3 py-2 align-items-center b-radius-5" style="cursor: pointer !important;"
                        :class="openTab === 'files' ? 'bg-primary-v2 text-white' : ' bg-solid-hover-secondary-light'"
                        @click="handleTabChanged('files')">
                        <i class="fi fi-rr-folder-open m-0 p-0" style="height: 16px;"></i>
                        <label class="m-0 flex-grow-1 f-14 f-w-400"  style="cursor: pointer !important;">Media, Files & Links</label>
                    </div>
                </div>
            </div>
            <div class="bg-white b-radius-8 flex-grow-1" style="margin-bottom: auto;">
                <div v-if="loading">
                    {{ openTab }} Loading.....
                </div>
                <div v-else-if="openTab === 'proposal'">
                    <ProposalTab :proposal="proposal"/>
                </div>
                <div v-else>
                    {{ openTab }}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import ProposalTab from '@/components/proposal/ProposalTab.vue';

    export default {
        props: ['lead'],
        components: { ProposalTab },
        data(){
            const openTab = 'activity';
            const customer = null;
            const loading = false;
            const proposal = null;

            return { openTab, customer, loading, proposal }
        },
        methods: {
            handleTabChanged(tabName){
                this.openTab = tabName;

                if(this.openTab === 'proposal'){
                    const lead_id = this.lead.lead_id;
                    console.log(this.lead.lead_id);
                    this.fetchProposals(lead_id);
                }
            },
            getAgeInDays(dateString) {
                const today = new Date();
                const createDate = new Date(dateString);
                const differenceInTime = today.getTime() - createDate.getTime();
                const differenceInDays = differenceInTime / (1000 * 3600 * 24);
                return Math.floor(differenceInDays);
            },
            async fetchProposals(id){
                try {
                    this.loading = true;
                    const response = await axios.get(`/api/customer-proposals/${id}`, {
                        params: {},
                        headers: {
                            'Authorization': 'Bearer ',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = response.data.data;
                    if(data && data.length != 0){
                        this.proposal = data[0];
                    }
                    
                    this.loading = false;
                    console.log(data);
                } catch (error) {
                    console.error("Error fetching customers: ", error);
                }
            }
        },
        mounted(){
            if(this.lead){
                const customer = this.lead.lead_customer;
                if(customer){
                    this.customer = customer;
                }
            }
        }
    }
</script>