<template>
    <div class="modal fade" id="leadToJobsiteModal" tabindex="-1" role="dialog" aria-labelledby="leadToJobsiteModal" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <div class="card p-0 m-0">
                        <div class="card-header border">
                            <h5>Lead to Jobsite</h5>
                            <span >This will be create a jobsite based on the lead details.</span>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card-body p-4 position-relative" style="background-color: #f5f7fb; overflow-y: auto; max-height: 65vh;">
                            <div class="row m-0 p-0">
                                <div class="card m-0 p-0 col-md-7">
                                    <div class="card-header pb-0 d-flex justify-content-between">
                                        <h5 class="card-title mb-0">Jobsite Details</h5>
                                    </div>
                                    <div class="card-body m-0 p-4">

                                        <div class="row m-0 p-0">
                                            
                                            <div class="col-md-12">
                                                <label class="form-label f-w-600 p-0" >Job Name</label>
                                                <input class="form-control border-success" type="text" v-model="form.jobsite_name">
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label f-w-600 p-0">Job Type</label>
                                                        <input class="form-control border-success" type="text">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label f-w-600 p-0">Contract Price</label>
                                                        <input class="form-control border-success" type="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="mt-4">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label f-w-600">Address</label>
                                                    <vue-google-autocomplete
                                                        id="jobsite_street_address"
                                                        name="jobsite_street_address"
                                                        classname="form-control border-success"
                                                        placeholder="Home Address"
                                                        @input="onJobsiteAddressChange"
                                                        required
                                                        v-on:placechanged="getAddressData"
                                                        :country="['us']"
                                                        :type="['address']">
                                                    </vue-google-autocomplete>
                                                </div>
                                            </div>
                                            <div class="row m-0 p-0 mb-3">
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label f-w-600">City</label>
                                                        <input class="form-control border-success" type="text" placeholder="City" name="city" v-model="form.city" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label f-w-600">Postal Code</label>
                                                        <input class="form-control border-success" type="number" placeholder="ZIP Code" name="zip_code" v-model="form.zipcode" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-5">
                                                <label class="form-label f-w-600">State</label>
                                                <input class="form-control border-success" type="text" placeholder="State"  name="state" v-model="form.state"  required>
                                            </div> 
                                            <hr>
                                            <div class="row m-0 p-0 mb-3">
                                                <h5 class="form-label mb-5">Include Proposal Computation</h5>
                                                <div class="row mx-3">
                                                    <div class="col">
                                                        <label class="d-block" for="chk-ani">
                                                            <input class="checkbox_animated" id="chk-ani" type="checkbox" v-model="form.proposal_line_items">Copy Proposal Line Items to Estimate
                                                        </label>
                                                        <label class="d-block" for="chk-ani1">
                                                            <input class="checkbox_animated" id="chk-ani1" type="checkbox" v-model="form.proposal_legal_content">Copy Proposal Introductory and Closing Text to Estimate
                                                        </label>
                                                        <label class="d-block" for="chk-ani2">
                                                            <input class="checkbox_animated" id="chk-ani2" type="checkbox" v-model="form.proposal_payment">Copy Proposal Payment to Owner Invoice
                                                        </label>
                                                        <label class="d-block" for="chk-ani3">
                                                            <input class="checkbox_animated" id="chk-ani3" type="checkbox" v-model="form.apply_estimate_line">Apply accross Estimate line items as <b>% Invoiced</b>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-header pb-0 d-flex justify-content-between">
                                            <h5 class="card-title mb-0">Customer Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <form class="theme-form">
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Name:</label>
                                                    <div class="col-sm-9">
                                                        <label class="col-form-label f-w-500" for="inputEmail3">{{ customerData.display_name }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Address:</label>
                                                    <div class="col-sm-9">
                                                        <label class="col-form-label f-w-500" for="inputEmail3">{{ customerData.street_address + ' ' + customerData.city + ' ' + customerData.state + ' ' + customerData.zip_code }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Phone:</label>
                                                    <div class="col-sm-9">
                                                        <label class="col-form-label f-w-500" for="inputEmail3">{{ formatPhoneNumber(customerData.phone) }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Other:</label>
                                                    <div class="col-sm-9">
                                                        <label class="col-form-label f-w-500" for="inputEmail3">{{ formatPhoneNumber(customerData.cell_phone) }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Email:</label>
                                                    <div class="col-sm-9">
                                                        <label class="col-form-label f-w-500" for="inputEmail3">{{ customerData.email }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Company:</label>
                                                    <div class="col-sm-9">
                                                        <label class="col-form-label f-w-500" for="inputEmail3">{{ customerData.company }}</label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute top-0 bottom-0 right-0 left-0" style="background-color: #e0e0e0ce;" v-if="processing">
                                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%;">
                                    <div style="height: 40px;">
                                        <LoadingStyleMetric></LoadingStyleMetric>
                                    </div>
                                    <a class="f-w-600 mt-1 mb-5">Converting Lead to Jobsite...</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-outline-primary" :disabled="processing">Advance Options</button>
                            <div>
                                <button class="btn btn-light  mr-2" data-bs-dismiss="modal" :disabled="processing">Cancel</button>
                                <button class="btn btn-primary" @click="handleLeadToJobsiteSubmit" :disabled="processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from 'vue';
import LoadingStyleMetric from './../LoadingStyleMetric.vue'
import Swal from 'sweetalert2';
import axios from "axios";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import { reload_jobsite_list } from '../../globalState';

const page = usePage();
const emit = defineEmits(['result']);
const processing = ref(false);
const props = defineProps({
    proposal_id: {
        typeof: Number,
        default: 0
    },
    customerData: Object, 
    leadData: Object
})
const { customerData, leadData } = props;

const form = useForm({
    cust_id: customerData.cust_id,
    jobsite_name: leadData.opportunity_title,
    street: leadData.street_address,
    city: leadData.city,
    state: leadData.state,
    zipcode: leadData.zipcode,
    proposal_line_items: false,
    proposal_legal_content: false,
    proposal_payment: false,
    apply_estimate_line: false
});

function onJobsiteAddressChange(value){
    form.street = value.target.value;
}

function formatPhoneNumber(number) {
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
}

function handleLeadToJobsiteSubmit(){
    saveJobsite();
}

/* Auto populate address*/
const getAddressData = async (addressData, placeResultData, id) => {

    const placeAddress = placeResultData.address_components;
    console.log(placeAddress);

    let streetAddress = ''

    for (const component of placeAddress) {
        const componentType = component.types[0]
        switch (componentType) {
            case "street_number":
                streetAddress = component.long_name;
            break;
            case "route":
                streetAddress += ' ' + component.long_name;
            break;
            case "postal_code":
                form.zipcode = component.long_name;
            break;
            case "administrative_area_level_1":
                form.state =  component.long_name
            break;
            case "administrative_area_level_2":
                form.state =  component.long_name
            break;
            case "neighborhood":
                form.city = component.long_name
            break;
        }
    }

    if(streetAddress){
        $('#jobsite_street_address').val(streetAddress);
        form.street = streetAddress;
    }
}

async function saveJobsite(){
    try {
        processing.value = true;
        form.proposal_id = props.proposal_id;
        console.log(form);

        const response = await axios.post('/api/jobsites', form, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.data.status === 'success') {
            let jobsite_id = response.data.data.id;
            document.querySelector('#leadToJobsiteModal .btn-close').click();
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Data has been sent successfully!',
            });
            reload_jobsite_list.value = true;
            emit('result', jobsite_id);
        } else if (response.data.status === 'error' && response.data.errors) {
            for (const [field, error] of Object.entries(response.data.errors)) {
                form.errors[field] = error[0];
            }
        }

        processing.value = false;
    } catch (error) {
        processing.value = false;
        console.log(error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'There was a problem when saving the data!',
        });
    }
}

</script>