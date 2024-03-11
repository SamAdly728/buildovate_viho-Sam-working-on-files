<template>
    <div class="d-flex flex-column gap-2 p-4">
        <div class="d-flex gap-3">
            <div class="flex-grow-1 d-flex flex-column">
                <label class="m-0 p-0 text-dark">Proposal Title</label>
                <input type="text" class="px-3 py-2 b-radius-8 b-muted-v2" placeholder="Entry proposal title..."  v-model="proposalTitle" @input="handleTitleChanged" />
            </div>
            
            <div class="d-flex flex-column" style="width: 300px;">
                <label class="m-0 p-0 text-dark">Approval Date</label>
                <div type="text" class="px-3 py-2 b-radius-8 b-muted-v2 d-flex" @click="handleDateClicked">
                    <label class="m-0 text-muted f-w-400 flex-grow-1">{{ approvalDate }}</label>
                    <i class="fi fi-rr-calendar-clock d-flex align-items-center f-18 f-w-400"></i>
                    <flat-pickr
                        ref="flatpickr"
                        class="position-absolute"
                        v-model="approvalDate"
                        :config="datePickerConfig"
                        id="appointment_date"
                        style="visibility: hidden;"
                        ></flat-pickr>
                </div>
            </div>

            <div class="d-flex flex-column">
                <label class="m-0 p-0 text-dark">Status</label>
                <label class="m-0 p-0 bg-secondary-light d-flex align-items-center px-4 f-w-600 b-radius-5" :class="`b-${statusColor}-v2 text-${statusColor}-v2`" style="height: 38px;">{{ status.toUpperCase() }}</label>
            </div>

            <div class="d-flex flex-column">
                <label class="m-0 p-0 text-dark">Preview</label>
                <div class="d-flex gap-2">
                    <label class="m-0 p-0 btn-outline-custom-primary d-flex align-items-center px-4 f-w-600" 
                        style="height: 38px;" @click="handleViewPortal">View Portal</label>
                    <div class="position-relative">
                        <label class="m-0 p-0 btn-outline-custom-primary d-flex align-items-center px-4 f-w-600"
                                style="height: 38px;" 
                                @click="handleWorkOrder">Work Order</label>
                        <div style="position: absolute; top: 35px; width: 250px; left: -95px; z-index: 2;" class="shadow-lg b-radius-10" v-if="toggleWorkOrderDropdown">
                            <div class="bg-white d-flex flex-column b-radius-10" style="overflow: hidden;">
                                <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleViewWorkOrder">
                                    <i class="fi fi-rr-eye text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">View</span>
                                </div>
                                <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleSendEmailWorkOrder">
                                    <i class="fi fi-rr-envelope text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">Send Email</span>
                                </div>
                                <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleSendSMSWorkOrder">
                                    <i class="fi fi-rr-message-sms text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">Send SMS</span>
                                </div>
                                <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleAddToPro">
                                    <i class="fi fi-rr-mode-portrait text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">Add to Pro Bulletin Board</span>
                                </div>
                                <div class="d-flex gap-2 text-muted align-items-center px-3 py-2 b-b-muted-v2 bg-hover-light" style="cursor: pointer;" @click="handleCopyLink">
                                    <i class="fi fi-rr-copy text-primary-v2 f-16" style="height: 20px;"></i> <span class="f-w-600">Copy Link</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex mt-3">
            <label class="m-0 px-3 py-2"
                :class="selectedTab === 'worksheet' ? 'b-b-primary-2' : 'b-b-muted-2 b-hover'"
                style="cursor: pointer;" 
                @click="handleTabClicked('worksheet')">Worksheet</label>
            <label class="m-0 px-3 py-2" 
                :class="selectedTab === 'payment' ? 'b-b-primary-2' : 'b-b-muted-2 b-hover'"
                style="cursor: pointer;" 
                @click="handleTabClicked('payment')">Payment Schedule</label>
            <label class="m-0 px-3 py-2" 
                :class="selectedTab === 'others' ? 'b-b-primary-2' : 'b-b-muted-2 b-hover'"
                style="cursor: pointer;" 
                @click="handleTabClicked('others')">Others</label>
            <label class="m-0 px-3 py-2" 
                :class="selectedTab === 'preview' ? 'b-b-primary-2' : 'b-b-muted-2 b-hover'"
                style="cursor: pointer;" 
                @click="handleTabClicked('preview')">Preview</label>
            <label class="m-0 px-3 py-2 b-b-muted-2 flex-grow-1" style="cursor: pointer;"></label>
        </div>
        <div class="" v-if="selectedTab === 'worksheet'">
            <WorksheetTab :proposalId="proposal.proposal_id"/>
        </div>
        <div v-else>
            {{ selectedTab }}
        </div>
        <div class="d-flex">
            <div class="btn-primary-v2 px-3 py-2 b-radius-8" style="cursor: pointer;" v-if="status === 'approved'">
                Change Order
            </div>
            <div class="flex-grow-1"></div>
            <div class="d-flex gap-2">
                <div class="btn-outline-custom-primary px-3 py-2 b-radius-8" style="cursor: pointer;" v-if="status === 'sent'">
                    Disable Sent Proposal
                </div>
                <div class="btn-success-v2 px-3 py-2 b-radius-8" style="cursor: pointer;" v-if="status !== 'approved'">
                    Manual Approve
                </div>
                <div class="btn-primary-v2 px-3 py-2 b-radius-8" style="cursor: pointer;" v-if="status !== 'approved'">
                    Send Proposal
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import FlatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import WorksheetTab from './WorksheetTab.vue';

    export default {
        components: { FlatPickr, WorksheetTab },
        props: {
            proposal: {
                typeof: Object,
                default: null
            }
        },
        data(){
            const datePickerConfig = {
                enableTime: false,
                dateFormat: "Y-m-d",
                time_24hr: false,
                allowInput: true,
                minuteIncrement: 30,
            };
            const approvalDate = "MM/DD/YYYY";
            const proposalTitle = "";
            const saveTimeout = null
            const selectedTab = 'worksheet';
            const status = 'not sent';
            const statusColor = 'primary';
            const toggleWorkOrderDropdown = false;

            return { datePickerConfig, approvalDate, proposalTitle, saveTimeout, selectedTab, status, statusColor, toggleWorkOrderDropdown }
        },
        methods: {
            handleViewPortal(){
                const portalPath = this.$crypto.encryptData(`customer-preview-${this.proposal.proposal_id}`);
                const url = `/portal/?token=${portalPath}`;
                window.open(url, '_blank');
            },
            handleWorkOrder(){
                this.toggleWorkOrderDropdown = !this.toggleWorkOrderDropdown;
            },
            handleSendEmailWorkOrder(){
                this.toggleWorkOrderDropdown = false;
            },
            handleSendSMSWorkOrder(){
                this.toggleWorkOrderDropdown = false;
            },
            handleAddToPro(){
                this.toggleWorkOrderDropdown = false;
            },
            handleViewWorkOrder(){
                this.toggleWorkOrderDropdown = false;
                const portalPath = this.$crypto.encryptData(`pros-${this.proposal.proposal_id}`);
                const url = `/portal/pros/?token=${portalPath}`;
                window.open(url, '_blank');
            },
            handleCopyLink(){
                this.toggleWorkOrderDropdown = false;
                const portalPath = this.$crypto.encryptData(`pros-${this.proposal.proposal_id}`);
                const url = `${window.location.origin}/portal/pros/?token=${portalPath}`;

                if (navigator.clipboard) { 
                    navigator.clipboard.writeText(url).then(() => {
                    console.log('URL copied to clipboard successfully!');
                    }).catch(err => {
                    console.error('Failed to copy URL: ', err);
                    });
                } else {
                    console.error('Clipboard API not available.');
                }

            },
            handleTabClicked(tab){
                this.selectedTab = tab;
            },
            handleDateClicked(){
                document.querySelector('#appointment_date').click();
            },
            handleTitleChanged(){
                if (this.saveTimeout) {
                    clearTimeout(this.saveTimeout);
                }
                
                this.saveTimeout = setTimeout(() => {
                    this.autoSave('title', this.proposalTitle);
                }, 3000);
            },
            async autoSave(key, value) {
                try {
                    await axios.put(`/api/proposal/update/${this.proposal.proposal_id}`, { key, value }, {
                        headers: {
                            'Authorization': 'Bearer ',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                } catch (error) {
                    console.error("Error fetching customers: ", error);
                }
            }
        },
        mounted(){
            if(this.proposal){
                this.proposalTitle = this.proposal.title;
                this.status = this.proposal.status.toLowerCase();
                this.statusColor = this.status === 'approved' ? 'success' : (this.status === 'sent') ? 'warning' : 'primary';
            }
        },
        watch: {
            approvalDate: {
                handler(date){
                    if(date && date !== "MM/DD/YYYY"){
                        this.autoSave('approval_deadline', date);
                    }
                }
            }
        }
    }
</script>