<template>
    <div class="d-flex flex-column p-3 gap-3" style="width: 100%;">
        <div class="d-flex align-items-center justify-content-center" style="width: 100%;">
            <img src="../../assets/post-1.png" style="height: 100px; width: 100px;"/>
        </div>
        <div class="d-flex flex-column gap-1">
            <label class="m-0 f-20">{{ company ? company.company_name : 'Loading...' }}</label>
            <label class="m-0 text-muted">License #: <span class="text-dark">{{ company ? company.license_number : 'Loading...' }}</span></label>
            <label class="m-0 text-muted">Address: <span class="text-dark">{{ company ? getCompanyLocation(company) : 'Loading...' }}</span></label>
        </div>
        <div class="d-flex gap-4 mt-2">
            <div style="border-top: 1px solid gray; width: 250px;" class="d-flex flex-column">
                <label class="m-0 text-muted">Contact</label>
                <label class="m-0 f-14">Louie Jay Fuentes</label>
                <label class="m-0 text-muted f-12"><span class="text-dark">Testing Testing Testing</span></label>
                <label class="m-0 text-muted f-12">Email: <span class="text-dark">louiefuentes.dev@gmail.com</span></label>
                <label class="m-0 text-muted f-12">Number: <span class="text-dark">+8 (123) (1231) (123)</span></label>
            </div>
            <div style="border-top: 1px solid gray;" class="flex-grow-1 d-flex flex-column">
                <label class="m-0 text-muted">Job Address</label>
                <label class="m-0 text-muted f-12"><span class="text-dark">{{ lead ? getJobsiteLocation(lead) : 'Loading...' }}</span></label>
            </div>
            <div style="border-top: 1px solid gray; width: 120px;" class="d-flex flex-column">
                <label class="m-0 text-muted">Proposal ID</label>
                <label class="m-0 text-dark f-12">#{{ proposal_id }}</label>
            </div>
            <div style="border-top: 1px solid gray; width: 120px;" class="d-flex flex-column">
                <label class="m-0 text-muted">Date</label>
                <label class="m-0 text-dark f-12">{{ formatDate(currentDate) }}</label>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div style="background-color: black;" class="d-flex gap-3">
                <label class="m-0 text-white p-2 flex-grow-1">Item</label>
                <label class="m-0 text-white p-2" style="width: 100px;">Quantity</label>
                <label class="m-0 text-white p-2" style="width: 100px;">Unit</label>
                <label class="m-0 text-white p-2" style="width: 120px;">Unit Cost</label>
                <label class="m-0 text-white p-2" style="width: 120px;" v-if="type === 'pros'">Total Cost</label>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props: {
        type: {
            typeof: String,
            default: 'customer'
        },
        company: {
            typeof: Object,
            default: null
        },
        lead: {
            typeof: Object,
            default: null
        },
        proposal_id: {
            typeof: Number,
            default: 0
        }
    },
    data(){
        return {
            currentDate: new Date(),
        }
    },
    methods: {
        getCompanyLocation(company){
            const primary_location = company.primary_location;

            if(primary_location){
                return `${primary_location.location_address} ${primary_location.location_street} ${primary_location.location_city} ${primary_location.location_zipcode}`
            }
            return 'Loading...';
        },
        getJobsiteLocation(lead){
            if(lead){
                return `${lead.street_address} ${lead.state} ${lead.city} ${lead.zipcode}`
            }
            return 'Loading...';
        },
        formatDate(date) {
            const options = { month: 'short', day: 'numeric', year: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }
    }
}
</script>