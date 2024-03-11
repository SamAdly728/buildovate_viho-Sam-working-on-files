<template>
    <div class="d-flex bg-main" style="width: 100vw; height: 100vh;">
        <div style="max-width: 400px;" class="bg-white shadow d-flex flex-column flex-grow-1">
            <div class="d-flex align-items-center justify-content-center p-3" style="width: 100%;">
                <img src="../../assets/post-1.png" style="height: 100px; width: 100px;"/>
            </div>
            <div class="d-flex">
                <div class="flex-grow-1"></div>
                <div class="d-flex flex-column" style="max-width: 250px;">
                    <div class="d-flex f-16 f-w-500 gap-2 px-3 py-2 bg-solid-hover-primary align-items-center" style="cursor: pointer;">
                        <i class="fi fi-rr-memo f-20"></i>
                        <div class="" @click="handleMenuClick('proposals')">Proposals</div>
                    </div>
                    <div class="d-flex f-16 f-w-500 gap-2 px-3 py-2 bg-solid-hover-primary align-items-center" style="cursor: pointer;">
                        <i class="fi fi-rr-file-invoice f-20"></i>
                        <div class="" @click="handleMenuClick('invoices')">Invoices</div>
                    </div>
                    <div class="d-flex f-16 f-w-500 gap-2 px-3 py-2 bg-solid-hover-primary align-items-center" style="cursor: pointer;">
                        <i class="fi fi-rr-calendar-lines f-20"></i>
                        <div class="" @click="handleMenuClick('schedule')">Request Appointment</div>
                    </div>
                    <div class="d-flex f-16 f-w-500 gap-2 px-3 py-2 bg-solid-hover-primary align-items-center" style="cursor: pointer;">
                        <i class="fi fi-rr-envelope-dot f-20"></i>
                        <div class="" @click="handleMenuClick('settings')">Email Settings</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-grow-1 d-flex justify-content-center px-3">
            <div class="shadow flex-grow-1 bg-white" style="max-width: 1000px; margin-top: 25px; margin-bottom: auto;" v-if="action === 'preview'">
                <DefaultTemplate 
                    :type="'customer'"
                    :proposal_id="id"
                    :company="company"
                    :lead="lead"/>
            </div>
            <div v-else>{{ action }}</div>
        </div>
    </div>
</template>
  
<script>
import DefaultTemplate from '@/components/proposal/DefaultTemplate.vue';
import axios from 'axios';

export default {
    props: ['token'],
    components: { DefaultTemplate },
    data(){
        const id = 0;
        const action = '';
        const type = '';
        const lead_id = 0;
        const company = null;
        const lead = null;

        return { id, action, type, lead_id, company, lead }
    },
    methods: {
        handleMenuClick(type){
            const url = `/portal/?token=${this.$crypto.encryptData(`customer-${type}-${this.lead_id}`)}`;
            window.open(url, '_self');
        },
        async fetchProposal(id){
            try {
                const response = await axios.get(`/api/proposal/${id}`, {
                    params: {},
                    headers: {
                        'Authorization': 'Bearer ',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = response.data.data;
                const lead = data.lead;

                if(lead){
                    this.lead = lead;
                    this.lead_id = lead.lead_id;
                    const company = lead.company;
                    if(company){
                        this.company = company;
                    }
                }
                console.log(data);
            } catch (error) {
                console.error("Error fetching customers: ", error);
            }
        },
        async fetchProposals(id){
            try {
                const response = await axios.get(`/api/customer-proposals/${id}`, {
                    params: {},
                    headers: {
                        'Authorization': 'Bearer ',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = response.data.data;
                
                console.log(data);
            } catch (error) {
                console.error("Error fetching customers: ", error);
            }
        }
    },
    mounted(){
        if(this.token){
            const decrypted = this.$crypto.decryptData(this.token);

            if(decrypted){
                const split = decrypted.split('-');

                this.type = split[0];
                this.action = split[1];
                this.id = split[2];

                if(this.action === 'preview'){
                    const proposal_id = this.id;
                    this.fetchProposal(proposal_id);
                }else if(this.action === 'proposals'){
                    const lead = this.id;
                    this.fetchProposals(lead);
                }else if(this.action === 'invoices'){
                    console.log('Load list of invoices here.');
                }else if(this.action === 'schedule'){
                    console.log('Request Schedule here.');
                }else if(this.action === 'settings'){
                    console.log('Change Settings here');
                }else{
                    console.log(this.type, this.id, this.action);
                }
            }
        }
    }
}
</script>
  