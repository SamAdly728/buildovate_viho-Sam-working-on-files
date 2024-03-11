<template>
    <div class="whole-page d-flex" :class="{'d-none': !show_filter}">
        <a class="flex-grow-1"  @click="hidePage"></a>
        <div class="side-panel card">
            <div class="card-header p-b-0">
                <h5>Filter</h5>
                <small>Please click apply after selecting.</small>
                <button class="btn-close position-absolute top-0 right-0 mr-4 mt-4"  @click="hidePage"></button>
                <hr>
            </div>
            <div clas="card-body m-0 p-0" style="overflow: auto;" id="filter-lists">
                <div class="row mx-3">
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Lead Title</label>
                            <input class="form-control border-success f-12" type="text" placeholder="Search title..." v-model="leadTitle">
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Customer Name</label>
                            <input class="form-control border-success f-12" type="text" placeholder="Search customer..." v-model="customerName">
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Salesperson</label>
                            <Select2 
                                v-model="selectSalesPerson"
                                :className="'container-style-outlined-no-hover'"
                                :placeholder="'Select Crew Member'" 
                                :id="'lead-filter-user-list'"
                                :purpose="'multiple-select'"
                                :items="userData"
                                :selectedItems="selectSalesPerson"
                                :isLoading="userLoading"
                            />
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Status</label>
                            <Select2 
                                v-model="selectStatus"
                                :className="'container-style-outlined-no-hover'"
                                :placeholder="'Select Status'" 
                                :id="'lead-filter-status'"
                                :purpose="'multiple-select'"
                                :items="leadStatus"
                                :selectedItems="selectStatus"
                            />
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Age of Lead</label>
                            <input class="form-control border-success f-12" type="text" placeholder="Search customer...">
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Tags</label>
                            <Select2 
                                v-model="selectTags"
                                :className="'container-style-outlined-no-hover'"
                                :placeholder="'Select Tag'" 
                                :id="'lead-filter-tags'"
                                :purpose="'multiple-select'"
                                :items="tags"
                                :selectedItems="selectTags"
                                :isLoading="tagLoading"
                            />
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Source</label>
                            <Select2 
                                v-model="selectSource"
                                :className="'container-style-outlined-no-hover'"
                                :placeholder="'Select Source'" 
                                :id="'lead-filter-sources'"
                                :purpose="'multiple-select'"
                                :items="sources"
                                :selectedItems="selectSource"
                                :isLoading="sourceLoading"
                            />
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Project Type</label>
                            <Select2 
                                v-model="selectJobtype"
                                :className="'container-style-outlined-no-hover'"
                                :placeholder="'Select Job Type'" 
                                :id="'lead-filter-job-type'"
                                :purpose="'multiple-select'"
                                :items="jobtypes"
                                :selectedItems="selectJobtype"
                                :isLoading="jobTypeLoading"
                            />
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Proposal Status</label>
                            <Select2 
                                v-model="selectProposalStatus"
                                :className="'container-style-outlined-no-hover'"
                                :placeholder="'Select Proposal Status'" 
                                :id="'lead-filter-proposal-status'"
                                :purpose="'multiple-select'"
                                :items="proposalStatus"
                                :selectedItems="selectProposalStatus"
                            />
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-02">
                        <div class="mb-3">
                            <label class="form-label f-w-600 f-12">Sold Date</label>
                            <input class="form-control border-success f-12" type="text" placeholder="Search customer...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary float-right" @click="handleApplyFilter">Apply Filter</button>
            </div>
        </div>
    </div>
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';
import { show_filter } from '../globalState';
import axios from 'axios';
import Swal from 'sweetalert2';
import Select2 from './Select2.vue';

const page = usePage();
const props = defineProps({
    open: {
        type: Boolean,
        default: false
    }
});
const emit = defineEmits(['filter']);
const leadTitle = ref('');
const customerName = ref('');
const sources = ref([]);
const sourceLoading = ref(false);
const jobtypes = ref([]);
const jobTypeLoading = ref(false);
const tags = ref([]);
const tagLoading = ref(false);
const userData = ref([]);
const userLoading = ref(false);
const leadStatus = ref([
    { id: 'open', text: 'Open' },
    { id: 'pitch', text: 'Pitch - No Sale' },
    { id: 'returned', text: 'Returned to Provider' },
    { id: 'sold', text: 'Sold' },
]);
const proposalStatus = ref([
    { id: 'Sent', text: 'Sent' },
    { id: 'Approved', text: 'Approved' },
    { id: 'Not Sent', text: 'Not Sent' },
])

