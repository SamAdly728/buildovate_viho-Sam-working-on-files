<style scope>
.slide-fade-enter-active {
  transition: all 0.5s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

.active{
  text-decoration: none !important;
}
#custom-datepicker .datepicker{
  width: 267px !important;
  border-radius: 0 !important;
  -webkit-box-shadow: none !important;
  -moz-box-shadow: none !important;
  box-shadow: none !important;
}

.dp__outer_menu_wrap {
  width: 289px !important;
}
.dp__action_row {
  display: none;
}
.dp__theme_light {
  border-color: transparent;
}
.group-text-style{
  border-radius: 0% !important;
  border-color: #24695c !important;
  background-color: #24695c !important;
  color: white;
}
.group-style{
  border-color: #24695c !important;
}

.badge:hover{
  color: white !important;
}

.no-scrollbar-space {
  overflow-y: hidden; 
  scrollbar-width: thin;
  scrollbar-color: #24695c transparent;
}

.no-scrollbar-space:hover {
  overflow-y: auto; 
}

.no-scrollbar-space::-webkit-scrollbar {
  width: 5px; 
}

.no-scrollbar-space::-webkit-scrollbar-thumb {
  background-color: #24695c93; 
  border-radius: 6px; 
  background-clip: content-box;
}

.hover-effect:hover{
  background-color: #24695c !important;
  cursor: pointer !important;
  color: white !important;
}

.selected-job{
  background-color: #24695c !important;
  cursor: pointer !important;
  color: white !important;
}

.truncate-text {
  white-space: nowrap; 
  overflow: hidden; 
  text-overflow: ellipsis;
  width: 100%; 
  text-align: left;
}

.filter-popup {
  background-color: white;
  padding: 20px;
  border: 1px solid #ddd;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  border-radius: 5px;
  z-index: 1000; /* Ensure it's above other content */
  min-width: 200px; /* Adjust as necessary */
}

</style>

