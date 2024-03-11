<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
/*.fc .fc-button .fc-icon {
  font-size: 1.5em !important;
  margin-top: -11px;
}*/

/*.fc .fc-button-primary {
  background-color: #24695C !important;
  border-color: #24695C !important;
}*/
.fc-button{
  text-transform: capitalize !important;
}
.fc-event{
  cursor: pointer !important;
  background-color: #24695C !important;
  color: #ffffff;
}

/*.fc-list-event:hover td{
  cursor: pointer !important;
  background-color: #24695C !important;
  color: #ffffff;
}*/

/*.fc-event-main {
  background-color: #24695C;
}*/

.fc-timegrid-slot {
  cursor: crosshair;
}
/*.fc-timegrid-slot:hover{
  background-color: #24695C ;
  opacity: 0.6;
}*/

.fc-day:hover .fc-event{
  color: white;
  background-color: #24695C ;
/* //opacity: 0.6; */
}

/*.fc-day:hover {
  background-color: #24695C ;
  opacity: 0.6;
}*/
.close:hover {
  background-color: #24695C;
  color: #FFFFFF;
}
input::placeholder {
  opacity: 0.5;
}

input::placeholder {
  opacity: .5;
}

#file-upload-label:hover {
  cursor: pointer;
}
input[type="range"] {
  accent-color: #24695C;
}

.multiselect__option--highlight {
  background: #24695C !important;
}

/*
.dropzone__message:before{
  content: 'test'
}
*/

#meeting-description {
  font-size: 13px !important;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.errorBorder {
  border-color: #e99aa2 !important;
  /* //box-shadow: inset 0 0 10px #e99aa2;
  //margin: 0; */
}

.select2-container--default .select2-selection--multiple {
  border: 1px solid #e6edef !important;
  color: #717171;
}

.select2-dropdown {
  border: 1px solid #e6edef !important;
}

.select2-results__message {
  color: #717171 !important;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
  border: 1px solid #e6edef !important;
}

.custom-dropzone {
  border: 2px dashed #0f5132 !important;
  cursor: pointer;
}

.centered-on-screen {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 9999;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5) !important;
}
backdrop {
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5) !important;
}

.stage-options:hover {
  background-color: #0f5132 !important;
}

.pac-container {
  z-index: 10000 !important;
}

.daterangepicker {
  z-index: 100000 !important;
}

/*.multiselect__tags {
  border-color: #e99aa2 !important;
}*/

.time-slot-overlay {
  width: 200px;
  height: 50px;
  cursor: pointer !important;
  position: absolute !important;
  background-color: rgba(0, 0, 0, 0) !important;
  z-index: 99999 !important;
}

.custom-alert {
  background-color: #FFFADF; /* Custom color */
  color: #856404; /* Custom text color */
}

/*.fc-toolbar-chunk {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  text-align: center !important;
}*/

.fc-button-group{
  margin-left: 80px !important;
}

