

<template >
    <div class="d-flex justify-content-center" style="height: 100vh; width: 100vw; vertical-align: top; position: relative;">
        
        <div class="bg-white shadow" style="position: absolute !important; top: 0; left: 0; border-bottom-right-radius: 15px; z-index: 5;">
            <div class="position-relative">
                <h1 class="f-w-800 f-12" style="position: absolute; top: 25px; left: 25px;">Powered By</h1>
                <img class="mx-4 mb-3" src="https://buildovate-development.s3.us-west-1.amazonaws.com/images/general/buildovate_logo_small.png" alt="buildovate_logo" style="height: 70px;">
            </div>
        </div>

        <div class="bg-white shadow p-3" style="position: absolute !important; bottom: 0; z-index: 5; max-width: 600px;">
            <div class="d-flex flex-column align-items-center"  v-if="status == 'sent'">
                <div class="d-flex gap-3 align-items-center">
                    <a class="btn btn-success btn-lg" @click="">Accept Proposal</a>
                    <a class="btn btn-outline-danger m-0 px-3 py-1" @click="this.handleDecline()">Decline</a>
                </div>
                <div  class="d-flex flex-column" >
                    <a class="f-12 f-w-500 text-dark mt-3">If you have any questions or clarifications with the proposal, Kindly contact us below.</a>
                    <a class="f-12 f-w-600 text-dark mt-3">Company Name: <a class="text-muted">{{ company_name }}</a></a>
                    <a class="f-12 f-w-600 text-dark">Contact Number: <a class="text-muted">{{ company_number }}</a></a>
                    <a class="f-12 f-w-600 text-dark">Email Address: <a class="text-muted">{{ company_email }}</a></a>
                </div>
            </div>

            <div class="d-flex flex-column"  v-else-if="status == 'declined'">
                <a class="f-14 f-w-700 text-danger" v-if="notes">You've previously declined this proposal, with feedback provided below.</a>
                <a class="f-14 f-w-700 text-danger" v-else>You have previously rejected this proposal.</a>
                <a class="f-12 f-w-600 text-dark" v-if="notes">Your Feedback: <i class="f-12 f-w-500 text-muted">"{{ notes }}""</i></a>
                <a class="f-12 f-w-500 text-dark mt-3">If you are now interested in the proposal, please get in touch with us using the attached contacts below.</a>
                <a class="f-12 f-w-600 text-dark mt-3">Company Name: <a class="text-muted">{{ company_name }}</a></a>
                <a class="f-12 f-w-600 text-dark">Contact Number: <a class="text-muted">{{ company_number }}</a></a>
                <a class="f-12 f-w-600 text-dark">Email Address: <a class="text-muted">{{ company_email }}</a></a>
            </div>

            
            <div class="d-flex flex-column"  v-else-if="status == 'approved'">
                <a class="f-14 f-w-700 text-success">Thank you trusting! We'll make sure to asist you all the with process.</a>
                <a class="f-12 f-w-500 text-dark">There will be someone from our team that contact you to proceed with the process.</a>
                <a class="f-12 f-w-500 text-dark mt-3">If you have any questions or clarifications with the proposal, Kindly contact us below.</a>
                <a class="f-12 f-w-600 text-dark mt-3">Company Name: <a class="text-muted">{{ company_name }}</a></a>
                <a class="f-12 f-w-600 text-dark">Contact Number: <a class="text-muted">{{ company_number }}</a></a>
                <a class="f-12 f-w-600 text-dark">Email Address: <a class="text-muted">{{ company_email }}</a></a>
            </div>

            <div class="d-flex flex-column"  v-else-if="status == 'disabled'">
                <a class="f-14 f-w-700 text-danger">Sorry for inconvennience this proposal has been temporarily disabled. </a>
                <a class="f-12 f-w-500 text-dark mt-3">If you have any questions or clarifications with the proposal, Kindly contact us below.</a>
                <a class="f-12 f-w-600 text-dark mt-3">Company Name: <a class="text-muted">{{ company_name }}</a></a>
                <a class="f-12 f-w-600 text-dark">Contact Number: <a class="text-muted">{{ company_number }}</a></a>
                <a class="f-12 f-w-600 text-dark">Email Address: <a class="text-muted">{{ company_email }}</a></a>
            </div>
        </div>


        <div style="display: table-cell; vertical-align: middle; text-align: center; width: 100vw;">
            <div style="height: 100%; overflow-y: auto !important; position: relative;"  v-if="status != 'disabled'">
                <template v-for="content in pdfContents">
                    <div class="row-container">
                        <section class="bg-white shadow my-4" style="width: 210mm; height: 297mm; overflow: hidden; display: inline-block; vertical-align: middle;" v-html="content"></section>
                    </div>
                </template>
            </div>
            <div style="height: 100%; width: 100%; position: relative; overflow: hidden;" v-else>
                <img :src="asset_link + 'general/proposal_disabled.png'" alt="disabled_logo"
                style="position: absolute; top: -50px; left: 0; right: 0; width: 100vw;" />
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="remarksModal" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0" style="max-height: 93vh !important;">
                    <div class="card p-0 m-0" style="max-height: 93vh !important; overflow: hidden;">
                        <div class="card-header border">
                            <h5 class="f-18">Reason for declining</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="card-body row p-0 m-0">
                                <textarea v-model="feedback" class="py-2" style="height: 250px;" placeholder="Please provide us with your feedback on why you are declining so that we can improve our services. Thank you!"></textarea>
                            </div>
                            <div class="d-flex align-items-center justify-content-center py-3 px-4">
                                <a class="flex-grow-1"></a>
                                <a class="btn btn-primary" data-bs-dismiss="modal" @click="handleFeedback">Submit</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</template>
  
