<style scoped>
  .installers-tab {
    font-family: Arial, sans-serif;
  }

  .view-all-check {
    text-align: center;
    margin-top: 1rem;
    /* margin-bottom: 1rem; */
    color: black;
  }
  .installers-list th {
    /* font-size: 0.75rem; */
    text-align: center;
    color: #6c757d;
  }
  .form-check.form-switch {
    float: right;
  }

  .form-check-input {
    width: 34px;
    height: 19px;
    margin-left: 0;
    cursor: pointer;
  }

  .form-check-input:checked {
    /* background-color: #4CAF50; */
    border-color: #007bff;
  }

  /* Correct the toggle switch label size */
  .form-check-label {
    display: block;
    width: 34px;
    height: 19px;
    background: inherit;
  }

  .disabled-slot {
      background-color: #8c8b90;
      pointer-events: none; /* Optionally disable clicking */
  }

  .event-details {
    position: absolute;
    background: white;
    border: 1px solid #000000;
    padding: 2px;
    z-index: 1000;
    /* Adjust the style as per your requirement */
  }

  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    border: none;
    background-color: transparent;
    cursor: pointer;
    /* Style as needed */
  }

  .v-enter-active,
  .v-leave-active {
    transition: opacity 0.5s ease;
  }

  .v-enter-from,
  .v-leave-to {
    opacity: 0;
  }

  .fc >>> .fc-button-primary {
    background-color: #1E5BB2 !important;
    border-color: #1E5BB2 !important;
  }
  .fc-button{
    text-transform: capitalize !important;
  }
  .fc-event{
    cursor: pointer !important;
    background-color: #1E5BB2 !important;
    color: #ffffff;
  }

  .fc-timegrid-slot {
    cursor: crosshair;
  }

  .fc-day:hover .fc-event{
    color: white;
    background-color: #1E5BB2 ;
  /* //opacity: 0.6; */
  }

  .close:hover {
    background-color: #1E5BB2;
    color: #1E5BB2;
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
    accent-color: #1E5BB2;
  }

  .multiselect__option--highlight {
    background: #1E5BB2 !important;
  }

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
    border: 2px dashed #1E5BB2 !important;
    cursor: pointer;
  }

  .stage-options:hover {
    background-color: #1E5BB2 !important;
  }

  .pac-container {
    z-index: 10000 !important;
  }

  .daterangepicker {
    z-index: 100000 !important;
  }

  .custom-alert {
    background-color: #FFFADF; /* Custom color */
    color: #856404; /* Custom text color */
  }

  .fc-button-group{
    margin-left: 80px !important;
  }

  .fc-button-group .fc-today-button {
    margin-top: 20px !important;
  }

  .nav-pills .nav-link.active {
    background-color: #1e5bb2 !important;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 18px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: white;
    transition: .4s;
    border: 3px solid #1e5bb2;
    border-radius: 34px;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 10px;
    width: 10px;
    left: 1px;
    bottom: 1px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
    border: 3px solid #1e5bb2;
  }

  input:checked + .slider {
    background-color: white;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    transform: translateX(12px);
  }

  
.nav-tabs .nav-link {
  border: none !important;
  color: #000000 !important;
  font-size: 16px !important;
}

.nav-tabs .nav-link:hover {
  border: none !important;
}

.nav-tabs .nav-link.active {
  color: #1e5bb2 !important;
  font-weight: bold !important;
  background-color: transparent !important;
  /* border-bottom: 1px solid !important; */
}
.nav-tabs {
  border-bottom: 1px solid #b3b4b6 !important;
}

</style>

