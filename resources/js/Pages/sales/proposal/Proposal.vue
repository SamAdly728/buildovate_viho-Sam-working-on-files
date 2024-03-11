<template>
    <div class="m-0 p-0 bg-white">
        <div class="col-xl-12 m-0 p-0 bg-white" style="height: calc(100vh - 98px); max-height: calc(100vh - 98px);">
            <div class="card m-0 p-0" style="height: 100%;">

                <div class="card-body m-0 p-5" v-if="leadForm.lead_id == 0">
                    <label class="col-sm-12 col-form-label f-w-700 pr-0 pl-2 text-center" for="inputEmail3" style="color: gray;">SELECT LEAD TO GET STARTED</label>
                </div>
                
                <div class="card-body m-0 d-flex flex-column bg-white pb-0 px-0" v-else>
                    <div class="m-0 p-0 px-3 d-flex gap-3">
                        <div class="flex-grow-1">
                            <div class="mb-3">
                                <label class="form-label f-w-600">Proposal Title</label>
                                <input class="form-control b-primary" type="text" placeholder="Enter title..." name="proposal_title" @input="handleInput" v-model="proposalForm.title" :disabled="processing">
                                <div class="text-danger" v-if="proposalForm.errors.title">{{ proposalForm.errors.title }}</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label f-w-600">Approval Deadline</label>
                                <input class="form-control digits b-primary" type="date" v-model="proposalForm.approval_deadline" :disabled="processing">
                                <div class="text-danger" v-if="proposalForm.errors.approval_deadline">{{ proposalForm.errors.approval_deadline }}</div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3">
                                <label class="form-label f-w-600">Status</label>
                                <span class="badge f-14 py-2 col-md-12" :class="[proposalStatusColor]">{{ proposalStatus }}</span>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex flex-column" style="height: 79px; width: 300px;">
                            <label class="form-label f-w-600">Preview</label>
                            <div class="d-flex gap-2">
                                <span class="btn btn-primary-v2 f-14 py-1 px-3 bigger" @click="handleViewPortal">View Portal</span>
                                <span class="btn btn-primary-v2 f-14 py-1 px-3 bigger" @click="handleWorkOrder">Work Order</span>
                            </div>
                        </div>
                    </div>

                    <ul class="d-flex f-w-600 mt-4 px-4 gap-2">
                        <li class="nav-item">
                            <a class="px-3 py-2" 
                                :class="activeTab === 'worksheet' ? 'bg-primary-v2 text-white b-radius-10' : 'text-primary-v2'"
                                @click="handleChangeTab('worksheet')" style="cursor: pointer;">Worksheet
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="px-3 py-2" 
                                :class="activeTab === 'payment' ? 'bg-primary-v2 text-white b-radius-10' : 'text-primary-v2'"
                                @click="handleChangeTab('payment')" style="cursor: pointer;">Payment Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="px-3 py-2" 
                                :class="activeTab === 'legal' ? 'bg-primary-v2 text-white b-radius-10' : 'text-primary-v2'"
                                @click="handleChangeTab('legal')" style="cursor: pointer;">Others
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="px-3 py-2" 
                                :class="activeTab === 'preview' ? 'bg-primary-v2 text-white b-radius-10' : 'text-primary-v2'"
                                @click="handleChangeTab('preview')" style="cursor: pointer;">Preview
                            </a>
                        </li>
                    </ul>

                    <div class="flex-grow-1 mt-5" style="overflow: hidden;">
                        <!-- START Worksheet -->
                        <div class="px-4" v-if="activeTab === 'worksheet'">
                            <EstimatesTable 
                                    :proposal_id="proposalForm.proposal_id" 
                                    :selectable="proposalForm.status != 'Approved'"
                                    :editable="proposalForm.status != 'Approved'"
                                    :proposal_form="proposalForm"
                                    @onRowChanged="handleRowChanged"
                                />
                        </div>
                        <!-- END Worksheet -->

                        <!-- START Payment -->
                        <div style="overflow: hidden;" v-if="activeTab === 'payment'">
                            <StagePaymentTable :worksheets="proposalForm.worksheet" :proposal_id="proposalForm.proposal_id"/>
                        </div>
                        <!-- END Payment -->

                        <!-- START Legal -->
                        <div style="overflow: hidden;" v-if="activeTab === 'legal'"> 
                            <OthersTab />
                        </div>
                        <!-- END Legal -->

                        <!-- START preview -->
                        <div class="px-4" style="overflow: hidden;" v-if="activeTab === 'preview'">
                            <p class="mb-0 f-w-700">Verify the PDF content and complete the form to send this proposal out for signature.</p>
                            <div class="col-md-12 mt-3">
                                <div class="mb-3">
                                    <label class="form-label f-w-600">What to Display to Lead</label>       
                                    <Select2 
                                        v-model="defaultPdfContent"
                                        :className="'container-style-outlined-no-hover'"
                                        :placeholder="'Select Items to show in proposal PDF'" 
                                        :id="'proposal-pdf-content'"
                                        :purpose="'multiple-select'"
                                        :items="pdfContentItems"
                                        :disabled="processing"
                                        :hasChecks="true"
                                        />
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 mx-3">
                                <button class="btn btn-primary-v2">Change Design template</button>
                            </div>
                            <div class="row m-0 p-0 pt-4">
                                <div class="col-md-8">
                                    <div v-if="generatingPDF">
                                        GENERATING PDF PLEASE WAIT....
                                    </div>
                                    <div class="b-primary bg-secondary" style="width: 100%; height: 700px; overflow-y: auto !important; display: table;" v-else>
                                        <div style="display: table-cell; vertical-align: middle; text-align: center;">
                                            <div style="height: 700px; overflow-y: auto !important; position: relative;">
                                                <template v-for="content in pdfContents">
                                                    <section class="bg-white shadow-lg my-4" style="width: 210mm; height: 297mm; overflow: hidden; display: inline-block; vertical-align: middle;" v-html="content"></section>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="tab-content m-0" id="pills-icontabContent">
                                        <div class="tab-pane fade active show" id="pills-preview-email" role="tabpanel" aria-labelledby="pills-preview-email-tab">
                                            <div class="row">
                                                <div class="btn btn-primary px-2 ml-3 mb-3 cursor-none" style="width: auto">Email Recipient</div>
                                                <div class="mb-3 col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label f-w-600">Recepient</label>
                                                        <Select2 
                                                            ref="select2Recepient"
                                                            v-model="selectedRecepient"
                                                            :className="'container-style-outlined-no-hover'"
                                                            :placeholder="'Enter email here...'" 
                                                            :id="'proposal-recepient'"
                                                            :purpose="'multiple-select'"
                                                            :items="userData"
                                                            :isLoading="userLoading"
                                                            :disabled="processing"
                                                            :type="'email'"
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label f-w-600">Cc</label>
                                                        <Select2 
                                                            ref="select2Cc"
                                                            v-model="selectedCc"
                                                            :className="'container-style-outlined-no-hover'"
                                                            :placeholder="'Enter email here...'" 
                                                            :id="'proposal-cc'"
                                                            :purpose="'multiple-select'"
                                                            :items="userData"
                                                            :isLoading="userLoading"
                                                            :disabled="processing"
                                                            :type="'email'"
                                                        />
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="btn btn-primary px-2 ml-3 mb-3 mt-2 cursor-none" style="width: auto">SMS Preview</div>
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label f-w-600">Send To</label>
                                                    <Select2 
                                                        ref="select2Numbers"
                                                        v-model="selectedNumber"
                                                        :className="'container-style-outlined-no-hover'"
                                                        :placeholder="'Enter phone here...'" 
                                                        :id="'proposal-numbers'"
                                                        :purpose="'multiple-select'"                                                        
                                                        :items="userData"
                                                        :isLoading="userLoading"
                                                        :disabled="processing"
                                                        :type="'phone'"
                                                    />
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <div class="d-flex justify-content-between">
                                                        <label class="form-label f-w-600">Message Content</label>
                                                        <label class="form-label f-w-600 cursor-pointer text-primary" @click="handleChooseMessageTemplate">Choose Template</label>
                                                    </div>
                                                    <textarea class="form-control border-success" type="text" placeholder="Enter message here..." name="sms_content" v-model="messageContent"></textarea>
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label f-w-600">Preview</label>
                                                    <div class="b-r-5 p-4" style="background-color: #d6d6d6; height: auto;">
                                                        <label v-if="messageContent == ''">Type Anything to the content</label>
                                                        <SMSChatBubble :message="messageContent" v-else/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END preview -->

                    </div>
                    <div class="text-end d-flex justify-content-between p-0 m-0 py-3 px-4" v-if="leadForm.lead_id != 0 && !worksheetStore.loading">
                        <a class="btn btn-primary-v2" v-if="proposalForm.status === 'Approved'" :href="`/sales/lead-management/change_order/${proposalForm.proposal_id}/${leadForm.lead_id}`">Change Order</a>
                        <div></div>
                        <div class="form-footer text-end position-relative" v-if="proposalForm.status != 'Approved'">
                            <div class="d-flex gap-2">
                                <a class="btn btn-outline-light mr-2" @click="handleSentProposal"  v-if="proposalEmailId && proposalForm.status == 'Sent'">{{ proposalEmailStatus != 'disabled' ? 'Disable'  : 'Enable'}} Sent Proposal</a>
                                <a class="btn btn-primary-v2 mr-2" @click="handleManualApprove"  v-if="!processing && (worksheetStore.worksheet && worksheetStore.worksheet.length != 0) && (worksheetStore.clientPrice === worksheetStore.paymentSchedulePrice)">Manual Approve</a>
                                <a class="btn btn-primary-v2 send-options-toggle" 
                                    id="dropdownMenuButton" 
                                    @click="toggleSendOptions"
                                    :disabled="processing" 
                                    style="color: white;">
                                    <i v-if="processing" class="fa fa-spin fa-spinner me-2"></i>
                                    {{ processing ? 'Loading' : (proposalForm.proposal_id != 0 ? 'Update and ...' : 'Save and ...') }}
                                </a>
                            </div>
                            <div v-if="closeSendOption"
                                @click="toggleSendOptions"
                                class="sendOptions-popover b-primary d-flex flex-column" 
                                style="background-color: white;">
                                <a class="dropdown-item text-right m-0 p-1 bg-hover-primary" @click="handleSubmit('stay')" style="cursor: pointer !important;">{{  (proposalForm.proposal_id != 0 ? 'Just Update' : 'Just Save')}}</a>
                                <a class="dropdown-item text-right m-0 p-1 bg-hover-primary" @click="handleSubmit('close')" style="cursor: pointer !important;">{{  (proposalForm.proposal_id != 0 ? 'Update and' : 'Save and')}} Close</a>
                                <a class="dropdown-item text-right m-0 p-1 bg-hover-primary" @click="handleSubmit('new')" style="cursor: pointer !important;">{{  (proposalForm.proposal_id != 0 ? 'Update and' : 'Save and')}} New</a>
                                <a class="dropdown-item text-right m-0 p-1 bg-hover-primary" @click="handleSubmit('send')" :style="{ cursor: (worksheetStore.worksheet && worksheetStore.worksheet.length !== 0) && (worksheetStore.clientPrice === worksheetStore.paymentSchedulePrice) ? 'pointer' : 'not-allowed' }">{{  (proposalForm.proposal_id != 0 ? 'Update and' : 'Save and')}}  Send Proposal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <PaymentRequestModal />
    <StagePaymentModal/>

    <div class="modal fade" id="addDiscount" tabindex="-1" role="dialog" aria-labelledby="addDiscount" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0 bg-white" style="max-height: 93vh !important; background-color: rgb(228, 228, 228);">
                    <div class="px-4 py-3 m-0 b-b-primary-v2 d-flex align-items-center">
                        <h5 class="f-18 f-w-600 text-dark flex-grow-1 m-0">Add Discount</h5>
                        <span class="bg-hover m-0 p-1 f-w-700 text-darkl f-18 close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"><i class="icon-close"></i></span>
                    </div>
                    <div class="m-0">
                        <div class="m-2">
                            <Estimate 
                                :owner_price="formatCurrency(worksheetStore.clientPrice)" 
                                :builder_cost="formatCurrency(worksheetStore.builderCost)" 
                                :markup="formatCurrency(worksheetStore.markUp)" 
                                :margin="worksheetStore.margin.toFixed(2)" 
                                :profit="formatCurrency(worksheetStore.profit - discount)"
                                :discount="formatCurrency(discount)"/>
                        </div>
                        <div class="m-4 d-flex gap-2 align-items-center">
                            <label class="m-0 text-muted">Set discount: </label>
                            <input type="number" class="b-primary-v2 px-2 py-1 b-radius-5" v-model="discount"/>
                            <div class="btn btn-primary-v2" data-bs-dismiss="modal" @click="handleSubmitDiscount">Submit</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { useForm, usePage } from "@inertiajs/vue3";
    import { Inertia } from '@inertiajs/inertia';
    import { useSmartEstimateModal } from '@/stores/smart-estimate-modal';
    import { useSideBar } from "@/stores/sidebar";
    import { useWorksheet } from "@/stores/worksheet-table";
    import { usePaymentRequest } from '@/stores/payment-request';
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import SMSChatBubble from '@/components/SMSChatBubble.vue';
    import Select2 from '@/components/Select2.vue';
    import EstimatesTable from '@/components/tables/EstimatesTable.vue';
    import StagePaymentModal from '@/components/modals/StagePaymentModal.vue';
    import StagePaymentTable from '@/components/tables/StagePaymentTable.vue';
    import PaymentRequestModal from '@/components/modals/PaymentRequestModal.vue';
    import OthersTab from '@/components/sales/OthersTab.vue';
    import Estimate from '@/components/Estimate.vue';

    export default { 
        
        props: ['errors', 'appName', 'company', 'support', 'csrf_token', 'style', 'flash', 'pageTitle', 'auth', 'proposal', 'lead', 'user_id', 'company_name', 'user_display_name', 'company_license_number', 'company_address', 'company_city', 'company_state', 'company_zipcode'],
        components: { Select2, SMSChatBubble, EstimatesTable, StagePaymentModal, StagePaymentTable, PaymentRequestModal, OthersTab, Estimate },
        setup(){
            const store = useSmartEstimateModal();
            const sidebarStore = useSideBar();
            const page = usePage();
            const worksheetStore = useWorksheet();
            const paymentStore = usePaymentRequest();
            const leadForm = useForm({
                lead_id: 0,
                cust_id: 0,
                opportunity_title: '',
                street_address: '',
                city: '',
                state: '',
                zipcode: '',
                opportunity_phone: '',
                status: 'open',
                description: '',
                cost_of_lead: 0,
                created_by: '',
                updated_by: ''
            });

            const form = useForm({
                cust_id: 0,
                first_name: '',
                last_name: '',
                display_name: '',
                phone: '',
                cell_phone: '',
                email: '',
                company: '',
                street_address: '',
                city: '',
                state: '',
                zip_code: '',
            });

            const proposalForm = useForm({
                proposal_id: 0,
                lead_id: 0,
                title: '',
                approval_deadline: '',
                status: 'Not Sent',
                discount: 0,
                internal_notes: '',
                introductory_text: '',
                closing_text: '',
                worksheet: [],
                payment_request: {
                    proposal_billing_id: 0,
                    deposit: 0.0,
                    deposit_type: 'amount',
                    payment_due: 'upon',
                    stages: 1,
                    payment_due_day: 1,
                    payment_method: 'credit',
                    percentage: 0,
                    stage_payments: [[]]
                }
            });
            
            return { page, store, leadForm, form, proposalForm, sidebarStore, worksheetStore, paymentStore }
        },
        data(){
            const asset_link = window.asset_link;
            const selected_proposal = '';
            const show_proposal_option = false;
            const proposalStatus = 'NEW ENTRY';
            const proposalStatusColor = 'bg-secondary-v2';
            const processing = false;
            const proposalData = null;
            const fetchingData = false;
            const closeSendOption = false;
            const proposalEmailId = null;
            const proposalEmailStatus = '';
            const activeTab = 'worksheet';
            const discount = 0;

            //FOR LEAD MODAL
            const isLoading = false;
            const currentPage = 1;
            const totalPages = 0;
            const startingEntry = 0;
            const endingEntry = 0;
            const totalEntries = 0;
            const leads = [];
            const searchTerm = '';

            //FOR LEAD DETAILS
            const showMore = true;
            const salesPeople = 'N/A';
            const tags = 'N/A';
            const sources = 'N/A';
            const jobTypes = 'N/A';
            const pdfContents = [];
            const leadData = null; 

            //FOR PREVIEW TAB
            const select2Recepient = null;
            const select2Cc = null;
            const select2Numbers = null;
            const generatingPDF = false;
            const messageContent = '';
            const userData = [];
            const userLoading = false;
            const defaultPdfContent = ['Item Title', 'Description'];
            const pdfContentItems = [
                { id: 'Item Title', text: 'Item Title'},
                { id: 'Description', text: 'Description'},
                { id: 'Qty / Unit', text: 'Qty / Unit'},
                { id: 'Unit Cost', text: 'Unit Cost'},
                { id: 'Builder Total Cost', text: 'Builder Total Cost'},
                { id: 'Markup', text: 'Markup'},
                { id: 'Markup Amount', text: 'Markup Amount'},
                { id: 'Unit Price', text: 'Unit Price'},
            ];
            const emailSubject = '';
            const selectedRecepient = [];
            const selectedCc = [];
            const selectedNumber = [];
            
            //FOR WORKSHEET
            const sumOwnerPrice = 0.0;
            const showPopoverBreakDown = false;
            const itemsChange = false;
            const initialWorksheet = [];
            const initialData = {};
            const initialPaymentRequest = {};
            const initialPaymentStages = [[]];

            return { asset_link, selected_proposal, show_proposal_option, select2Recepient, select2Cc, select2Numbers, generatingPDF, messageContent, userData,
                userLoading, defaultPdfContent, pdfContentItems, emailSubject, selectedRecepient, selectedCc, selectedNumber,
                proposalStatus, proposalStatusColor, processing, proposalData, fetchingData, closeSendOption, proposalEmailId, proposalEmailStatus,
                isLoading, currentPage, totalPages, startingEntry, endingEntry, totalEntries, leads, searchTerm, showMore, salesPeople, tags,
                sources, jobTypes, pdfContents, leadData, sumOwnerPrice, showPopoverBreakDown, 
                itemsChange, initialWorksheet, initialData, initialPaymentRequest, initialPaymentStages, activeTab, discount}
        },
        mounted(){
            document.addEventListener('click', this.handleDocumentClick);

            this.initialData = { ...this.proposalForm };
            this.initialPaymentRequest = { ...this.proposalForm.payment_request };
            if(this.page.props){
                const user_id = this.page.props.user_id;
                const lead = this.page.props.lead;
                const proposal = this.page.props.proposal;

                this.emailSubject = `Your Custom Proposal from ${this.page.props.company_name} Awaits!`;

                if(lead){
                    this.sidebarStore.setSelectedLead(lead);
                    const lead_customer = lead.lead_customer;

                    this.leadData = lead;
                    if(lead_customer){
                        this.selectedRecepient = [lead_customer.cust_id];
                        this.selectedNumber = [lead_customer.cust_id];
                    }
                }

                if(proposal){
                    this.sidebarStore.setSelectedProposal(proposal);
                    this.proposalData = proposal;
                }

                if(user_id){
                    this.select2Cc = [user_id];
                }

            }

            const savedEstimateId = localStorage.getItem('estimateId');
            if(savedEstimateId){
                this.store.estimated_id = savedEstimateId;
                this.store.toggleModal();
            }else{
                this.store.estimated_id = 0;
            }

            if(this.leadData){
                this.populateLeadFormWithLeadData(this.leadData);
            }

            if(this.proposalData){
                this.populateProposalData(this.proposalData);
            }
            this.fetchSalesPersons();
        },
        beforeDestroy() {
            document.removeEventListener('click', this.handleDocumentClick);
        },
        methods: {
            handleViewPortal(){
                const portalPath = this.$crypto.encryptData(`customer-preview-${this.proposalForm.proposal_id}`);
                const url = `/portal/?token=${portalPath}`;
                window.open(url, '_blank');
            },
            handleWorkOrder(){
                const portalPath = this.$crypto.encryptData(`pros-${this.proposalForm.proposal_id}`);
                const url = `/portal/pros/?token=${portalPath}`;
                window.open(url, '_blank');
            },
            handleSubmitDiscount(){
                this.worksheetStore.setDiscount(this.discount);
            },
            handleChangeTab(tab){
                this.activeTab = tab;
                if(this.activeTab === 'preview'){
                    this.generatePDF();
                }
            },
            changePage(pageNumber) {
                if (pageNumber >= 1 && pageNumber <= this.totalPages) {
                    this.currentPage = pageNumber;
                }
                this.fetchLeads(this.currentPage, this.searchTerm);
            },
            toggleSendOptions() {
                this.closeSendOption = !this.closeSendOption;
            },
            handleDocumentClick(event) {
                if (!event.target.closest('.break-pop-over')) {
                    this.showPopoverBreakDown = false;
                }
                if (!event.target.closest('.send-options-toggle')) {
                    this.closeSendOption = false;
                }
            },
            populateProposalData(proposalData){
                this.fetchingData = true;
                if(proposalData){
                    // console.log('proposalData', proposalData);
                    this.worksheetStore.setDiscount(parseFloat(proposalData.discount));
                    this.proposalForm.proposal_id = proposalData.proposal_id;
                    this.proposalForm.title = proposalData.title;
                    this.proposalForm.approval_deadline = proposalData.approval_deadline;
                    this.proposalForm.status = proposalData.status;
                    this.proposalForm.internal_notes = proposalData.internal_notes;
                    this.proposalForm.introductory_text = proposalData.introductory_text;
                    this.proposalForm.closing_text = proposalData.closing_text;

                    if(this.proposalForm.status === 'Not Sent'){
                        this.proposalStatus = 'NOT SENT';
                        this.proposalStatusColor = 'bg-primary-v2';
                    }else if(this.proposalForm.status === 'Approved'){
                        this.proposalStatus = 'APPROVED';
                        this.proposalStatusColor = 'bg-success-v2';
                    }else if(this.proposalForm.status === 'Sent'){
                        this.proposalStatus = 'SENT';
                        this.proposalStatusColor = 'bg-warning-v2';
                        this.getEmailStatus(this.proposalForm.proposal_id);
                    }
                }else{
                    this.resetProposal()
                    this.proposalForm.title = leadForm.opportunity_title;
                    this.proposalForm.lead_id = leadForm.lead_id;
                    this.proposalStatus = 'NEW ENTRY';
                    this.proposalStatusColor = 'bg-secondary-v2';
                    
                    this.initialData = { ...this.proposalForm };
                    this.initialWorksheet = proposalForm.worksheet;
                    this.initialPaymentRequest = {
                        proposal_billing_id: 0,
                        deposit: 0.0,
                        deposit_type: 'amount',
                        payment_due: 'upon',
                        payment_due_day: 1,
                        payment_method: 'credit',
                        percentage: 0,
                        stage_payments: [[]]
                    }
                    this.initialPaymentStages = [[]];
                    
                    this.fetchingData = false;
                }
            },
            resetProposal(){
                this.proposalForm.proposal_id = 0;
                this.proposalForm.lead_id = 0;
                this.proposalForm.title = '';
                this.proposalForm.approval_deadline = '';
                this.proposalForm.status = 'Not Sent';
                this.proposalForm.internal_notes = '';
                this.proposalForm.introductory_text = '';
                this.proposalForm.closing_text = '';
                this.proposalForm.worksheet = [];
            },
            populateLeadFormWithLeadData(leadData) {
                if (leadData) {
                    this.leadForm.lead_id = leadData.lead_id || 0;
                    this.proposalForm.lead_id = this.leadForm.lead_id;
                    this.leadForm.cust_id = leadData.cust_id || 0;
                    this.leadForm.opportunity_title = leadData.opportunity_title || '';
                    this.proposalForm.title = this.leadForm.opportunity_title;
                    this.leadForm.street_address = leadData.street_address || '';
                    this.leadForm.city = leadData.city || '';
                    this.leadForm.state = leadData.state || '';
                    this.leadForm.zipcode = leadData.zipcode || '';
                    this.leadForm.opportunity_phone = leadData.opportunity_phone || '';
                    this.leadForm.status = leadData.status || 'open';
                    this.leadForm.description = leadData.description || '';
                    this.leadForm.cost_of_lead = leadData.cost_of_lead || 0;
                    this.leadForm.created_by = leadData.created_by || '';
                    this.leadForm.updated_by = leadData.updated_by || '';

                    this.populateFormWithCustomer(leadData.lead_customer);
                    this.getSalesperson(leadData.sales_people);
                    this.getTags(leadData.tags);
                    this.getSources(leadData.sources);
                    this.getJobTypes(leadData.job_types);
                }
            },
            populateFormWithCustomer(selectedCustomer) {
                this.leadForm.cust_id = selectedCustomer.cust_id;
                this.form.cust_id = selectedCustomer.cust_id;
                this.form.first_name = selectedCustomer.first_name;
                this.form.last_name = selectedCustomer.last_name;
                this.form.display_name = selectedCustomer.display_name;
                this.form.phone = selectedCustomer.phone;
                this.form.cell_phone = selectedCustomer.cell_phone;
                this.form.email = selectedCustomer.email;
                this.form.company = selectedCustomer.company;
                this.form.street_address = selectedCustomer.street_address;
                this.form.city = selectedCustomer.city;
                this.form.state = selectedCustomer.state;
                this.form.zip_code = selectedCustomer.zip_code;
            },
            getSalesperson(salesPeopleArray){
                this.salesPeople = salesPeopleArray.map(salesperson => `
                    <span class="badge badge-primary mb-1">${salesperson.user.display_name}</span>
                `).join('');
            },
            getTags(tagsArray){
                this.tags = tagsArray.map(tag => `
                    <span class="badge badge-primary mb-1">${tag.tag.tags_name}</span>
                `).join('');
            },
            getSources(sourcesArray){
                this.sources = sourcesArray.map(source => `
                    <span class="badge badge-primary mb-1">${source.source.source_name}</span>
                `).join('');
            },
            getJobTypes(jobtypesArray){
                this.jobTypes = jobtypesArray.map(job_type => `
                    <span class="badge badge-primary mb-1">${job_type.job_type.job_type_name}</span>
                `).join('');
            },
            toggleShow(){
                this.showMore = !this.showMore;
            },
            handleRowChanged(rowChanged){
                if(rowChanged){
                    const rowIndex = rowChanged.index;
                    const rowData = rowChanged.data;
                    this.proposalForm.worksheet.map((field, index) => {
                        if(index === rowIndex){
                            Object.keys(rowData).forEach(key => {
                                const value = rowData[key];
                                if(key === 'Unit Cost'){
                                    field.unit_cost = value;
                                }else if(key === 'Description'){
                                    field.description = value;
                                }else if(key === 'Item'){
                                    field.title = value;
                                }else if(key === 'Quantity'){
                                    field.unit_quantity = value;
                                }else if(key === 'Unit'){
                                    field.unit = value;
                                }else if(key === 'Labor Type'){
                                    field.labor = value;
                                }else if(key === 'Markup'){
                                    field.unit_mark_up = value;
                                }else if(key === 'Markup Type'){
                                    field.unit_mark_up_type = value;
                                }
                            });
                        }
                    });
                }
            },
            handleChangeLead(){
                if(this.itemsChange){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You have unsave changes, do you wish to proceed?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.leadForm.reset();
                            this.form.reset();
                            this.proposalForm.reset();
                            this.show_proposal_option = false;
                        }
                    });
                }else{
                    this.leadForm.reset();
                    this.form.reset();
                    this.proposalForm.reset();
                    this.show_proposal_option = false;
                }
            },
            hasDataChanged() {
                const isChanged = Object.keys(this.proposalForm.payment_request).some(key => {
                    if(key == 'stage_payments'){
                        if(this.proposalForm.payment_request[key].length == 0){
                            return false;
                        }else{
                            for (const [index, stageData] of this.proposalForm.payment_request[key].entries()) {
                                const item1 = this.initialPaymentStages[index];
                                const item2 = stageData;

                                if(item1.length !== item2.length){
                                    return true;
                                }else{
                                    let returnValue = false;
                                    for (const itemData of item1) {
                                        for (const initialData of item2) {
                                            if(itemData.proposal_billing_stage_id === initialData.proposal_billing_stage_id && itemData.proposal_billing_stage_id !== 0){
                                                const stage_name = itemData.stage_name !== initialData.stage_name;
                                                const stage_amount = itemData.stage_amount !== initialData.stage_amount;
                                                if(!returnValue){
                                                    returnValue = (stage_name || stage_amount);
                                                }
                                            }
                                        } 
                                    }
                                    if(returnValue){
                                        return returnValue;
                                    }
                                }
                            }
                        }
                    }
                    return this.proposalForm.payment_request[key] != this.initialPaymentRequest[key];
                });

                if(isChanged){
                    return isChanged;
                }

                return Object.keys(this.proposalForm).some(key => {
                    if (key === 'errors') return false; // Ignore the errors property
                    return this.proposalForm[key] !== this.initialData[key];
                });
            },
            handleInput(e){
                this.proposalForm.clearErrors(e.target.name);
            },
            handleManualApprove(){
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Please make sure that the customer is fully aware of this manual approve.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.handleSubmit('approved');
                    }
                });
            },
            handleSubmit(type){
                const hasWorksheet = (this.worksheetStore.worksheet && this.worksheetStore.worksheet.length !== 0);
                const accurateStage = (this.worksheetStore.clientPrice === this.worksheetStore.paymentSchedulePrice);

                if((type === 'send' && !hasWorksheet && !accurateStage)){
                    return;
                }

                this.proposalForm.discount = this.worksheetStore.discount;
                this.proposalForm.worksheet = this.worksheetStore.worksheet;
                this.proposalForm.payment_request = this.paymentStore.form;

                if(this.proposalForm.proposal_id === 0){
                    this.saveProposal(type);
                }else{
                    this.updateProposal(type);
                }
            },
            async saveProposal(type){
                try {
                    this.processing = true;
                    if(type === 'send'){
                        this.proposalForm.status = 'Sent';
                    }else if(type === 'approved'){                
                        this.proposalForm.status = 'Approved';
                    }
                    const response = await axios.post('/api/proposals', this.proposalForm, {
                            headers: {
                                    'Authorization': 'Bearer ' + this.page.props.csrf_token,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                            }
                    });

                    if (response.data.status === 'success') {
                        let proposal_id = response.data.data.id;
                        this.itemsChange = false;

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data has been sent successfully!',
                        });

                        if(type === 'stay' || type === 'send' || type === 'approved'){
                            this.proposalForm.proposal_id = proposal_id;

                            this.initialData = { ...this.proposalForm };
                            this.initialWorksheet.value = this.proposalForm.worksheet;

                            if(typ === 'send'){
                                this.sendProposal(proposal_id);
                            }
                        }else if(type === 'new'){
                            this.resetProposal();
                            this.initialData = { ...this.proposalForm };
                            this.initialWorksheet = this.proposalForm.worksheet;
                        }else if(type === 'close'){
                            this.resetProposal();
                            this.initialData = { ...this.proposalForm };
                            this.initialWorksheet = this.proposalForm.worksheet;

                            this.processing = true;
                            Inertia.get('/sales/lead-management');
                        }
                    } else if (response.data.status === 'error' && response.data.errors) {
                        for (const [field, error] of Object.entries(response.data.errors)) {
                            this.proposalForm.errors[field] = error[0];
                        }
                    }
                    
                    this.processing = false;
                } catch (error) {
                    this.processing = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `There was a problem when saving the data! .${ error }`,
                    });
                }
            },
            async updateProposal(type){
                try {
                    this.processing = true;
                    if(type === 'send'){
                        this.proposalForm.status = 'Sent';
                    }else if(type === 'approved'){                
                        this.proposalForm.status = 'Approved';
                    }
                    const response = await axios.post(`/api/updateProposal/${this.proposalForm.proposal_id}`, this.proposalForm, {
                        headers: {
                            'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (response.data.status === 'success') {
                        let proposal_id = response.data.data.id;
                        this.itemsChange = false;

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data has been sent successfully!',
                        });
                        
                        if(type === 'stay' || type === 'send' || type === 'approved'){
                            this.proposalForm.proposal_id = proposal_id;

                            this.initialData = { ...this.proposalForm };
                            this.initialWorksheet = this.proposalForm.worksheet;
                            if(type === 'send'){
                                this.sendProposal(proposal_id);
                            }
                        }else if(type === 'new'){
                            this.resetProposal();
                            this.initialData = { ...this.proposalForm };
                            this.initialWorksheet = this.proposalForm.worksheet;
                        }else if(type === 'close'){
                            this.resetProposal();
                            this.initialData = { ...this.proposalForm };
                            this.initialWorksheet = this.proposalForm.worksheet;

                            this.processing = true;
                            Inertia.get('/sales/lead-management');
                        }
                    } else if (response.data.status === 'error' && response.data.errors) {
                        for (const [field, error] of Object.entries(response.data.errors)) {
                            this.proposalForm.errors[field] = error[0];
                        }
                    }
                    
                    this.processing = false;
                } catch (error) {
                    this.processing = false;
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `There was a problem when saving the data! .${ error }`,
                    });
                }
            },
            async sendProposal(proposal_id){
                try {
                    this.proposal_option_loading = true;
                    this.proposal_options = [];
                    const response = await axios.post(`/api/send`, {
                        data: {
                            SEND_BY: this.page.props.user_display_name,
                            DISPLAY_NAME: this.page.props.lead.lead_customer.display_name,
                            CODE: btoa(proposal_id),
                            COMPANY_NAME: this.page.props.company_name
                        },
                        recipient: ['louiefuentes.dev@gmail.com', 'dev@buildovate.com'],
                        cc: ['joe@buildovate.com'],
                        subject: this.emailSubject,
                        view: 'emails.send-proposal'
                    }, {
                        headers: {
                            'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    this.saveSentProposal(proposal_id);
                } catch (error) {
                    console.error(error);
                }
            },
            async handleSentProposal() {
                const status = this.proposalEmailStatus === 'disabled' ? 'sent' : 'disabled'
                this.proposalEmailStatus = status;
                this.updateSentProposal(this.proposalEmailId, status);
            },
            async updateSentProposal(proposal_id, status){
                try {
                    const response = await axios.put(`/api/proposals/email/${proposal_id}`, {
                        status: status
                    }, {
                        headers: {
                            'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    console.log(response);
                } catch (error) {
                    console.error(error);
                }
            },
            async saveSentProposal(proposal_id){
                try {
                    const response = await axios.post(`/api/proposals/email/${proposal_id}`, {
                        proposal_id: proposal_id,
                        receiver_emails: 'louiefuentes.dev@gmail.com,dev@buildovate.com,joe@buildovate.com',
                        status: 'sent'
                    }, {
                        headers: {
                            'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    console.log(response);
                } catch (error) {
                    console.error(error);
                }
            },
            formatPhoneNumber(number) {
                if(number){
                    const cleaned = ('' + number).replace(/\D/g, '');
                    const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
                    if (match) {
                            return '(' + match[1] + ') ' + match[2] + '-' + match[3];
                    }
                    return number;
                }else{
                    return 'N/A';
                }
            },
            formatCurrency(amount) {
                    if(amount){
                        const formatter = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD',
                        });
                        return formatter.format(parseFloat(amount));
                    }else{
                        return '$0.0';
                    }
            },
            async generatePDF() {
                this.generatingPDF = true;
                try {
                    const opt = {
                        filename: 'myfile.pdf',
                        jsPDF: {
                            orientation: 'portrait',
                            unit: 'px', // Set the unit to pixels
                            format: [1180, 2014.39], // Set the page width and height
                        },
                    };
                    
                    try {
                        const response = await axios.get('/api/proposal-template-default', {
                            params: {
                                DISPLAY_NAME: this.form.display_name,
                                CUSTOMER_PHONE: this.form.phone,
                                JOBSITE_ADDRESS: this.leadForm.street_address,
                                JOBSITE_CITY: this.leadForm.city,
                                JOBSITE_STATE: this.leadForm.state,
                                JOBSITE_ZIPCODE: this.leadForm.zipcode,
                                COMPANY_LICENSE: this.page.props.company_license_number,
                                COMPANY_ADDRESS: this.page.props.company_address,
                                COMPANY_CITY: this.page.props.company_city,
                                COMPANY_STATE: this.page.props.company_state,
                                COMPANY_ZIPCODE: this.page.props.company_zipcode,
                                ITEMS: this.proposalForm.worksheet
                            },
                            headers: {
                                'Authorization': 'Bearer ' + this.page.props.csrf_token,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                                }
                        });
                        this.generatingPDF = false;
                        this.pdfContents = response.data;
                    } catch (error) {
                        console.error('Failed to fetch proposal:', error);
                    }
                } catch (error) {
                    this.generatingPDF = false;
                    console.error('Error generating PDF:', error);
                }
            },
            setMarkupColumn(item){
                if(item){
                    const item_m_type = item.unit_mark_up_type;
                    const item_m_amount = item.unit_mark_up;
                    const item_unit = item.unit;
                    let markUpReturn = '';

                    const formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                    });

                    if(item_m_type === '%'){
                        return formatter.format(item_m_amount) + '%';
                    }else if(item_m_type === '$/'){
                        return formatter.format(item_m_amount) + '/' + item_unit;
                    }else if(item_m_type === '$'){
                        return formatter.format(item_m_amount);
                    }else if(item_m_type === '--'){
                        return '--'
                    }

                    return markUpReturn;
                }else{
                    return 'N/A';
                }
            },
            setOwnerPrice(item){
                if(item){
                    const builder_cost = parseFloat(item.unit_cost * item.unit_quantity);
                    const item_m_type = item.unit_mark_up_type;
                    const item_m_amount = parseFloat(item.unit_mark_up);
                    const quantity = item.unit_quantity;
                    let markUpReturn = '';

                    const formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                    });

                    if(item_m_type === '%'){
                        return formatter.format(builder_cost + ((item_m_amount/100) * builder_cost));
                    }else if(item_m_type === '$/'){
                        return formatter.format(builder_cost + (item_m_amount * quantity));
                    }else if(item_m_type === '$'){
                        return formatter.format(builder_cost + item_m_amount);
                    }else if(item_m_type === '--'){
                        return formatter.format(builder_cost);
                    }

                    return markUpReturn;
                }else{
                    return '$0.0';
                }
            },
            getMarkup(unit_mark_up_type, unit_mark_up, unit_quantity, builder_cost){
                let markUpReturn = 0.0;

                if(unit_mark_up_type === '%'){
                    return ((unit_mark_up/100) * builder_cost);
                }else if(unit_mark_up_type === '$/'){
                    return (unit_mark_up * unit_quantity);
                }else if(unit_mark_up_type === '$'){
                    return unit_mark_up;
                }else if(unit_mark_up_type === '--'){
                    return 0.0;
                }

                return markUpReturn;
            },
            async getEmailStatus(proposal_id) {
                try {
                    const response = await axios.get(`/api/proposals/email/${proposal_id}`, {}, {
                        headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = response.data.data;
                    this.proposalEmailId = data.proposal_email_id;
                    this.proposalEmailStatus = data.status;

                    console.log(response);
                } catch (error) {
                    this.proposalEmailId = null;
                    this.proposalEmailStatus = '';
                    console.error(error);
                }
            },
            handleChooseMessageTemplate() {
                Swal.fire({
                    icon: 'info',
                    title: 'Hold on...!',
                    text: 'Choose SMS template coming soon!',
                });
            },
            async fetchSalesPersons() {
                try {
                    this.userLoading = true;
                    const response = await axios.get('/api/userContacts', {
                        headers: {
                            'Authorization': 'Bearer ' + this.page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = response.data;

                    this.userData = Object.values(data.data).map(userDetails => {
                        return {
                            text: userDetails.display_name,
                            id: userDetails.user_id ? userDetails.user_id : userDetails.cust_id,
                            email: userDetails.email,
                            phone: userDetails.phone,
                            type: userDetails.user_id ? 'crew' : 'customer'
                        };
                    })

                    this.userLoading = false;
                } catch (error) {
                    console.error("Error fetching customers: ", error);
                }
            }
        },
        computed: {
            pagesToShow(){
                let startPage = Math.max(1, this.currentPage - 1);
                let endPage = Math.min(this.totalPages, this.currentPage + 1);
                return Array.from({ length: endPage - startPage + 1 }, (_, index) => startPage + index);
            },
            grandTotal(){
                // Check if the stage payments structure is valid or return a default value.
                if (!this.proposalForm.payment_request.stage_payments) {
                    return 0.0;
                }

                // Calculate the total for each stage and sum them up.
                return this.proposalForm.payment_request.stage_payments.reduce((total, currentStagePayments) => {
                    return total + (currentStagePayments || []).reduce((stageTotal, payment) => {
                    return stageTotal + parseFloat(payment.stage_amount || 0);
                    }, 0.0);
                }, 0.0);
            },
            selectedItems(){
                return this.store.selectedItems;
            },
            storeWorksheet(){
                return this.worksheetStore.worksheet;
            }
        },
        watch: {
            storeWorksheet: {
                handler(worksheet){
                    if(worksheet){
                        this.proposalForm.worksheet = worksheet;
                    }else{
                        this.proposalForm.worksheet = [];
                    }
                }
            },
            searchTerm: {
                handler(newValue){
                    this.fetchLeads(this.currentPage, newValue);
                }
            },
            proposalForm: {
                hander(_){
                    if(this.proposalForm.proposal_id != 0 && !this.fetchingData){
                        this.itemsChange = this.hasDataChanged();
                    }
                },
                deep: true
            },
            selectedItems: {
                handler(estimates){
                    if(estimates){
                        estimates.forEach(item => {
                            const newItem = {
                                proposal_item_id: 0,
                                proposal_id: this.proposalForm.proposal_id,
                                ...item,
                            }
                            this.proposalForm.worksheet.push(newItem);
                        });
                        this.worksheetStore.setWorksheet(this.proposalForm.worksheet);
                    }
                },
                deep: true
            },
            selectedLead: {
                handler(lead){
                    if(lead){
                        this.populateLeadFormWithLeadData(lead);
                    }
                }
            }
        }
    }
</script>
<style scoped>
    .overflow-handler{
        overflow: hidden;
    }
    .table-responsive {
        overflow: auto;
        width: 100%;
    }

    .table-responsive::-webkit-scrollbar {
        width: 5px;  /* Width of vertical scrollbar */
        height: 5px;  /* Height of horizontal scrollbar */
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    .table-responsive::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        border-radius: 4px;
    }
    .progress-bar-animated {
        animation: progress-bar-stripes 0.5s linear infinite !important;
    }

    @keyframes swing {
        0%, 20% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(-8deg);
        }
        30% {
            transform: rotate(8deg);
        }
        35% {
            transform: rotate(-4deg);
        }
        40% {
            transform: rotate(4deg);
        }
        45% {
            transform: rotate(-2deg);
        }
        50% {
            transform: rotate(2deg);
        }
        55%, 100% {
            transform: rotate(0deg);
        }
    }

    .swing {
        display: inline-block;
        transform-origin: top center;
        animation: swing 1.5s ease-in-out infinite;
    }
    .wrap-content {
        flex-wrap: wrap;
    }

    .decrement-button,
    .increment-button {
        cursor: pointer;
    }

    .stage-input {
        height: 33px !important;
    }

    .stage-input-label {
        height: 33px !important;
        width: 150px !important;
    }

    .custom-border{
        border-color: #d5d7d6 !important;
        border-style: solid!important;
        border-width: thin!important;
    }
    .payment-amount-style{
        width: 20%; 
        background-color: #f5f7fb; 
        position: absolute; 
        right: 0; 
        top: 3px; 
        bottom: 0; 
        display: flex; 
        align-items: center; 
        justify-content: center;
    }

</style>