<script>
    import axios from "axios";

    export default {
        data() {
            return {
                windowWidth: 0,
                decodedCode: '',
                pdfContents: null,
                contentDiv: null,
                status: null,
                feedback: '',
                proposal_email_id: null,
                notes: '',
                company_name: '',
                company_email: '',
                company_number: '',
                asset_link: window.asset_link
            };
        },
        mounted() {
            this.decodeCodeFromURL();
            this.windowWidth = window.innerWidth;
            window.addEventListener('resize', this.handleResize);
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.handleResize);
        },
        methods: {
            handleDecline(){
                const modal = document.querySelector('#remarksModal');
                var bootstrapModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
                bootstrapModal.show();
            },
            handleResize(){
                this.windowWidth = window.innerWidth;
            },
            formatPhoneNumber(number) {
                const cleaned = ('' + number).replace(/\D/g, '');
                const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
                if (match) {
                    return '(' + match[1] + ') ' + match[2] + '-' + match[3];
                }
                
                return number;
            },
            decodeCodeFromURL() {
                const queryParams = new URLSearchParams(window.location.search);
                const encodedCode = queryParams.get('code');
                if (encodedCode) {
                    try {
                        this.decodedCode = atob(encodedCode);
                        this.fetchProposal(this.decodedCode)
                    } catch(e) {
                        console.error('Error decoding code:', e);
                    }
                }
            },
            async handleFeedback(){
                try {
                    const response = await axios.put(`/api/proposals/email/${this.proposal_email_id}`, {
                        notes: this.feedback,
                        status: 'declined'
                    }, {
                        headers: {
                            'Authorization': 'Bearer ',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    window.location.reload();
                } catch (error) {
                    console.error(error);
                }
            },
            async fetchProposal(id){
                try {
                    const response = await axios.get(`/api/proposals/${id}`, {
                        params: {},
                        headers: {
                            'Authorization': 'Bearer ',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = response.data.data;
                    const email = data.sent_email;
                    const company = data.lead.company.company;

                    if(email){
                        this.status = email.status;
                        this.proposal_email_id = email.proposal_email_id;
                        this.notes = email.notes;
                    }

                    if(company){
                        const primary_email = company ? company.primary_email : null;
                        const primary_number = company ? company.primary_number : null;

                        this.company_name = company.company_name ? company.company_name : ' - ';
                        this.company_email = primary_email ? primary_email.company_email : ' - ';
                        this.company_number = primary_number ? this.formatPhoneNumber(primary_number.company_number) : ' - ';
                    }

                    console.log(data);
                    this.fetchProposalTemplate(data);
                } catch (error) {
                    console.error("Error fetching customers: ", error);
                }
            },
            async fetchProposalTemplate(proposal){
                const company = proposal.lead.company.company;
                const primary_email = company ? company.primary_email : null;
                const primary_location = company ? company.primary_location : null;
                const primary_number = company ? company.primary_number : null;
                const primary_website = company ? company.primary_website : null;
                const customer = proposal.lead.lead_customer;
                try {
                    const response = await axios.get('/api/proposal-template-default', {
                        params: {
                            DISPLAY_NAME: customer ? customer.display_name : '',
                            CUSTOMER_PHONE: customer ? customer.phone : '',
                            JOBSITE_ADDRESS: proposal.lead.street_address,
                            JOBSITE_CITY: proposal.lead.city,
                            JOBSITE_STATE: proposal.lead.state,
                            JOBSITE_ZIPCODE: proposal.lead.zipcode,
                            COMPANY_LICENSE: company ? company.license_number : '',
                            COMPANY_ADDRESS: primary_location ? primary_location.location_address : '',
                            COMPANY_CITY: primary_location ? primary_location.location_city : '',
                            COMPANY_STATE: primary_location ? primary_location.location_street : '',
                            COMPANY_ZIPCODE: primary_location ? primary_location.location_zipcode : '',
                            COMPANY_EMAIL: primary_email ? primary_email.company_email : ' - ',
                            COMPANY_NUMBER: primary_number ? this.formatPhoneNumber(primary_number.company_number) : ' - ',
                            COMPANY_WEBSITE: primary_website ? primary_website.company_website : ' - ',
                            // ITEMS: []
                        },
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                            }
                    });
                    
                    this.pdfContents = response.data;
                } catch (error) {
                    console.error('Failed to fetch proposal-template:', error);
                }
            }
        }
    }
</script>