<template>
  <div>
    <div class="row">
        <div class="col-md-4 d-flex">
            <div class="card w-100">
                <div class="card-header m-0 pb-0">
                  <div class="card-title flex  mb-0 pb-0"> <h6>Vehicle Tracking</h6> </div>
                </div>
                <div class="card-body pt-0">
                  <!-- Google calendar -->
                  <div class="p-3 pt-0 rounded-3"><googleMap></googleMap></div>

                  <div class="p-3 bg-gray rounded-3">
                    <ul class="nav nav-tabs bg-gray">
                      <li class="nav-item" v-for="tab in tabs" :key="tab.id">
                          <!-- <a class="nav-link active" href="#">Details</a> -->
                          <a class="nav-link" :class="{ active: activeTab === tab.id }" href="#" @click.prevent="setActiveTab(tab.id)" >
                          {{ tab.name }}
                        </a>
                      </li>
                    </ul>
                    <div class="installers-tab">
                      <div class="view-all-check ">
                        See your installers schedule. Share it with them too.
                        <hr style="background-color: #A2C5F6; width: 100%;">
                      </div>
                      <div class="d-flex justify-content-between align-items-center  mb-2">
                        <div>
                          <CheckboxStyle :checkboxId="'0'" :initialColor="'#000000'"></CheckboxStyle>
                          <div style="margin-left: 30px; margin-top: -10px;">
                            <span class="view-all-check pl-4 ml-4"> <strong> View All </strong></span>
                          </div>
                        </div>

                        <div class="view-all-check" style="margin-top: -2px;"> <strong> Schedule Shared</strong></div>
                      </div>
                      <div v-for="installer in installers" :key="installer.id" class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                          <CheckboxStyle :checkboxId="installer.id" :initialColor="installer.statusColor"></CheckboxStyle>
                          <div style="margin-left: 30px; margin-top: -10px;">
                            <span class="ml-3" :style="{ color: installer.statusColor }"> <strong>{{ installer.name }}</strong>  </span>

                          </div>
                        </div>

                        <label class="switch">
                          <input type="checkbox" :id="`schedule${installer.id}`" checked>
                          <span class="slider"></span>
                        </label>
                      </div>
                      </div>
                  </div>

                </div>
            </div>
        </div>

        <div class="col-md-8 d-flex">
            <div class="card w-100">
                <div class="card-header mb-0 pb-0">
                  <div class="card-title flex  mb-0 pb-0"> <h6>Check the Schedule</h6> </div>
                </div>
                <div class="card-body">
                  <div id="full-calendar">
                    <FullCalendar ref="fullCalendar" :options="calendarOptions" style="height: 500px;"/>
                  </div>
                  <div v-if="selectedEvent" class="event-details" ref="eventDetails" >
                    <button class="close-button" @click="closeEventDetails">X</button> <!-- Close button -->
                    <h5>Event Details</h5>
                    <!-- <p>Appointment ID: {{ selectedEvent.extendedProps.appointment_id }}</p> -->
                    <p><strong>{{ this.selectedEvent.extendedProps.entityType }}</strong></p>
                    <p>Title: {{ selectedEvent.title }}</p>
                    <p>Description: {{ selectedEvent.extendedProps.description }}</p>
                    <p>Start: {{ formatDate(selectedEvent.start) }}</p>
                    <p>End: {{ formatDate(selectedEvent.end) }}</p>

                    <button class="btn btn-primary w-100 mt-5" @click.prevent="EditScheduleClick">Edit</button>
                    <!-- Add more details as needed -->
                  </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add appointment modal -->

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
                      <input @change="toggleBindJob" class="checkbox_animated mt-3" id="bindJob" type="checkbox" v-model="bindJob">
                      <span class="text-muted">Job</span>
                    </div>
                    <div class="col-md-4 mt-0">
                      <input @change="toggleBindLead" class="checkbox_animated mt-3" id="bindLead" type="checkbox" v-model="bindLead">
                      <span class="text-muted">Lead</span>
                    </div>
                    <div class="col-md-3 mt-0">
                      <input @change="toggleNonWork" class="checkbox_animated mt-3" id="unbindLead" type="checkbox" v-model="nonwork">
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
                          v-model="formData.jobsite"
                          @select="getJobId"
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
                      <VueGoogleAutocomplete
                          id="street_address_new_appointment"
                          name="street_address_new_appointment"
                          classname="form-control"
                          placeholder="Street Address"
                          @input="newAppointmentAddress"
                          v-on:placechanged="getAddressDataForNewAppointment"
                          :country="['us']"
                          :type="['address']">
                      </VueGoogleAutocomplete>
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
                                <input type="checkbox" v-model = "formData.reminder_sms">
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
                                <input type="checkbox" v-model = "formData.reminder_email">
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
          </form>
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
            <EditTemplate></EditTemplate>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import { INITIAL_EVENTS } from "@/stores/calender";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import googleCalendarPlugin from "@fullcalendar/google-calendar";
import axios from 'axios';
import Swal from 'sweetalert2';