<template>
  <!-- Page Sidebar Start-->
  <Transition name="slide-fade">
    <header v-show="page.props.style.sidebar" class="main-nav" :style="page.props.style.sidebar_opacity">

      <!--  Calendar Section    -->
      <div id="custom-datepicker" v-if="page.url ==='/calendar'"></div>
      <!--      <hr v-if="page.url ==='/calendar'" style="margin: 0">-->
      <!--  End for Calendar Section    -->

      <div id="user" class="default-according style-1">
        
        <div class="card d-flex flex-column" style="max-height: calc(100vh - 80px);">
          
          <div v-if="jobsites.length === 0"></div>
          <span class="card-header f-w-700 cursor-default d-flex justify-content-between cursor-pointer" v-else-if="page.url.includes('/projects')">
            <a>Projects</a>
            <a class="pull-right">List View</a>
          </span>
          <span class="p-2 card-header f-w-700 cursor-default d-flex justify-content-between cursor-pointer"  @click="toggleJobDetails" v-else>
            <a>{{ selected_jobsite != null ? 'Job Details' : 'Select Jobsite'}}</a>
            <i :class="isDetailsOpen ? 'icon-angle-up' : 'icon-angle-right'" v-if="selected_jobsite != null"></i>
          </span>          

          <div class="card-body post-about" :class="(isDetailsOpen && !(page.url.includes('/projects'))) ? '' : 'd-none'">
            <ul class="cursor-default">
              <li>
                <div v-if="!isStatistics">
                  <h5 class="f-w-600 txt-dark truncate" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    :title="selectedJobsite.jobsite_name">
                    {{ selectedJobsite.jobsite_name }}
                  </h5>
                  <div class="d-flex flex-column mt-2">
                    <a class="f-w-400 txt-dark truncate">{{ selectedJobsite.street }}</a>
                    <a class="f-w-400 txt-dark truncate">{{ selectedJobsite.city }}</a>
                    <a class="f-w-400 txt-dark truncate">{{ selectedJobsite.state }} {{ selectedJobsite.zipcode}}</a>
                    <hr>
                    <a class="f-w-700 d-flex justify-content-between">Current Total: <a>$0.0</a></a>
                    <hr>
                  </div>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 175px;" v-else>
                  <a class="f-w-700">COMING SOON...</a>
                </div>
                <div class="d-flex justify-content-between">
                  <a class="badge badge-primary cursor-pointer" @click="toggleStatDetails">
                    <i :class="isStatistics ? 'icon-info-alt' : 'icon-pulse'"></i> {{ isStatistics ? 'Basic Info' : 'Statistics'}}
                  </a>
                  <div>
                    <a class="badge badge-primary cursor-pointer text-light" data-toggle="tooltip" data-placement="top" title="View Job Details" style="color: white: !important;"><i class="icon-info-alt"></i></a>
                    <a class="badge badge-primary cursor-pointer" data-toggle="tooltip" data-placement="top" title="Send Message to Owner"><i class="icon-email"></i></a>
                    <a class="badge badge-primary cursor-pointer text-light" data-toggle="tooltip" data-placement="top" title="View Owner Site" style="color: white: !important;"><i class="icon-home"></i></a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="input-group group-style" v-if="jobsites.length !== 0">
            <span class="input-group-text group-text-style"><i class="icon-search"></i></span>
              <input class="form-control" type="text" @input="handleSearchJobsite">
              <span class="input-group-text group-text-style" @click="toogleFilter"><i class="icon-filter"></i></span>
          </div>

          <div class="position-relative d-inline-block">
            <!-- Filter Popup Form -->
            <div v-if="showFilterPopup" class="filter-popup">
              <form @submit.prevent="handleSearchJobsite">
                <div class="mb-3">
                  <label for="savedFilter" class="form-label">Saved Filter</label>
                  <select v-model="filters.savedFilter" class="form-select" id="savedFilter">
                    <option value="1">Standard Filter</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="groups" class="form-label">Groups</label>
                  <input v-model="filters.groups" type="text" class="form-control" id="groups" placeholder="Groups">
                </div>
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select v-model="filters.status" class="form-select" id="status">
                    <option value="openclose">--- Open or Closed ---</option>
                    <option value="open">Open Jobs Only</option>
                    <option value="close">Closed Jobs Only</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="projectmanagers" class="form-label">Project Managers</label>
                  <input v-model="filters.projectmanagers" type="text" class="form-control" id="projectmanagers" placeholder="Project Managers">
                </div>
                <!-- Add more filter fields as needed -->
                <button type="submit" class="btn btn-success me-2">Update Result</button>
                <button type="button" @click="ResetFilter" class="btn btn-light me-2">Reset Filters</button>
                <button type="button" @click="showFilterPopup = false" class="btn btn-light me-2">Save Filters</button>
              </form>
            </div>
          </div>

          

          <Link href="/internal" class="btn btn-outline-light hover-effect truncate-text px-3 text-center mt-1" v-if="page.url.includes('/files')">Internal</Link>
          <div style="background-color: #e0e0e0; height: 3px;"></div>
          <div class="mt-5 d-flex flex-column align-items-center" v-if="loadingJobsites">
            <div style="height: 40px;">
              <LoadingMetric></LoadingMetric>
            </div>
            <a class="f-w-600 mt-1 mb-5">Retrieving Jobsites...</a>
          </div>
          <div class="mt-5 d-flex flex-column align-items-center" v-else-if="jobsites.length === 0">
            <div class="container" style="width: 100%;">
              <div class="col-md-12 d-flex flex-column align-items-center">
                  <div style="width: 200px; height: 180px;">
                    <img src="../../assets/sales/empty-jobsite.png" alt="">
                  </div>
                  <h3 class="text-center mt-5 mb-3 f-w-700 text-success">NO JOBSITE!</h3>
                  <p class="sub-content text-center"> Convert your lead to jobsite or create from scratch</p>
                  <a class="btn btn-primary" style="width: 200px;" @click="handleCreateJobsite">CREATE JOBSITE</a>
              </div>
          </div>
          </div>
          <div class="post-about flex-grow-1 no-scrollbar-space" v-else>
            <ul class="cursor-default">
              <template v-for="jobsite in jobsites" :key="jobsite.jobsite_id">
                <li class="btn btn-outline-light btn-sm txt-dark hover-effect truncate-text px-3" :class="(selected_jobsite && selected_jobsite.jobsite_id == jobsite.jobsite_id) ? 'selected-job' : ''" @click="handleSelectJobsite(jobsite)">{{ jobsite.jobsite_name }}</li>
              </template>
            </ul>
          </div>
        </div>

      </div>
      <nav>
        <div class="main-navbar">
          <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
          <div id="mainnav">
            <ul class="nav-menu custom-scrollbar cursor-default">
              <li class="back-btn">
                <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
              </li>
              <li class="sidebar-main-title">
              </li>
            </ul>
          </div>
          <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
      </nav>
    </header>
  </Transition>
  <!-- Page Sidebar Ends-->
