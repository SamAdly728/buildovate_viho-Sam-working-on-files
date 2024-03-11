<template>
  <div class="m-4">
    <div class="container bg-white card p-5" style="width: 100%;" v-if="proposalError != '' && !loading">
      <div class="col-md-12 d-flex flex-column align-items-center">
        <div style="width: 300px; height: auto;">
          <img src="../../../assets/sales/error-image.png" alt="">
        </div>
        <h3 class="text-center mb-3 f-w-700 text-danger">UNEXPECTED ERROR</h3>
        <p class="sub-content text-center"> ERROR MESSAGE: {{ proposalError }} <br><a class="f-w-500">Please contact our customer service <b class="text-info">customer@buildovate.com</b></a></p>
      </div>
    </div>
    <div class="row" v-else>

      <div class="col-md-12 d-flex justify-content-between mb-3">
        <div class="d-flex">
          <button class="btn btn-primary" type="button" data-v-bb7f81bc="">In-House</button>
          <button class="btn btn-light" type="button" data-v-bb7f81bc="">Sub-Contractor</button>
          <a class="btn btn-outline-primary" @click="populatePendingConfirmation" id="populate-select2" style="visibility: hidden;"> TESTING </a>
          <a id="project-modal-open" data-bs-toggle="modal" data-original-title="projectStatusModal" data-bs-target="#projectStatusModal" style="visibility: hidden;"> TESTING </a>
        </div>
        <button class="btn btn-outline-primary">Find Buildovate Professionals</button>
      </div>

      <div class="col-md-12">    
        <div class="card">
          <div class="card-header pb-0">
            <h5>WORK ORDER</h5>
          </div>
          <div class="card-body mt-3 d-flex flex-column align-items-center" v-if="loading">
            <div style="height: 40px;">
              <LoadingStyleMetric></LoadingStyleMetric>
            </div>
            <a class="f-w-600 mt-1 mb-5">Retrieving Worksheets...</a>
          </div>
          <div class="card-body" v-else>
            <div class="overflow-handler flex-grow-1 d-flex flex-column">
              <div class="table-responsive flex-grow-1">
                  <table class="table" id="worksheet-list">
                      <thead>
                          <tr>
                              <template v-for="(col, index) in worksheetheaders" :key="index">
                                  <th class='f-w-500'  
                                  :style="{ width: col.width }"
                                      :class="col.class"
                                  >{{ col.headerName }}</th>
                              </template>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="(worksheet, index) in worksheets" :key="worksheet.proposal_item_id">
                              <template v-for="(col, index) in worksheetheaders">
                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class"
                                      v-if="col.headerName === 'Item Name'">
                                      <a>{{ worksheet.title }}</a>
                                  </td>

                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class, 'm-0 p-0'"
                                      v-if="col.headerName === 'Unit Cost'">
                                      <a>
                                        <div class="input-group"><span class="input-group-text">$  </span>
                                          <input class="form-control text-right" type="number" aria-label="Amount (to the nearest dollar)" :value="parseFloat(worksheet.unit_cost).toFixed(2)">
                                        </div>
                                      </a>
                                  </td>
                                  
                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class"
                                      v-if="col.headerName === 'Unit'">
                                      <a>{{ worksheet.unit }}</a>
                                  </td>

                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class"
                                      v-if="col.headerName === 'Quantity'">
                                      <a>{{ worksheet.unit_quantity }}</a>
                                  </td>

                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class"
                                      v-if="col.headerName === 'Labor Only'">
                                      <a class='text-center'> <input class="radio_animated" :id="'labor_'+ worksheet.proposal_item_id" type="radio" :name="'labor_'+ worksheet.proposal_item_id" checked></a>
                                  </td>

                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class"
                                      v-if="col.headerName === 'Labor + Material'">
                                      <a class='text-center'> <input class="radio_animated" :id="'labor_'+ worksheet.proposal_item_id" type="radio" :name="'labor_'+ worksheet.proposal_item_id"></a>
                                  </td>

                                  
                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class, 'm-0 p-0'"
                                      v-if="col.headerName === 'Total Price'">
                                      <a>
                                        <div class="input-group"><span class="input-group-text">$  </span>
                                          <input class="form-control text-right" type="number" aria-label="Amount (to the nearest dollar)" :value="parseFloat(worksheet.unit_cost * worksheet.unit_quantity).toFixed(2)">
                                        </div>
                                      </a>
                                  </td>

                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class"
                                      v-if="col.headerName === 'Checklist'">
                                      <a>Coming soon...</a>
                                  </td>

                                  <td 
                                      :style="col.style, { width: col.width }"
                                      :class="col.class, 'm-0 p-0'"
                                      v-if="col.headerName === 'Select Crew'">
                                      <a>        
                                        <Select2
                                          v-model="worksheet.selectedCrew"
                                          :className="'container-style-outlined'"
                                          :placeholder="'Select Crew'" 
                                          :id="'work-order-index_' + worksheet.proposal_item_id"
                                          :purpose="'multiple-select-no-chips'"
                                          :items="crews"
                                          :noChipsDisplay="select2Labels"
                                          :isLoading="false"
                                        />
                                      </a>
                                  </td>

                              </template>
                          </tr>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>

        </div>
      </div>

      
      <div class="col-md-12">    
        <div class="card">
          <div class="card-header pb-0">
            <h5>PROJECT STATUS</h5>
            <small v-if="pendingRequestInProgress" class="text-danger">Updating list with latest changes...</small>
          </div>

          <div class="card-body mt-3 d-flex flex-column align-items-center" v-if="loading">
            <div style="height: 40px;">
              <LoadingStyleMetric></LoadingStyleMetric>
            </div>
            <a class="f-w-600 mt-1 mb-5">Retrieving Project Status...</a>
          </div>
            <div class="card-body d-flex gap-4 flex-wrap w-100 justify-content-center" v-else>
              <template v-for="(confirmationDetails, index) in pendingConfirmationDisplay" :key="confirmationDetails.user_id">
                <ProjectStatusCard :projectDetails="confirmationDetails" @click="handleCardClick"/>
              </template>
            </div>
        </div>
      </div>
      
    </div>
  </div>
  
  <ProjectStatusModal :projectDetails="selectedPendingConfirmation" :filterBy="filterBy" @click="handleChangeStatus"/>
