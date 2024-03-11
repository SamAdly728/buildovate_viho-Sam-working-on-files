<template>
    <div class="modal fade" id="projectStatusModal" tabindex="-1" role="dialog" aria-labelledby="projectStatusModal" aria-hidden="true" style="overflow: hidden" @click.self="handleCloseModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <div class="card p-0 m-0">
                        <div class="card-header border">
                            <h5>{{ props.projectDetails ? props.projectDetails.crew.text : 'NULL' }}</h5>
                            <small>Primary Contact: <span class="text-info">{{ props.projectDetails ? props.projectDetails.crew.email : 'NULL' }}</span></small>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="handleCloseModal"></button>
                        </div>
                        <div class="card-body p-4" style="background-color: #f5f7fb; overflow-y: auto; max-height: 65vh;">
                            <div class="card m-0">
                                <div class="card-header pb-3 pt-4 d-flex justify-content-between align-items-center">
                                    <h6 class="text-muted">Assigned Work</h6>
                                    <div class="d-flex gap-2 align-items-center" style="width: auto;">
                                        <div class="checkbox checkbox-primary">
                                            <input id="checkbox-state-dark" type="checkbox" v-model="hideContractPrice">
                                            <label for="checkbox-state-dark" style="margin-top: 5px !important;">Show Comparison</label>
                                        </div>
                                        <label class="text-muted">|</label>
                                        <label>Filter by Status: </label>
                                        <select class="form-control border-success" style="width: 200px" v-model="filterByStatus">
                                            <option value="-">All</option>
                                            <option value="not yet invited">Stand By</option>
                                            <option value="invited">Waiting for Confirmation</option>
                                            <option value="accepted">Project Accepted</option>
                                            <option value="declined">Project Declined</option>
                                            <option value="approved">In-progess</option>
                                            <option value="completed">Completed</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="card-body py-0 pb-4">
                                    <div class="overflow-handler flex-grow-1 d-flex flex-column border-success">
                                        <div class="table-responsive flex-grow-1">
                                            <table class="table" id="worksheet-list">
                                                <thead>
                                                    <tr>
                                                        <template v-for="(col, index) in worksheetheaders" :key="index">
                                                            <th class='f-w-500'  
                                                                :style="{ width: col.width }"
                                                                :class="col.class"
                                                                v-if="(col.headerName === 'Rate' || col.headerName === 'Contract Price' || col.headerName === 'Contract Total') ? hideContractPrice : true"
                                                            >{{ col.headerName }}</th>
                                                        </template>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="props.projectDetails">
                                                    <template v-for="(worksheet, index) in props.projectDetails.worksheets" :key="worksheet.proposal_item_id">
                                                        <tr v-if="(filterByStatus === '-') ? true : (filterByStatus === worksheet.status)">
                                                            <template v-for="(col, index) in worksheetheaders">
                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class"
                                                                    v-if="col.headerName === ' - '">
                                                                    <input :id="`checkbox-assigned_${worksheet.proposal_item_id}`" type="checkbox" 
                                                                            :checked="checkedItems.includes(worksheet.proposal_item_id)"
                                                                            @change="handleCheckedItem(worksheet.user_workload_id)"
                                                                            v-if="worksheet.status === 'not yet invited' || worksheet.status === 'invited' || worksheet.status === 'declined' || worksheet.loading">
                                                                    <div v-else>-</div>
                                                                </td>
                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class"
                                                                    v-if="col.headerName === 'Item Name'">
                                                                    <a>{{ worksheet.title }}</a>
                                                                </td>

                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class"
                                                                    v-if="col.headerName === 'Status'">
                                                                    <a class="badge" :class="`badge-${getBadgeByStatus(worksheet.status, 'color')}`, worksheet.status === 'not yet invited' ? 'text-dark' : 'text-light'"> {{ getBadgeByStatus(worksheet.status, 'label') }} </a>   
                                                                </td>


                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class, 'm-0 p-0'"
                                                                    v-if="col.headerName === 'Price'">
                                                                    <a>
                                                                        <div class="input-group"><span class="input-group-text">$  </span>
                                                                            <input class="form-control text-right" type="number" aria-label="Amount (to the nearest dollar)" :value="parseFloat(worksheet.unit_cost).toFixed(2)">
                                                                        </div>
                                                                    </a>
                                                                </td>
                                                                
                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class"
                                                                    v-if="col.headerName === 'Total'">
                                                                    <a>
                                                                        <div class="input-group"><span class="input-group-text">$  </span>
                                                                            <input class="form-control text-right" type="number" aria-label="Amount (to the nearest dollar)" :value="parseFloat(worksheet.unit_cost).toFixed(2)">
                                                                        </div>
                                                                    </a>
                                                                </td>

                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class"
                                                                    v-if="col.headerName === 'Contract Price' && hideContractPrice">
                                                                    <a>
                                                                        <div class="input-group"><span class="input-group-text">$  </span>
                                                                            <input class="form-control text-right" type="number" aria-label="Amount (to the nearest dollar)" :value="parseFloat(worksheet.unit_cost).toFixed(2)">
                                                                        </div>
                                                                    </a>
                                                                </td>

                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class"
                                                                    v-if="col.headerName === 'Contract Total' && hideContractPrice">
                                                                    <a>
                                                                        <div class="input-group"><span class="input-group-text">$  </span>
                                                                            <input class="form-control text-right" type="number" aria-label="Amount (to the nearest dollar)" :value="parseFloat(worksheet.unit_cost).toFixed(2)">
                                                                        </div>
                                                                    </a>
                                                                </td>

                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class"
                                                                    v-if="col.headerName === 'Rate' && hideContractPrice">
                                                                    <a> - </a>   
                                                                </td>

                                                                
                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class, 'm-0 p-0'"
                                                                    v-if="col.headerName === 'Date Invited'">
                                                                    <a> - </a>
                                                                </td>

                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class"
                                                                    v-if="col.headerName === 'Date Accepted'">
                                                                    <a> - </a>
                                                                </td>

                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class, 'm-0 p-0'"
                                                                    v-if="col.headerName === 'Date Approved'">
                                                                    <a>-</a>
                                                                </td>

                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class, 'm-0 p-0'"
                                                                    v-if="col.headerName === 'Date Completed'">
                                                                    <a>-</a>
                                                                </td>

                                                                <td 
                                                                    :style="col.style, { width: col.width }"
                                                                    :class="col.class, 'm-0 p-0'"
                                                                    v-if="col.headerName === 'Action'">
                                                                    <div v-if="worksheet.loading">
                                                                        Loading...
                                                                    </div>
                                                                    <div v-else>
                                                                        <a class="badge badge-success cursor-pointer" 
                                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Send for confirmation"
                                                                            v-if="worksheet.status === 'not yet invited' || worksheet.status === 'invited' || worksheet.status === 'declined'"
                                                                            @click="handleClick('send', worksheet.user_workload_id)"><i class="fa fa-send"></i></a>
                                                                        <a class="badge badge-success cursor-pointer" 
                                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Finalize the confirmation"
                                                                            v-if="worksheet.status === 'accepted'"
                                                                            @click="handleClick('approved', worksheet.user_workload_id)"><i class="fa fa-check"></i></a>
                                                                        <a class="badge badge-success cursor-pointer" 
                                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Mark as completed"
                                                                            v-if="worksheet.status === 'approved'"
                                                                            @click="handleClick('completed', worksheet.user_workload_id)"><i class="fa fa-check"></i></a>
                                                                        <a class="badge badge-danger cursor-pointer"
                                                                            @click="handleClick('kickout', worksheet.user_workload_id)" 
                                                                            v-if="worksheet.status === 'approved'">
                                                                            <i class="icofont icofont-logout"></i>
                                                                        </a>
                                                                        <a class="badge badge-success cursor-pointer"
                                                                            @click="handleClick('view_details', worksheet.user_workload_id)" 
                                                                            v-if="worksheet.status === 'completed'">
                                                                            Completed
                                                                        </a>
                                                                        <a class="badge badge-danger cursor-pointer" 
                                                                            @click="handleClick('delete', worksheet.user_workload_id)" v-else>
                                                                            <i class="icofont icofont-ui-delete"></i>
                                                                        </a>
                                                                        <a class="badge badge-secondary cursor-pointer"  
                                                                            v-if="!(worksheet.status === 'completed' || worksheet.status === 'approved' || worksheet.status === 'accepted' || worksheet.status === 'declined')"
                                                                            @click="handleClick('edit', worksheet.user_workload_id)"><i class="icofont icofont-edit"></i></a>
                                                                    </div>
                                                                </td>

                                                            </template>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card m-0" v-if="checkedItems.length !== 0">
                                <div class="card-header m-0 px-4 pb-3 pt-4 d-flex justify-content-between">
                                    <h6 class="text-muted cursor-pointer" @click="handleShowSummary">Summary</h6>
                                    <div class="d-flex gap-3" v-if="sendSMS || sendEmail">
                                        <h6 class="text-muted mr-3">Preview:</h6>
                                        <h6 class="text-success cursor-pointer" @click="handlePreviewSMS()" v-if="sendSMS"><i class="icofont icofont-eye-alt"></i> Message</h6>
                                        <h6 class="text-danger cursor-pointer" @click="handlePreviewEmail" v-if="sendEmail"><i class="icofont icofont-eye-alt"></i> Email</h6>
                                    </div>
                                </div>
                                <div class="card-body m-0 px-4 pt-0">
                                    <div class="border" v-if="showSummary">
                                        <textarea class="w-100 p-4" rows="10" v-model="sampleTemplate"></textarea>
                                    </div>
                                    <div class="border p-4" v-else-if="previewSMS">
                                        <label class="position-absolute cursor-pointer text-success" @click="handleShowSummary">Close Preview</label>
                                        <SMSChatBubble :message="sampleTemplate"/>
                                    </div>
                                    <div class="border p-4" v-else-if="previewEmail">
                                        <label class="position-absolute cursor-pointer text-success" @click="handleShowSummary">Close Preview</label>
                                        <EmailChatBubble :message="sampleTemplate"/>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class=" mb-0"><label class="form-check-label">Send Via:</label>
                                            <div class="mb-0 d-flex justify-content-between">
                                                <div>
                                                    <div class="form-check form-check-inline checkbox checkbox-primary">
                                                        <input class="form-check-input" id="inline-form-1" type="checkbox" v-model="sendSMS">
                                                        <label class="form-check-label" for="inline-form-1">Text Message</label>
                                                    </div>
                                                    <div class="form-check form-check-inline checkbox checkbox-primary ">
                                                        <input class="form-check-input" id="inline-form-3" type="checkbox" v-model="sendEmail">
                                                        <label class="form-check-label" for="inline-form-3" disabled>Email</label>
                                                    </div>
                                                </div>
                                                <div class="form-check form-check-inline checkbox checkbox-primary">
                                                    <input class="form-check-input" id="inline-form-0" type="checkbox">
                                                    <label class="form-check-label" for="inline-form-0">
                                                        Remind crew every &nbsp;
                                                        <input type="number" value="5" min="5" max="60" style="width: 25px;"> 
                                                        <select class="form-control2" style="">
                                                            <option value="hrs">Hours</option>
                                                            <option value="days">Days</option>
                                                        </select> 
                                                        until they confirm 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between" v-if="checkedItems.length !== 0">
                            <button class="btn btn-primary float-right" @click="handleClick('approved_all', null)">Manual Approve</button>
                            <button class="btn btn-primary mr-2 float-right" @click="handleClick('invite_all', null)">Send Confirmation</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref, watch } from 'vue';
    import SMSChatBubble from '../../../components/SMSChatBubble.vue';
    import EmailChatBubble from '../../../components/EmailChatBubble.vue';
    
    const sampleTemplate = ref(`For [ScopeOfWork], [CrewName] will begin the work on [START] and should be done by [FINISH] for the total amount of [PaymentAmount]. \n
FOR [CREW NAME] TO GET PAID:
For [CREW NAME] to get paid by [COMPANY NAME], [CREW NAME] agrees to submit Payment Requests to [COMPANY NAME] anytime before [CREWPAYMENTREQUESTCUTOFF] of the week. [CREW] must also submit Payment Request with photos of that stage of the job completed in order to get paid. This can all be easily done by using the Buildovate app.\n
In order to get data for these brackets, you may get the users Company Name from https://buildovate.io/company/details
We also need to add a new line on the Basic Information on https://buildovate.io/company/details
Crew Payment Request Cutoff dropdown for days of the week: Sunday | Monday | Tuesday | Wednesday | Thursday | Friday | Saturday`);
    const props = defineProps({
        filterBy: {
            type: String,
            default: '-'
        },
        projectDetails: { 
            type: Object,
            default: () => null
        }
    });
    const emit = defineEmits(['click'])

    const hideContractPrice = ref(false);
    const filterByStatus = ref('-');
    const sendSMS = ref(true);
    const sendEmail = ref(true);
    const previewSMS = ref(false);
    const previewEmail = ref(false);
    const showSummary = ref(true);
    const checkedItems = ref([]);

    const worksheetheaders = ref([
       { headerName: " - ", width: '40px', class: 'text-center'},
       { headerName: "Item Name", width: '200px'},
       { headerName: "Status", width: '150px'},
       { headerName: "Price", width: '150px', class: '', style: 'padding: 3px;'},
       { headerName: "Total", width: '150px', class: '', style: 'padding: 3px;'},
       { headerName: "Contract Price", width: '150px', class: '', style: 'padding: 3px;'},
       { headerName: "Contract Total", width: '150px', class: '', style: 'padding: 3px;'},
       { headerName: "Rate", width: '100px', class: 'text-center', style: ''},
       { headerName: "Date Invited", width: '180px'},
       { headerName: "Date Accepted", width: '180px'},
       { headerName: "Date Approved", width: '180px'},
       { headerName: "Date Completed", width: '180px'},
       { headerName: "Action", width: '120px', class: 'text-center sticky-last', style: 'padding: 3px; padding-top: 10px;'},
    ]);

    const getBadgeByStatus = (statusValue, type) => {
        let color = 'primary';
        let status = 'Completed';

        if(statusValue === 'not yet invited'){
            status = 'Stand By';
            color = 'light';
        }else if(statusValue === 'invited'){
            status = 'For Confirmation';
            color = 'warning';
        }else if(statusValue === 'accepted'){
            status = 'Project Accepted';
            color = 'info';
        }else if(statusValue === 'declined'){
            status = 'Project Declined';
            color = 'danger';
        }else if(statusValue === 'approved'){
            status = 'In-progress';
            color = 'secondary';
        }

        return type === 'color' ? color : status;
    };

    function handleClick(type, user_workload_id) {
        emit('click', {
            user_workload_ids: checkedItems.value,
            user_workload_id: user_workload_id,
            type: type,
            project: props.projectDetails
        });

        if(type === 'approved_all' || type === 'invite_all'){
            checkedItems.value = [];
        }
    }

    const handleCloseModal = () => {
        checkedItems.value = [];
    }
    
    const handleShowSummary = () => {
        previewSMS.value = false;
        previewEmail.value = false;
        showSummary.value = true;
    }

    const handlePreviewSMS = () => {
        previewEmail.value = false;
        showSummary.value = false;
        previewSMS.value = true;
    }

    const handlePreviewEmail = () => {
        showSummary.value = false;
        previewSMS.value = false;
        previewEmail.value = true;
    }

    const handleCheckedItem = (user_workload_id) => {
        const index = checkedItems.value.indexOf(user_workload_id);

        if (index > -1) {
            checkedItems.value.splice(index, 1);
        } else {
            checkedItems.value.push(user_workload_id);
        }
    }

    watch(() => props.filterBy, (newValue) => {
        filterByStatus.value = newValue;
    });