.fc-button-group .fc-today-button {
  margin-top: 20px !important;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<template>
  <div class="centered-on-screen" v-if="showLoader">
    <div class="backdrop"></div>
    <div class="d-flex flex-column align-items-center">
      <div style="height: 400px; margin-top: 15%">
        <LoadingMetric></LoadingMetric>
      </div>
    </div>
  </div>
<!--  <div class="p-2 pb-0 mb-0">-->
<!--    <div class="alert alert-warning custom-alert" role="alert">-->
<!--      <p>This is a warning alert—check it out!</p>-->
<!--    </div>-->
<!--  </div>-->
  <div class="row mt-0">
    <div id="full-cal-container" class="col-md-12 h-100" style="padding-right: 0px !important;">
      <div class="card vh-100">
        <div class="card-body pt-2">
          <div id="calendar-alert" class="alert alert-warning custom-alert p-1 rounded mt-2" role="alert">
            <p class="text-black"><i class="icofont icofont-exclamation-circle" style="color: #856404"></i>Your schedule is offline and is unavailable to subs and clients. Notifications will not be sent.</p>
          </div>
          <div class="d-flex flex-row-reverse mt-0">
            <i class="icofont icofont-gear h4 mt-1 txt-primary" style="cursor: pointer" data-bs-toggle="modal" data-original-title="test" data-bs-target="#calendar-settings"></i>
            <div class="media mb-1">
              <div class="media-body text-end switch-sm mr-1 icon-state">
                <label class="switch">
                  <input id="schedule-offline" type="checkbox"><span id="so-color-state" class="switch-state" ></span>
                </label>
              </div>
              <span class="col-form-label m-r-10">Schedule <span id="offline-online"></span></span>
            </div>
          </div>
          <div id="full-calendar"></div>
        </div>
      </div>
    </div>
    <div id="right-section" class="col-md-2 p-0 m-0" >
      <div class="card vh-100 overflow-auto">
        <div class="card-body mx-auto p-4">
          <div class="card-title">
            <button id="exit-right-section" type="button" class="close float-right pr-2 pl-2 rounded" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <p> <span class="txt-success f-w-700" id="appointment-title"></span></p>
          </div>
          <hr>
          <div>
            <p class="m-0"><small><span class="txt-success f-w-700">Full Name: </span><span id="full-name"></span></small></p>
            <p class="m-0"><small><span class="txt-success f-w-700">Phone Number:</span> <span id="phonenumber">+123456789</span></small></p>
            <p class="m-0"><small><span class="txt-success f-w-700">E-mail:</span> <span id="email" class="text-danger">email@email.com</span></small></p>
            <p class="m-0"><small><span class="txt-success f-w-700">Meeting Date:</span> <span id="meeting-date">Nov. 7, 2023</span></small></p>
            <p class="m-0"><small><span class="txt-success f-w-700">Description:</span> <span id="meeting-description"></span></small></p>
            <p class="m-0"><small><span class="txt-success f-w-700">Address:</span> <span id="street-address"></span></small></p>
            <p class="m-0"><small><span class="txt-success f-w-700">Assigned To:</span> <span id="assignee"></span></small></p>
            <p class="m-0"><small><span class="txt-success f-w-700">Guest:</span> <span id="guest"></span></small></p>
          </div>
          <hr>
          <h6 class="card-title mt-2 txt-success">Lead Management</h6>
          <small>
            <label class="form-label" for="">Stage:</label>
            <select id="stage-options-select" class="form-select" v-model="leadManagement.stage" @change="handleStage">
              <option class="stage-options" value="In Progress">In Progress</option>
              <option class="stage-options" value="Follow Up" >Follow Up</option>
              <option class="stage-options" value="Sold" >Sold</option>
            </select>
          </small>
          <p class="mb-0 mt-1 mb-1"><small>Reminder:</small></p>
          <div class="mt-0">
            <small class="">
              <label class="d-block" for="no-reminder">
                <input class="radio_animated" id="no-reminder" type="radio" name="no-reminder" value="0" v-model="withReminder" v-on:change="withReminderYesOrNo">
                <span class="mt-0">No Reminder</span>
              </label>
            </small>
            <small class="">
              <label class="d-block" for="with-reminder">
                <input class="radio_animated" id="with-reminder" type="radio" name="with-reminder" value="1" v-model="withReminder" v-on:change="withReminderYesOrNo">
                <span class="mt-0">Schedule a Reminder</span>
              </label>
              <Transition>
                <div class="schedule-time-and-note" v-if="hideSchedReminder">
                  <div class="form-check">
                    <small>Title:</small>
                    <div class="input-group input-group-sm">
                      <input class="form-control" type="text">
                    </div>
                  </div>
                  <div class="form-check">
                    <small>Schedule Day time:</small>
                    <div class="input-group input-group-sm">
                      <input class="form-control" type="text" id="schedule-reminder-date-and-time">
                    </div>
                  </div>
                </div>
              </Transition>
            </small>
          </div>
          <p class="mb-0"><small>Appointment SMS and Email reminder</small></p>
          <p class="mb-0"><small>Notes</small></p>
          <p class="mb-0"><small>Lead Added on 2023-06-10</small></p>
          <hr>
<!--          <label for="file-upload" class="w-100" id="file-upload-label" style="display: inline">-->
<!--            <div class="card rounded-3">-->
<!--              <div class="card-body text-center">-->
<!--                <i class="fa fa-cloud-upload" style="font-size: 50px; color: #24695C"></i>-->
<!--                <input type="file" id="file-upload" hidden v-on:change="uploadFileName">-->
<!--                <small><input class="w-100 text-center text-muted" placeholder="Upload..." type="text" v-model="fileName" readonly></small>-->
<!--              </div>-->
<!--            </div>-->
<!--          </label>-->

          <button class="btn btn-primary w-100" data-bs-toggle="modal" data-original-title="uploadsModals" data-bs-target="#uploads-modal">View Uploads</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="add-appointment" tabindex="-1" role="dialog" aria-labelledby="add-appointment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex justify-content-start text-center">
            <h5 class="text-muted">Schedule Appointment</h5>
          </div>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form @submit.prevent="saveAppointment" method="POST">
          <div class="modal-body pt-4 pb-4">
            <div class="row">
              <div class="col">
                <div class="row g-3" id="body-content">
                  <div class="col-md-1 mt-0"></div>
                  <div class="col-md-4 mt-0">
                    <input @change="toggleBindJob" class="checkbox_animated mt-3" id="bindJob" type="checkbox">
                    <span class="text-muted">Job</span>
                  </div>
                  <div class="col-md-4 mt-0">
                    <input @change="toggleBindLead" class="checkbox_animated mt-3" id="bindLead" type="checkbox">
                    <span class="text-muted">Lead</span>
                  </div>
                  <div class="col-md-3 mt-0">
                    <input @change="toggleNonWork" class="checkbox_animated mt-3" id="unbindLead" type="checkbox">
                    <span class="text-muted">Non-Work</span>
                  </div>
                  <div v-show="bindLead" class="col-md-1 text-center">
                    <i class="fa fa-search fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div v-show="bindLead" class="col-md-11">
                    <VueMultiselect
                        id="select-lead"
                        placeholder="Select a lead..."
                        label="opportunity_title"
                        track-by="lead_id"
                        :searchable="true"
                        :close-on-select="true"
                        v-model="formData.lead"
                        @select="getLeadId"
                        :options="leadOptions">
                    </VueMultiselect>
                  </div>

                  <div v-show="bindJob" class="col-md-1 text-center">
                    <i class="fa fa-search fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div v-show="bindJob" class="col-md-11">
                    <VueMultiselect
                        id="select-job"
                        placeholder="Select a job..."
                        label="jobsite_name"
                        track-by="lead_id"
                        :searchable="true"
                        :close-on-select="true"
                        :ref="jobsiteName"
                        v-model="formData.jobsite"
                        @select=""
                        :options="jobsiteOptions">
                    </VueMultiselect>
                  </div>

                  <div class="col-md-1 text-center">
                    <i class="fa fa-pencil-square-o fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <input id="title" type="text" class="form-control" placeholder="Title" name="appointment-title" v-model="formData.title">
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-clock-o fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <input class="form-control digits" data-language="en" id="meetingDate" type="text" placeholder="Meeting Date" name="appointment-start-day" readonly>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-location-arrow fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
<!--                    <input id="streetAddress" type="text" class="form-control" placeholder="Street Address" name="appointment-location">-->
                    <vue-google-autocomplete
                        id="street_address_new_appointment"
                        name="street_address_new_appointment"
                        classname="form-control"
                        placeholder="Street Address"
                        @input="newAppointmentAddress"
                        v-on:placechanged="getAddressDataForNewAppointment"
                        :country="['us']"
                        :type="['address']">
                    </vue-google-autocomplete>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-4">
                    <input id="city" type="text" class="form-control" placeholder="City" v-model="formData.city">
                  </div>
                  <div class="col-md-4">
                    <input id="state" type="text" class="form-control" placeholder="State" v-model="formData.state">
                  </div>
                  <div class="col-md-3">
                    <input id="zipcode" type="number" class="form-control" placeholder="Zip Code" v-model="formData.zipcode">
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-user fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <VueMultiselect
                        placeholder="Select a user..."
                        label="display_name"
                        track-by="user_id"
                        id="assignedToUser"
                        :searchable="true"
                        :close-on-select="true"
                        v-model="formData.assignedToUser"
                        @select="getAssignedToId"
                        :options="userOptions">
                    </VueMultiselect>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-users fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <select class="" name="" id="appointment_guests" multiple="multiple" title="Include email addresses, separated by commas(,) to send to your guests that are outside your platform."></select>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-clipboard fa-lg" style="opacity: 0.5; margin-top: 5px"></i>
                  </div>
                  <div class="col-md-11">
                    <textarea class="form-control" name="appointment-note" id="description" rows="5" placeholder="Description" v-model="formData.description"></textarea>
                  </div>
                </div>
              </div>

              <div class="col">
                  <div class="col-md-12">
                    <div class="card mb-3 rounded-2">
                      <div class="card-body justify-content-between align-middle d-flex">
                        <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test" data-bs-target="#email-and-sms-preview">Preview</p>
                        <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test" data-bs-target="#edit-sms-email">Edit</p>
                        <p class="btn btn-danger btn-xs mt-1" style="cursor: context-menu">SMS</p>
                        <div class="media">
                          <div class="media-body text-end icon-state switch-outline">
                            <label class="switch">
                              <input type="checkbox" checked="">
                              <span class="switch-state"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card mb-3 rounded-2">
                      <div class="card-body justify-content-between d-flex">
                        <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test" data-bs-target="#email-and-sms-preview">Preview</p>
                        <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test" data-bs-target="#edit-sms-email">Edit</p>
                        <p class="btn btn-danger btn-xs mt-1" style="cursor: context-menu">Email</p>
                        <div class="media">
                          <div class="media-body text-end icon-state switch-outline">
                            <label class="switch">
                              <input type="checkbox" checked="">
                              <span class="switch-state"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                    <label for="custom-file-upload" class="w-100" id="file-upload-label" style="display: inline">
                      <div class="card mb-0 custom-dropzone rounded" id="custom-dropzone">
                        <div class="card-body">
                          <input type="file" id="custom-file-upload" hidden multiple="multiple" @change="handleFileUpload">
                          <img id="upload-image" :src="uploadIcon" alt="" style="display: block; margin-left: auto; margin-right: auto">
                        </div>
                      </div>
                    </label>
                    <div id="image-container">
                    </div>
                <button class="btn btn-primary w-100 mt-5">Create</button>
              </div>

            </div>
          </div>
<!--          <div class="modal-footer">-->
<!--            <button class="btn btn-primary w-100">Create</button>-->
<!--          </div>-->
        </form>
      </div>
    </div>
  </div>

<!-- uploads modal  -->
  <div class="modal fade" id="uploads-modal" tabindex="-1" role="dialog" aria-labelledby="uploadsModals" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted" id="uploadsModals">Uploads</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row" id="file-holder">

          </div>
        </div>
<!--        <div class="modal-footer">-->
<!--          <div class="col-md-12" id="add-new-upload"><button class="btn btn-primary w-100" >Add</button></div>-->
<!--          <div class="col-md-12" id="save-new-upload"><button class="btn btn-primary w-100" >Save</button></div>-->
<!--        </div>-->
      </div>
    </div>
  </div>

<!-- Settings Modal -->

  <div class="modal fade" id="calendar-settings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted" id="exampleModalLabel">Settings</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card rounded">
            <div class="card-header p-3">
              <div class="card-title m-0 flex">
                <img class="mr-1" src="../../../public/assets/images/google_logo.png" style="width: 22px" alt=""> <span>Google</span></div>
            </div>
            <hr class="p-0 m-0">
            <div class="card-body">
              <div class="row d-flex align-items-center">
                <div class="col">
                  <div class="d-flex align-items-center m-0">
                    <div class="mr-2 d-flex align-items-center" style="border-radius: 50%; width: 60px; height: 60px; box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.19); -webkit-box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.19);-moz-box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.19);">
                      <img class="" src="../../../public/assets/images/calendar_icon.png" style="margin-left: 10px; margin-top: 4px; width: 40px" alt="">
                    </div>
                    <span>Google Calendar</span>
                  </div>
                </div>
                <div class="col">
                  <div class="d-flex align-items-center">
                    <span>Gmail, G Suite</span>
                  </div>
                </div>
                <div class="col text-end">
                  <a href="/auth/google" class="btn btn-pill" style="background-color: #0b5ed7; color: #FFFFFF" v-if="!db_check">Connect</a>
                  <a href="/google/disconnect" class="btn btn-pill" style="background-color: red; color: #FFFFFF" v-if="db_check">Disconnect</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal for schedule-offline -->
  <div class="modal fade" id="schedule-offline-modal" tabindex="-1" role="dialog" aria-labelledby="scheduleOffline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body p-5">
          <h6 class="mb-3 d-flex items-center"><i class="fa fa-check-circle mr-4 h4" style="color: #47cf73"></i><span class="mb-1">Your Schedule is now online</span></h6>
          <ul style="margin-left: 50px">
            <li style="list-style-type: circle">Notifications and reminders will be sent as scheduled</li>
            <li style="list-style-type: circle">Subs/Vendors and the Owner can see schedule items if permitted</li>
            <li style="list-style-type: circle">Schedule items cannot be modified directly in the Calendar and Gantt tabs</li>
          </ul>
          <label class="d-block mt-3" for="chk-ani">
            <input class="checkbox_animated" id="chk-ani" type="checkbox">
            <small>Hide future online/offline alerts</small>
          </label>
        </div>
        <div class="modal-footer border-0 mt-0 pt-0">
          <button class="btn" style="background-color: #0b5ed7 !important; color: white" type="button" @click="toggleSchedule">Ok</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal preview for SMS and Email template -->
  <div class="modal fade" id="email-and-sms-preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">SMS / E-Mail</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Modal preview of SMS and Email template here...
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<!-- Edit Modal -->
  <div class="modal fade" id="edit-sms-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit SMS / Email </h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <templates></templates>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


</template>

<script setup>
import LoadingMetric from '@/components/LoadingStyleMetric.vue';
import templates from '@/Pages/Templates.vue';
import VueGoogleAutocomplete from "vue-google-autocomplete";
import {reload_jobsite_list, selected_jobsite} from '../globalState';
import { ref, watch} from "vue";

const blockPage = ref(true)
let jobsiteName = ''

if (selected_jobsite.value != null) {
  jobsiteName = ref(selected_jobsite.value.jobsite_name)
} else {
  blockPage.value = false
}

watch(selected_jobsite, (val) => {
  jobsiteName = val.jobsite_name
  blockPage.value = true
})

watch(reload_jobsite_list, (newValue) => {
  // console.log(newValue)
  jobsiteName = val.jobsite_name
  blockPage.value = true
}, { deep: true });

</script>

<script>

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import axios from "axios";
import Datepicker from 'vue3-datepicker';
import VueMultiselect from 'vue-multiselect';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import Dropzone from "dropzone";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Swal from "sweetalert2";

export default {
  components: {
    Datepicker,
    VueMultiselect
  },
  props: ['customData', 'leads', 'users', 'jobsites', 'google_cal', 'db_check', 'check_dis'],
  data() {
    return {
      uploadIcon: window.location.origin + '/assets/images/upload-100.png',
      deleteIcon: window.location.origin + '/assets/images/delete.png',
      showLoader: false,
      bindLead: false,
      bindJob: false,
      nonWork: false,
      selected: null,
      leadOptions: this.leads,
      userOptions: this.users,
      jobsiteOptions: this.jobsites,
      showCalendar : false,
      show : false,
      toggleIsAllDay: true,
      withReminder: 0,
      hideSchedReminder: false,
      formData: {
        jobsite: '',
        leadId: '',
        lead: '',
        title: '',
        meetingDate: '',
        // dateStartTime: '',
        // dateEnd: '',
        // dateEndTime: '',
        streetAddress: '',
        city: '',
        state: '',
        zipcode: '',
        // isAllDay: '',
        assignedToUser: '',
        assignedToUserId: '',
        guest: '',
        description: '',
        fileName: '',
        file: []
      },
      leadManagement: {
        stage: ''
      },
      additionalUpload: {
        saveIsOn: true,
        onSave: false
      },
      calendarSelect: true
    }
  },
  methods: {
    toggleSchedule: function() {
      $('#schedule-offline-modal').modal('hide')
      $('#calendar-alert').hide()
    },
    getAddressDataForNewAppointment: function(addressData, placeResultData, id) {
      const placeAddress = placeResultData.address_components

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
            if (id === "street_address_new_appointment")
              this.formData.zipcode = component.long_name;
            else
              this.formData.zipcode = component.long_name;
            break;
          case "administrative_area_level_1":
            if (id === "street_address_new_appointment")
              this.formData.state = component.long_name;
            else
              this.formData.state =  component.long_name
            break;
          case "administrative_area_level_2":
            if (id === "street_address_new_appointment")
              this.formData.state = component.long_name;
            else
              this.formData.state =  component.long_name
            break;
          case "neighborhood":
            if (id === "street_address_new_appointment")
              this.formData.city = component.long_name;
            else
              this.formData.city = component.long_name
            break;
        }
      }

      if(streetAddress){
        if (id === "street_address_new_appointment"){
          $('#street_address_new_appointment').val(streetAddress);
          this.formData.streetAddress = streetAddress;
        }
      }
    },
    newAppointmentAddress: function() {
      this.formData.streetAddress = event.target.value
    },
    addNewUpload: function() {
      $('.info-message').hide()
      this.additionalUpload.onSave = !this.additionalUpload.onSave
      this.additionalUpload.saveIsOn = !this.additionalUpload.saveIsOn
    },
    saveNewUpload: function() {

    },
    handleStage: function(info) {
      // console.log(this.leadManagement.stage)
    },
    fileChange: function(e) {
      this.file = e.target.files[0]
    },
    saveUpload: function() {
      // const formData = new FormData()
      // formData.append('file[]', this.formData.file)

      // axios.post('/calendar/save-file-upload', formData).then((res) => {
      //   console.log(res)
      // })
    },
    async saveAppointment() {

      this.formData.guest = $('#appointment_guests').val().join(', ')
      const form = new FormData()
      form.append('file[]', this.formData.file)

      try {
        this.showLoader = true
        let errorCount = this.validateRequiredFields(this.formData, ['description','zipcode', 'state', 'city', 'streetAddress', 'meetingDate', 'jobsite', 'leadId', 'lead', 'guest', 'fileName', 'file'])
        if(errorCount > 0) {
          if(errorCount === 1) {
            toast.error('Field is required!')
          } else {
            toast.error('Fields are required!')
          }
        } else {
          await axios.post('/calendar/save-appointment', this.formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          }).then((response) => {
            if (response.status == 201) {
              $('#add-appointment').modal('hide')
              toast.success('Appointment Added!')
              location.reload()
            }
          })
              .catch((error) => {
                console.log(error)
              })
        }
      } catch (error) {
        console.log(error)
      } finally {
        this.showLoader = false
      }

    },
    isAllDayChecked: function() {
      this.toggleIsAllDay = !this.toggleIsAllDay;
    },
    withReminderYesOrNo: function(info) {
      if(info.target.value == 1)
        this.hideSchedReminder = true
      else
        this.hideSchedReminder = false
    },
    uploadFileName: function(info) {
      this.formData.fileName = info.target.files[0].name
    },
    getLeadId: function(info) {
      this.formData.leadId = info.lead_id
    },
    getAssignedToId: function(info) {
      this.formData.assignedToUserId = info.user_id
    },
    toggleBindLead: function(info) {
      $('#street_address_new_appointment').val('')
      this.formData.city = ''
      this.formData.state = ''
      this.formData.zipcode = ''
      this.bindLead = !this.bindLead
      this.bindJob = false
      $('#unbindLead').prop('checked', false)
      $('#bindJob').prop('checked', false)
    },
    toggleBindJob: function() {
      if (selected_jobsite.value) {
        $('#street_address_new_appointment').val(selected_jobsite.value.street)
        this.formData.city = selected_jobsite.value.city
        this.formData.state = selected_jobsite.value.state
        this.formData.zipcode = selected_jobsite.value.zipcode
      }

      this.bindJob = !this.bindJob
      this.bindLead = false
      $('#bindLead').prop('checked', false)
      $('#unbindLead').prop('checked', false)
    },
    toggleNonWork: function() {
      if (this.bindLead) {
        $('#street_address_new_appointment').val('')
        this.formData.city = ''
        this.formData.state = ''
        this.formData.zipcode = ''
        this.bindLead = !this.bindLead
        $('#bindLead').prop('checked', false)
      }
      if (this.bindJob) {
        $('#street_address_new_appointment').val('')
        this.formData.city = ''
        this.formData.state = ''
        this.formData.zipcode = ''
        this.bindJob = !this.bindJob
        $('#bindJob').prop('checked', false)
      }
      if (this.bindLead && this.bindJob){
        $('#street_address_new_appointment').val('')
        this.formData.city = ''
        this.formData.state = ''
        this.formData.zipcode = ''
        this.bindLead = !this.bindLead
        this.bindJob = !this.bindJob
        $('#bindLead').prop('checked', false)
        $('#bindJob').prop('checked', false)
      }
    },
    validateRequiredFields: function(fields, exceptKey) {
      let countError = 0;

      $.each(fields, function(key, value) {
        let i = $.inArray(key, exceptKey)
        if (i === -1 && value.length === 0 ) {
          countError++
          if (key == 'assignedToUser') {
            $('.multiselect__tags').addClass('errorBorder')
          }
          $('#'+key).addClass('errorBorder')
        } else {
          if (key == 'assignedToUser') {
            $('.multiselect__tags').removeClass('errorBorder')
          }
          $('#'+key).removeClass('errorBorder')
        }
      })
      return countError
    },
    manageFileUpload: function() {
      let thisInstance = this
      $(document).on('click', '.delete-icon', function(){
        $(this).parent().remove();

        let dataArray = thisInstance.formData.file
        let keyId = $(this).attr('image-name')

        $.each(dataArray, function(key, val) {
          let keyTobeRemove = dataArray.indexOf(key)
          if (val.name == keyId) {
            dataArray.splice(keyTobeRemove, 1)
          }
        })
      })

      $(document).on('mouseover', '.delete-icon', function(){
        $(this).siblings().addClass('opacity');
      })

      $(document).on('mouseout', '.delete-icon', function(){
        $(this).siblings().removeClass('opacity');
      })

      document.getElementById('custom-dropzone').addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        let file = e.dataTransfer.files;
        // uploadFile(file);
        filePreview(file)
      });

      document.getElementById('custom-dropzone').addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        let file = e.dataTransfer.files;
        // uploadFile(file);
        filePreview(file)
      });

      let keyId = []
      document.getElementById('custom-file-upload').addEventListener('change', function(e) {
        let file = e.target.files;
        // uploadFile(file);
        filePreview(file)
      });

      function filePreview(file) {
        let imageCount = 0
        for (let i = 0; i < file.length; i++) {
          imageCount++
          let uniqueId = Math.floor(Math.random() * (0x10FFFF - 0x20 + 1)) + 0x20
          let reader = new FileReader();
          reader.onload = function(e) {
            let img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.marginRight = '5px'
            img.style.marginBottom = '5px'
            img.style.borderRadius = '10px'
            img.style.position = 'relative'
            img.classList.add('images-item')

            let removeItem = document.createElement('a')
            removeItem.innerText = 'Remove'
            removeItem.setAttribute('image-name', file[0].name)
            removeItem.style.marginLeft = '18px'
            removeItem.classList.add('delete-icon')

            let imageContainer = document.createElement('div')
            imageContainer.style.position = 'relative'
            imageContainer.style.display = 'inline-block'
            imageContainer.style.zIndex = '99999'
            imageContainer.style.padding = '10px'
            imageContainer.setAttribute('id', 'image-block-container-' + uniqueId)

            document.getElementById('image-container').appendChild(imageContainer);
            document.getElementById('image-block-container-'+ uniqueId).appendChild(img);
            document.getElementById('image-block-container-'+ uniqueId).appendChild(removeItem);
          };
          reader.readAsDataURL(file[i]);
        }
      }
    },
    handleFileUpload: function() {
     let files = event.target.files

      for (let i = 0; i < files.length; i++) {
        this.formData.file.push(files[i]);
      }
    },
    handlePreviewOrAddUpload: function(appointmentId) {
      $('#file-holder').empty()
      axios.get('/calendar/get-upload', {params:{appointmentId:appointmentId}}, {
        timeout: 1000,
        headers: {
          'Content-Type': 'multipart/form-data',
          'Access-Control-Allow-Origin': '*'
        }
      }).then(response => {

        if (response.data.length <= 0 && !$('#file-holder').has('.info-message').length) {
          $('#file-holder').append('<div class="col-md-12 info-message"><div class="alert alert-light dark mb-0" role="alert"><p class="text-muted">No files available.</p></div></div>')
        }

        $.each(response.data, function(key, val) {
          $('#file-holder').append('<div class="col-md-4"><img class="rounded mb-2" style="width: 200px; height: 200px;" src="'+val+'" alt=""></div>')
          $('#save-new-upload').hide()
        })

      });
    }
  },
  beforeMount: function() {
  },
  mounted: function() {

    if (this.google_cal) {
      Swal.fire({
        text: "Success! Google Calendar is now connected.",
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn btn-success"
        }
      })
    }

    if (this.check_dis) {
      Swal.fire({
        text: "Success! Google Calendar is now Disconnected.",
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn btn-success"
        }
      })
    }

    let preSelectedJob = ''
    if (selected_jobsite.value) {
      preSelectedJob = selected_jobsite.value.jobsite_name
    }

    this.formData.jobsite = this.jobsiteOptions.find(option => option.jobsite_name === preSelectedJob);

    let selfie = this

    $('#save-new-upload').hide()

    $(document).on('click', '#add-new-upload', function() {
      $('#save-new-upload').show()
      $('.info-message').hide()
      $('#additional-file-upload-label').show()
      $('#file-holder').append('<label for="additional-upload" class="w-100" id="additional-file-upload-label" style="display: inline">\n' +
          '              <div class="card mb-0 custom-dropzone rounded" id="additional">\n' +
          '                <div class="card-body">\n' +
          '                  <input type="file" id="additional-upload" hidden multiple="multiple" @change="handleFileUpload">\n' +
          '                  <img id="upload-image" src="'+selfie.uploadIcon+'" alt="" style="display: block; margin-left: auto; margin-right: auto">\n' +
          '                </div>\n' +
          '              </div>\n' +
          '            </label>\n' +
          '            <div id="image-container">\n' +
          '            </div>')
      $(this).hide()
    })

    this.manageFileUpload()
    $('#appointment_guests').select2({
      tags: true,
      tokenSeparators: [','],
      createTag: function(params) {
        let term = $.trim(params.term);

        if (term === '') {
          return null;
        }

        return {
          id: term,
          text: term
        };
      }
    });
    $('html, body').css({
      overflow: 'hidden',
      height: '100%'
    });

    let calCon = $('#full-cal-container')
    let rightSection = $('#right-section')

    rightSection.hide()

    // $('#custom-datepicker').datepicker()
    //Initialize datepicker
    $('#custom-datepicker').datepicker({
      language: "en",
      format: "yyyy-mm-dd",
      weekStart: 0,
      // defaultDate: '2023-09-22',
      minDate: new Date(new Date().setDate(new Date().getDate() - 730)),
      maxDate: new Date(new Date().setDate(new Date().getDate() + 730)),
      maxViewMode: 2,
      minViewMode: 0,
      todayHighlight: true,
      onSelect: function (selectedDate) {
        // let selected = date.datepicker("getDate")
        if ($('#custom-datepicker').val()) {
          calendar.gotoDate(new Date(selectedDate))
          calendar.select(new Date(selectedDate))
        }
      }
    });

    $('#meetingDate').daterangepicker({
      language: "en",
      autoClose: true,
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY h:mm A'
      },
      onSelect: function(date) {
        selfie.formData.meetingDate = new Date(date)
      }
    })

      let dateId = null
      let lastSelectionInfo = null
      let dateClick = null
      // Initialize full calendar
      let calendarEl = document.getElementById('full-calendar')
      let calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        initialView: 'timeGridWeek',
        allDaySlot: false,
        height: $(window).height() - 130,
        stickyHeaderDates: true,
        selectable: selfie.calendarSelect,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        headerToolbar: {
          left: 'addEvent',
          center: 'title prev,next today',
          right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        customButtons: {
          addEvent: {
            text: 'Add Schedule',
            click: function (ev, element) {
              $('#add-appointment').modal('show')
              let selectedJob = ''
              if (selected_jobsite.value) {
                $('#street_address_new_appointment').val(selected_jobsite.value.street)
                selfie.formData.city = selected_jobsite.value.city
                selfie.formData.state = selected_jobsite.value.state
                selfie.formData.zipcode = selected_jobsite.value.zipcode
                selectedJob = selected_jobsite.value.jobsite_id
              }
              selfie.formData.jobsite = selfie.jobsiteOptions.find(option => option.jobsite_id === selectedJob);
            }
          }
        },
        events: this.customData,
        select: function(info) {
          let element = document.querySelector('.fc-event-main');
          let overlay = document.createElement('div');
          overlay.className = 'time-slot-overlay';
          overlay.style.top = element.getBoundingClientRect().y + 'px';
          overlay.style.left = element.getBoundingClientRect().x + 'px';
          overlay.style.width = '210px';
          overlay.style.height = '20px';
          document.body.appendChild(overlay);

          $('.time-slot-overlay').on('click', function() {
            let selectedJob = ''
            if (selected_jobsite.value) {
              // $('#street_address_new_appointment').val(selected_jobsite.value.street)
              // selfie.formData.city = selected_jobsite.value.city
              // selfie.formData.state = selected_jobsite.value.state
              // selfie.formData.zipcode = selected_jobsite.value.zipcode
              selectedJob = selected_jobsite.value.jobsite_id
            }
            selfie.formData.jobsite = selfie.jobsiteOptions.find(option => option.jobsite_id === selectedJob);
            $('#add-appointment').modal('show')
            calendar.unselect();
            $(this).remove()
          })
        },
        dateClick: function (calDate) {
          dateClick = calDate.date
          // console.log(new Date(calDate.date).toLocaleDateString())
          // let stDate = new Date(calDate.date).toLocaleDateString('en-US', {
          //   day: '2-digit',
          //   month: '2-digit',
          //   year: 'numeric',
          // })
          //
          //  $('#appointment-start-day').val(stDate)
          // $('#add-appointment').modal('show')
          let selectedJob = ''
          if (selected_jobsite.value) {
            selectedJob = selected_jobsite.value.jobsite_name
          }
          selfie.formData.jobsite = selfie.jobsiteOptions.find(option => option.jobsite_name === selectedJob);
          // date.datepicker({dateFormat: 'yy-mm-dd'})
          // $('#custom-datepicker').datepicker("setDate", new Date(calDate.date).toLocaleDateString())
          // console.log($('#custom-datepicker').datepicker('getDates'))
          // date.datepicker("setDate", new Date('2023-20-09'))
        },
        eventClick: function (info) {
          // console.log(info.event._def)
          // console.log(info.event._def.extendedProps)
          selfie.handlePreviewOrAddUpload(info.event._def.extendedProps.appointment_id)
          calCon.removeClass('col-md-12').addClass('col-md-10')
          rightSection.fadeIn().show()
          $('#full-name').text(info.event._def.extendedProps.cx_name)
          $('#phonenumber').text(info.event._def.extendedProps.opportunity_phone)
          $('#email').text(info.event._def.extendedProps.email)
          $('#appointment-title').text(info.event._def.title)
          $('#meeting-description').text(info.event._def.extendedProps.description)
          $('#state').text(info.event._def.extendedProps.state)
          $('#street-address').text(info.event._def.extendedProps.street + ' ' + info.event._def.extendedProps.city + ' ' + info.event._def.extendedProps.state + ' ' + info.event._def.extendedProps.zipcode)
          $('#city').text(info.event._def.extendedProps.city)
          $('#zip-code').text(info.event._def.extendedProps.zipcode)
          $('#assignee').text(info.event._def.extendedProps.assign_to)
          $('#guest').text(info.event._def.extendedProps.guests)
          $('#stage-options-select').text(info.event._def.extendedProps.stage)
        }
      });

      $('#exit-right-section').on('click', function () {
        router.reload()
        rightSection.hide()
        calendar.updateSize()
        calCon.removeClass('col-md-10').addClass('col-md-12')
      });

      $('#appointment-date-end').datepicker({
        language: "en"
      })

      $('#schedule-reminder-date-and-time').datepicker()

      calendar.render()

    $('#add-appointment').on('hidden.bs.modal',function(e) {
      selfie.bindLead = false
      selfie.bindJob = false
      selfie.nonWork = false
      $('#bindJob').prop('checked', false)
      $('#bindLead').prop('checked', false)
      $('#unbindLead').prop('checked', false)
      $('#street_address_new_appointment').val('')
      selfie.formData.city = ''
      selfie.formData.state = ''
      selfie.formData.zipcode = ''
    })

    $('#so-color-state').addClass('bg-info')
    $('#offline-online').text('Offline')
    $('#schedule-offline').on('change', function() {
      if (this.checked) {
        $('#offline-online').text('Online')
        $('#schedule-offline-modal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#schedule-offline-modal').modal('show')
        $('#so-color-state').removeClass('bg-info').css('background-color', '#0b5ed7')
      } else {
        $('#offline-online').text('Offline')
        $('#calendar-alert').show()
        $('#so-color-state').addClass('bg-info')
      }
    })

  },
  created() {
    axios.interceptors.request.use(
        config => {
          let token = document.head.querySelector('meta[name="csrf-token"]');
          if (token) {
            config.headers['X-CSRF-TOKEN'] = token.content;
          }
          return config;
        },
        error => Promise.reject(error)
    );
  }
}


</script>