</template>

<script setup>
  import { usePage } from "@inertiajs/vue3";
  import { ref, watch, nextTick } from 'vue';
  import { selected_jobsite } from './../../globalState';
  import axios from 'axios';
  import Swal from 'sweetalert2';
  import LoadingStyleMetric from '../../components/LoadingStyleMetric.vue';
  import Select2 from '../../components/Select2.vue';
  import ProjectStatusCard from "./cards/ProjectStatusCard.vue";
  import ProjectStatusModal from "./cards/ProjectStatusModal.vue";

  const page = usePage();
  const crews = ref(page.props.crews);
  const sendingInvitation = ref(false);
  const pendingRequestQueue = ref([]);
  const pendingRequestInProgress = ref(false);
  const pendingConfirmation = ref([]);
  const pendingConfirmationDisplay = ref([]);
  const filterBy = ref('-');
  const loading = ref(false);
  const proposalError = ref('');
  const selectedPendingConfirmation = ref(null);
  const worksheetheaders = ref([
       { headerName: "Item Name", width: '200px', class: '', style: ''},
       { headerName: "Unit Cost", width: '160px', class: '', style: 'padding: 3px;'},
       { headerName: "Unit", width: '100px', class: '', style: ''},
       { headerName: "Quantity", width: '100px', class: 'text-center', style: ''},
       { headerName: "Labor Only", width: '120px', class: 'text-center', style: ''},
       { headerName: "Labor + Material", width: '150px', class: 'text-center', style: ''},
       { headerName: "Total Price", width: '160px', class: 'sticky-second-last', style: 'padding: 3px;'}, //sticky-third-last
       { headerName: "Checklist", width: '150px', class: '', style: ''}, //sticky-second-last
       { headerName: "Select Crew", width: '200px', class: 'sticky-last', style: 'padding: 3px;'},
  ]);
  const worksheets = ref([]);
  const select2Labels = ref({
    no_selected: 'Select Crew',
    multi_selected: 'Selected Crew',
    one_selected: 'Selected Crew',
  });

  const getCrew = (id) => {
    const crew = crews.value.find(crew => crew.id == id);
    return crew ? crew : { id: 0, text: 'N/A', email: 'N/A'};
  }

  function handleCardClick(value) {
    selectedPendingConfirmation.value = value.project;
    filterBy.value = value.type;
    document.querySelector('#project-modal-open').click();
  }

  function handleChangeStatus(value) {
    const projectDetails = value.project;
    const user_id = projectDetails.user_id;
    const user_workload_id = value.user_workload_id;
    const user_workload_ids = value.user_workload_ids;
    const type = value.type;

    if(type === 'send'){
      workLoadLoading(user_workload_id, user_id);
      inviteCrew(user_workload_id, user_id);
    }else if(type === 'approved'){
      workLoadLoading(user_workload_id, user_id);
      approvedProject(user_workload_id, user_id);
    }else if(type === 'completed'){
      Swal.fire({
        title: 'Mark as Completed!',
        text: "Please make sure that everything is completed including payments, papers and etc. before marking this as completed, do you wish to proceed?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed'
      }).then((result) => {
        if (result.isConfirmed) {
          workLoadLoading(user_workload_id, user_id);
          markAsCompleted(user_workload_id, user_id);
        }
      });
    }else if(type === 'view_details'){
      Swal.fire({
        icon: 'info',
        title:'Comming Soon!',
        text: 'You can check here all the details regarding the project, from lead, proposal, jobsite, timeline, transactions and many more. ;)',
      });
    }else if(type === 'approved_all'){
      if(user_workload_ids && user_workload_id === null){
        Swal.fire({
          title: 'Manual Approve All Selected!',
          text: "All selected project will be manually approved, if the crew acknowledge this, then please click proceed.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Proceed'
        }).then((result) => {
          if (result.isConfirmed) {
            workLoadLoading(user_workload_ids, user_id);
            approvedAllProject(user_workload_ids, user_id);
          }
        });
      }
    }else if(type === 'invite_all'){
      workLoadLoading(user_workload_ids, user_id);
      inviteAllProject(user_workload_ids, user_id);
    }

  }

  const getProposalItems = async (proposal_id) => {
        try {
            const response = await axios.get(`/api/proposals/items/${proposal_id}`, {}, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data;
            if(data.status === 'success'){
              worksheets.value = Object.values(data.data).map(worksheet => ({
                ...worksheet,
                selectedCrew: []
              }));

              getUserWorkload();
            }else{
              proposalError.value = 'FETCHING PROPOSAL ITEM ON PROPOSAL.';
              Swal.fire({
                  icon: 'error',
                  title: 'Unexpected Error!',
                  text: 'ERROR MESSAGE: FETCHING PROPOSAL ITEM ON PROPOSAL.',
              });
            }
        } catch (error) {
            loading.value = false;
            console.error("Error fetching proposal items: ", error);
        }
  };
    
  const getProposalByJobsiteId = async (jobsite_id) => {
        try {
          loading.value = true;
            const response = await axios.get(`/api/getProposalByJobsiteId/${jobsite_id}`, {}, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data;
            if(data.status === "success"){
              proposalError.value = '';
              const proposal = data.data;
              getProposalItems(proposal.proposal_id);
            }else{
              loading.value = false;
              const message = data.data;
              proposalError.value = message;
              Swal.fire({
                  icon: 'error',
                  title: 'Unexpected Error!',
                  text: 'ERROR MESSAGE: ' + message,
              });
            }
        } catch (error) {
            loading.value = false;
            console.error("Error fetching proposal items: ", error);
        }
    };

    const addQueue = async (worksheet, user_id, type) => {
      pendingRequestQueue.value.push({ worksheet, user_id, type });
      if (!pendingRequestInProgress.value) {
        processQueue();
      }

      pendingRequestInProgress.value = true;
    };

    const processQueue = async () => {
          if (pendingRequestQueue.value.length === 0) {
            pendingRequestInProgress.value = false;
            return;
          }

          pendingRequestInProgress.value = true;
          const { worksheet, user_id, type } = pendingRequestQueue.value.shift();

        try {
          if(type === 'add'){
            const response = await addUserWorkload(worksheet, user_id);
            const user_workload_id = response.data.data;

            pendingConfirmation.value.map(item => {
              if(item.proposal_item_id == worksheet.proposal_item_id && item.user_id == user_id){
                item.user_workload_id = user_workload_id;
                item.loading = false;
              }
            });

            pendingConfirmationDisplay.value.map(item => {
              if(item.user_id == worksheet.user_id){
                item.crew = getCrew(item.user_id);
                if(item.worksheets.length != 0)
                item.worksheets.forEach(element => {
                  if(element.proposal_item_id == worksheet.proposal_item_id && element.user_id == worksheet.user_id){
                    element.user_workload_id = user_workload_id;
                    element.loading = false;
                  }
                });
              }
            });

          }else if (type === 'delete'){
            await removeUserWorkload(worksheet, user_id);
          }
        } catch (error) {
          pendingRequestInProgress.value = false;
          console.error("Error fetching proposal items: ", error);
        } finally {
          processQueue();
        }
    };

    const getUserWorkload = async () => {
        try {
            const response = await axios.get(`/api/userworkloads`, {}, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data;

            if(data.status === "success"){
              proposalError.value = ''
              const userWorkloads = data.data;

              pendingConfirmation.value = userWorkloads;
              loading.value = false;

              nextTick(() => {
                document.querySelector('#populate-select2').click();
              });
              
            }else{
              loading.value = false;

              const message = data.message;
              proposalError.value = message;
              Swal.fire({
                  icon: 'error',
                  title: 'Unexpected Error!',
                  text: 'ERROR MESSAGE: ' + message,
              });
            }
        } catch (error) {
            loading.value = false;
            console.error("Error fetching user workloads: ", error);
        }
  };

  const workLoadLoading = (user_workload_id, user_id) => {
    const idsToCheck = Array.isArray(user_workload_id)
    ? user_workload_id.map(id => String(id))
    : [String(user_workload_id)];

    selectedPendingConfirmation.value.loading = true;
    pendingConfirmation.value.map(item => {
      if (idsToCheck.includes(String(item.user_workload_id))) {
        item.loading = true;
      }
    });
          
    pendingConfirmationDisplay.value.map(item => {
      if(item.user_id == user_id){
        item.crew = getCrew(item.user_id);
          if(item.worksheets.length != 0){
            item.worksheets.forEach(element => {
              if (idsToCheck.includes(String(element.user_workload_id))) {
                element.loading = true;
              }
            });
        }
      }
    });
  }

  const inviteCrew = async (user_workload_id, user_id) => {
    try {
      sendingInvitation.value = true;
      const response=  await axios.put(`/api/userworkloads/invite/${user_workload_id}`, {}, {
        headers: {
          'Authorization': 'Bearer ' + page.props.csrf_token,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const data = response.data;
      if(data.status === "success"){
        const updateWorkLoad = data.data;

        selectedPendingConfirmation.value.status = updateWorkLoad.status;
        selectedPendingConfirmation.value.invited_by = updateWorkLoad.invited_by;
        selectedPendingConfirmation.value.invited_date = updateWorkLoad.invited_date;
        selectedPendingConfirmation.value.loading = false;

        pendingConfirmation.value.map(item => {
          if(item.user_workload_id == user_workload_id){
            item.status = updateWorkLoad.status;
            item.invited_by = updateWorkLoad.invited_by;
            item.invited_date = updateWorkLoad.invited_date;
            item.loading = false;
          }
        });
          
        pendingConfirmationDisplay.value.map(item => {
          if(item.user_id == user_id){
            item.crew = getCrew(item.user_id);
            if(item.worksheets.length != 0){
              item.worksheets.forEach(element => {
                if(element.user_workload_id == user_workload_id){
                  element.status = updateWorkLoad.status;
                  element.invited_by = updateWorkLoad.invited_by;
                  element.invited_date = updateWorkLoad.invited_date;
                  element.loading = false;
                }
              });
            }
          }
        });

        console.log()
        Swal.fire({
          icon: 'success',
          title: 'Crew Confirmation Email Sent!',
          text: 'An email sent to the crew with the details above for item assignment confirmation.',
        });
      }

      sendingInvitation.value = false;
    }catch (error) {
      sendingInvitation.value = false;
      console.error("Error fetching user workloads: ", error);
    }
  };

  const approvedProject = async (user_workload_id, user_id) => {
    try {
      sendingInvitation.value = true;
      const response=  await axios.put(`/api/userworkloads/approve/${user_workload_id}`, {}, {
        headers: {
          'Authorization': 'Bearer ' + page.props.csrf_token,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const data = response.data;
      if(data.status === "success"){
        const updateWorkLoad = data.data;

        selectedPendingConfirmation.value.status = updateWorkLoad.status;
        selectedPendingConfirmation.value.approved_by = updateWorkLoad.approved_by;
        selectedPendingConfirmation.value.approved_date = updateWorkLoad.approved_date;
        selectedPendingConfirmation.value.loading = false;

        pendingConfirmation.value.map(item => {
          if(item.user_workload_id == user_workload_id){
            item.status = updateWorkLoad.status;
            item.approved_by = updateWorkLoad.approved_by;
            item.approved_date = updateWorkLoad.approved_date;
            item.loading = false;
          }
        });
          
        pendingConfirmationDisplay.value.map(item => {
          if(item.user_id == user_id){
            item.crew = getCrew(item.user_id);
            if(item.worksheets.length != 0){
              item.worksheets.forEach(element => {
                if(element.user_workload_id == user_workload_id){
                  element.status = updateWorkLoad.status;
                  element.approved_by = updateWorkLoad.approved_by;
                  element.approved_date = updateWorkLoad.approved_date;
                  element.loading = false;
                }
              });
            }
          }
        });

        Swal.fire({
          icon: 'success',
          title: 'Crew Assigment Final Approval!',
          text: 'An email sent to the crew containing approval details of the project.',
        });
      }

      sendingInvitation.value = false;
    }catch (error) {
      sendingInvitation.value = false;
      console.error("Error fetching user workloads: ", error);
    }
  };

  const approvedAllProject = async (user_workload_ids, user_id) => {
    try {
      sendingInvitation.value = true;
      const response=  await axios.put(`/api/userworkloads/approveAll/${user_id}`, {user_workload_ids: user_workload_ids}, {
        headers: {
          'Authorization': 'Bearer ' + page.props.csrf_token,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const data = response.data;
      if(data.status === "success"){
        const updateWorkLoad = data.data;

        selectedPendingConfirmation.value.status = updateWorkLoad.status;
        selectedPendingConfirmation.value.approved_by = updateWorkLoad.approved_by;
        selectedPendingConfirmation.value.approved_date = updateWorkLoad.approved_date;
        selectedPendingConfirmation.value.loading = false;

        pendingConfirmation.value.map(item => {
          if(user_workload_ids.includes(item.user_workload_id)){
            item.status = updateWorkLoad.status;
            item.approved_by = updateWorkLoad.approved_by;
            item.approved_date = updateWorkLoad.approved_date;
            item.loading = false;
          }
        });
          
        pendingConfirmationDisplay.value.map(item => {
          if(item.user_id == user_id){
            item.crew = getCrew(item.user_id);
            if(item.worksheets.length != 0){
              item.worksheets.forEach(element => {
              if(user_workload_ids.includes(element.user_workload_id)){
                  element.status = updateWorkLoad.status;
                  element.approved_by = updateWorkLoad.approved_by;
                  element.approved_date = updateWorkLoad.approved_date;
                  element.loading = false;
                }
              });
            }
          }
        });

        Swal.fire({
          icon: 'success',
          title: 'Crew Assigment Final Approval!',
          text: 'An email sent to the selected crews containing approval details of the project.',
        });
      }

      sendingInvitation.value = false;
    }catch (error) {
      sendingInvitation.value = false;
      console.error("Error fetching user workloads: ", error);
    }
  };

  const inviteAllProject = async (user_workload_ids, user_id) => {
    try {
      sendingInvitation.value = true;
      const response=  await axios.put(`/api/userworkloads/inviteAll/${user_id}`, {user_workload_ids: user_workload_ids}, {
        headers: {
          'Authorization': 'Bearer ' + page.props.csrf_token,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const data = response.data;
      if(data.status === "success"){
        const updateWorkLoad = data.data;

        selectedPendingConfirmation.value.status = updateWorkLoad.status;
        selectedPendingConfirmation.value.invited_by = updateWorkLoad.invited_by;
        selectedPendingConfirmation.value.invited_date = updateWorkLoad.invited_date;
        selectedPendingConfirmation.value.loading = false;

        pendingConfirmation.value.map(item => {
          if(user_workload_ids.includes(item.user_workload_id)){
            item.status = updateWorkLoad.status;
            item.invited_by = updateWorkLoad.invited_by;
            item.invited_date = updateWorkLoad.invited_date;
            item.loading = false;
          }
        });
          
        pendingConfirmationDisplay.value.map(item => {
          if(item.user_id == user_id){
            item.crew = getCrew(item.user_id);
            if(item.worksheets.length != 0){
              item.worksheets.forEach(element => {
              if(user_workload_ids.includes(element.user_workload_id)){
                  element.status = updateWorkLoad.status;
                  element.invited_by = updateWorkLoad.invited_by;
                  element.invited_date = updateWorkLoad.invited_date;
                  element.loading = false;
                }
              });
            }
          }
        });

        Swal.fire({
          icon: 'success',
          title: 'Crew Confirmation Email Sent!',
          text: 'An email sent to the selected crew with the details above for item assignment confirmation.',
        });
      }

      sendingInvitation.value = false;
    }catch (error) {
      sendingInvitation.value = false;
      console.error("Error fetching user workloads: ", error);
    }
  };

  const markAsCompleted = async (user_workload_id, user_id) => {
    try {
      sendingInvitation.value = true;
      const response=  await axios.put(`/api/userworkloads/complete/${user_workload_id}`, {}, {
        headers: {
          'Authorization': 'Bearer ' + page.props.csrf_token,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const data = response.data;
      if(data.status === "success"){
        const updateWorkLoad = data.data;

        selectedPendingConfirmation.value.status = updateWorkLoad.status;
        selectedPendingConfirmation.value.completed_by = updateWorkLoad.completed_by;
        selectedPendingConfirmation.value.completed_date = updateWorkLoad.completed_date;
        selectedPendingConfirmation.value.loading = false;

        pendingConfirmation.value.map(item => {
          if(item.user_workload_id == user_workload_id){
            item.status = updateWorkLoad.status;
            item.completed_by = updateWorkLoad.completed_by;
            item.completed_date = updateWorkLoad.completed_date;
            item.loading = false;
          }
        });
          
        pendingConfirmationDisplay.value.map(item => {
          if(item.user_id == user_id){
            item.crew = getCrew(item.user_id);
            if(item.worksheets.length != 0){
              item.worksheets.forEach(element => {
                if(element.user_workload_id == user_workload_id){
                  element.status = updateWorkLoad.status;
                  element.completed_by = updateWorkLoad.completed_by;
                  element.completed_date = updateWorkLoad.completed_date;
                  element.loading = false;
                }
              });
            }
          }
        });

        Swal.fire({
          icon: 'success',
          title: 'Crew Assigment Final Approval!',
          text: 'An email sent to the crew containing approval details of the project.',
        });
      }

      sendingInvitation.value = false;
    }catch (error) {
      sendingInvitation.value = false;
      console.error("Error fetching user workloads: ", error);
    }
  };

    const addUserWorkload = async (worksheet, user_id) => {
      return await axios.post(`/api/userworkloads`, constructFormData(worksheet, user_id), {
            headers: {
              'Authorization': 'Bearer ' + page.props.csrf_token,
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });
    };

    const removeUserWorkload = async (worksheet, user_id) => {
      return await axios.delete(`/api/userworkloads/${worksheet.proposal_item_id}/${user_id}`, {}, {
            headers: {
              'Authorization': 'Bearer ' + page.props.csrf_token,
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });
    };

    const constructFormData = (worksheet, user_id) => {
      return {
            user_id: user_id,
            proposal_item_id: worksheet.proposal_item_id,
            title: worksheet.title,
            description: worksheet.description,
            internal_notes: worksheet.internal_notes,
            unit_cost: worksheet.unit_cost,
            unit: worksheet.unit,
            unit_quantity: worksheet.unit_quantity,
            unit_mark_up: worksheet.unit_mark_up,
            unit_mark_up_type: worksheet.unit_mark_up_type,
            status: 'not yet invited',
            labor: worksheet.labor,
            material: worksheet.material,
            discount: worksheet.discount,
            discount_type: worksheet.discount_type
          }
    };

    const populatePendingConfirmation = () => {
      //You might be wondering why I did it this way, welp! virtual DOM in vue is not updating the DOM in select2 so need to manually trigger it with jquery.
      let populatedWorksheet = null;
      pendingConfirmation.value.forEach(workload => {
        const user_id = workload.user_id;

          populatedWorksheet = worksheets.value.map(worksheet => {
          if(worksheet.proposal_item_id === workload.proposal_item_id){
            worksheet.selectedCrew.push(user_id + '');
          }

          return worksheet;
        });
      });

      if(populatedWorksheet){
        worksheets.value = populatedWorksheet;
      }
    }

    const handleManualApprove = () => {

    }

    function formatCurrency(amount) {
        if(amount){
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            return formatter.format(parseFloat(amount));
        }else{
            return '$0.0';
        }
   }

    function addToPendingConfirmation(worksheet, user_id) {
      if(worksheet.proposal_item_id && user_id){
        addQueue(worksheet, user_id, 'add');
      }
      
      worksheet.user_id = user_id;
      worksheet.status = 'not yet invited';
      worksheet.loading = true;
      pendingConfirmation.value.push(worksheet);
    }

    const addOrUpdateWorkOrder = (userId, worksheetData) => {
      const userEntry = pendingConfirmationDisplay.value.find(entry => entry.user_id == userId);

      if (userEntry) {
        userEntry.worksheets.push(worksheetData);
      } else {
        const newObj = {
          user_id: userId,
          crew: getCrew(userId),
          worksheets: [worksheetData]
        };

        pendingConfirmationDisplay.value.push(newObj);
      }
    }

    const processSelectCrewChanges = (newValue) => {
      newValue.forEach(worksheet => {
          if(pendingConfirmation.value.length === 0){
            const user_id = worksheet.selectedCrew[0];
            addToPendingConfirmation(worksheet, user_id);
          }else{
            if(worksheet.selectedCrew.length != 0){

              worksheet.selectedCrew.forEach(user_id => {
                const isItemExisting = pendingConfirmation.value.some(item => {
                  return item.proposal_item_id == worksheet.proposal_item_id && item.user_id == user_id
                });

                if (!isItemExisting) {
                  addToPendingConfirmation(worksheet, user_id);
                }
              });
            }
          }
      });

      const itemsToRemove = pendingConfirmation.value.filter(item => {
        return !newValue.some(worksheet =>
          worksheet.proposal_item_id == item.proposal_item_id &&
          (worksheet.selectedCrew || []).includes(item.user_id + '')
        );
      });

      if(itemsToRemove.length !== 0){
        if(itemsToRemove[0].proposal_item_id && itemsToRemove[0].user_id){
          addQueue(itemsToRemove[0], itemsToRemove[0].user_id, 'delete');
        }
      }

      pendingConfirmation.value = pendingConfirmation.value.filter(item => {
        return newValue.some(worksheet =>
          worksheet.proposal_item_id == item.proposal_item_id &&
          (worksheet.selectedCrew || []).includes(item.user_id + '')
        );
      });

      pendingConfirmationDisplay.value = [];
      pendingConfirmation.value.forEach(worksheet => {
        addOrUpdateWorkOrder(worksheet.user_id, worksheet);
      });

    }
  
    watch(selected_jobsite, (newValue) => {
      if(newValue !== null){
        selectedPendingConfirmation.value = null;
        getProposalByJobsiteId(newValue.jobsite_id);
      }
    });

    watch(() => worksheets, (newValue) => {
      processSelectCrewChanges(newValue.value);
    }, { deep: true });
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
  #worksheet-list td.sticky-second-last::before, #worksheet-list th.sticky-second-last::before {
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