</script>
<style scoped>
    .overflow-handler{
        overflow: hidden;
    }
    .table-responsive {
        overflow: auto;
        width: 100%;
    }

    #worksheet-list  {
        table-layout: fixed;
    }

    #worksheet-list thead {
        background-color: #e6edef;
    }

    #worksheet-list tbody tr td {
        position: relative;
        border: 1px solid #d3d3d3;
    }

    #worksheet-list thead th {
        position: sticky;
        top: 0;
        background-color: #e6edef;
        z-index: 5;
        border: 1px solid #d3d3d3;
    }

    .worksheet-hover-effect:hover {
      background-color: #24695236 !important;
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
  #worksheet-list td.sticky-last, #worksheet-list td.sticky-second-last{
    position: sticky;
    right: 0px; 
    z-index: 6;
    background-color: white;
  }

  #worksheet-list th.sticky-last, #worksheet-list th.sticky-second-last{
    position: sticky;
    right: 0px; 
    z-index: 6;
    background-color: #e6edef;
    box-sizing: border-box;
  }
  #worksheet-list th.sticky-second-last, #worksheet-list td.sticky-second-last{
    right: 200px; 
  }

  /* , th.sticky-second-last::before */
  #worksheet-list td.sticky-last::before, #worksheet-list th.sticky-last::before {
        content: ''; /* necessary for the pseudo-element to work */
        position: absolute;
        top: 0;
        bottom: 0;
        left: -2px; /* push it to the left edge of the cell */
        width: 3px;
        background-color: #ddd; /* adjust color as needed */
        z-index: 7; /* make sure it stays on top */
  }
</style>