const selectSalesPerson = ref([]);
const selectStatus = ref([]);
const selectTags = ref([]);
const selectSource = ref([]);
const selectJobtype = ref([]);
const selectProposalStatus = ref([]);

const hidePage = () => {
    show_filter.value = false;
}

const handleApplyFilter = () => {
    const form = {
        oppurtunityTitle: leadTitle.value,
        customerName: customerName.value,
        salesperson: selectSalesPerson.value,
        tags: selectTags.value,
        leadStatus: selectStatus.value,
        sources: selectSource.value,
        jobtypes: selectJobtype.value,
        proposalStatus: selectProposalStatus.value
    }
    emit('filter', form);
    show_filter.value = false;
}

const fetchSalesPersons = async () => {
        try {
            userLoading.value = true;
            const response = await axios.get('/api/users', {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data;
            userData.value = Object.values(data.data).map(userDetails => {
                return {
                        id: userDetails.user_id,
                        text: userDetails.display_name
                    };
            });

            // nextTick(() => {
            //     document.querySelector('#appointment_by').click();
            // });
            userLoading.value = false;
        } catch (error) {
            console.error("Error fetching customers: ", error);
        }
    };

    const fetchCustomers = async () => {
        try {
            const response = await axios.get('/api/getCustomers', {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            customers.value = response.data.data;
        } catch (error) {
            console.error("Error fetching customers: ", error);
        }
    };

    const getAllTag = async () => {
        try {
            tagLoading.value = true;
            const response = await axios.get('/api/tags', {}, {
                headers: {
                        'Authorization': 'Bearer ' + page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.status === 200) {
                const data = response.data;
                tags.value = Object.values(data.data).map(tag => {
                    return {
                        id: tag.tags_id,
                        text: tag.tags_name
                    };
                });
                
                tagLoading.value = false;
            } else {
                tagLoading.value = false;
                console.log(response);
            }

        } catch (error) {
            tagLoading.value = false;
            console.log(error);
        }
    }

    
    const getAllSource = async () => {
        try {
            sourceLoading.value = true;
            const response = await axios.get('/api/sources', {}, {
                headers: {
                        'Authorization': 'Bearer ' + page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.status === 200) {
                const data = response.data;
                sources.value = Object.values(data.data).map(source => {
                    return {
                        id: source.source_id,
                        text: source.source_name
                    };
                });
                
                sourceLoading.value = false;
            } else {
                sourceLoading.value = false;
                console.log(response);
            }

        } catch (error) {
            sourceLoading.value = false;
            console.log(error);
        }
    }

    
    const getAllJobType = async () => {
        try {
            jobTypeLoading.value = true;
            const response = await axios.get('/api/jobTypes', {}, {
                headers: {
                        'Authorization': 'Bearer ' + page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.status === 200) {
                const data = response.data;
                jobtypes.value = Object.values(data.data).map(jobtype => {
                    return {
                        id: jobtype.job_type_id,
                        text: jobtype.job_type_name
                    };
                });
                
                jobTypeLoading.value = false;
            } else {
                jobTypeLoading.value = false;
                console.log(response);
            }

        } catch (error) {
                jobTypeLoading.value = false;
            console.log(error);
        }
    }

    onMounted(() => {
        getAllTag();
        getAllSource();
        getAllJobType();
        fetchSalesPersons();
    });

</script>
<style scoped>
.whole-page{
    background-color: rgba(0, 0, 0, 0.575);
    position: absolute;
    z-index: 10;
    top: -90px;
    bottom: 0;
    right: 0;
    left: 0;
}

.side-panel{
    width: 300px;
    height: 100%;
    background-color: white;
    float: right;
}

#filter-lists::-webkit-scrollbar {
    width: 6px; /* Adjust to make it slim */
}

#filter-lists::-webkit-scrollbar-thumb {
    background-color: #888; /* Customize the thumb color */
    border-radius: 3px; /* Rounded corners for the thumb */
}

#filter-lists::-webkit-scrollbar-track {
    background-color: #ccc; /* Customize the track color */
}

</style>