</template>


<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import { selected_jobsite, reload_jobsite_list, jobsite_list } from '../globalState';
import LoadingMetric from './LoadingStyleMetric.vue';
import Swal from 'sweetalert2';
import { Link } from "@inertiajs/vue3";

const showFilterPopup = ref(false);
const filters = ref({
  savedFilter: '1',
  groups: '',
  status: 'openclose',
  projectmanagers: '',
});

const page = usePage();
const isDetailsOpen = ref(false);
const isStatistics = ref(false);
const searchJosbite = ref('');
const searchTimeout = ref(null);
const jobsites = ref([]);
const selectedJobsite = ref({
  cust_id: '',
  jobsite_name: '',
  street: '',
  city: '',
  state: '',
  zipcode: ''
});
const loadingJobsites = ref(false);

function ResetFilter(){
  filters.value = ref({
    savedFilter: '1',
    groups: '',
    status: 'openclose',
    projectmanagers: ''
  });
}

function toogleFilter(){
  showFilterPopup.value = !showFilterPopup.value;
}

function fetchSearchResults(filters) {
  // Replace with actual API call logic
  return []; // Return search results
}


function toggleJobDetails(){
  if(selected_jobsite.value != null){
    isDetailsOpen.value = !isDetailsOpen.value;
  }else{
    isDetailsOpen.value = false;
  }
}

function toggleStatDetails(){
  isStatistics.value = !isStatistics.value;
}

async function fetchJobsites(search,filters){
  try {
    showFilterPopup.value = false;
    loadingJobsites.value = true;
    const response = await axios.get('/api/jobsites', {
      params: {
        search: search,
        savedFilter: filters.savedFilter,
        groups: filters.groups,
        status: filters.status,
        projectmanagers: filters.projectmanagers
      },  // Pass the page as a query parameter
      headers: {
        'Authorization': 'Bearer ' + page.props.csrf_token,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    const data = response.data;

    if(data.status === 'success'){
      jobsites.value = data.data.data;
      jobsite_list.value = jobsites.value;
    }else{
      console.error("Error fetching jobsites status is fail");
    }
    loadingJobsites.value = false;
    reload_jobsite_list.value = false;
  } catch (error) {
    loadingJobsites.value = false;
    console.error("Error fetching jobsites: ", error);
  }
}

function handleCreateJobsite(){
  Swal.fire({
    icon: 'info',
    title: 'Notification!',
    text: 'Creating of Jobsite from here coming soon.',
  });
}

function handleSearchJobsite(event){
  if(searchTimeout.value){
    clearTimeout(searchTimeout.value);
  }

  searchJosbite.value = event.target.value;
  searchTimeout.value = setTimeout(() => {
    fetchJobsites(searchJosbite.value,filters.value);
  }, 1000);
}

function handleSelectJobsite(jobsite){
  if(selected_jobsite.value !== null && selected_jobsite.value.jobsite_id === jobsite.jobsite_id){
    selected_jobsite.value = null;
    selectedJobsite.value = {
      cust_id: '',
      jobsite_name: '',
      street: '',
      city: '',
      state: '',
      zipcode: ''
    }
    isDetailsOpen.value = false;
  }else{
    selectedJobsite.value = jobsite;
    isDetailsOpen.value = true;
    selected_jobsite.value = jobsite;
  }
}

onMounted(() => {
  fetchJobsites(searchJosbite.value,filters.value);
});

watch(reload_jobsite_list, (newValue) => {
  if(newValue){
    fetchJobsites(searchJosbite.value,filters.value);
  }
}, { deep: true });

</script>