import { toast } from 'vue3-toastify';
import LoadingMetric from '@/components/LoadingStyleMetric.vue';
import CheckboxStyle from '@/components/form/CheckboxStyle.vue';
import EditTemplate from '@/Pages/Templates.vue';
import VueMultiselect from 'vue-multiselect';
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Datepicker from 'vue3-datepicker';
import {reload_jobsite_list, selected_jobsite} from '../globalState';

import Select2 from './Select2.vue';

import { useCalendarScheduleSidebar } from '../stores/calendar-schedule';
import { usePage } from '@inertiajs/inertia-vue3';
import googleMap from '../components/calendar/GoogleMap.vue'

export default {
  components: {
    FullCalendar,
    LoadingMetric,
    EditTemplate,
    Datepicker,
    VueMultiselect,
    VueGoogleAutocomplete,
    Select2,
    googleMap,
    CheckboxStyle
  },
  props: {
    heigth: {
      type: [Number],
      default: 980
    },
    initialView: {
      type: [String],
      default: "timeGridWeek"
    },
    setDate: {
      type: [String],
      default: new Date()
    },
    showsidebar: {
      type: [Boolean],
      default: true
    },
    showtitle: {
      type: [Boolean],
      default: true
    },
    showAddButton: {
      type: [Boolean],
      default: true
    },
    enableScheduleAppointment: {
      type: [Boolean],
      default: true
    },
    salePersons:{
      type: [Array],
      default: []
    }
  },
  data() {
    const selfie = this;
    return {
      clickCount: 0,
      lastClickedTime: null,
      activeTab: 'installers', // Default active tab
      tabs: [
        { id: 'installers', name: 'Installers', content: 'Content for Installers...' },
        { id: 'users', name: 'Users', content: 'Content for Users...' },
        { id: 'all', name: 'All', content: 'Content for All...' }
      ],
      installers: [
        { id: 1, name: 'Installer 01', statusColor: '#1E5BB2' },
        { id: 2, name: 'Installer 02', statusColor: '#1EB23F' },
        { id: 3, name: 'Installer 03', statusColor: '#B21E1E' },
        { id: 4, name: 'Installer 04', statusColor: '#E38D02' },
        { id: 5, name: 'Installer 05', statusColor: '#00060F' }
      ],
      events: [],
      selectedEvent: null,
      lastSelectedEvent: null,
      unSelectedEvent: [],
      selectedCount: 0,
      uploadIcon: window.location.origin + '/assets/images/upload-100.png',
      deleteIcon: window.location.origin + '/assets/images/delete.png',
      showLoader: false,
      bindLead: false,
      bindJob: false,
      nonWork: true,
      selected: null,
      leadOptions: [],
      userOptions: [],
      jobsiteOptions: [],
      showCalendar : false,
      show : false,
      toggleIsAllDay: true,
      withReminder: 0,
      hideSchedReminder: false,
      dateClick: null,
      formData: {
        appointment_id: '',
        jobsite: '',
        leadId: '',
        lead: '',
        title: '',
        startDate: '',
        endDate: '',
        streetAddress: '',
        city: '',
        state: '',
        zipcode: '',
        assignedToUser: '',
        assignedToUserId: '',
        guest: '',
        description: '',
        fileName: '',
        reminder_sms: false,
        reminder_email: true,
        entityType: 'non-work',
        entityId: 0,
        file: []
      },
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, googleCalendarPlugin],
        initialView: this.initialView,
        scrollTime: '08:00:00',
        dateClick: "",
        initialEvents: INITIAL_EVENTS,
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        height: this.heigth,
        headerToolbar: {
          left: this.showAddButton ? "addEvent prev,next today" : "prev,next today",
          center: "title",
          right: this.showAddButton ? "dayGridMonth,timeGridWeek,timeGridDay": "",
        },
        businessHours: {
          daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
          startTime: '08:00',
          endTime: '18:00',
        },
        slotLabelFormat: [
          { hour: '2-digit', minute: '2-digit', hour12: false }
        ],
        // slotLaneContent: function(arg) {
        //   if (!selfie.isInBusinessHours(arg.date)) {
        //     return { domNodes: [selfie.createNonBusinessHoursContent()] };
        //   }
        // },
        customButtons: {
          addEvent: {
            text: 'Add Schedule',
            click: function (ev, element) {
              selfie.bindJob = false;
              selfie.bindLead = false;
              selfie.nonWork = true;
              selfie.formData.appointment_id = "";
              selfie.formData.jobsite = "";
              selfie.formData.leadId = "";
              selfie.formData.lead = "";
              selfie.formData.title = "";
              selfie.formData.startDate = "";
              selfie.formData.endDate = "";
              selfie.formData.streetAddress = "";
              selfie.formData.city = "";
              selfie.formData.state = "";
              selfie.formData.zipcode = "";
              selfie.formData.assignedToUser = "";
              selfie.formData.assignedToUserId = "";
              selfie.formData.guest = "";
              selfie.formData.description = "";
              selfie.formData.fileName = "";
              selfie.formData.reminder_sms = false;
              selfie.formData.reminder_email = true;
              selfie.formData.entityType = 'non-work';
              selfie.formData.entityId = 0;
              selfie.formData.file = [];
              $('#add-appointment').modal('show')
            }
          }
        },
        eventSources: [],
        datesSet: function () {
          console.log("Data Set");
          let dayHeaders = document.querySelectorAll('.fc-col-header-cell');

          dayHeaders.forEach(function (header) {
            var existingIcon = header.querySelector('.weather_icon');
            // Create your SVG element or any other custom content here
            if (!existingIcon) {
              var customContent = document.createElement('span'); // For example, a span element
              customContent.innerHTML = '<svg class="climacon climacon_sun" id="sun" version="1.1" viewBox="15 15 70 70" style="width: 50px; height: 50px">\n' +
                  '                          <clippath id="sunFillClip">\n' +
                  '                            <path d="M0,0v100h100V0H0z M50.001,57.999c-4.417,0-8-3.582-8-7.999c0-4.418,3.582-7.999,8-7.999s7.998,3.581,7.998,7.999C57.999,54.417,54.418,57.999,50.001,57.999z"></path>\n' +
                  '                          </clippath>\n' +
                  '                          <g class="climacon_iconWrap climacon_iconWrap-sun">\n' +
                  '                            <g class="climacon_componentWrap ">\n' +
                  '                              <g class="climacon_componentWrap climacon_componentWrap-sunSpoke">\n' +
                  '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-east" d="M72.03,51.999h-3.998c-1.105,0-2-0.896-2-1.999s0.895-2,2-2h3.998c1.104,0,2,0.896,2,2S73.136,51.999,72.03,51.999z"></path>\n' +
                  '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-northEast" d="M64.175,38.688c-0.781,0.781-2.049,0.781-2.828,0c-0.781-0.781-0.781-2.047,0-2.828l2.828-2.828c0.779-0.781,2.047-0.781,2.828,0c0.779,0.781,0.779,2.047,0,2.828L64.175,38.688z"></path>\n' +
                  '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north" d="M50.034,34.002c-1.105,0-2-0.896-2-2v-3.999c0-1.104,0.895-2,2-2c1.104,0,2,0.896,2,2v3.999C52.034,33.106,51.136,34.002,50.034,34.002z"></path>\n' +
                  '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-northWest" d="M35.893,38.688l-2.827-2.828c-0.781-0.781-0.781-2.047,0-2.828c0.78-0.781,2.047-0.781,2.827,0l2.827,2.828c0.781,0.781,0.781,2.047,0,2.828C37.94,39.469,36.674,39.469,35.893,38.688z"></path>\n' +
                  '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-west" d="M34.034,50c0,1.104-0.896,1.999-2,1.999h-4c-1.104,0-1.998-0.896-1.998-1.999s0.896-2,1.998-2h4C33.14,48,34.034,48.896,34.034,50z"></path>\n' +
                  '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-southWest" d="M35.893,61.312c0.781-0.78,2.048-0.78,2.827,0c0.781,0.78,0.781,2.047,0,2.828l-2.827,2.827c-0.78,0.781-2.047,0.781-2.827,0c-0.781-0.78-0.781-2.047,0-2.827L35.893,61.312z"></path>\n' +
                  '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-south" d="M50.034,65.998c1.104,0,2,0.895,2,1.999v4c0,1.104-0.896,2-2,2c-1.105,0-2-0.896-2-2v-4C48.034,66.893,48.929,65.998,50.034,65.998z"></path>\n' +
                  '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-southEast" d="M64.175,61.312l2.828,2.828c0.779,0.78,0.779,2.047,0,2.827c-0.781,0.781-2.049,0.781-2.828,0l-2.828-2.827c-0.781-0.781-0.781-2.048,0-2.828C62.126,60.531,63.392,60.531,64.175,61.312z"></path>\n' +
                  '                              </g>\n' +
                  '                              <g class="climacon_componentWrap climacon_componentWrap_sunBody" clip-path="url(#sunFillClip)">\n' +
                  '                                <circle class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody" style="fill:#FDB813" cx="50.034" cy="50" r="11.999"></circle>\n' +
                  '                              </g>\n' +
                  '                            </g>\n' +
                  '                          </g>\n' +
                  '                        </svg>'; // Your SVG content goes here
              customContent.classList.add('weather_icon')

              // Append your custom content to the header
              header.prepend(customContent);
            }
          });
        }
      },
      salesperson_ids: []
    };
  },    
  setup(){
      const store = useCalendarScheduleSidebar();
      const page = usePage();

      return { store, page }
  },
  methods: {
    setActiveTab(tabId) {
      this.activeTab = tabId;
    },
    toggleSchedule: function() {
      $('#schedule-offline-modal').modal('hide')
      $('#calendar-alert').hide()
    },
    EditScheduleClick: function() {
      this.formData.appointment_id = this.selectedEvent.extendedProps.appointment_id;
      this.formData.title = this.selectedEvent.title;

      this.formData.reminder_sms = this.selectedEvent.extendedProps.reminder_sms;
      this.formData.reminder_email = this.selectedEvent.extendedProps.reminder_email;
      this.formData.entityType = this.selectedEvent.extendedProps.entityType;

      this.formData.entityId = this.selectedEvent.extendedProps.entityId;
      if(this.formData.entityType == "jobs"){
        this.bindJob = true;
        this.bindLead = false;
        this.nonwork = false;

        this.formData.jobsite  = this.jobsiteOptions.find(item => item.jobsite_id === this.selectedEvent.extendedProps.entityId);
      }else if(this.formData.entityType == "leads"){
        this.bindJob = false;
        this.bindLead = true;
        this.nonwork = false;

        console.log(this.leadOptions);
        this.formData.lead  = this.leadOptions.find(item => item.lead_id === this.selectedEvent.extendedProps.entityId);
      }else{
        this.bindJob = false;
        this.bindLead = false;
        this.nonwork = true;
      }

      this.formData.leadId = this.selectedEvent.extendedProps.lead_id;
      this.formData.startDate = this.selectedEvent.extendedProps.start_date;
      this.formData.endDate = this.selectedEvent.extendedProps.end_date;
      this.formData.city = this.selectedEvent.extendedProps.city;
      this.formData.state = this.selectedEvent.extendedProps.state;
      this.formData.zipcode = this.selectedEvent.extendedProps.zipcode;
      this.formData.streetAddress = this.selectedEvent.extendedProps.street;
      $('#street_address_new_appointment').val(this.formData.streetAddress);
      this.formData.description = this.selectedEvent.extendedProps.description;
      this.formData.assignedToUserId = this.selectedEvent.extendedProps.assignedToUserId;

      this.formData.assignedToUser = this.userOptions.find(item => item.user_id === this.selectedEvent.extendedProps.assignedToUserId)

      // this.formData.guest = this.selectedEvent.guest;
      // this.formData.fileName = this.selectedEvent.fileName;
      // this.formData.file = this.selectedEvent.file;

      $('#meetingDate').data('daterangepicker').setStartDate(this.selectedEvent.start);
      $('#meetingDate').data('daterangepicker').setEndDate(this.selectedEvent.end);

      this.selectedEvent = null;
      $('#add-appointment').modal('show')
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

      console.log("Save Appointment...");

      this.formData.guest = $('#appointment_guests').val().join(', ')
      const form = new FormData()
      form.append('file[]', this.formData.file)

      console.log(this.formData);

      //return true;

      try {
        this.showLoader = true
        //let errorCount = this.validateRequiredFields(this.formData, ['description','zipcode', 'state', 'city', 'streetAddress', 'meetingDate', 'jobsite', 'leadId', 'lead', 'guest', 'fileName', 'file'])
        let errorCount = 0;
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
            if (response.status == 201 || response.status == 200) {
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
      this.formData.entityId = info.lead_id
    },
    getJobId: function(info) {
      this.formData.entityId = info.jobsite_id
    },
    getAssignedToId: function(info) {
      this.formData.assignedToUserId = info.user_id
    },
    toggleBindLead: function(info) {
      $('#street_address_new_appointment').val('')
      this.formData.city = ''
      this.formData.state = ''
      this.formData.zipcode = ''
      this.bindJob = false
      this.nonwork = false;
      // $('#unbindLead').prop('checked', false)
      // $('#bindJob').prop('checked', false)
      this.formData.entityType = "leads";
    },
    toggleBindJob: function() {
      if (selected_jobsite.value) {
        $('#street_address_new_appointment').val(selected_jobsite.value.street)
        this.formData.city = selected_jobsite.value.city
        this.formData.state = selected_jobsite.value.state
        this.formData.zipcode = selected_jobsite.value.zipcode
      }

      this.formData.entityType = "jobs";
      this.bindLead = false;
      this.nonwork = false;
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
      this.formData.entityType = "non-work";
      this.formData.entityId = 0;
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
    },
    isInBusinessHours: function(date) {
      // Define business hours
      var businessStart = '08:00';
      var businessEnd = '18:00';

      // Convert business hours to date objects
      var startHour = parseInt(businessStart.split(':')[0]);
      var startMinutes = parseInt(businessStart.split(':')[1]);
      var endHour = parseInt(businessEnd.split(':')[0]);
      var endMinutes = parseInt(businessEnd.split(':')[1]);

      // Create date objects for start and end times on the given date
      var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), startHour, startMinutes);
      var endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), endHour, endMinutes);

      // Check if the given date is within the business hours
      return date >= startDate && date < endDate;
    },
    getCalendarInstance() {
      return this.$refs.fullCalendar.getApi();
    },
    createNonBusinessHoursContent() {
      let element = document.querySelector('.fc-event-main');
      const el = document.createElement('div');
      el.className = 'disabled-slot';
      // el.style.top = element.getBoundingClientRect().y + 'px';
      // el.style.left = element.getBoundingClientRect().x + 'px';
      el.style.width = '100%';
      el.style.height = '21px';
      // You can add more customization here if needed
      return el;
    },
    handleEventClick(clickInfo) {
      // this.selectedEvent = {
      //   title: clickInfo.event.title,
      //   start: clickInfo.event.start.toISOString(),
      //   end: clickInfo.event.end ? clickInfo.event.end.toISOString() : 'N/A'
      // };
      if(this.enableScheduleAppointment){
        this.selectedEvent = clickInfo.event;

        // Position the details box next to the event
        this.$nextTick(() => {
          console.log('this.$el:', this.$el); // Debugging
          if (this.$el) {
            let eventElement = clickInfo.el;
            let detailsElement = this.$el.querySelector('.event-details');
            let colElement = this.$el.querySelector('.col-md-3');
            colElement = colElement.getBoundingClientRect();
            let calendarRect = this.$el.getBoundingClientRect();
            let eventRect = eventElement.getBoundingClientRect();
            // detailsElement.style.top = `${eventRect.top - calendarRect.top + eventRect.height}px`;
            // detailsElement.style.left = `${eventRect.left - calendarRect.left + eventRect.width}px`;
            detailsElement.style.background = `#${clickInfo.event.backgroundColor}`;
            detailsElement.style.top = `${eventRect.top - calendarRect.top}px`;
            detailsElement.style.left = `${eventRect.left - calendarRect.left - colElement.width}px`;
          }
        });
      }
    },
    handleSelectEvent(info){
      this.selectedEvent = null;
      let selfie = this;
      // Prevent selection outside of business hours
      if (!this.isInBusinessHours(info.start)) {
        selfie.getCalendarInstance().unselect();
          Swal.fire({
              title: 'Business Hours!',
              text: "This time slot is not available for booking.",
              icon: 'warning',
          })
      }else{
        
        if(this.enableScheduleAppointment){

          selfie.bindJob = false;
          selfie.bindLead = false;
          selfie.nonWork = true;
          selfie.formData.appointment_id = "";
          selfie.formData.jobsite = "";
          selfie.formData.leadId = "";
          selfie.formData.lead = "";
          selfie.formData.title = "";
          selfie.formData.startDate = "";
          selfie.formData.endDate = "";
          selfie.formData.streetAddress = "";
          selfie.formData.city = "";
          selfie.formData.state = "";
          selfie.formData.zipcode = "";
          selfie.formData.assignedToUser = "";
          selfie.formData.assignedToUserId = "";
          selfie.formData.guest = "";
          selfie.formData.description = "";
          selfie.formData.fileName = "";
          selfie.formData.reminder_sms = false;
          selfie.formData.reminder_email = true;
          selfie.formData.entityType = 'non-work';
          selfie.formData.entityId = 0;
          selfie.formData.file = [];

          let t_laststart = this.formatDate(this.lastSelectedEvent);
          let t_nowstart = this.formatDate(info.startStr);

          console.log("Last Selected: " + t_laststart)
          console.log("Current Selectde: " + t_nowstart)
          if(t_laststart != t_nowstart){
            this.$nextTick(() => {
              console.log("Hide Appointment");
              $('#add-appointment').modal('hide')
            });
          }
          this.lastSelectedEvent = info.startStr;
        }else{
          let t_laststart = this.formatDate(info.endStr);
          let t_nowstart = this.formatDate(info.startStr);

          this.store.setStartDate(t_nowstart);
          this.store.setEndDate(t_laststart);
        }
      }
    },
    UnSelectEvent(info){
      if(this.enableScheduleAppointment){
        $('#add-appointment').modal('show');
      }
      //$('#add-appointment').modal('hide');
      //this.lastSelectedEvent = null;
    },
    initializeCalendarOptionsDependentOnDOM() {
      // Modify calendarOptions to include eventClick
      this.calendarOptions = {
        ...this.calendarOptions, // Spread existing options
        eventClick: this.handleEventClick,
        select: this.handleSelectEvent,
        unselect: this.UnSelectEvent,
      };
    },
    closeEventDetails() {
      this.selectedEvent = null;
    },
    formatDate(date){
      if (date) {
      return new Intl.DateTimeFormat('en-US', {
        year: 'numeric', month: '2-digit', day: '2-digit',
        hour: '2-digit', minute: '2-digit',hour12: true
      }).format(new Date(date));
    }
    },
    extractTime(dateString) {
      const date = new Date(dateString);
      let hours = date.getHours();
      let minutes = date.getMinutes();
      const ampm = hours >= 12 ? 'PM' : 'AM';

      // Convert hours from 24-hour to 12-hour format
      hours = hours % 12;
      hours = hours ? hours : 12; // The hour '0' should be '12'

      // Pad single digit minutes with a leading zero
      minutes = minutes < 10 ? '0' + minutes : minutes;

      // Format the time in HH:MM AM/PM format
      return `${hours}:${minutes}`;
    },
    slotClickHandler() {
      console.log("slotClickHandler");
      $('#add-appointment').modal('show')
    },
    setCalendarDate(date) {
      const calendarApi = this.$refs.fullCalendar.getApi();
      calendarApi.gotoDate(date);
    },
  },
  mounted() {
    axios.get('/api/calendar/getData') // Your Laravel endpoint to fetch events
      .then(response => {
        this.events  = response.data.data;
        this.calendarOptions.eventSources = [
            { events: this.events }
          ];
        console.log(this.calendarOptions.eventSources);
      });

    axios.get('/api/calendar/getLib') // Your Laravel endpoint to fetch events
        .then(response => {
          this.leadOptions = response.data.leads;
          this.userOptions = response.data.users;
          this.jobsiteOptions = response.data.jobsites;
          console.log(response.data);
        });

    let selfie = this
    $('#meetingDate').daterangepicker({
      language: "en",
      autoClose: true,
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY h:mm A'
      }
    }, function(start, end, label) {
      console.log("Selected range: " + start.format('MM/DD/YYYY h:mm A') + ' - ' + end.format('MM/DD/YYYY h:mm A'));
      selfie.formData.startDate =start.format('MM/DD/YYYY h:mm A');
      selfie.formData.endDate = end.format('MM/DD/YYYY h:mm A');
    });

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

    this.$nextTick(() => {
      // After ensuring the DOM is ready, initialize eventClick
      this.initializeCalendarOptionsDependentOnDOM();
    });
  },
  computed: {
      apptDate(){
          return this.store.apptDate;
      },
      startDate(){
          return this.store.startDate;
      },
      endDate(){
          return this.store.endDate;
      },
      selectedSalesPeople(){
          return this.store.selectedSalesPerson;
      }
  },
  watch: {
    // setDate(newValue, oldValue) {
    //   console.log(`Prop myProp changed from ${oldValue} to ${newValue}`);
    //   this.setCalendarDate(newValue);
    // }
    salesperson_ids(newValue, oldValue){
      console.log("Sales Person Change");
      console.log(newValue);
      
      this.store.setSelectedSalesPerson(newValue);
    }
  }
};
</script>